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

$GLOBALS['global_design3'] = 1;

// GET CURRENT PRICE
$current_price = get_post_meta($post->ID, 'price_current', true);
if (!is_numeric($current_price)) {
  $current_price = 0;
}

$live_auction_start_date = get_post_meta($post->ID, 'live_auction_start_date', true);

$auction_end_date_time = get_post_meta($post->ID, 'listing_expiry_date', true);


$timestamp = strtotime($auction_end_date_time);
$formatted_date = date('F jS, g:ia', $timestamp); // Format to "March 2nd, 9:38pm"
$day_name = date('l', $timestamp); // Get the day name (e.g., Sunday)
$formatted_time = date('h:iA', $timestamp);


// Format the live_auction_start_date to match the current_time format
$formatted_live_auction_start_date = date('Y-m-d H:i:s', strtotime($live_auction_start_date));

$formatted_auction_end_date_time = date('Y-m-d H:i:s', strtotime($auction_end_date_time));

$auction_location = wp_get_post_terms($post->ID, location);

$current_time = date('Y-m-d H:i:s');

$vin_number = get_post_meta($post->ID, 'key72706', true);

$itemsincludedsale = get_post_meta($post->ID, 'itemsincludedsale', true);

$ownershipHistory = get_post_meta($post->ID, 'ownershipHistory', true);

$serviceHistory = get_post_meta($post->ID, 'serviceHistory', true);

$modifications = get_post_meta($post->ID, 'modifications', true);

$vehicleFlaws = get_post_meta($post->ID, 'vehicle-flaws', true);

$bid_increments = wp_get_post_terms($post->ID, 'bid-increments');

if (!is_wp_error($bid_increments) && !empty($bid_increments)) {
  foreach ($bid_increments as $bid_increment) {
    $dynamicIncrement = $bid_increment->name;
  }
} else {
  $dynamicIncrement = 2000000;
}

$sellername = get_post_meta($post->ID, 'sellername', true);

?>

<style>
  .ai-border-radius {
    border-radius: 16px;
  }

  .process-radius {
    border-radius: 16px;
    border: 3px solid #BF9D3E;
  }

  .sticky-bottom {
    position: fixed;
    bottom: 0px;
    left: 0px;
    right: 0px;
    z-index: 9999;
  }

  .f_size12 {
    font-size: 12px;
  }

  .f_size6 {
    font-size: 6px;
  }

  .gray-text {
    color: #9A9EA7;
  }

  /* Styles for Desk */
  @media screen and (min-width: 992px) {
  
  .main-single-container{padding-top: 50px;}
  
  .custom-icon-circle{
     width: 50px;
    height: 50px;
    align-self: center;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .top-right-icon-circle{
  width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

    .content-tabs .nav-link {
      font-size: 14px;
    }

    .single-vehicle-auction {

      padding-top: 75px;

    }

    .topHeaderDesk {
      display: block;
    }

    .header-auction-title {
      box-shadow: 0 1px 4px rgba(0, 0, 0, .25);
    }

    .gallery-items img,
    .slick-current.slick-active img {
      object-fit: cover;

    }


    .photo-videoblock .card {

      border: 0px solid rgba(0, 0, 0, .125) !important;
      border-radius: 0px !important;
      height: 250px !important;
    }


    .images-modal-item {

      max-width: 80%;
    }

  }

  /* Styles for mobile */
  @media screen and (max-width: 992px) {
  
  .main-single-container{padding-top: 80px;}
  
   .custom-icon-circle{
     width: 30px;
    height: 30px;
    align-self: center;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .top-right-icon-circle{
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
    .single-vehicle-auction {

      padding-top: 70px;

    }

    .photo-videoblock {
      display: flex;
      flex-direction: row;
    }

    .photo-videoblock .card {
      border: 0px solid rgba(0, 0, 0, .125) !important;
      border-radius: 0px !important;
      height: 200px !important;
      width: 100%;
    }

    .col-xs-12 {
      flex: 0 0 100%;
      max-width: 100%;
    }

    .col-xs {
      flex: 0 0 50%;
      max-width: 50%;

    }

    .topHeaderDesk {
      display: none;
    }

    .radiusx {
      margin-top: 10px;
    }

    .extra-modal-container {
      margin: 20px;
    }
  }


  /* Styles topHeaderMobile for mobile */
  .topHeaderMobile {
    display: none;
  }

  .sticky-top-mobile {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    z-index: 9999;

  }


  @media screen and (max-width: 992px) {
    .topHeaderMobile {
      display: flex;
      padding: 15px;

    }



    .mobile-timeLeft-bid {
      background: #212228;
      color: white;
      display: flex;
      justify-content: space-around;
      width: 60%;
      border-radius: 5px;
      margin-right: 10px;
      align-items: center;
      height: 38px;

    }

    .mobile-bids {
      width: 40%;
      background: #efa503;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 5px;
      border-radius: 5px;
      height: 38px;
    }

    .mobile-bid {

      background: #efa503;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;

      border-radius: 5px;
      height: 38px;
    }


    .mobile-buy {
      width: 50%;
      background: #000;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;

      border-radius: 5px;
      height: 38px;
    }

    .mobile-bid-button {
      width: 100%;
      background: #efa503;
      color: white;
      display: flex;
      align-items: center;
      border-radius: 5px;
      height: 38px;

    }

  }



  @media screen and (min-width: 992px) {
    .contentDesktop {
      display: block;
    }



  }

  /* Styles for mobile */
  @media screen and (max-width: 992px) {

    .text-mobile-9 {
      font-size: 9px !important;
    }


    .contentDesktop {
      display: none;
    }
  }


  .contentMobileImage {
    display: none;
  }


  #vehicle-details .col-6{
    padding:0px;
    }
    
  /* Styles for mobile */
  @media screen and (max-width: 992px) {
    .content-tabs .nav-link {
      font-size: 12px;
    }
    
  

    .contentMobileImage {
      display: block;
      margin: 10px;
    }

    .fieldtype-taxonomy,
    .fieldtype-input {
      display: flex;
      border-bottom: 0.5px solid #eee;
      margin-bottom: 4px !important;
      padding: 5px;
      font-size: 12px;
    }

    .fieldtype-taxonomy .title,
    .fieldtype-input .title {
      width: 30%;
      margin-bottom: 0px !important;
      font-size: 12px;

    }

    .fieldtype-taxonomy .title .mb-3,
    .fieldtype-input .title .mb-3 {

      margin-bottom: 0px !important;
    }
  }



  .gallery-items .img-fluid {
    /*   border-radius: 10px; */
  }


  .msg-modal-container,
  .video-modal-container,
  .images-modal-container {
    padding: 0;
    background: #353535 !important;
    overflow: hidden;
    border-radius: 10px;
  }

  .msg-modal-container .card {
    background-color: #0000 !important;

  }





  .ppt_shortcode_fields.style-1 {

    padding: 10px;
  }



  .gallery-items .slick-slide {
    padding: 0 0px;
  }

  .slash {
    font-size: 35px;
    /* Adjust the font size as needed */
    margin: 0 10px;
    /* Adjust the spacing around the slash */
    color: white;
  }



  .x-modal-wrap {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 1000;
    display: none;
    overflow: auto;
    -webkit-transform: translate3d(0, 0, 0);
  }
  
</style>






<section class="main-single-container" style="background:#f4f4f4;">
  <div class="container">


    <!-- Top image and bidding section Block start -->
    <div class="col-12 pr-0 pl-0 mt-5 ">

      <div class="p-2 p-md-0">


            <div class="d-flex d-md-none p-1 p-md-3 row ml-0 mr-0 mb-2"
              style="border: 1px solid #EACD7A; border-radius:8px; background:#BC9F4C4D; border-image-source: linear-gradient(277.91deg, #BC9F4C 47.11%, #EACD7A 76.64%);">
              <span style="width:60px; height:60px;" class="d-flex justify-content-center align-items-center bg-white text-primary rounded-circle p-1 p-md-3 mr-2">
              <i class="far fa-clock" style="font-size:30px;"></i></span>

              <div
                class="small ml-md-2 d-flex flex-column align-items-start justify-content-center text-dark">
                <span class="small text-primary "><?php echo __("Auction Ending", "premiumpress"); ?></span>
                <?php echo $formatted_date; ?>

              </div>
            </div>

        <div class="row m-0 align-items-center justify-content-between">


          <h6 itemprop="name" class="h6 text-black">
            <?php echo do_shortcode('[TITLE]'); ?>
          </h6>


          <a href="<?php echo home_url(); ?>/what-is-turbobid/">
            <i class="fa-solid fa-circle-question text-dark"></i> </a>


        </div>



      </div>

      <div class="px-0 mt-3 row">
        <!-- Gallery Block start -->
        <div class="col-lg-6">
          <?php _ppt_template('framework/design/singlenew/parts/_new_single_slick_slider'); ?>
        </div><!-- Gallery Block Close -->

        <!-- Right side Block start -->
        <div class="col-lg-6  mt-3 mt-md-0">
          <div class="row justify-content-between align-items-center m-0">
            <span class=" buybox-price-num  pricetag h4  <?php echo $CORE->GEO("price_formatting", array()); ?>"
              style="font-weight:600;">00</span>
            <div class="row align-items-center justify-content-end">

              <div class="mr-2">
                <?php if (in_array(_ppt(array('user', 'favs')), array("", "1"))) { ?>

                  <?php if (!$userdata->ID) { ?>
                    <a href="javascript:void(0);" onclick="processLogin();"
                      class="top-right-icon-circle bg-white text-secondary rounded-circle"> <i class="fal fa-heart"></i></a>
                  <?php } else { ?>
                    <div class="bg-white rounded-pill text-primary">
                      <?php echo do_shortcode('[FAVS  icon_name="class="fal fa-heart " text=1 icon=1]'); ?>
                    </div>
                  <?php } ?>

                <?php } ?>

              </div>
              <a href="#" id="bookmarkButton" class="top-right-icon-circle bg-white text-secondary rounded-circle mr-2"><i
                  class="fas fa-bookmark"></i></a>
              <script>
                document.getElementById('bookmarkButton').addEventListener('click', function () {
                  var bookmarkURL = window.location.href;
                  var bookmarkTitle = document.title;

                  if (window.sidebar && window.sidebar.addPanel) { // Firefox <=22
                    window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
                  } else if (window.external && ('AddFavorite' in window.external)) { // IE Favorites
                    window.external.AddFavorite(bookmarkURL, bookmarkTitle);
                  } else if (window.opera && window.print) { // Opera <=12
                    this.title = bookmarkTitle;
                    return true;
                  } else { // Other browsers (mainly WebKit - Chrome/Safari)
                    alert('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D to bookmark this page.');
                  }
                });

              </script>
              <div class="dropdown">
                <a href="javascript:void(0);" class="top-right-icon-circle bg-white text-secondary rounded-circle"
                  id="shareDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-share-alt "></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="shareDropdown">
                  <a class="dropdown-item" href="#" onclick="shareOnFacebook()">Facebook</a>
                  <a class="dropdown-item" href="#" onclick="shareOnTwitter()">Twitter</a>
                  <a class="dropdown-item" href="#" onclick="shareOnWhatsApp()">WhatsApp</a>
                </div>
                <script>
                  function shareOnFacebook() {
                    // Get the current post URL
                    var postUrl = window.location.href;
                    // Share on Facebook
                    var facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(postUrl);
                    // Open Facebook share dialog
                    window.open(facebookUrl, "_blank");
                  }

                  function shareOnTwitter() {
                    // Get the current post URL
                    var postUrl = window.location.href;
                    // Share on Twitter
                    var twitterUrl = "https://twitter.com/intent/tweet?url=" + encodeURIComponent(postUrl);
                    // Open Twitter share dialog
                    window.open(twitterUrl, "_blank");
                  }

                  function shareOnWhatsApp() {
                    // Get the current post URL
                    var postUrl = window.location.href;

                    // Construct the WhatsApp share URL
                    var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(postUrl);

                    // Open WhatsApp share dialog
                    window.open(whatsappUrl, "_blank");
                  }
                </script>
              </div>

            </div><!-- Second Block Close -->
          </div><!-- Price row Block Close -->

          <hr />
          <!-- First basic info row Block start -->
          <div class="d-flex align-items-center my-2" style="overflow-x:scroll;">
            <span class="badge rounded-pill py-2 px-3 mr-2" style="background: #e5e9f4; color:#3A4980;"><img
                src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/Frame.png" class="mr-1" width:19px; />
              <?php echo get_comments_number($post_id); ?> Comments</span>

            <span class="badge rounded-pill py-2 px-3 mr-2" style="background: #1BBB6B3D; color:#1BBB6B; "><img
                src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/Group-107.png" class="mr-1"
                width:19px; /><?php echo do_shortcode('[BIDS]'); ?> Bid Active</span>

            <span class="badge rounded-pill py-2 px-3 mr-2" style="background: #FBF3EA; color:#444444;"><i
                class="fa-regular fa-eye mr-1"></i><?php echo do_shortcode('[HITS]'); ?> Views</span>

          </div><!-- First basic info row Block start -->

          <!-- Auction and basic info row Block start -->
          <div class="d-flex align-items-center m-0">
            <span class=" font-weight-bold mr-2 small" style="color:#3E9242;"><?php echo __("Lot Number", "premiumpress"); ?>:
              #<?php echo $post->ID; ?></span>

            <span class="gray-text small"><?php $kilomiter = get_post_meta($post->ID, 'key1', true);
            echo $kilomiter; ?> KM </span><?php if ($kilomiter) { ?><i
                class="gray-text f_size6 p-2 fas fa-circle"></i><?php } ?>

            <span class="gray-text small"><?php
            $auction_color = wp_get_post_terms($post->ID, color);
            $color_term_link = get_term_link($auction_color[0]);

            if (!is_wp_error($color_term_link)) {
              echo '<a class="gray-text" href="' . esc_url($color_term_link) . '">' . esc_html($auction_color[0]->name) . '</a>';
            } ?> </span><?php if ($auction_color) { ?><i class="gray-text f_size6 p-2 fas fa-circle"></i><?php } ?>

            <span class="gray-text small"><?php $drive_type = get_post_meta($post->ID, 'key32996', true);
            echo $drive_type; ?>
            </span>

          </div><!-- Auction and basic info row Block Close -->

          <hr />

          <!-- Auction and minimum row Block start -->
          <div class="row m-0 pb-4">

            <div class=" col p-1 p-md-3 row ml-0 mr-1 mr-md-2"
              style="border: 1px solid #EACD7A; border-radius:8px; background:#BC9F4C4D; border-image-source: linear-gradient(277.91deg, #BC9F4C 47.11%, #EACD7A 76.64%);">
              <span class="custom-icon-circle bg-white text-primary rounded-circle p-1 p-md-3 mr-2">
              <i class="far fa-clock"></i></span>

              <div
                class="small ml-md-2 d-flex flex-column align-items-start justify-content-center text-dark">
                <span class="small text-primary "><?php echo __("Auction Ending", "premiumpress"); ?></span>
                <?php echo $formatted_date; ?>

              </div>
            </div>

            <div class="col p-1 p-md-3 row ml-1 mr-0 ml-md-2"
              style="border: 1px solid #EACD7A; border-radius:8px; background:#BC9F4C4D; border-image-source: linear-gradient(277.91deg, #BC9F4C 47.11%, #EACD7A 76.64%);">
               <span class="custom-icon-circle bg-white text-primary rounded-circle p-1 p-md-3 mr-2">
              <i class="fa-solid fa-chart-line "></i></span>

              <div
                class="small ml-md-2 d-flex flex-column align-items-start justify-content-center text-dark ">
                <span class="small text-primary "><?php echo __("Minimum Increment", "premiumpress"); ?></span>
                <span class="text-dark <?php echo $CORE->GEO("price_formatting", array()); ?>">
                  <?php echo $dynamicIncrement; ?>
                </span>

              </div>
            </div>

          </div><!-- Auction and minimum row Block Close -->

          <?php _ppt_template('framework/design/singlenew/parts/_auction_buy'); ?>


          <div class=" py-2">
            <h4 class="text-dark mb-2 font-weight-bold "><?php echo __("Turbo Assistant", "premiumpress"); ?>
            </h4>

          </div>


          <div class="ai-border-radius p-3 mb-3"
            style="background: #E3DBC2; border: 1px solid; border-image-source: linear-gradient(93.25deg, #BF9B3E 2.69%, #FFE092 102.12%);">
            <div class="row m-0"><i class="fas fa-robot pr-2 text-primary"></i>
              <h6>Ask your questions</h6>
            </div>

            <div class="d-flex flex-wrap justify-content-evenly m-0 py-2">
              <span id="auction-process" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="Auction Process">Auction Process</span>
              <span id="auction-fees" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="TurboBid Fees">TurboBid Fees</span>
              <span id="financing-ai" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="Financing">Financing</span>
              <span id="uvip" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="What is a UVIP?">What is a UVIP?</span>
              <span id="extended-warranty" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="Extended Warranty">Extended Warranty</span>
              <span id="escrow-services" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="Escrow Services">Escrow Services</span>
                <span id="purchase-additional-car-key" class="ai-button py-1 px-2 mr-2 small rounded bg-white mb-2"
                data-title="Purchase Additional Car Key?">Purchase Additional Car Key?</span>
            </div>
          </div>


          

          <p class="text-primary small font-weight-bold my-3">After securing a vehicle through bidding,
            explore warranty, insurance, and add-on options post-closing. Use TurboBid MyAccount for a streamlined
            payment, transfer, and bill of sale process.</p>


        </div> <!-- Top gallery right side Block Close -->




      </div><!-- Top gallery Block Close -->


      <div class="bg-white p-4 my-4" style=" border-radius:20px;">

        <?php
        _ppt_template('framework/design/singlenew/blocks/features');
        ?>




      </div>
    </div><!-- Top image and bidding section Block Close -->

    <!-- Middle section start -->
    <div class="row m-0">

      <div class="col-md-9 p-0">



        <div class="content-tabs owl-carousel owl-theme owl-loaded owl-drag">
          <div class="owl-stage-outer">
            <div class="owl-stage"
              style="transform: translate3d(0px, 0px, 0px); transition: all 0.25s ease 0s; width: 3623px;">
              <div class="owl-item"><a class="nav-link active text-secondary font-weight-bold" role="tab"
                  data-toggle="vehicle-details" href="#vehicle-details">Vehicle Details</a></div>
              <div class="owl-item"><a class="nav-link text-secondary font-weight-bold" href="#vehicle-description"
                  role="tab" data-toggle="vehicle-description">Description</a></div>
              <div class="owl-item"><a class="nav-link text-secondary font-weight-bold d-flex" href="#warranty-details"
                  role="tab" data-toggle="warranty-details">Warranty Details</a></div>
              <div class="owl-item"><a class="nav-link text-secondary font-weight-bold d-flex"
                  href="#turbobid-checklist" role="tab" data-toggle="turbobid-checklist">Turbobid Checklist<img
                    src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/TurboBid_DD1.png" alt="TurboBid"
                    style="width=30ps; height:20px;" /></a></div>

            </div>
          </div>
        </div>

        <!-- Tab panes -->
        <div class="tab-content my-2">
          <div role="tabpanel" class="tab-pane fade show active" id="vehicle-details">

            <div>

              <?php if ($vin_number) { ?>
                <span class="btn btn-light" style="color:#9C9C9C;">VIN: <span
                    class="font-weight-bold text-black"><?php echo $vin_number; ?></span></span>
              <?php } ?>

              <?php
              $post_status = get_post_status();

              _ppt_template('framework/design/singlenew/blocks/customfields');

              ?>

            </div>
          </div>
          <div role="tabpanel" class="tab-pane fade small" id="vehicle-description">
            <h5 class="text-secondary mb-2 font-weight-bold "><?php echo __("Description", "premiumpress"); ?></h5>
            <?php


            _ppt_template('framework/design/singlenew/parts/_global_content');

            ?>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="warranty-details">
            <div class=" py-2">
              <h5 class="text-secondary mb-2 font-weight-bold "><?php echo __("Warranty Details", "premiumpress"); ?>
              </h5>

              <?php $warranty = get_post_meta($post->ID, 'warranty', true);
              if ($warranty || $warranty != '') { ?>
                <div class="col-12 row justify-content-start  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="small font-weight-bold py-1 px-2 mr-2 small rounded bg-light mb-2">
                    <?php echo __("Factory Warranty", "premiumpress"); ?>
                  </div>
                  <div class="py-1 px-2 mr-2 small rounded bg-light mb-2">
                    <?php echo $warranty; ?>
                  </div>
                </div>
              <?php } ?>

              <?php $protectionPlan = get_post_meta($post->ID, 'protection-plan', true);
              if ($protectionPlan || $protectionPlan != '') { ?>
                <div class="col-12 row justify-content-start  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="small font-weight-bold py-1 px-2 mr-2 small rounded bg-light mb-2 ">
                    <?php echo __("Extended Protection Plan Monthly", "premiumpress"); ?>
                  </div>
                  <div class="py-1 px-2 mr-2 small rounded bg-light mb-2">
                    <?php echo $protectionPlan; ?>
                  </div>
                </div>
              <?php } ?>

            </div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="turbobid-checklist">

            <div>


              <h5 class="text-secondary mb-2 font-weight-bold "><?php echo __("TurboBid Checklist", "premiumpress"); ?>
              </h5>



              <div class="col-12 row justify-content-between mt-3 mb-3 mb-3 ml-0 mr-0 pl-0 pr-0">
                <div class="col-8 mb-3 ml-0  pl-0 ">
                  <span
                    class="font-weight-bold mb-3"><?php echo __("TURBO CONDITION REPORT", "premiumpress"); ?></span><br>
                  <span
                    class="text small "><?php echo __("Discover our AI-driven vehicle inspection report, pinpointing damages across 81 different parts of the vehicle, Our thorough inspection covers all areas, detecting over 19 types of damage.", "premiumpress"); ?></span>

                </div>
                <div class="col-4 mb-3 ml-0 mr-0 pl-0 pr-0">
                  <a href="javascript:void(0);" <?php if($userdata->ID) { ?> onClick="processConditionReportPop();"
                    <?php } else { ?> onClick="processLogin();" <?php } ?>> <img style="width: 100px;margin-left: -36px;" src="<?php echo get_template_directory_uri(); ?>/framework/images/TurboBid_DD-1.svg" alt="TurboBid"
                    />
                  </a>
                </div>
              </div>

              <div class="col-12 row justify-content-between mb-3 mb-3 ml-0 mr-0 pl-0 pr-0">
                <div class="col-8 mb-3 ml-0 pl-0 ">
                  <span class="font-weight-bold mb-3"><?php echo __("CARFAX", "premiumpress"); ?></span>
                </div>
                <div class="col-4 mb-3 ml-0 mr-0 pl-0 pr-0">
                  <a href="javascript:void(0);" <?php if($userdata->ID){ ?> onClick="processCarfaxPop();" <?php }else{ ?>  onclick="processLogin()" <?php } ?> > <img class="history-icon-image"
                      src="<?php echo home_url(); ?>/wp-content/uploads/2023/06/image-3.png" /> </a>
                </div>
              </div>

              <div class="col-12 row justify-content-between  mb-3 ml-0 mr-0 pl-0 pr-0 pb-2"
                style="border-bottom:2px solid #BF9D3E">
                <div class="col-8 ml-0 pl-0 ">
                  <span
                    class="font-weight-bold mb-3"><?php echo __("USED VEHICLE INFO PACKAGE", "premiumpress"); ?></span>
                </div>
                <div class="col-4 ml-0 mr-0 pl-0 pr-0">

                  <?php


                  $term_link = get_term_link($auction_location[0]);

                  if (!is_wp_error($term_link)) {
                    // "' . esc_url($term_link) . '"  esc_html($auction_location[0]->name)
                    ?>
                    <a class="text-primary" href="<?php echo $term_link; ?>" target="blank"><img
                        class="history-icon-image"
                        src="<?php echo home_url(); ?>/wp-content/uploads/2024/02/imgbin_barrie-government-of-ontario-logo-organization-png.png" /></a>
                    <?php
                  } else { ?>
                    <img class="history-icon-image"
                      src="<?php echo home_url(); ?>/wp-content/uploads/2024/02/imgbin_barrie-government-of-ontario-logo-organization-png.png" />

                    <?php
                  }

                  ?>
                </div>
              </div>

              <?php $sellertype = get_post_meta($post->ID, 'sellertype', true);
              if ($sellertype || $sellertype != '') { ?>
                <div class="col-12 row justify-content-start  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="small font-weight-bold btn btn-light btn-sm">
                    <?php echo __("SELLER TYPE", "premiumpress"); ?>
                  </div>
                  <div class="btn btn-light small ml-2 btn-sm">
                    <?php echo $sellertype; ?>
                  </div>
                </div>
              <?php } ?>

              <?php 
              if ($sellername || $sellername != '') { ?>
                <div class="col-12 row justify-content-start  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="small font-weight-bold btn btn-light btn-sm">
                    <?php echo __("SELLER NAME", "premiumpress"); ?>
                  </div>
                  <div class="btn btn-light small ml-2 btn-sm">
                    <?php echo $sellername; ?>
                  </div>
                </div>
              <?php } ?>

              <?php $ownersno = get_post_meta($post->ID, 'ownersno', true);
              if ($ownersno || $ownersno != '') { ?>
                <div class="col-12 row justify-content-between  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="col-8 ml-0 pl-0 ">
                    <span
                      class="small font-weight-bold text-primary"><?php echo __("Number of owners ", "premiumpress"); ?></span>
                  </div>
                  <div class="col-4 ml-0 mr-0 pl-0 pr-0 small">
                    <?php echo $ownersno; ?>
                  </div>
                </div>
              <?php } ?>

              <?php $anyLiens = get_post_meta($post->ID, 'anyLiens', true);
              if ($anyLiens || $anyLiens != '') { ?>
                <div class="col-12 row justify-content-between  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="col-8 ml-0 pl-0 ">
                    <span
                      class="small font-weight-bold text-primary"><?php echo __("Any Liens? ", "premiumpress"); ?></span>
                  </div>
                  <div class="col-4 ml-0 mr-0 pl-0 pr-0 small">
                    <?php echo $anyLiens; ?>
                  </div>
                </div>
              <?php } ?>

              <?php $anyaccidents = get_post_meta($post->ID, 'anyaccidents', true);
              if ($anyaccidents || $anyaccidents != '') { ?>
                <div class="col-12 row justify-content-between  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="col-8 ml-0 pl-0 ">
                    <span
                      class="small font-weight-bold text-primary"><?php echo __("Any accidents on the vehicle ? ", "premiumpress"); ?></span>
                  </div>
                  <div class="col-4 ml-0 mr-0 pl-0 pr-0 small">
                    <?php echo $anyaccidents; ?>
                  </div>
                </div>
              <?php } ?>

              <?php $vehiclecomesafetied = get_post_meta($post->ID, 'vehiclecomesafetied', true);
              if ($vehiclecomesafetied || $vehiclecomesafetied != '') { ?>
                <div class="col-12 row justify-content-between  mb-1 ml-0 mr-0 pl-0 pr-0 pb-1">
                  <div class="col-8 ml-0 pl-0 ">
                    <span
                      class="small font-weight-bold text-primary"><?php echo __("Does the vehicle come safetied? ", "premiumpress"); ?></span>
                  </div>
                  <div class="col-4 ml-0 mr-0 pl-0 pr-0 small">
                    <?php echo $vehiclecomesafetied; ?>
                  </div>
                </div>
              <?php } ?>
              
		
		
              <div class="col-12">

                <div class="radiusx ">

                  <div>
                    <div class="pb-2 mb-2 bidfieldrow small">

                      <div class="text">

                      </div>

                    </div>


                  </div>
                </div>
              </div>

              <div class="contentDesktop mt-3">


              </div>

            </div>

          </div>

        </div>


        <style>
          .content-tabs .nav-link.active {
            border-bottom: 3px solid #004225;
          }

          .content-tabs .owl-stage {
            border-bottom: 1px solid #DADADA;
          }
        </style>
        <script>
          jQuery(document).ready(function () {
            // Initialize Owl Carousel
            jQuery(".content-tabs").owlCarousel({
              loop: false,
              margin: 10,
              nav: false,
              dots: false,
              responsive: {
                0: {
                  items: 2
                },
                600: {
                  items: 2
                },
                1000: {
                  items: 4
                },
                1200: {
                  items: 4
                }
              }
            });

            // Show the first tab content initially
            jQuery('.tab-content .tab-pane:first').addClass('show active');

            jQuery('.owl-item .nav-link').click(function (e) {
              e.preventDefault();
              var target = jQuery(this).attr('href');

              // Remove active class from all tabs
              jQuery('.tab-content .tab-pane').removeClass('show active');
              jQuery('.nav-link').removeClass('active');

              // Add active class to the clicked tab
              jQuery(target).addClass('show active');
              jQuery(this).addClass('active');
            });
          });
        </script>

  <div class="col-12  my-3 mx-0 p-4 row justify-content-between align-items-center" style="background: linear-gradient(90deg, rgba(236,247,237,1) 0%, rgba(238,244,226,1) 100%); border:1px solid #fff; border-radius:12px;">
          <div class="col-8 col-md-10 row justify-content-start align-items-center"><img src="<?php echo home_url(); ?>/wp-content/themes/AT10/framework/images/group-1000009785@2x.png" style="width:50px;transform: rotate(298deg);" ><h5 class="h5 mx-3 font-weight-bold">TurboBid Transport </h5><span>Get an instant quote for all Canada wide transport</span> </div> <div class="col-4 col-md-2 p-0 text-right"> <button <?php if($userdata->ID){ ?> onclick="turboBidTransportPop()" <?php }else{ ?>  onclick="processLogin()" <?php } ?> type="button" class="btn rounded-pill py-2 px-3 text-white" style="background:#3B634C;">Get Quote</button></div>
          
          </div>

        <div class="row m-0">
          <div class="col-md-6 p-0">

            <h5 class="text-secondary mb-2 font-weight-bold "><?php echo __("Auction Summary", "premiumpress"); ?>
            </h5>

            <div class="col-12 p-0 d-flex align-items-center my-3">
              <div
                class="col p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Auction Ending", "premiumpress"); ?></span>
                <?php echo $formatted_date; ?>

              </div>

              <div
                class="col p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Auction views:", "premiumpress"); ?></span>
                <?php echo do_shortcode('[HITS]'); ?>

              </div>

              <div
                class="col p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Favorited:", "premiumpress"); ?></span>
                454

              </div>

            </div>


            <div class="col-12 p-0 d-flex align-items-center my-3">
              <div
                class="col p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Location", "premiumpress"); ?></span>
                <?php echo $auction_location[0]->name; ?>

              </div>

              <div
                class="col p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Seller", "premiumpress"); ?></span>
                <?php echo $sellername; ?>

              </div>

              <div
                class="col p-0 small d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
                <span class="small" style="color:#444444;"><?php echo __("Time Left:", "premiumpress"); ?></span>
                <?php echo do_shortcode("[TIMELEFT]"); ?>

              </div>

            </div>

            <div class="my-4 d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
              <span class="small" style="color:#444444;"><?php echo __("Highest bid ↑", "premiumpress"); ?></span>
              <span class=" buybox-price-num  pricetag h6  <?php echo $CORE->GEO("price_formatting", array()); ?>"
                style="font-weight:600;">00</span>

            </div>

            <?php _ppt_template('framework/design/singlenew/parts/_auction_buy'); ?>





          </div><!-- Left secsion close -->

          <div class="col-md-6">
            <span class="h5 font-weight-bold text-uppercase">Bid History</span>

            <div
              class="bg-white rounded px-3 py-3 my-2 d-flex flex-column align-items-start justify-content-center text-dark font-weight-bold ">
              <span class="small" style="color:#444444;"><?php echo __("Bid placed by:", "premiumpress"); ?></span>
              <div id="bidding_history_data"></div>
            </div>

          </div>
        </div>



        <div class="comment-main-section my-4">

          <div>

            <h5 class="text-secondary mb-2 font-weight-bold ">
              <?php echo __("Comments & Bids", "premiumpress"); ?>
            </h5>
            <?php

            if (have_posts()):
              while (have_posts()):
                the_post(); ?>
                <div>
                  <div>
                    <div>
                      <?php if (comments_open()) { ?>
                        <div>
                          <?php

                          if ($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE')) {
                          } else {

                            // BUILD COMMENT BLOCK
                            ob_start();
                            try {
                              echo '<div id="auction-comments">';
                              comments_template();  // GET THE DEFAULT WORDPRESS TEMPLATE FOR COMMENTS
                              echo '</div>';
                            } catch (Exception $e) {
                              ob_end_clean();
                              throw $e;
                            }
                          }

                          if ($userdata->ID) {

                            ?>


                            <div id="comment-block">
                              <form id="newcomment" class="d-block d-md-flex align-items-center"
                                action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                                <textarea id="comment" name="comment" style="background:transparent; height:37px;"
                                  aria-required="true" class="my-4 rounded-pill col-12 col-md-10"
                                  placeholder="Add a comment here..."></textarea>
                                <div class="btn-toolbar col-12 col-md-2">
                                  <button type="button" class="btn btn-secondary rounded-pill btn-sm col" onclick="postComment()">
                                    <?php echo __("Comment", "premiumpress"); ?></button>
                                </div>
                                <input type="hidden" name="action" value="post_comment">
                                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                              </form>
                            </div>

                            <?php

                          }

                          /*

                              3. DISPLAY EVERYTHING

                          */

                          if (!$userdata->ID) {

                            ?>
                            <form id="newcomment" class="d-flex align-items-center"
                              action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                              <textarea id="comment" name="comment" style="background:transparent; height:37px;"
                                aria-required="true" class="my-4 rounded-pill col-12 col-md-10"
                                placeholder="To write a comment, please sign in to your account"></textarea>
                              <div class="btn-toolbar col-12 col-md-2">
                                <button type="button" class="btn btn-secondary rounded-pill btn-sm col"
                                  onclick="processRegister();">
                                  <?php echo __("Comment", "premiumpress"); ?></button>
                              </div>
                            </form>
                          <?php } ?>

                        </div>

                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php endwhile;
            endif; ?>

          </div>

          <script>
            function postComment() {
              var comment = document.getElementById('comment').value;
              var postId = <?php echo get_the_ID(); ?>; // Get the current post ID

              // Make AJAX request to post the comment
              jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                  action: 'post_comment',
                  comment: comment,
                  post_id: postId
                },
                success: function (response) {
                  jQuery('#comment').val('');
                  // Update the comments section with the new comment
                  jQuery('#auction-comments').load(location.href + ' #auction-comments');
                  jQuery('#comment-block').load(location.href + ' #comment-block');
                },
                error: function (xhr, status, error) {
                  console.error(error);
                }
              });
            }




            function showReplyForm(commentId, authorName) {
              // Generate the title for the reply form
              var replyTitle = '<?php echo __("Reply to", "premiumpress"); ?> ' + authorName + ' :';

              // Create the HTML for the reply form
              var replyFormHtml = '<h6>' + replyTitle + '</h6>' +
                '<form id="reply-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">' +
                '<textarea id="reply-comment" name="comment" style="min-height:100px;" aria-required="true" class="form-control my-4" placeholder="<?php echo __("Add a Reply...", "premiumpress"); ?>"></textarea>' +
                '<input id="comment_parent" type="hidden" name="comment_parent" value="' + commentId + '">' +
                '<input type="hidden" name="action" value="post_reply">' +
                '<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">' +
                '<div class="d-flex btn-toolbar mt-4">' +
                '<button type="button" class="btn btn-secondary btn-sm" onclick="postReply()"><?php echo __("Add Reply", "premiumpress"); ?></button>' +
                '<button type="button" class="ml-2 btn btn-primary btn-sm" onclick="replyCancel()"><?php echo __("Cancel", "premiumpress"); ?></button>' +
                '</div>' +
                '</form>';

              // Display the reply form in the designated section
              jQuery('#comment-block').html(replyFormHtml);



              // Get the offset top position of the comment
              var commentOffsetTop = jQuery('#comment-block').offset().top;

              // Calculate the middle of the viewport
              var middleOfViewport = jQuery(window).scrollTop() + (jQuery(window).height() / 2);

              // Calculate the new scroll position to center the comment
              var newScrollPosition = commentOffsetTop - (jQuery(window).height() / 2);

              // Animate scrolling to the new position
              jQuery('html, body').animate({
                scrollTop: newScrollPosition
              }, 500);

            }



            function postReply() {
              // Get the comment content and parent comment ID from the reply form
              var commentContent = jQuery('#reply-comment').val();
              var parentId = jQuery('#comment_parent').val();
              var postId = <?php echo get_the_ID(); ?>;

              // Create the data object to be sent via AJAX
              var data = {
                'action': 'post_reply',
                'comment': commentContent,
                'comment_parent': parentId,
                'post_id': postId
              };

              // Send the AJAX request
              jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data,
                success: function (response) {

                  console.log(response);


                  // Update the comments section with the newly posted reply
                  jQuery('#auction-comments').load(location.href + ' #auction-comments');

                  jQuery('#comment-block').load(location.href + ' #comment-block');



                },
                error: function (xhr, status, error) {
                  // Handle errors if any
                  console.error(xhr.responseText);
                }
              });
            }


            function replyCancel() {
              jQuery('#comment-block').load(location.href + ' #comment-block');
            }
          </script>

          <style>
            .bid-cmnt {
              background-color: #004225;
              padding: 5px;
              border-radius: 5px;
              color: white;

            }

            .bided {
              color: #e5e5e5;
            }
          </style>

        </div> <!-- Comment main close -->



      </div><!-- Middle Left secsion close -->

      <div class="d-none d-md-block col-md-3">


        <h6 class=" text-black mb-0"><i class="fas fa-gavel"></i> <?php echo __("ENDING SOON", "premiumpress"); ?> </h6>

        <div class="bg-white m-0 m-md-2 p-2" style="border-radius: 15px;">
          <?php _ppt_template('framework/design/singlenew/parts/side_ending_soon'); ?>
        </div>

      </div><!-- Middle right section close -->



    </div> <!-- Middle section close -->



  </div><!-- Main  container close -->

  <div class="bottomSellWithUs p-2  text-center bg-primary">
    <span class="small text-white font-weight-bold text-mobile-9">Sell with us — it’s free! Apply in just 5 minutes.
      <a href="<?php echo home_url(); ?>/sell-a-car/" class="text-white font-weight-bold">Get Started<a /></span>

    <a onclick="jQuery('.bottomSellWithUs').fadeOut(400);" class="btn close-stripe d-block">
      <i class="fas fa-times"></i>
    </a>
  </div>







  <div class="text-center py-4">
    <h2>Deals You might like</h2>
  </div>

  <?php

  echo do_shortcode("[ending_soon_listings]");


  ?>

</section> <!-- Main  section close -->

<?php 

  echo do_shortcode('[elementor-template id="313983"]');
?>

<style>
  .bidfieldrow {
    display: flex;
    font-size: 12px;
    border-bottom: 0.1px solid #eeeeee82;
  }


  .bidfieldrow .text {
    font-weight: 700;
    font-family: 'Lato Bold', sans-serif;
    color: #343537;
    min-width: 68%;
    max-width: 100%;
  }

  .bidfieldrow .text .timeCountEndDate {
    text-align: start !important;
    color: #d91616 !important;
    font-weight: 700 !important;
    font-size: 13px;
  }



  .bid_disclaimer_block {
    margin: 8px 0 0 0;
    border-top: 1px solid #dfdfdf;
  }



  .bid_disclaimer .gray-text {
    color: #616263;
    font-size: 13px;
    font-weight: 600 !important;

  }





  .s-h-separator {
    width: 100%;
    margin: 1px 0;
    height: 2px;
    background: #BF9D3E;
    border: none;
  }



  .fieldrow {
    display: flex;
    font-size: 12px;
    border-bottom: 0.1px solid #eee;
  }




  .extra-modal-wrap {
    backdrop-filter: blur(5px) brightness(50%) !important;
  }



  button.btn-system,
  span.btn-system {
    border-radius: 30px !important;
  }

  .btn-icon.icon-before.btn-block {
    border-radius: 30px !important;
  }

  .input-group-append .btn,
  .input-group-prepend .btn {

    border: 0.5px solid #dadada !important;
    border-radius: 5px;
    background: #dadada;

  }


  .history-icon-image {
    max-width: 100px;
    max-height: 100px;
  }

  .history-content {
    width: 100%;
    min-height: 100px;
    background: #eee;
    border-radius: 10px;
  }
</style>


<script>
  function processCarfaxPop() {
    jQuery(".carfax-modal-wrap").fadeIn(400);
  }

  function processConditionReportPop() {
    jQuery(".condition-report-modal-wrap").fadeIn(400);
  }


  function processusedVehicleInfoPop() {
    jQuery(".used-vehicle-info-report-modal-wrap").fadeIn(400);
  }

  function procesUserUpdateLocationPop() {
    jQuery(".user-loation-modal-wrap").fadeIn(400);
  }
  
   function turboBidTransportPop() {
    elementorProFrontend.modules.popup.showPopup({
        id: 321412
    });
}
</script>

<!-- carfax model -->
<div class="carfax-modal-wrap x-modal-wrap shadow hidepage" style="display:none;">
  <div class="extra-modal-wrap-overlay"></div>
  <div class="extra-modal-item">
    <div class="extra-modal-container">
      <div class="card-body bg-white border-0">
        <div class="container bg-white ">

          <?php $carfaxPdfLink = get_post_meta($post->ID, 'carfax-pdf-link', true);
          if ($carfaxPdfLink || $carfaxPdfLink != '') { ?>
            <embed class="pdf-embed" src="<?php echo $carfaxPdfLink; ?>" type="application/pdf" />
          <?php } else { ?>
            <h1>No turbo CARFAX report</h1>

          <?php } ?>

        </div>
      </div>
      <div class="card-footer text-center d-flex flex-row justify-content-between">


        <button type="button" onclick="jQuery('.carfax-modal-wrap').fadeOut(400);"
          class="btn btn-primary shadow-sm btn-sm radiusx">
          <?php echo __("Close", "premiumpress"); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- condition report model -->
<div class="condition-report-modal-wrap x-modal-wrap shadow hidepage" style="display:none;">
  <div class="extra-modal-wrap-overlay"></div>
  <div class="extra-modal-item">
    <div class="extra-modal-container">
      <div class="card-body bg-white border-0">
        <div class="container bg-white ">

          <?php $turboConditionReport = get_post_meta($post->ID, 'turbo-condition-report', true);
          if ($turboConditionReport || $turboConditionReport != '') { ?>
            <embed class="pdf-embed" src="<?php echo $turboConditionReport; ?>" type="application/pdf" />
          <?php } else { ?>
            <h1>No turbo Status Report</h1>

          <?php } ?>

        </div>
      </div>
      <div class="card-footer text-center d-flex flex-row justify-content-between">
        <button type="button" onclick="jQuery('.condition-report-modal-wrap').fadeOut(400);"
          class="btn btn-primary shadow-sm btn-sm radiusx">
          <?php echo __("Close", "premiumpress"); ?>
        </button>
      </div>
    </div>
  </div>
</div>


<!-- used vehicle info report model -->
<div class="used-vehicle-info-report-modal-wrap x-modal-wrap shadow hidepage" style="display:none;">
  <div class="extra-modal-wrap-overlay"></div>
  <div class="extra-modal-item">
    <div class="extra-modal-container">
      <div class="card-body bg-dark border-0">
        <div class="container bg-white ">

        </div>
      </div>
      <div class="card-footer text-center d-flex flex-row justify-content-between">
        <button type="button" onclick="jQuery('.used-vehicle-info-report-modal-wrap').fadeOut(400);"
          class="btn btn-success shadow-sm btn-xl">
          <?php echo __("Ok", "premiumpress"); ?>
        </button>
      </div>
    </div>
  </div>
</div>



<script>

// Bid Increment Button function

var getDynamicBidIncrement = <?php echo $dynamicIncrement; ?>;
var currentPrice = <?php echo $current_price; ?>;

// Function to format numbers with commas
function formatNumber(num) {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Function to remove commas and convert to integer
function unformatNumber(num) {
  return parseInt(num.replace(/,/g, ''));
}

// Function to update the bid amount field with formatted value
function updateBidAmount(inputField, value) {
  inputField.value = formatNumber(value);
}

// Get all bid input elements
var bidInputs = document.getElementsByClassName('bid_amount');

// Attach event listeners to increment buttons
var incrementBtns = document.getElementsByClassName('incrementBtn');
for (var i = 0; i < incrementBtns.length; i++) {
  incrementBtns[i].addEventListener('click', function() {
    var inputField = this.parentNode.parentNode.getElementsByClassName('bid_amount')[0];
    var currentValue = unformatNumber(inputField.value);
    var incrementedValue = currentValue + getDynamicBidIncrement;
    updateBidAmount(inputField, incrementedValue);
  });
}

// Attach event listeners to decrement buttons
var decrementBtns = document.getElementsByClassName('decrementBtn');
for (var i = 0; i < decrementBtns.length; i++) {
  decrementBtns[i].addEventListener('click', function() {
    var inputField = this.parentNode.parentNode.getElementsByClassName('bid_amount')[0];
    var currentValue = unformatNumber(inputField.value);
    var decrementedValue = currentValue - getDynamicBidIncrement;

    // Check if decremented value is less than or equal to the current price
    if (decrementedValue >= currentPrice) {
      updateBidAmount(inputField, decrementedValue);
    } else {
      updateBidAmount(inputField, currentPrice);
    }
  });
}

  
</script>