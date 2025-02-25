<?php

namespace ImportWP\Pro\Importer\Template;

use ImportWP\Common\Importer\ParsedData;
use ImportWP\Common\Importer\Template\Template;
use ImportWP\Common\Model\ImporterModel;
use ImportWP\Container;
use ImportWP\EventHandler;

class CustomFields
{
    /**
     * @var Template $template
     */
    private $template;

    /**
     * Keep track of custom fields for log that have already been processed
     *
     * @var array
     */
    public $virtual_fields;

    /**
     * @var EventHandler $event_handler
     */
    private $event_handler;

    public function __construct(Template $template, EventHandler $event_handler)
    {
        $this->template = $template;
        $this->event_handler = $event_handler;

        $this->event_handler->run('importer.custom_fields.init', [null, $this]);
    }

    public function register_field_callbacks()
    {
        return [
            'custom_fields.*.key' => [$this, 'get_fields']
        ];
    }

    /**
     * Get list of posts
     * 
     * @param ImporterModel $importer_model
     *
     * @return array
     */
    public function get_fields($importer_model)
    {
		
		$options = array();
		$cfields = get_option("cfields");
		
		
		// DEFAULTS
		$options[] = ['value' =>  "image", 'label' => "Image (Full Link Required https://....)" ];
		
		if(is_array($cfields) && !empty($cfields) ){ $i=0; $setKeys = array(); $selectedcatlist = array();
                  
                  foreach($cfields['name'] as $data){ 
                  
                  	if($cfields['dbkey'][$i] !="" && $cfields['name'][$i] != "" ){ 
                  	
                  	// ADJUST KEY IF IS DUPLICATE
                  	if(in_array($cfields['dbkey'][$i], $setKeys) ){  $cfields['dbkey'][$i] = $cfields['dbkey'][$i]."".$i; }
                  	
                  	// ADD TO ALREADY DONE LIST
                  	$setKeys[] = $cfields['dbkey'][$i];	
					
					 $options[] = ['value' =>  $cfields['dbkey'][$i], 'label' => $cfields['name'][$i] ];
					
					}
				
				$i++;
				
				}
		}
		
		
		
  
		
        //$options = $this->event_handler->run('importer.custom_fields.get_fields', [$options, $importer_model]);
		 
		
		
		
		
        return $options;
    }
 

    public function register_fields()
    {
        $attachment_condition = [
            'relation' => 'OR',
            [
                'relation' => 'AND',
                ['_field_type', '==', 'attachment'], // field_type = attachment
                ['key', '!*', '::'] // key not contains ::
            ],
            [
                'relation' => 'AND',
                ['key', '*=', '::attachment::'] // key contains ::attachment::
            ]
        ];

		
		
		 

       return $this->template->register_group('Custom Fields', 'custom_fields', [
            
			 
			$this->template->register_field('Name', 'key', [
                'options' => 'callback'
            ]),
			
			
            $this->template->register_field('Value', 'value', []),
			
            $this->template->register_field('Field Type', '_field_type', [
                'default' => 'text',
                'options' => [
                    ['value' => 'text', 'label' => 'Text'],
                    ['value' => 'attachment', 'label' => 'Attachment'],
                ],
                'type' => 'select',
                'tooltip' => __('Select how the custom field should be handled', 'importwp'),
                'condition' => ['key', '!*', '::'],
            ]),
			
			
            $this->template->register_field('Return Value', '_return', [
                'condition' => [
                    ['_field_type', '==', 'attachment'],
                    ['key', '!*', '::']
                ],
                'defualt' => 'url',
                'options' => [
                    ['value' => 'url', 'label' => 'Attachment URL'],
                    ['value' => 'id', 'label' => 'Attachment ID'],
                    ['value' => 'url-serialize', 'label' => 'Attachment URL - Serialized'],
                    ['value' => 'id-serialize', 'label' => 'Attachment ID - Serialized'],
                ],
                'type' => 'select'
            ]),
            // Add attachment fields
            $this->template->register_field('Download', '_download', [
                'condition' => $attachment_condition,
                'options' => [
                    ['value' => 'remote', 'label' => 'Remote URL'],
                    ['value' => 'ftp', 'label' => 'FTP'],
                    ['value' => 'local', 'label' => 'Local Filesystem'],
                ],
                'default' => 'remote',
                'type' => 'select',
                'tooltip' => __('Select how the attachment is being downloaded.', 'importwp')
            ]),
            $this->template->register_field('Host', '_ftp_host', [
                'condition' => [
                    $attachment_condition,
                    ['_download', '==', 'ftp'],
                ],
                'tooltip' => __('Enter the FTP hostname', 'importwp')
            ]),
            $this->template->register_field('Username', '_ftp_user', [
                'condition' => [
                    $attachment_condition,
                    ['_download', '==', 'ftp'],
                ],
                'tooltip' => __('Enter the FTP username', 'importwp')
            ]),
            $this->template->register_field('Password', '_ftp_pass', [
                'condition' => [
                    $attachment_condition,
                    ['_download', '==', 'ftp'],
                ],
                'tooltip' => __('Enter the FTP password', 'importwp')
            ]),
            $this->template->register_field('Path', '_ftp_path', [
                'condition' => [
                    $attachment_condition,
                    ['_download', '==', 'ftp'],
                ],
                'tooltip' => __('Enter the FTP base path, this is prefixed onto the Location field, leave empty to be ignore', 'importwp')
            ]),
            $this->template->register_field('Base URL', '_remote_url', [
                'condition' => [
                    $attachment_condition,
                    ['_download', '==', 'remote']
                ],
                'tooltip' => __('Enter the base url, this is prefixed onto the Location field, leave empty to be ignore', 'importwp')
            ]),
            $this->template->register_field('Base URL', '_local_url', [
                'condition' => [
                    $attachment_condition,
                    ['_download', '==', 'local']
                ],
                'tooltip' => __('Enter the base path from this servers root file system, this is prefixed onto the Location field, leave empty to be ignore', 'importwp')
            ]),
            $this->template->register_field('Enable Meta', '_enabled', [
                'condition' => $attachment_condition,
                'default' => 'no',
                'options' => [
                    ['value' => 'no', 'label' => 'No'],
                    ['value' => 'yes', 'label' => 'Yes'],
                ],
                'type' => 'select',
                'tooltip' => __('Enable/Disable the fields to import attachment meta data.', 'importwp')
            ]),
            $this->template->register_field('Alt Text', '_alt', [
                'condition' => [
                    $attachment_condition,
                    ['_enabled', '==', 'yes'],
                ],
                'tooltip' => __('Image attachment alt text.', 'importwp'),
            ]),
            $this->template->register_field('Title Text', '_title', [
                'condition' => [
                    $attachment_condition,
                    ['_enabled', '==', 'yes'],
                ],
                'tooltip' => __('Attachments title text.', 'importwp')
            ]),
            $this->template->register_field('Caption Text', '_caption', [
                'condition' => [
                    $attachment_condition,
                    ['_enabled', '==', 'yes'],
                ],
                'tooltip' => __('Image attachments caption text.', 'importwp')
            ]),
            $this->template->register_field('Description Text', '_description', [
                'condition' => [
                    $attachment_condition,
                    ['_enabled', '==', 'yes'],
                ],
                'tooltip' => __('Attachments description text.', 'importwp')
            ])
        ], ['type' => 'repeatable', 'row_base' => true]);
		
		
		return $groups;
    }

    public function process($post_id, ParsedData $data, ImporterModel $importer_model)
    {
        // Handle Sub Query
        $group_name = 'custom_fields';
        $custom_fields = $data->getData($group_name);
		
		
        $row_count = isset($custom_fields[$group_name . '._index']) ? intval($custom_fields[$group_name . '._index']) : 0;
        $output = [];
        $this->virtual_fields = [];
        $default_keys = [];

        for ($i = 0; $i < $row_count; $i++) {
            $prefix = $group_name . '.' . $i . '.';

            // store in a temp variable so can be processed the same as sub rows
            $sub_rows = [$custom_fields];

            if (isset($custom_fields[$prefix . 'row_base']) && !empty($custom_fields[$prefix . 'row_base'])) {
                $sub_group_id = $group_name . '.' . $i;
                $sub_rows = $data->getData($sub_group_id);
            }

            foreach ($sub_rows as $custom_field_record) {
                $key = $custom_field_record[$prefix . 'key'];

                $permission_key = $group_name . '.' . $key;
                $allowed = $data->permission()->validate([$permission_key => ''], $data->getMethod(), $group_name);
                $is_allowed = isset($allowed[$permission_key]) ? true : false;

                if (!$is_allowed || empty($key)) {
                    continue 2;
                }

                $value = $custom_field_record[$prefix . 'value'];
                $field_type = $custom_field_record[$prefix . '_field_type'];

                if (strpos($key, '::') !== false) {

                    // process prefixed fields
                    $custom_field_result = $this->event_handler->run('importer.custom_fields.process_field', [null, $post_id, $key, $value, $custom_field_record, $prefix, $importer_model, $this]);

                    // allow for process to return a list of custom fields to be updated
                    if (is_array($custom_field_result)) {
                        $output = array_merge($output, $custom_field_result);
                    }
                } else {
                    $default_keys[] = $key;
                    switch ($field_type) {
                        case 'attachment':
                            $output[$key][] = $this->processAttachmentField($value, $post_id, $custom_fields, $prefix);
                            break;
                        case 'text':
                        default:
                            $output[$key][] = $this->processTextField($value);
                            break;
                    }
                }
            }
        }

        if (!empty($default_keys)) {
            foreach ($default_keys as $key) {
                if (count($output[$key]) == 1) {
                    $output[$key] = $output[$key][0];
                }
            }
        }

        $data->replace($output, $group_name);

        return $data;
    }

    public function log_message($id, $data)
    {
        $fields = $data->getData('custom_fields');
        $fields = array_merge($fields, $this->virtual_fields);
        if (empty($fields)) {
            return '';
        }

        $message = ', Custom Fields (' . implode(', ', array_keys($fields)) . ')';
        return $message;
    }

    public function processTextField($value)
    {
        return $value;
    }

    public function processAttachmentField($value, $post_id, $custom_fields, $prefix)
    {
        /**
         * @var Filesystem $filesystem
         */
        $filesystem = Container::getInstance()->get('filesystem');

        /**
         * @var Ftp $ftp
         */
        $ftp = Container::getInstance()->get('ftp');

        /**
         * @var Attachment $attachment
         */
        $attachment = Container::getInstance()->get('attachment');

        $delimiter = apply_filters('iwp/value_delimiter', ',');
        $delimiter = apply_filters('iwp/attachment/value_delimiter', $delimiter);

        $result = false;
        $return = isset($custom_fields[$prefix . '_return']) ? $custom_fields[$prefix . '_return'] : null;
        $download = isset($custom_fields[$prefix . '_download']) ? $custom_fields[$prefix . '_download'] : null;

        $locations = explode($delimiter, $value);
        $attachment_output = [];
        foreach ($locations as $location) {

            // remove whitespace
            $location = trim($location);

            switch ($download) {
                case 'remote':
                    $base_url = isset($custom_fields[$prefix . '_remote_url']) ? $custom_fields[$prefix . '_remote_url'] : null;

                    // check if file hash is already stored
                    $source = $base_url . $location;
                    $source = apply_filters('iwp/attachment/filename', $source);
                    if (empty($source)) {
                        continue 2;
                    }

                    $attachment_id = $attachment->get_attachment_by_hash($source);
                    if ($attachment_id <= 0) {
                        $result = $filesystem->download_file($source);
                    }
                    break;
                case 'ftp':
                    $ftp_host = isset($custom_fields[$prefix . '_ftp_host']) ? $custom_fields[$prefix . '_ftp_host'] : null;
                    $ftp_user = isset($custom_fields[$prefix . '_ftp_user']) ? $custom_fields[$prefix . '_ftp_user'] : null;
                    $ftp_pass = isset($custom_fields[$prefix . '_ftp_pass']) ? $custom_fields[$prefix . '_ftp_pass'] : null;
                    $base_url = isset($custom_fields[$prefix . '_ftp_path']) ? $custom_fields[$prefix . '_ftp_path'] : null;

                    // check if file hash is already stored
                    $source = $base_url . $location;
                    $source = apply_filters('iwp/attachment/filename', $source);
                    if (empty($source)) {
                        continue 2;
                    }

                    $attachment_id = $attachment->get_attachment_by_hash($source);
                    if ($attachment_id <= 0) {
                        $result = $ftp->download_file($source, $ftp_host, $ftp_user, $ftp_pass);
                    }
                    break;
                case 'local':
                    $base_url = isset($custom_fields[$prefix . '_local_url']) ? $custom_fields[$prefix . '_local_url'] : null;

                    // check if file hash is already stored
                    $source = $base_url . $location;
                    $source = apply_filters('iwp/attachment/filename', $source);
                    $attachment_id = $attachment->get_attachment_by_hash($source);
                    if ($attachment_id <= 0) {
                        $result = $filesystem->copy_file($source);
                    }
                    break;
                default:
                    continue 2;
                    break;
            }

            // insert attachment
            if ($attachment_id <= 0) {

                if (is_wp_error($result)) {
                    $this->template->add_error($result);
                    continue;
                }

                if (!$result) {
                    continue;
                }

                $attachment_args = [];
                $enabled = isset($custom_fields[$prefix . '_enabled']) ? $custom_fields[$prefix . '_enabled'] : null;
                if ('yes' === $enabled) {
                    $attachment_args['title'] = isset($custom_fields[$prefix . '_title']) ? $custom_fields[$prefix . '_title'] : null;
                    $attachment_args['alt'] = isset($custom_fields[$prefix . '_alt']) ? $custom_fields[$prefix . '_alt'] : null;
                    $attachment_args['caption'] = isset($custom_fields[$prefix . '_caption']) ? $custom_fields[$prefix . '_caption'] : null;
                    $attachment_args['description'] = isset($custom_fields[$prefix . '_description']) ? $custom_fields[$prefix . '_description'] : null;
                }

                $attachment_id = $attachment->insert_attachment($post_id, $result['dest'], $result['mime'], $attachment_args);
                if (is_wp_error($attachment_id)) {
                    continue;
                }

                $attachment->generate_image_sizes($attachment_id, $result['dest']);
                $attachment->store_attachment_hash($attachment_id, $source);
            } else {
                $enabled = isset($custom_fields[$prefix . '_enabled']) ? $custom_fields[$prefix . '_enabled'] : null;
                if ('yes' === $enabled) {

                    $post_data = [];

                    if (isset($custom_fields[$prefix . '_title']) && !empty($custom_fields[$prefix . '_title'])) {
                        $post_data['post_title'] = $custom_fields[$prefix . '_title'];
                    }

                    if (isset($custom_fields[$prefix . '_description']) && !empty($custom_fields[$prefix . '_description'])) {
                        $post_data['post_content'] = $custom_fields[$prefix . '_description'];
                    }

                    if (isset($custom_fields[$prefix . '_caption']) && !empty($custom_fields[$prefix . '_caption'])) {
                        $post_data['post_excerpt'] = $custom_fields[$prefix . '_caption'];
                    }

                    if (!empty($post_data)) {
                        $post_data['ID'] = $attachment_id;
                        wp_update_post($post_data);
                    }

                    if (isset($custom_fields[$prefix . '_alt']) && !empty($custom_fields[$prefix . '_alt'])) {
                        update_post_meta($attachment_id, '_wp_attachment_image_alt', $custom_fields[$prefix . '_alt']);
                    }
                }
            }

            switch ($return) {
                case 'url-serialize':
                case 'url':
                    $attachment_output[] = wp_get_attachment_url($attachment_id);
                    break;
                case 'id-serialize':
                default:
                    $attachment_output[] = $attachment_id;
                    break;
            }
        }

        if (strpos($return, 'serialize') !== false) {
            return serialize($attachment_output);
        } else {
            return implode(',', $attachment_output);
        }
    }
}
