<?php
   /* 
   * Theme: TURBOBID CORE FRAMEWORK FILE
   * Url: www.turbobid.ca
   * Author: Md Nuralam
   *
   * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
   * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
   *
   * http://codex.wordpress.org/Child_Themes
   */
   if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
   
global $wpdb, $CORE, $userdata, $STRING, $escrows, $finance;


?>

<div class="mt-3 mb-5">
    <div class="col-12 my-3 row">
        <h4 class="mb-2 "><?php echo __("Escrow Transactions", "premiumpress"); ?> </h4>
    </div>

    <div class="card-body p-0">
        <?php if (!empty($escrows)) { ?>
        <div class="overflow-auto">
            <table class="table small table-orders">
                <thead>
                    <tr>
                        <th class="text-center bg-primary text-white " style="border-radius:10px 0 0 0;">
                            <?php echo __("ID", "premiumpress"); ?></th>
                        <th class="text-center bg-primary text-white ">
                            <?php echo __("Transaction Title", "premiumpress"); ?></th>
                        <th class="text-center bg-primary text-white"><?php echo __("Created", "premiumpress"); ?></th>
                        <th class="text-center bg-primary text-white dashhideme">
                            <?php echo __("Amount", "premiumpress"); ?></th>
                        <th class="text-center bg-primary text-white "><?php echo __("Role", "premiumpress"); ?></th>
                        <th class="text-center text-white  bg-primary  dashhideme" style="border-radius:0 10px 0 0;">
                            <?php echo __("Status", "premiumpress"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($escrows as $entry) {
    $entry_id = $entry->entry_id;

    // Fetch metadata for the entry
    $meta = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_key, meta_value FROM $meta_table WHERE entry_id = %d",
            $entry_id
        )
    );

    // Fetch escrow statuses
    $buyer_escrow_status = get_post_meta($entry_id, 'buyer_escrow_step_status', true);
    $seller_escrow_status = get_post_meta($entry_id, 'seller_escrow_step_status', true);

    // Determine row class based on escrow status
    $rowClass = 'escrow-start'; // Default class

    if (!empty($buyer_escrow_status)) {
        if ($buyer_escrow_status['step'] >= 5 && $buyer_escrow_status['status'] === "Approved") {
            $rowClass = 'escrow-finished';
        } elseif ($buyer_escrow_status['step'] >= 2 && $buyer_escrow_status['status'] === "Approved") {
            $rowClass = 'escrow-open';
        }
    }

    if (!empty($seller_escrow_status)) {
        if ($seller_escrow_status['step'] >= 5 && $seller_escrow_status['status'] === "Approved") {
            $rowClass = 'escrow-finished';
        } elseif ($seller_escrow_status['step'] >= 3 && $seller_escrow_status['status'] === "Approved") {
            $rowClass = 'escrow-verified';
        } elseif ($seller_escrow_status['step'] >= 2 && $seller_escrow_status['status'] === "Approved") {
            $rowClass = 'escrow-approved';
        }
    }

    // Prepare metadata for easy access
    $meta_data = [];
    foreach ($meta as $m) {
        $meta_data[$m->meta_key] = $m->meta_value;
    }
    ?>
    <tr class="row-<?php echo esc_attr($entry_id); ?> <?php echo esc_attr($rowClass); ?>">
        <td>
            <a class="text-dark entry-link" href="javascript:void(0)"
                data-entry-id="<?php echo esc_attr($entry->entry_id); ?>">
                #<?php echo esc_html($entry->entry_id); ?>
            </a>
        </td>
        <td class="text-center text-dark">
            <?php echo isset($meta_data['name-1']) ? esc_html($meta_data['name-1']) : ''; ?><br>
            <span
                class="small opacity-5"><?php echo isset($meta_data['text-12']) ? esc_html($meta_data['text-12']) : ''; ?></span>
        </td>
        <td class="text-center text-muted text-dark">
            <?php echo esc_html(hook_date($entry->date_created)); ?>
        </td>
        <td class="text-center text-dark">
            <?php echo isset($meta_data['currency-1']) ? esc_html(hook_price($meta_data['currency-1'])) : ''; ?>
        </td>
        <td class="text-center text-dark">
            <?php echo isset($meta_data['select-10']) ? esc_html($meta_data['select-10']) : ''; ?>
        </td>
        <td class="text-center text-success">
            <i class="fas fa-circle small mr-2"></i> Awaiting Agreement
        </td>
    </tr>
    <?php
}

                        ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div class="not-fount-entries py-4 text-center">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group222.png" />
            <h6><i class="fal fa-frown mr-2"></i>
                <?php echo __("There’s nothing here yet. Click below to start a new transaction.", "premiumpress"); ?>
            </h6>
            <a href="<?php echo home_url(); ?>/escrow-back-end/" class="btn btn-primary rounded-pill">Start a new
                transaction</a>
        </div>
        <?php } ?>
    </div>
</div>