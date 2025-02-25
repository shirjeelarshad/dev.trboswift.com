<?php
/*
 * Template Name: Live Auctions
 * Description: A custom template for the Live Auctions page.
 */

// WordPress header




get_header();





// if ($userdata->ID) {
?>


<script>






    // Connect to the WebSocket server
    var socket = io('https://liveoffer.turbobid.ca');

    socket.on('connect', () => {
         console.log('Connected to WebSocket server');
    });


</script>




<div id="float-live-cast" class="bg-secondary">

    <div class="bidding-box-header d-flex col-12 justify-content-between p-2 bg-white ">

        <div class="d-flex justify-content-start align-items-center   p-0 m-0">

            <a class="nav-link dropdown-toggle btn btn-primary mr-3" href="#" id="navbarDropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bars"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <button class="dropdown-item btn btn-light" onClick="getAuctionLaneAPosts()"><?php echo __("Lane A", "premiumpress"); ?></button>
                <button class="dropdown-item btn btn-light" onClick="getAuctionLaneBPosts()"><?php echo __("Lane B", "premiumpress"); ?></button>
                <button class="dropdown-item btn btn-light" onClick="getAuctionLaneCPosts()"><?php echo __("Lane C", "premiumpress"); ?></button>
            </div>



            <h4 class=" live-auction-header  mr-4" ><?php echo __("Livestream", "premiumpress"); ?></h4>

            <div class="live-header-btn-group bg-light  d-flex justify-content-center text-center"
                style="border:1px solid #eee; border-radius: 50px; ">
                <button id="liveAuctionGetButton" onclick="refreshPosts()"
                    class="btn btn-primary live-auction-header-text-button"
                    style=" border-radius:50px; "><?php echo __("LIVESTREAM", "premiumpress"); ?></button>
                <button id="watchListGetButton" onclick="showMyFavorite()"
                    class="btn btn-white  live-auction-header-text-button" style=" border-radius:50px; "><?php echo __("WATCHLIST", "premiumpress"); ?></button>
            </div>



        </div>



    </div>


    <div id="live-auction-post-container">
        <div style="height: 100vh;  display: flex;  justify-content: center; flex-direction: column; align-items: center; "
            class="bg-secondary col-12   p-6   ">
            <h5 class="text-light text-center"><?php echo __("LIVE STREAMING CHECKING...", "premiumpress"); ?></h5><br>
        </div>
    </div>

    <div id="mySidepanel" class="sidepanel ">

        <div class="p-4">
            <a href="javascript:void(0)" class="closebtn" onclick="closeVideoPanel()">×</a>


            <?php if (current_user_can('administrator')) {
                ?>

            <?php } ?>
            <!-- <button id="startStopLiveCast" onclick="toggleGetLive()" class="btn btn-primary  mb-3">Show Live</button> -->
            <div id="showLiveCastContainer" class="pt-5 d-flex align-items-center">

                <!--<h3 class="text-white">The live webcast has not yet started.</h3>-->



            </div>
        </div>

    </div>

</div>

<style>
    .bidding-box-header {
        position: sticky;
        top: 0;
        background-color: #fff;
        /* You can set the background color as needed */
        z-index: 100;
        /* Adjust the z-index as necessary to layer it above other content */
    }
</style>



<style>
    /* Style the video player controls */
    video::-webkit-media-controls {
        /*background: rgba(0, 0, 0, 0.5);*/
        border-radius: 5px;
    }

    video::-webkit-media-controls-play-button {
        display: none;
    }

    video::-webkit-media-controls-start-playback-button {
        display: none;
    }

    video::-webkit-media-controls-current-time-display {
        color: #fff;
    }

    video::-webkit-media-controls-time-remaining-display {
        color: #fff;
    }

    /* Customize other video control elements as needed */

    /* Style the poster image */
    video::poster {
        /* Add styling for the poster image here */
    }
</style>



<!--<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>-->

<script>









    function refreshPosts() {

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            dataType: "html",
            data: {
                action: 'refresh_posts'
            },
            success: function (data) {
                // Clear previous content
                jQuery('#live-auction-post-container').empty();

                // Display the new post content
                jQuery('#live-auction-post-container').html(data);

                jQuery('#liveAuctionGetButton').addClass('btn-primary');

                jQuery('#watchListGetButton').removeClass('btn-primary');


            }, error: function (e) {
                // console.log(e)
            }
        });
    }

    refreshPosts();


    function getAuctionLaneAPosts() {


        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            dataType: "html",
            data: {
                action: 'getauction_lane_a'
            },
            success: function (data) {
                // Clear previous content
                jQuery('#live-auction-post-container').empty();

                // Display the new post content
                jQuery('#live-auction-post-container').html(data);




            }, error: function (e) {
                // console.log(e)
            }
        });
    }


    function getAuctionLaneBPosts() {


        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            dataType: "html",
            data: {
                action: 'getauction_lane_b'
            },
            success: function (data) {
                // Clear previous content
                jQuery('#live-auction-post-container').empty();

                // Display the new post content
                jQuery('#live-auction-post-container').html(data);






            }, error: function (e) {
                // console.log(e)
            }
        });
    }



    function getAuctionLaneCPosts() {


        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            dataType: "html",
            data: {
                action: 'getauction_lane_c'
            },
            success: function (data) {
                // Clear previous content
                jQuery('#live-auction-post-container').empty();

                // Display the new post content
                jQuery('#live-auction-post-container').html(data);






            }, error: function (e) {
                // console.log(e)
            }
        });
    }














    // Function to toggle the state and call appropriate functions
    function showMyFavorite() {

        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'GET',
            data: {
                action: 'get_user_fav_auc'
            },
            success: function (data) {

                jQuery('#live-auction-post-container').empty();

                jQuery('#live-auction-post-container').html(data);

                jQuery('#watchListGetButton').addClass('btn-primary');

                jQuery('#liveAuctionGetButton').removeClass('btn-primary');

            },
        });

    }












</script>



<script src="https://cdn.jsdelivr.net/npm/flv.js@1.5.0/dist/flv.min.js"></script>



<?php

// } else {


//     header("Location: /wp-login.php");
//     exit;
// }


?>




<style>
    .radiusx {
        border: 0.5px solid #eee;
        border-radius: 10px;

    }

    @media screen and (max-width: 992px) {

        .radiusx {
            margin-top: 10px;
        }
    }

    .bidfieldrow {
        display: flex;
        font-size: 12px;
        border-bottom: 0.1px solid #eeeeee82;
    }

    .bidfieldrow .title {
        font-weight: 400;
        width: fit-content;
        min-width: 38%;
        max-width: 100%;
        color: #616263;
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

    .bidfieldrow .text .pricetag {
        font-size: 17px;
        font-weight: 700 !important;
        font-family: 'Lato Bold', sans-serif;
        color: #343537;
    }


    .bid_disclaimer_block {
        margin: 8px 0 0 0;
        border-top: 1px solid #dfdfdf;
    }

    .bid_disclaimer {
        border: none;
        margin: 7px 12px 7px 12px;
        border-radius: 0;
        color: #3a4351;
        font-size: 13px;
        text-align: center;
    }

    .bid_disclaimer .gray-text {
        color: #616263;
        font-size: 13px;
        font-weight: 600 !important;

    }





    .s-h-separator {
        width: 35px;
        margin: 1px 0;
        height: 2px;
        background: #1e1f21;
        border: none;
    }

    .details-header {
        border-bottom: 0.5px solid #eee;
    }

    .fieldrow {
        display: flex;
        font-size: 12px;
        border-bottom: 0.1px solid #eeeeee82;
    }

    .ppt_shortcode_fields.style-1 .title {
        font-weight: 600;
        margin-bottom: 5px !important;
        width: 50%;
        color: #585858;
    }

    .ppt_shortcode_fields.style-1 .text {

        width: 60%;
    }

    .f_size12 {
        font-size: 12px;
    }

    .live-bids {
        width: 100%;
        background: #efa503;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;

        border-radius: 5px;
        height: 38px;
    }



    .gallery-items .img-fluid {
        /*border-radius: 10px;*/
    }

    .radiusx {
        border-radius: 10px;
        /*box-shadow: 0 25px 50px -12px rgba(0,0,0,.25);*/
    }


    #imageContainer {
        padding: 10px;
    }






    .sidepanel {
        width: 0;
        position: fixed;
        z-index: 1050;
        height: 100%;
        top: 0;
        right: 0;
        background-color: ##ffffff1c;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        box-shadow: rgba(0, 0, 0, 0.1) -8px 0px 15px -6px;
    }



    .sidepanel .closebtn {
        position: absolute;
        top: 10px;
        left: 25px;
        font-size: 40px;
        color: #eee;
    }



    .closebtn:hover {

        color: ##f923233d;
    }

    .upCommingSide {
        width: 0;
        position: fixed;
        z-index: 999;
        height: 100%;
        top: 0;
        right: 0;
        background-color: #111;
        overflow-x: hidden;
        overflow-y: scroll;
        transition: 0.5s;
        padding-top: 60px;
        box-shadow: rgba(0, 0, 0, 0.1) -8px 0px 15px -6px;
    }



    .upCommingSide .closebtn {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 40px;
        color: #6c757d;
    }

    /* #bidding-message-display<?php echo $post->ID; ?>
        {
        display: none;
    }

    */
    
    .countdown {
        display: none;
        font-size: 18px;
        font-family: ITC Avant Garde Gothic Std;
		font-style: normal;
		font-weight: 600;
        color: black;
        text-shadow: 5px 5px 50px #ff0000;
    }



    .bid_amount {
        font-size: 25px;
		font-family: ITC Avant Garde Gothic Std;
		font-style: normal;
        font-weight: bold;
        color: white;
        background: black;
        border: 1px solid black;
    }

    @media (min-width: 1020px) {
        /* For desktop: */

        #videoElement {
            width: 900px;
            height: auto;
            min-height: 300px;
            min-width: 500px;
            max-width: 100%;
            max-height: 500px;
        }





        .live-auction-header {
            display: block;
            font-size: 20px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            font-weight: bold;
            color: #565757;
        }

        .live-auction-header-text-button {
            font-size: 14px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding: 5px;
            height: 37px;
            /*width: 100px;*/
        }

        #startStopButton,
        #pauseResumeButton,
        .mute-button {
            font-size: 14px !important;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding-left: 15px !important;
            padding-right: 15px;
            padding-top: 0px;
            padding-bottom: 0px;
            margin-left: 15px;
            border-radius: 5px;
        }



        /* Live Auction 1st Block */


        .live-auction-slider-img {
            height: 300px;
        }

        .live-auction-font-tit {
            font-size: 18px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-bid {
            font-size: 14px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .buybox-price-num {
            font-size: 18px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;;
        }

        .upcomingHeading,
        .live-auction-highlights,
        #liveaAuctionChangetimer {
            font-size: 25px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
        }


        .bidding-box-close {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 100%;
            width: 100%;

            background: #3d3d3df0;
        }


        .bid-added-middle {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 10;
            height: 300px;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .bid-added-text {
            font-size: 25px;
            font-weight: bold;
            color: white;
            text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
            font-family: "ITCAvantGardeStd", Sans-serif;
        }


        .bidding_message_middle {

            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 300px;
            width: 100%;
            text-align: center;
            display: flex;
            background: #3d3d3df0;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }


        .biding-close-gavel {
            width: 60px;
        }

        .auction-end-text {
            font-size: 25px;
            font-weight: bold;
            color: white;
            font-family: "ITCAvantGardeStd", Sans-serif;

        }

        .auction-next-text {
            font-size: 18px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            background: white;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 5px;
            color: black;

        }


        /* Live Auction 3st Block */

        .gallery-image-header {
            font-size: 14px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }


    }

    @media (max-width: 1020px) {
        /* For desktop: */



        .live-auction-header {
            display: block;
            font-size: 18px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            font-weight: bold;
            color: #565757;
        }

        .live-auction-header-text-button {
            font-size: 14px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding: 5px;
            height: 33px;
            /*width: 100px;*/
        }

        #startStopButton,
        #pauseResumeButton,
        .mute-button {
            font-size: 14px !important;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding-left: 15px !important;
            padding-right: 15px;
            padding-top: 0px;
            padding-bottom: 0px;
            margin-left: 10px;
            border-radius: 5px;
        }




        /* Live Auction 1st Block */


        .live-auction-slider-img {
            height: 220px;
            font-family: "ITCAvantGardeStd", Sans-serif;
        }

        .live-auction-font-tit {
            font-size: 18px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-bid {
            font-size: 14px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        #buybox-price, .buybox-price-num {
            font-size: 18px;
            color: #FFF !important;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-highlights,
        .upcomingHeading,
        #liveaAuctionChangetimer {
            font-size: 25px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
        }

        .bidding-box-close {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 100%;
            width: 100%;

            background: #3d3d3df0;
        }

        .bid-added-middle {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 10;
            height: 220px;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .bid-added-text {
            font-size: 22px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            font-weight: bold;
            color: white;
            text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
        }

        .bidding_message_middle {

            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 220px;
            width: 100%;
            text-align: center;
            display: flex;
            background: #3d3d3df0;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }


        .biding-close-gavel {
            width: 40px;
        }

        .auction-end-text {
            font-size: 22px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;

        }

        .auction-next-text {
            font-size: 16px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            background: white;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 5px;
            color: black;

        }


        /* Live Auction 3st Block */

        .gallery-image-header {
            font-size: 13px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }


    }


    @media (max-width: 920px) {
        /* For desktop: */



        .live-auction-header {
            display: block;
            font-size: 16px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            font-weight: bold;
            color: #565757;
        }

        .live-auction-header-text-button {
            font-size: 11px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding: 5px;
            height: 33px;
            /*width: 80px;*/
        }

        #startStopButton,
        #pauseResumeButton,
        .mute-button {
            font-size: 12px !important;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding-left: 15px !important;
            padding-right: 15px;
            padding-top: 0px;
            padding-bottom: 0px;
            margin-left: 10px;
            border-radius: 5px;
        }




        /* Live Auction 1st Block */


        .live-auction-slider-img {
            height: 200px;
        }

        .live-auction-font-tit {
            font-size: 14px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-bid {
            font-size: 13px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .buybox-price-num {
            font-size: 16px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-highlights,
        .upcomingHeading,
        #liveaAuctionChangetimer {
            font-size: 22px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            font-weight: bold;
        }


        .bidding-box-close {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 100%;
            width: 100%;

            background: #3d3d3df0;
        }


        .bid-added-middle {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 10;
            height: 200px;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .bid-added-text {
            font-size: 20px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;
            text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
        }


        .bidding_message_middle {

            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 200px;
            width: 100%;
            text-align: center;
            display: flex;
            background: #3d3d3df0;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }


        .biding-close-gavel {
            width: 40px;
        }

        .auction-end-text {
            font-size: 20px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            font-weight: bold;
            color: white;

        }

        .auction-next-text {
            font-size: 14px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            background: white;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 5px;
            color: black;

        }




        /* Live Auction 3st Block */

        .gallery-image-header {
            font-size: 12px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

    }


    @media (max-width: 720px) {

        #videoElement {
            width: 100%;
            height: auto;
            min-height: 300px;
            max-height: 500px;
        }


        /* For tablets: */

        .live-auction-header {
            display: none;
        }

        .live-header-btn-group {}

        .live-auction-header-text-button {
            font-size: 12px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding: 5px;
            height: 30px;
            /*width: 85px;*/
        }

        #startStopButton,
        #pauseResumeButton,
        .mute-button {
            font-size: 10px !important;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding-left: 10px !important;
            padding-right: 10px;
            margin-left: 5px;
            border-radius: 5px;
        }



        /* Live Auction 1st Block */


        .live-auction-slider-img {
            height: 200px;
        }

        .live-auction-font-tit {
            font-size: 16px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-bid {
            font-size: 12px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .buybox-price-num {
            font-size: 14px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-highlights,
        .upcomingHeading,
        #liveaAuctionChangetimer {
            font-size: 20px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
        }


        .bidding-box-close {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 100%;
            width: 100%;

            background: #3d3d3df0;
        }

        .bid-added-middle {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 10;
            height: 200px;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .bid-added-text {
            font-size: 18px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;
            text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
        }


        .bidding_message_middle {

            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 200px;
            width: 100%;
            text-align: center;
            display: flex;
            background: #3d3d3df0;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }


        .biding-close-gavel {
            width: 40px;
        }

        .auction-end-text {
            font-size: 18px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;

        }

        .auction-next-text {
            font-size: 12px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            background: white;
            padding-left: 5px;
            padding-right: 5px;
            color: black;
            border-radius: 5px;
            font-family: "ITCAvantGardeStd", Sans-serif;
        }




        /* Live Auction 3st Block */

        .gallery-image-header {
            font-size: 12px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

    }

    @media (max-width: 400px) {
        /* For tablets: */


        /* Live Auction Header */


        .bidding-box-header {
            position: sticky !important;
            top: 0;
            background-color: #fff;
            /* You can set the background color as needed */
            z-index: 100;
            /* Adjust the z-index as necessary to layer it above other content */
        }

        .live-auction-header {
            display: none;

        }

        .live-header-btn-group {
            margin-left: 50px;
        }

        .live-auction-header-text-button {
            font-size: 12px;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding: 2px;
            /*height: 30px;*/

        }

        #startStopButton,
        #pauseResumeButton,
        .mute-button {
            font-size: 12px !important;
            font-family: "ITCAvantGardeStd", Sans-serif;
            padding-left: 4px;
            padding-right: 4px;
            margin-left: 2px;
            border-radius: 5px;
        }







        /* Live Auction 1st Block */


        .live-auction-slider-img {
            height: 300px;
        }

        .live-auction-font-tit {
            font-size: 16px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
            text-transform: uppercase;
        }

        .live-auction-bid {
            font-size: 12px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;

        }

        .buybox-price-num {
            font-size: 12px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

        .live-auction-highlights,
        .upcomingHeading,
        #liveaAuctionChangetimer {
            font-size: 16px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
        }


        .bidding-box-close {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;
            height: 100%;
            width: 100%;

            background: #3d3d3df0;
        }

        .bid-added-middle {
            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 10;
            height: 300px;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }

        .bid-added-text {
            font-size: 16px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;
            text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
        }

        .bidding_message_middle {

            position: absolute;
            top: 0%;
            left: 0%;
            z-index: 1000;

            height: 300px;
            width: 100%;
            text-align: center;
            display: flex;
            background: #3d3d3df0;
            align-items: center;
            justify-content: center;
            flex-direction: column;

        }


        .biding-close-gavel {
            width: 30px;
        }

        .auction-end-text {
            font-size: 18px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;

        }

        .auction-next-text {
            font-size: 12px;
            font-weight: bold;
            font-family: "ITCAvantGardeStd", Sans-serif;
            background: white;
            padding-left: 5px;
            padding-right: 5px;
            color: black;
            border-radius: 5px;

        }


        /* Live Auction 3st Block */

        .gallery-image-header {
            font-size: 12px;
            color: #FFF;
			font-family: ITC Avant Garde Gothic Std;
			font-style: normal;
			font-weight: 600;
        }

    }


    #twoColumnsBtn,
    #oneColumnBtn {
        padding-left: 10px;
        padding-right: 10px;

    }

    #bidPriceUpdate {
        font-weight: bold !important;
        padding: 10px;
        font-size: 18px;
    }

    #bidPriceUpdate:hover {
        background: black !important;
        color: white !important;


    }
</style>



<?php

get_footer();

?>