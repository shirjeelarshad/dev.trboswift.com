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

global $CORE, $post, $userdata;




// GET FILES
$files = $CORE->MEDIA("get_all_images", $post->ID);


?>


<div class=" text-center product-img-box ">

    <div class="addeditmenu" data-key="images"></div>

    <?php
    if (empty($files) || (count($files) == 1 && $files[0]['src'] == "")) {
        ?>

        <?php echo do_shortcode('[IMAGE link=0]'); ?>

    <?php } elseif (count($files) > 0) { ?>
        <div class="auction-end-countdown ">
            <div id="bidding-message-display<?php echo $post->ID; ?>" style="display: none;">
                <div id="bidding_message_middle<?php echo $post->ID; ?>" class="bidding_message_middle">
                    <div>
                        <img class="biding-close-gavel" src="<?php echo home_url(); ?>/wp-content/uploads/2023/09/204180.png">
                    </div>

                    <div class="auction-end-text m-2"></div>
                    <div class="auction-next-text m-2"></div>

                </div>
            </div>

            <div id="bid-added-middle<?php echo $post->ID; ?>" class="bid-added-middle">

                <span id="countdown<?php echo $post->ID; ?>" class="countdown"></span>
            </div>

            <style>
                .auction-end-countdown {
                    position: relative;

                }
            </style>
            <div class="gallery-items clearfix">
                <?php $i = 1;
                foreach ($files as $f) { ?>
                    <a href="<?php echo $f['src']; ?>" data-toggle="lightbox" data-type="image"> <img loading="lazy"
                            style="width:100%; object-fit: cover; object-position: center center;"
                            src="<?php echo $f['src']; ?>" class="img-fluid lazyload live-auction-slider-img"
                            alt="image <?php echo $i; ?>"> </a>
                    <?php $i++;
                } ?>
            </div>

            <div id="iam_highest_bidder_now<?php echo $post->ID; ?>" class="small iam_highest_bidder_now"></div>


            <div class="auction-circle-countdown">
                <div class="base-timer">
                    <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <g class="base-timer__circle">
                            <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
                            <path id="base-timer-path-remaining<?php echo $post->ID; ?>" stroke-dasharray="283"
                                class="base-timer__path-remaining " d="
                        M 50, 50
                        m -45, 0
                        a 45,45 0 1,0 90,0
                        a 45,45 0 1,0 -90,0
                    "></path>
                        </g>
                    </svg>
                    <span id="base-timer-label<?php echo $post->ID; ?>" class="base-timer__label"></span>
                </div>
            </div>


        </div>

    <?php } ?>

</div>


<?php if (count($files) == 1 && $files[0]['src'] == "") {
} elseif (count($files) > 1) { ?>
    <script src="<?php echo FRAMREWORK_URI . 'js/js.plugins-slickslider.js'; ?>"></script>
    <script>

        jQuery(document).ready(function () {
            // Function to replace image source with higher quality after a delay
            function replaceImageSource(imageElement, newSource) {
                setTimeout(function () {
                    imageElement.setAttribute('src', newSource);
                }, 1000); // Replace with the desired delay (1 second)
            }

            // Iterate through each image and replace source
            jQuery('.gallery-items a').each(function () {
                var imgElement = jQuery(this).find('img')[0];
                var newSource = jQuery(this).attr('href');
                replaceImageSource(imgElement, newSource);
            });

            // Slick slider initialization code (if needed)
            // ...

        });


        jQuery(document).ready(function () {

            var slider = jQuery('.gallery-items').slick({
                centerMode: false,
                adaptiveHeight: true,
                centerPadding: '0',
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 3000,
                prevArrow: '<span class="fal fa-angle-left left" style="left:-10px;"></span>',
                nextArrow: '<span class="fal fa-angle-right right" style="right:-10px;"></span>',
                //asNavFor: '.gallery-items-nav'
            });



            jQuery('.gallery-items').attr('dir', 'ltr');


        });
    </script>
<?php } ?>