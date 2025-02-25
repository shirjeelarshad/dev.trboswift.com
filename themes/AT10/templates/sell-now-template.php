<?php
/* 
Template Name: Sell Now Template 
*/

get_header();

// Retrieve URL parameters
$vin = isset($_GET['vin']) ? sanitize_text_field($_GET['vin']) : '';
$make = isset($_GET['make']) ? sanitize_text_field($_GET['make']) : '';
$model = isset($_GET['model']) ? sanitize_text_field($_GET['model']) : '';
$year = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : '';

?>

<div class="container">
    <h1>Sell Your Car</h1>

    <?php if ($vin && $make && $model && $year): ?>
        <p><strong>VIN:</strong> <?php echo esc_html($vin); ?></p>
        <p><strong>Make:</strong> <?php echo esc_html($make); ?></p>
        <p><strong>Model:</strong> <?php echo esc_html($model); ?></p>
        <p><strong>Year:</strong> <?php echo esc_html($year); ?></p>
    <?php else: ?>
        <p>Required vehicle information is missing.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>