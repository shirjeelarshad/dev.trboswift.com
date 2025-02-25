<?php
/* 
 * Theme: rancoded CORE FRAMEWORK FILE
 * Url: www.rancoded.com
 * Author: Nuralam
 *
 * THIS FILE WILL BE UPDATED WITH EVERY UPDATE
 * IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
 *
 * http://codex.wordpress.org/Child_Themes
 */



if (!defined('THEME_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

global $CORE, $CORE_CART, $post, $userdata;


?>



<div class="new-auction-card p-2">


    <?php


    $files = $CORE->MEDIA("get_all_images", $post->ID);

    if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
        echo '<span>No Image</span>';
    } elseif (count($files) > 0) {
        $f = $files[0]; // Get the first image
        ?>
        <a href="<?php echo get_permalink($post->ID); ?>" target="_blank"><img loading="lazy"
                style="width:100%; height:171px;  border-radius: 10px; object-fit: cover; object-position: center;"
                src="<?php echo $f['src']; ?>" data-src="<?php echo $f['src']; ?>" alt="image"
                class="new-img-height img-fluid lazyload"></a>
    <?php } ?>



    <div class="new-bottom-section mt-2">

        <span class="new-font-size small">
            <?php if (strlen($post->post_title) > 25) {
                echo substr($post->post_title, 0, 25) . '...';
            } else {
                echo $post->post_title;
            } ?>
        </span>


    </div>

</div>