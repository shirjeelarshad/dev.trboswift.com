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
if (!defined('THEME_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

global $CORE, $CORE_CART, $post, $userdata;



// GET FILES
$files = $CORE->MEDIA("get_all_images", $post->ID);

// GET PRICE
$price = get_post_meta($post->ID, 'price', true);

// GET OLD PRICE
$oldprice = get_post_meta($post->ID, 'old_price', true);

// GET QUTY
$qty = get_post_meta($post->ID, "qty", true);
if ($qty == "") {
    $qty = 10;
}


?>






<section class="live-bidding-box p-0 m-0 bg-secondary">

    <div class=" d-flex justify-content-center text-center p-2" style="background:#eeeeeea3; ">
        <p class="col-lg-4 h5 d-none d-lg-block"><i class="fal fa-gavel mr-2"></i> <?php echo __("ON THE BLOCK", "premiumpress"); ?></p>


        <div class="col-lg-8 col-12  d-flex justify-content-end p-0 m-0">
            <button id="toggleSound<?php echo $post->ID; ?>" onclick="toggleSoundStartStop<?php echo $post->ID; ?>()"
                class="mute-button btn btn-light"><i class="fas fa-volume-mute d-block"></i></button>

            <?php
            if (current_user_can('administrator')) {
                ?>


                <button id="startStopButton" onclick="toggleStartStop<?php echo $post->ID; ?>()"
                    class="btn btn-light"><?php echo __("Restart Auction", "premiumpress"); ?></button>
                <button id="pauseResumeButton" onclick="togglePauseResume<?php echo $post->ID; ?>()"
                    class="btn btn-light"><?php echo __("Pause Auction", "premiumpress"); ?></button>

                <?php
            }
            ?>

            <button onclick="toggleGetLive<?php echo $post->ID; ?>()" class=" mute-button btn btn-light"><i
                    class="fas fa-video d-block"></i></button>


            <button onclick="openUpCommingSide<?php echo $post->ID; ?>()" class=" mute-button btn btn-light"><i
                    class="fas fa-list-ol d-block"></i></button>

        </div>
    </div>




    <div class="main-live-bidding-row row m-0 p-3">
        <div id="live-auction-slider-bid-section" class="col-xl-4 col-md-4 col-sm-12 m-0 p-2">


            <!-- Add this to your HTML file -->



            <?php


            _ppt_template('framework/design/singlenew/parts/_live_auction_images_slider');


            ?>








            <div class="col-12 bg-secondary mt-3 pt-2 pl-2 pr-2 radiusx">

                <div>


                    <p itemprop="name" class=" live-auction-font-tit">
                        <?php echo do_shortcode('[TITLE]'); ?>
                    </p>


                </div>



                <?php
                _ppt_template('framework/design/singlenew/parts/_live_auction_bid');


                ?>


            </div>



        </div>



        <div class="col-xl-4 col-md-4 col-sm-6 pl-2 pr-2  bg-secondary  ">

            <?php

            // _ppt_template( 'framework/design/singlenew/blocks/current-live-auction-features' ); 
            
            _ppt_template('framework/design/singlenew/blocks/customfields');

            ?>

        </div>

        <div class="col-xl-4 col-md-4 col-sm-6  pl-2 pr-2  bg-secondary  ">

            <div class="radiusx pl-2 pr-2 pt-3 bg-secondary  ">
                <?php
                $files = $CORE->MEDIA("get_all_images", $post->ID);

                if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
                    echo '<span>No Image</span>';
                } elseif (count($files) > 0) {
                    $totalImages = count($files);

                    ?>
                    <div class="text-center mb-2 d-flex justify-content-between justify-content-center">
                        <p class="gallery-image-header"><i class="fas fa-images"></i>
                            <?php echo $totalImages; ?> <?php echo __("Images", "premiumpress"); ?>
                        </p>
                        <div class="bg-white  d-flex justify-content-center text-center"
                            style="border:1px solid #eee; border-radius: 50px; ">
                            <button id="twoColumnsBtn"
                                class="bg-primary text-white border-0 rounded-circle gallery-image-header"><i
                                    class="fas fa-th-large"></i></button>
                            <button id="oneColumnBtn"
                                class="text-dark bg-white border-0 rounded-circle gallery-image-header"><i
                                    class="fas fa-image"></i></button>
                        </div>


                    </div>
                    <div class="row" id="imageContainer">
                        <?php
                        foreach ($files as $file) {
                            ?>
                            <div class="col-6 p-2 image-column">
                                <a href="<?php echo $file['src']; ?>" data-toggle="lightbox" data-type="image">
                                    <img style="width:100%; border-radius: 10px; object-fit: cover; object-position: center center;"
                                        src="<?php echo $file['src']; ?>" data-src="<?php echo $file['src']; ?>"
                                        alt="image" class="shadow-sm img-fluid lazyload">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <script>
                        // JavaScript to toggle between one and two columns
                        document.getElementById("oneColumnBtn").addEventListener("click", function () {
                            document.querySelectorAll(".image-column").forEach(function (column) {
                                column.classList.remove("col-6");
                                column.classList.add("col-12");
                            });
                        });

                        document.getElementById("twoColumnsBtn").addEventListener("click", function () {
                            document.querySelectorAll(".image-column").forEach(function (column) {
                                column.classList.remove("col-12");
                                column.classList.add("col-6");
                            });
                        });
                    </script>
                    <?php
                }
                ?>


            </div>
        </div>

    </div>
    <div class="loader" id="loader"></div>
</section>



<script>








    function closeVideoPanel() {

        jQuery('#showLiveCastContainer').empty();
        document.getElementById("mySidepanel").style.width = "0";

    }




    function closeUpCommingSide() {
        document.getElementById("upCommingSide").style.width = "0";
    }



    function isMobileDevice() {
        return window.innerWidth < 768; // You can adjust the screen width threshold as needed
    }


    if (isMobileDevice()) {
        // function openNav<?php echo $post->ID; ?>() {
        //     document.getElementById("mySidepanel").style.width = "80%";
        // }

        function openUpCommingSide<?php echo $post->ID; ?>() {
            document.getElementById("upCommingSide").style.width = "80%";
        }
    } else {
        // function openNav<?php echo $post->ID; ?>() {
        //     document.getElementById("mySidepanel").style.width = "65%";
        // }

        function openUpCommingSide<?php echo $post->ID; ?>() {
            document.getElementById("upCommingSide").style.width = "40%";
        }
    }


</script>