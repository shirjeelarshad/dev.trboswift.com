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



// Function to generate slick slider
function generate_slick_slider($slider_id, $images) {
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
                        <img src="<?php echo $f['src']; ?>" class="img-fluid" alt="<?php echo $f['name']; ?>"
                             style="width:100%; border-radius:15px">
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="slider slider-nav-<?php echo $slider_id; ?>">
                <?php foreach ($images as $f): ?>
                    <div>
                        <img src="<?php echo $f['src']; ?>" alt="<?php echo $f['name']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="single-image">
                <a href="<?php echo $images[0]['src']; ?>" data-toggle="lightbox" data-type="image">
                    <img src="<?php echo $images[0]['src']; ?>" class="img-fluid" alt="<?php echo $images[0]['name']; ?>"
                         style="width:100%; border-radius:15px">
                </a>
            </div>
        <?php endif; ?>
    </div>

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
                .slider-nav-<?php echo $slider_id; ?> .slick-prev {
                    left: 0;
                    position: absolute;
                    cursor: pointer;
                }
                .slider-nav-<?php echo $slider_id; ?> .slick-next {
                    right: 0;
                    position: absolute;
                    cursor: pointer;
                }
                
                .slider-for-<?php echo $slider_id; ?> img {
                    border-radius: 15px;
                }
                
                .slider-nav-<?php echo $slider_id; ?> img {
                    
                    cursor: pointer;
                }
                
                @media (max-width:500px) {
                    .slider-for-<?php echo $slider_id; ?> img{
                        height: 280px !important;
                        margin-bottom:20px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 60px;
                        height: 60px;
                        
                    margin-right: 5px;
                    border-radius: 8px;
                    }
                    
                    .slider-nav-<?php echo $slider_id; ?> .slick-prev {
                    
                    top: 20px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> .slick-next {

                        top: 20px;
                    }
                }
                @media screen and (max-width: 900px) and (min-width: 501px) {
                    .slider-for-<?php echo $slider_id; ?> img{
                        height: 400px!important;
                        margin-bottom:20px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 70px;
                        height: 70px;
                        
                    margin-right: 6px;
                    border-radius: 6px;
                    }
                    
                     .slider-nav-<?php echo $slider_id; ?> .slick-prev {
                    
                    top: 25px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> .slick-next {

                        top: 25px;
                    }
                    
                }
                @media screen and (max-width: 1200px) and (min-width: 901px) {
                    .slider-for-<?php echo $slider_id; ?> img{
                        height: 351px!important;
                        margin-bottom:20px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> img {
                        width: 80px;
                        height: 80px;
                        
                    margin-right: 8px;
                    border-radius: 8px;
                    }
                    
                     .slider-nav-<?php echo $slider_id; ?> .slick-prev {
                    
                    top: 30px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> .slick-next {

                        top: 30px;
                    }
                }
                @media (min-width:1201px) {
                    .slider-for-<?php echo $slider_id; ?> img {
                        height: 464px!important;
                        margin-bottom:20px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> img {
                    width: 100px;
                    height: 100px;
                    margin-right: 10px;
                    border-radius: 10px;
                    
                }
                 .slider-nav-<?php echo $slider_id; ?> .slick-prev {
                    
                    top: 40px;
                    }
                    .slider-nav-<?php echo $slider_id; ?> .slick-next {

                        top: 40px;
                    }
                }
                
                
        </style>
    <?php endif;
}

// Filter images by categories
$files = $CORE->MEDIA("get_all_images", $post->ID);

$exterior_files = array_filter($files, function ($file) {
    return strpos(strtolower($file['name']), 'exterior') !== false;
});

$interior_files = array_filter($files, function ($file) {
    return strpos(strtolower($file['name']), 'interior') !== false;
});

$mechanical_files = array_filter($files, function ($file) {
    return strpos(strtolower($file['name']), 'mechanical') !== false;
});

$others_files = array_filter($files, function ($file) {
    return strpos(strtolower($file['name']), 'exterior') === false &&
           strpos(strtolower($file['name']), 'interior') === false &&
           strpos(strtolower($file['name']), 'mechanical') === false;
});
?>
<div class="image-gallery-tabs owl-carousel owl-theme">
    <div class="image-gallery-tab">
        <a class="nav-link active gallery-tab-link" role="tab" data-toggle="tab" data-category="all" href="#all-images">ALL</a>
    </div>
    <div class="image-gallery-tab">
        <a class="nav-link gallery-tab-link" role="tab" data-toggle="tab" data-category="exterior" href="#exterior-images">EXTERIOR</a>
    </div>
    
    <div class="image-gallery-tab">
        <a class="nav-link gallery-tab-link" role="tab" data-toggle="tab" data-category="interior" href="#interior-images">INTERIOR</a>
    </div>
    <div class="image-gallery-tab">
        <a class="nav-link gallery-tab-link" role="tab" data-toggle="tab" data-category="mechanical" href="#mechanical-images">MECHANICAL</a>
    </div>
    <div class="image-gallery-tab">
        <a class="nav-link gallery-tab-link" role="tab" data-toggle="tab" data-category="video" href="#video-tab-content">VIDEO</a>
    </div>
    <div class="image-gallery-tab">
        <a class="nav-link gallery-tab-link" role="tab" data-toggle="tab" data-category="others" href="#others-images">OTHERS</a>
    </div>
</div>

<!-- Tab panes -->
<div class="image-gallery-tab-content my-2">
    <div id="image-gallery-content">
        <?php generate_slick_slider('all', $files); ?>
    </div>
</div>

<script src="<?php echo FRAMREWORK_URI . 'js/js.plugins-slickslider.js'; ?>"></script>

<script>
jQuery(document).ready(function ($) {
    // Initialize Owl Carousel
    $(".image-gallery-tabs").owlCarousel({
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

    // Handle tab click
    $('.gallery-tab-link').click(function (e) {
        e.preventDefault();
    	var target = jQuery(this).attr('href');
        var category = $(this).data('category');
        var post_id = <?php echo $post->ID; ?>;
        var nonce = '<?php echo wp_create_nonce('filter_images_nonce'); ?>';

        // Remove active class from all tabs
        $('.gallery-tab-link').removeClass('active');
        $(this).addClass('active');
        
        if (target === '#video-tab-content') {
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
            	post_id: post_id,
                action: 'load_video_content'
            },
            success: function (response) {
                jQuery('#image-gallery-content').html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    	}else{

        // Make AJAX request to get filtered images
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'filter_images',
                post_id: post_id,
                category: category,
                nonce: nonce
            },
            dataType: 'json',
            success: function (response) {
                if (response.content) {
                    $('#image-gallery-content').html(response.content);
                } else {
                    $('#image-gallery-content').html('<p>No images found.</p>');
                }
            },
            error: function () {
                $('#image-gallery-content').html('<p>Error loading images.</p>');
            }
        });
        }
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
    .image-gallery-tab {
        text-align: center;
    }
</style>