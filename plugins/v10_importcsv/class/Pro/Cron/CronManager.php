<?php

namespace ImportWP\Pro\Cron;

use ImportWP\Common\Filesystem\Filesystem;
use ImportWP\Common\Http\Http;
use ImportWP\Common\Importer\ImporterStatusManager;
use ImportWP\Common\Model\ImporterModel;
use ImportWP\Common\Properties\Properties;
use ImportWP\Pro\Importer\ImporterManager;

class CronManager
{
    /**
     * @var Properties
     */
    private $properties;

    /**
     * @var Http
     */
    private $http;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImporterManager
     */
    private $importer_manager;

    /**
     * @var ImporterStatusManager
     */
    private $importer_status_manager;

    private $_cron_handle = 'iwp_scheduler';

    public function __construct(ImporterManager $importer_manager, ImporterStatusManager $importer_status_manager, Properties $properties, Http $http, Filesystem $filesystem)
    {
        $this->importer_manager = $importer_manager;
        $this->importer_status_manager = $importer_status_manager;
        $this->properties = $properties;
        $this->http = $http;
        $this->filesystem = $filesystem;

        // TODO: Register cron handler
        add_action('init', [$this, 'register_cron_runner']);
        add_action('iwp_scheduler', [$this, 'spawner']);
        add_action('iwp_runner', [$this, 'runner'], 10, 3);

        add_filter('cron_schedules', [$this, 'register_cron_interval']);
    }

    public function register_cron_interval($schedules)
    {
        $schedules['iwp_spawner'] = [
            'interval' => MINUTE_IN_SECONDS * 5,
            'display' => __('Every 5 minutes.', 'importwp')
        ];
        return $schedules;
    }

    public function register_cron_runner()
    {
        if (!wp_next_scheduled('iwp_scheduler')) {
            wp_schedule_event(time(), 'iwp_spawner', 'iwp_scheduler');
        }
    }

    /**
     * Triggered every time the WordPress cron schedule is ran
     * This importer events when needed.
     *
     * @return void
     */
    public function spawner()
    {
        // TODO: 1. loop through importers that are setup to be scheduled, and have not yet been scheduled
        // TODO: 2. calculate next schedule and register event

        $importers = $this->get_scheduled_imports();
        if (empty($importers)) {
            return;
        }

        foreach ($importers as $importer_model) {

            $scheduled = get_post_meta($importer_model->getId(), '_iwp_scheduled', true);
            if (!$scheduled) {
                $this->spawn_importer($importer_model);
            } elseif (isset($scheduled['time'], $scheduled['session'])) {

                $session = $scheduled['session'];
                // $time = $scheduled['time'];

                if ($session === 'init') {
                    $cron_args = [$importer_model->getId(), 'start', null];
                } else {

                    // skip if importer is currently running
                    $importer_status = $this->importer_status_manager->get_importer_status($importer_model, $session);
                    if ($importer_status->has_status('running')) {
                        continue;
                    }

                    $cron_args = [$importer_model->getId(), 'resume', $session];
                }

                if (false === wp_next_scheduled('iwp_runner', $cron_args)) {
                    $this->unschedule($importer_model->getId());
                }
            }
        }
    }

    /**
     * @param ImporterModel $importer_model
     */
    public function spawn_importer($importer_model)
    {
        $schedule = $importer_model->getSetting('cron_schedule');
        $day = $importer_model->getSetting('cron_day');
        $hour = $importer_model->getSetting('cron_hour');
        $minute = $importer_model->getSetting('cron_minute');

        $scheduled_time = $this->calculate_scheduled_time($schedule, $day, $hour, $minute);
        if (false === $scheduled_time) {
            return false;
        }

        update_post_meta($importer_model->getId(), '_iwp_scheduled', [
            'session' => 'init',
            'time' => $scheduled_time
        ]);

        return wp_schedule_single_event($scheduled_time, 'iwp_runner', [$importer_model->getId(), 'start', null]);
    }

    /**
     * @return ImporterModel[]
     */
    public function get_scheduled_imports()
    {
        $query = new \WP_Query([
            'post_type' => IWP_POST_TYPE,
            'posts_per_page' => -1,
        ]);

        if (!$query->have_posts()) {
            return false;
        }

        $importers = [];

        foreach ($query->posts as $post) {
            $importer_model = $this->importer_manager->get_importer($post);
            if ('schedule' === $importer_model->getSetting('import_method') && false === $importer_model->getSetting('cron_disabled')) {
                $importers[] = $importer_model;
            }
        }

        return $importers;
    }

    public function calculate_scheduled_time($schedule, $day = 0, $hour = 0, $minute = 0, $current_time = null)
    {
        $minute_padded = str_pad($minute, 2, 0, STR_PAD_LEFT);
        $hour_padded = str_pad($hour, 2, 0, STR_PAD_LEFT);
        $day_padded = str_pad($day, 2, 0, STR_PAD_LEFT);
        $current_time = !is_null($current_time) ? $current_time : time();
        $scheduled_time = false;

        switch ($schedule) {
            case 'month':
                // 1-31

                // 31st of feb, should = 28/29
                if (date('t', $current_time) < $day) {
                    $day_padded = str_pad(date('t', $current_time), 2, 0, STR_PAD_LEFT);
                }

                $scheduled_time = strtotime(date('Y-m-' . $day_padded . ' ' . $hour_padded . ':' . $minute_padded . ':00', $current_time));

                if ($scheduled_time < $current_time) {

                    // 31st of feb, should = 28/29
                    $future_time = strtotime('+28 days', $current_time); // 28 days is the shortest month, adding + 1 month can skip feb
                    if (date('t', $future_time) < $day) {
                        $day_padded = str_pad(date('t', $future_time), 2, 0, STR_PAD_LEFT);
                    }

                    $scheduled_time = strtotime(date('Y-m-' . $day_padded . ' ' . $hour_padded . ':' . $minute_padded . ':00', $future_time));
                }
                break;
            case 'week':
                // day 0-6 : 0 = SUNDAY
                $day_str = '';
                switch (intval($day)) {
                    case 0:
                        $day_str =  'sunday';
                        break;
                    case 1:
                        $day_str =  'monday';
                        break;
                    case 2:
                        $day_str =  'tuesday';
                        break;
                    case 3:
                        $day_str =  'wednesday';
                        break;
                    case 4:
                        $day_str =  'thursday';
                        break;
                    case 5:
                        $day_str =  'friday';
                        break;
                    case 6:
                        $day_str =  'saturday';
                        break;
                }
                $scheduled_time = strtotime(date('Y-m-d ' . $hour_padded . ':' . $minute_padded . ':00', strtotime('next ' . $day_str, $current_time)));
                if ($scheduled_time - WEEK_IN_SECONDS > $current_time) {
                    $scheduled_time -= WEEK_IN_SECONDS;
                }
                break;
            case 'day':
                $scheduled_time = strtotime(date('Y-m-d ' . $hour_padded . ':' . $minute_padded . ':00', $current_time));
                if ($scheduled_time <= $current_time) {
                    $scheduled_time += DAY_IN_SECONDS;
                }
                break;
            case 'hour':
                $scheduled_time = strtotime(date('Y-m-d H:' . $minute_padded . ':00', $current_time));
                if ($scheduled_time <= $current_time) {
                    $scheduled_time += HOUR_IN_SECONDS;
                }
                break;
        }

        return $scheduled_time;
    }

    public function runner($importer_id, $action = 'start', $session = null)
    {
        // Fetch new file
        $importer_model = $this->importer_manager->get_importer($importer_id);

        if ('schedule' !== $importer_model->getSetting('import_method')) {
            return;
        }

        if ($action === 'start') {

            $datasource = $importer_model->getDatasource();
            switch ($datasource) {
                case 'remote':
                    $url = $importer_model->getDatasourceSetting('remote_url');
                    $attachment_id = $this->importer_manager->remote_file($importer_model, $url, $importer_model->getParser());
                    break;
                case 'local':
                    $url = $importer_model->getDatasourceSetting('local_url');
                    $attachment_id = $this->importer_manager->local_file($importer_model, $url);
                    break;
                default:
                    // TODO: record error 
                    $attachment_id = new \WP_Error('IWP_CRON_1', 'Unable to get new file using datasource: ' . $datasource);
                    break;
            }

            $importer_model = $this->importer_manager->get_importer($importer_id);
            $status = $this->importer_status_manager->create($importer_model);
            $session = $status->get_session_id();

            if (is_wp_error($attachment_id)) {
                // TODO: record error
                $status->record_fatal_error($attachment_id->get_error_message());
                $status->save();
                $status->write_to_file();
                return;
            }

            // TODO: rotate files to not fill up server
            $importer_model->limit_importer_files(5);
        } else {
            $importer_status = $this->importer_status_manager->get_importer_status($importer_model, $session);
            if ($importer_status->get_session_id() !== $session) {
                return;
            }

            $meta = get_post_meta($importer_model->getId(), '_iwp_scheduled', true);
            if ($meta && isset($meta['session'])) {
                $meta['session'] = $session;
                update_post_meta($importer_model->getId(), '_iwp_scheduled', $meta);
            }
        }

        $status = $this->importer_manager->import($importer_model, $session);

        if (!is_null($session) && $status->has_status('timeout')) {
            $scheduled_time = time();

            $meta = get_post_meta($importer_model->getId(), '_iwp_scheduled', true);
            if (!$meta) {
                $meta = [
                    'session' => $session
                ];
            }
            $meta['time'] = $scheduled_time;

            update_post_meta($importer_model->getId(), '_iwp_scheduled', $meta);

            wp_schedule_single_event($scheduled_time, 'iwp_runner', [$importer_model->getId(), 'resume', $session]);
        } else {
            delete_post_meta($importer_model->getId(), '_iwp_scheduled');
            $this->spawn_importer($importer_model);
        }
    }

    public function unschedule($importer_id)
    {
        $importer_model = $this->importer_manager->get_importer($importer_id);
        $meta = get_post_meta($importer_model->getId(), '_iwp_scheduled', true);
        if (!$meta) {
            return false;
        }

        $scheduled_time = $meta['time'];
        $session = $meta['session'];

        if ($session === 'init') {
            $cron_args = [$importer_model->getId(), 'start', null];
        } else {
            $cron_args = [$importer_model->getId(), 'resume', $session];
        }


        $has_schedule = wp_next_scheduled('iwp_runner', $cron_args);
        if ($has_schedule) {
            $unschedule_cron = wp_unschedule_event($scheduled_time, 'iwp_runner', $cron_args);
            if (false === $unschedule_cron) {
                // for some reason we couldn't remove event
                return false;
            }
        }

        $unschedule_meta = delete_post_meta($importer_model->getId(), '_iwp_scheduled');
        if (false === $unschedule_meta) {
            return false;
        }

        return true;
    }

    public function get_status($importer_id)
    {
        $importer_model = $this->importer_manager->get_importer($importer_id);
        $time = wp_next_scheduled('iwp_runner', [$importer_model->getId(), 'start', null]);
        $meta = get_post_meta($importer_model->getId(), '_iwp_scheduled', true);
        $spawner_time = wp_next_scheduled('iwp_scheduler');

        // if no session has been set
        if (!isset($meta['session'])) {
            return [
                'status' => 'spawner',
                'time' => $spawner_time,
                'delta' => $spawner_time - time()
            ];
        }

        if (false === $time) {

            $session_id = isset($meta['session']) ? $meta['session'] : 'init';
            if ($session_id !== 'init') {
                $time = wp_next_scheduled('iwp_runner', [$importer_model->getId(), 'resume', $session_id]);
                if (false === $time) {
                    $status = $this->importer_status_manager->get_importer_status($importer_model, $session_id);

                    if ($status->has_status('complete') || $status->has_status('timeout')) {
                        $spawner_time = wp_next_scheduled('iwp_scheduler');
                        return [
                            'status' => 'spawner',
                            'time' => $spawner_time,
                            'delta' => $spawner_time - time()
                        ];
                    }

                    return [
                        'status' => $status->get_status(),
                        'time' => 0,
                        'delta' => 0
                    ];
                } else {
                    return [
                        'status' => 'resume',
                        'time' => $time,
                        'delta' => $time - time()
                    ];
                }
            }

            // importer might be running
            $status = $this->importer_status_manager->get_importer_status($importer_model, $session_id);
            if ($status->has_status('complete') || $status->has_status('timeout')) {
                $spawner_time = wp_next_scheduled('iwp_scheduler');
                return [
                    'status' => 'spawner',
                    'time' => $spawner_time,
                    'delta' => $spawner_time - time()
                ];
            }

            return [
                'status' => $status->get_status(),
                'session' => $session_id,
                'time' => $time,
                'delta' => $time - time()
            ];
        }

        return [
            'status' => 'start',
            'time' => $time,
            'delta' => $time - time()
        ];
    }
}
