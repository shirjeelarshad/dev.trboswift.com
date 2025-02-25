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


if (THEME_KEY == "vt") {

    $_POST['pid'] = $post->ID;
    $GLOBALS['top-video'] = 1;
    _ppt_template('ajax-modal-video');

} elseif (!$CORE->USER("membership_hasaccess", "view_photos")) { ?>


    <div style=" width: 100%;    height: 100%;" class="bg-white y-middle border hide-mobile">

        <div class="p-4 text-center">

            <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access", "premiumpress"); ?></h4>

            <div class="mt-4 small"><?php echo __("Please upgrade your membership to view photos.", "premiumpress"); ?>
            </div>

            <?php if (!$userdata->ID) { ?>
                <a onclick="processLogin();" href="javascript:void(0);"
                    class="btn btn-system btn-md mt-4"><?php echo __("Login Now", "premiumpress"); ?></a>
            <?php } else { ?>

                <a onclick="processUpgrade();" href="javascript:void(0);"
                    class="btn btn-system btn-md mt-4"><?php echo __("Upgrade Now", "premiumpress"); ?></a>

            <?php } ?>
        </div>

    </div>


<?php } else { ?>

    <?php
    // GET FILES
    $files = $CORE->MEDIA("get_all_images", $post->ID);

    // Function to generate slick slider
    function generate_slick_slider($slider_id, $images)
    {
        if (empty($images)) {
            echo do_shortcode('[IMAGE link=0]');
            return;
        }
        ?>

 
        <div class="main">
            <?php if (count($images) > 1): ?>
                <div class="slider slider-for-<?php echo $slider_id; ?>">
                    <?php foreach ($images as $f): ?>
                        
                            <a href="<?php echo $f['src']; ?>" data-toggle="lightbox" data-type="image">
                                <img src="<?php echo $f['src']; ?>" class="" alt="<?php echo $f['name']; ?>"
                                    style="width:100%; height:100%; border-radius:15px">
                                <img src="<?php echo get_template_directory_uri(); ?>/framework/images/search.svg" style="position:absolute; right:20px; bottom:20px; width:50px; height:50px;" >
                            </a>
                        
                    <?php endforeach; ?>
                </div>
                <div class="slider slider-nav-<?php echo $slider_id; ?>">
                    <?php foreach ($images as $f): ?>
                            <img src="<?php echo $f['src']; ?>" alt="<?php echo $f['name']; ?>">
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <?php foreach ($images as $f): ?>
                  
                        <a href="<?php echo $f['src']; ?>" data-toggle="lightbox" data-type="image">
                            <img src="<?php echo $f['src']; ?>" class="" alt="<?php echo $f['name']; ?>"
                                style="width:100%; border-radius:15px">
                                <img src="<?php echo get_template_directory_uri(); ?>/framework/images/search.svg" style="position:absolute; right:20px; bottom:20px; width:50px; height:50px;" >
                        </a>
                   
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div id="bidding_message" style="
    position: absolute;
    left: 15px;
    bottom: 15px;
    z-index: 1;
"></div>
 <script src="<?php echo FRAMREWORK_URI . 'js/js.plugins-slickslider.js'; ?>"></script>

        <?php if (count($images) > 1): ?>
           
            <script>
                jQuery(document).ready(function ($) {
                    // Initialize slick sliders
                    $('.slider-for-<?php echo $slider_id; ?>').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        asNavFor: '.slider-nav-<?php echo $slider_id; ?>'
                    });

                    $('.slider-nav-<?php echo $slider_id; ?>').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        asNavFor: '.slider-for-<?php echo $slider_id; ?>',
                        dots: false,
                        focusOnSelect: true,
                        centerMode: true,
                        variableWidth: true,
                        prevArrow: '<span class="slick-prev"><i class="fa-solid fa-chevron-left"></i></span>',
                        nextArrow: '<span class="slick-next"><i class="fa-solid fa-chevron-right"></i></span>'
                    });
                    
                    
                
                });
            </script>

            <style>
            
    
                .slider-nav-<?php echo $slider_id; ?> {
                    padding-left: 50px;
                    padding-right: 50px;
                }

                @media (max-width:500px) {
                    .slider-for-<?php echo $slider_id; ?> {
                        height: 280px;
                    }

                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 60px;
                        height: 60px;
                    }
                }

                @media screen and (max-width: 900px) and (min-width: 501px) {
                    .slider-for-<?php echo $slider_id; ?> {
                        height: 400px;
                    }

                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 70px;
                        height: 70px;
                    }
                }

                @media screen and (max-width: 1200px) and (min-width: 901px) {
                    .slider-for-<?php echo $slider_id; ?> {
                        height: 351px;
                    }

                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 80px;
                        height: 80px;
                    }
                }

                @media (min-width:1201px) {
                    .slider-for-<?php echo $slider_id; ?> {
                        height: 464px;
                    }

                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 90px;
                        height: 90px;
                    }
                }

                .slider-nav-<?php echo $slider_id; ?> .slick-prev {
                    left: 0;
                    position: absolute;
                    top: 40px;
                    cursor: pointer;
                }

                .slider-nav-<?php echo $slider_id; ?> .slick-next {
                    right: 0;
                    position: absolute;
                    top: 40px;
                    cursor: pointer;
                }

                .slider-for-<?php echo $slider_id; ?> img {
                    border-radius: 15px;
                }

                .slider-nav-<?php echo $slider_id; ?> img {
                    width: 100px;
                    height: 100px;
                    margin-right: 10px;
                    border-radius: 10px;
                    cursor: pointer;
                }
            </style>
        <?php endif;
    }

    // Filter images by categories
    $exterior_files = array_filter($files, function ($file) {
        return strpos(strtolower($file['name']), 'exterior') !== false;
    });
    
    if (count($exterior_files) == 0){ $exterior_files = $files; }

    $interior_files = array_filter($files, function ($file) {
        return strpos(strtolower($file['name']), 'interior') !== false;
    });
    
    if (count($interior_files) == 0){ $interior_files = $files; }

    $mechanical_files = array_filter($files, function ($file) {
        return strpos(strtolower($file['name']), 'mechanical') !== false;
    });
    
    if (count($mechanical_files) == 0){ $mechanical_files = $files; }

    $others_files = array_filter($files, function ($file) {
        return strpos(strtolower($file['name']), 'exterior') === false &&
            strpos(strtolower($file['name']), 'interior') === false &&
            strpos(strtolower($file['name']), 'mechanical') === false;
    });
    
    if (count($others_files) == 0){ $others_files = $files; }
    
    ?>

    <div class="image-gallery-tabs owl-carousel owl-theme">
        <div class="image-gallery-tab">
            <a class="gallery-tab-link active" role="tab" data-toggle="tab" href="#all-images">ALL</a>
        </div>
        <div class="image-gallery-tab">
            <a class="gallery-tab-link" role="tab" data-toggle="tab" href="#exterior-images">EXTERIOR</a>
        </div>
        <div class="image-gallery-tab">
            <a class="gallery-tab-link" role="tab" data-toggle="tab" href="#interior-images">INTERIOR</a>
        </div>
        <div class="image-gallery-tab">
            <a class="gallery-tab-link" role="tab" data-toggle="tab" href="#mechanical-images">MECHANICAL</a>
        </div>
        <div class="image-gallery-tab">
            <a class="gallery-tab-link" role="tab" data-toggle="tab" href="#video-tab-content">VIDEO</a>
        </div>
        <div class="image-gallery-tab">
            <a class="gallery-tab-link" role="tab" data-toggle="tab" href="#others-images">OTHERS</a>
        </div>
    </div>

    <!-- Tab panes -->
    <div class="image-gallery-tab-content my-2">
        <div role="image-gallery-tab-panel" class="image-gallery-tab-panel fade show active" id="all-images">
            <?php generate_slick_slider('all', $files); ?>
        </div>
        <div role="image-gallery-tab-panel" class="image-gallery-tab-panel fade " id="exterior-images">
            <?php generate_slick_slider('exterior', $exterior_files); ?>
        </div>
        <div role="image-gallery-tab-panel" class="image-gallery-tab-panel fade" id="interior-images">
            <?php generate_slick_slider('interior', $interior_files); ?>
        </div>
        <div role="image-gallery-tab-panel" class="image-gallery-tab-panel fade" id="mechanical-images">
            <?php generate_slick_slider('mechanical', $mechanical_files); ?>
        </div>
        <div role="image-gallery-tab-panel" class="image-gallery-tab-panel fade" id="video-tab-content">
            <?php _ppt_template('framework/design/singlenew/blocks/top_video'); ?>
        </div>
        <div role="image-gallery-tab-panel" class="image-gallery-tab-panel fade" id="others-images">
            <?php generate_slick_slider('others', $others_files); ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function () {
            // Initialize Owl Carousel
            jQuery(".image-gallery-tabs").owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 5
                    },
                    1200: {
                        items: 6
                    }
                }
            });

            // Show the first tab content initially
            jQuery('.image-gallery-tab-content .image-gallery-tab-panel:first').addClass('show active');

            jQuery('.image-gallery-tab .gallery-tab-link').click(function (e) {
                e.preventDefault();
                var target = jQuery(this).attr('href');

                // Remove active class from all tabs
                jQuery('.image-gallery-tab-content .image-gallery-tab-panel').removeClass('show active');
                jQuery('.image-gallery-tab .gallery-tab-link').removeClass('show active');

                // Add active class to the clicked tab
                jQuery(target).addClass('show active');
                jQuery(this).addClass('show active');
            });
        });
    </script>

    <style>
        .image-gallery-tab-content>.image-gallery-tab-panel.active {
            display: block;
        }

        .image-gallery-tab-content>.image-gallery-tab-panel {
            display: none;
        }

        .image-gallery-tabs .gallery-tab-link.active {
            border-bottom: 1px solid #004225;
            color: #000;
        }

        .image-gallery-tabs .gallery-tab-link {
            font-size: 12px;
            color: #515151;
        }
        .image-gallery-tab{
        text-align:center;
        }
    </style>


<?php } ?>