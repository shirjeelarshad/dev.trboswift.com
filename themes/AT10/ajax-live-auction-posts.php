<?php


define('WP_USE_THEMES', false);
require_once('../../wp-load.php');




    global $userdata, $CORE_AUCTION, $wpdb, $CORE, $post;
  



    $current_time = current_time('mysql');

    $expiry_date = get_post_meta($post->ID, 'live_auction_start_date', true);
    $new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds"));

    $vv = $CORE->date_timediff($expiry_date);
    
    
    
    
        $args = array(
            'post_type' => 'listing_type',
            'post_status' => 'publish',
            'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'value' => $current_time,
                'compare' => '<=',
                'type' => 'DATETIME',
                'order' => 'ASC',
                
            ),
        ),
        
            'orderby' => 'ID', // Order by post ID
            'order' => 'ASC', // Acending order (latest first)
        
        );

        $posts = new WP_Query($args);

        if ($posts->have_posts()) {
            $post_count = 0;
            $post_countx = 0;
            
            ?>
            
 
  <div class="d-flex col-12 justify-content-between p-2 bg-white ">
  
  <div class="col-4 d-flex justify-content-around justify-content-center  p-0 m-0" >
      <div class="d-flex align-self-center"><h4 class=" live-auction-header " >LiveAuction</h4></div>
  
  <div class="live-header-btn-group bg-light  d-flex justify-content-center text-center" style="border:1px solid #eee; border-radius: 50px; ">
        <button  class="btn btn-primary live-auction-header-text-button" style=" border-radius:50px; ">AUCTIONS</button>
        <a href="<?php echo home_url(); ?>/?s=&favs=1"><button  class="btn btn-white  live-auction-header-text-button"  >WATCH LIST</button></a>
  </div>    
   </div>   
  
  
  <div class="col-8 d-flex justify-content-end p-0 m-0">
            <button id="toggleSound" onclick="toggleSoundStartStop()"  class="mute-button btn btn-light"><i class="fas fa-volume-up"></i></button>
            
            <?php
            if (current_user_can('administrator')) {
            ?>
            
            
            <button id="startStopButton" onclick="toggleStartStop()" class="btn btn-light">Restart Auction</button>
            <button id="pauseResumeButton" onclick="togglePauseResume()" class="btn btn-light">Pause Auction</button>
            
             <?php
            }
            ?>
            
           <button onclick="openNav()" class=" mute-button btn btn-light"><i class="fas fa-video"></i></button> 
           
           
           <button onclick="openUpCommingSide()" class=" mute-button btn btn-light"><i class="fas fa-list-ol"></i></button> 
            
    </div>
    
<script>
function openNav() {
  document.getElementById("mySidepanel").style.width = "65%";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}


function openUpCommingSide() {
  document.getElementById("upCommingSide").style.width = "40%";
}

function closeUpCommingSide() {
  document.getElementById("upCommingSide").style.width = "0";
}


</script>

<style>


#bidding-message-display{
    display:none;
}


#countdown{
            display:none;
            font-size: 18px;
            font-weight: 700;
            font-family: "ITCAvantGardeStd", Sans-serif;
            color: white;
            text-shadow: 5px 5px 50px #ff0000;
            }



.bid_amount{
    font-size: 25px;
    font-family: "ITCAvantGardeStd", Sans-serif;
    font-weight: bold;
    color: white;
    background: black;
    border: 1px solid black;
}

    @media (min-width: 1020px) {
  /* For desktop: */
  
 
  
  .live-auction-header{
      display:block;
      font-size:20px;
      font-family: "ITCAvantGardeStd", Sans-serif;
      font-weight:bold;
      color:#565757;
  }
  .live-auction-header-text-button{
      font-size: 14px;
      font-family: "ITCAvantGardeStd", Sans-serif;
      padding: 5px;
    height: 37px;
    width: 100px;
  }
  
  #startStopButton, #pauseResumeButton, .mute-button{
    font-size: 14px!important;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding-left: 15px !important;
    padding-right: 15px;
    padding-top: 0px;
    padding-bottom: 0px;
    margin-left: 15px;
    border-radius: 5px; 
  }
  
  
      
    /* Live Auction 1st Block */


.live-auction-slider-img{
  height: 300px;  
}

.live-auction-font-tit{
    font-size:18px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}  
 
.live-auction-bid{
     font-size:14px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}  

.buybox-price-num{
    font-size:18px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}

.upcomingHeading, .live-auction-highlights, #liveaAuctionChangetimer{
     font-size:25px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
}


#bidding-box-close{
    position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 100%;
    width: 100%;
    display: none;
    background: #3d3d3df0;
}


#bid-added-middle{
     position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 300px;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;        
    overflow:hidden; 
}

.bid-added-text{
    font-size:25px;
     font-weight:bold;
     color:white;
     text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
     font-family: "ITCAvantGardeStd", Sans-serif;
}


#bidding_message_middle{
            
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
    overflow:hidden;        
 }
 
 
 .biding-close-gavel{
     width:60px;
 }
 
 .auction-end-text{
     font-size:25px;
     font-weight:bold;
     color:white;
     font-family: "ITCAvantGardeStd", Sans-serif;
     
 }

 .auction-next-text{
     font-size:18px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     background:white;
     padding-left:10px;
     padding-right:10px;
     padding-top:5px;
     padding-bottom:5px;
     border-radius:5px;
     color:black;
     
 }


/* Live Auction 3st Block */
  
 .gallery-image-header{
     font-size:14px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}  
  
  
}

    @media (max-width: 1020px) {
  /* For desktop: */
  
 
  
  .live-auction-header{
      display:block;
      font-size:18px;
      font-family: "ITCAvantGardeStd", Sans-serif;
      font-weight:bold;
      color:#565757;
  }
  .live-auction-header-text-button{
      font-size: 14px;
      font-family: "ITCAvantGardeStd", Sans-serif;
      padding: 5px;
    height: 33px;
    width: 100px;
  }
  
  #startStopButton, #pauseResumeButton, .mute-button{
    font-size: 14px!important;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding-left: 15px !important;
    padding-right: 15px;
    padding-top: 0px;
    padding-bottom: 0px;
    margin-left: 10px;
    border-radius: 5px; 
  }
  
  
  
    
    /* Live Auction 1st Block */


.live-auction-slider-img{
  height: 220px; 
  font-family: "ITCAvantGardeStd", Sans-serif;
}

.live-auction-font-tit{
    font-size:18px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}  
 
.live-auction-bid{
     font-size:14px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}  

.buybox-price-num{
    font-size:18px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}

.live-auction-highlights, .upcomingHeading, #liveaAuctionChangetimer{
     font-size:25px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
}

#bidding-box-close{
    position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 100%;
    width: 100%;
    display: none;
    background: #3d3d3df0;
}

#bid-added-middle{
     position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 220px;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;        
    overflow:hidden; 
}

.bid-added-text{
    font-size:22px;
    font-family: "ITCAvantGardeStd", Sans-serif;
     font-weight:bold;
     color:white;
     text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
}

#bidding_message_middle{
            
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
    overflow:hidden;        
 }
 
 
 .biding-close-gavel{
     width:40px;
 }
 
 .auction-end-text{
     font-size:22px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     color:white;
     
 }

 .auction-next-text{
     font-size:16px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     background:white;
     padding-left:10px;
     padding-right:10px;
     padding-top:5px;
     padding-bottom:5px;
     border-radius:5px;
     color:black;
     
 }
  
 
  /* Live Auction 3st Block */
  
 .gallery-image-header{
     font-size:13px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}
  
  
}


    @media (max-width: 920px) {
  /* For desktop: */
  
 
  
  .live-auction-header{
      display:block;
      font-size:16px;
      font-family: "ITCAvantGardeStd", Sans-serif;
      font-weight:bold;
      color:#565757;
  }
  .live-auction-header-text-button{
      font-size: 11px;
      font-family: "ITCAvantGardeStd", Sans-serif;
      padding: 5px;
    height: 33px;
    width: 80px;
  }
  
  #startStopButton, #pauseResumeButton, .mute-button{
    font-size: 12px!important;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding-left: 15px !important;
    padding-right: 15px;
    padding-top: 0px;
    padding-bottom: 0px;
    margin-left: 10px;
    border-radius: 5px; 
  }
  
  
  
  
    /* Live Auction 1st Block */


.live-auction-slider-img{
  height: 200px;  
}

.live-auction-font-tit{
    font-size:14px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}  
 
.live-auction-bid{
     font-size:13px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}  

.buybox-price-num{
    font-size:16px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}

.live-auction-highlights, .upcomingHeading, #liveaAuctionChangetimer{
     font-size:22px;
     font-family: "ITCAvantGardeStd", Sans-serif;
     font-weight:bold;
}


#bidding-box-close{
    position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 100%;
    width: 100%;
    display: none;
    background: #3d3d3df0;
}


#bid-added-middle{
     position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 200px;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;        
    overflow:hidden; 
}

.bid-added-text{
    font-size:20px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     color:white;
     text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
}


#bidding_message_middle{
            
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
    overflow:hidden;        
 }
 
 
 .biding-close-gavel{
     width:40px;
 }
 
 .auction-end-text{
     font-size:20px;
     font-family: "ITCAvantGardeStd", Sans-serif;
     font-weight:bold;
     color:white;
     
 }

 .auction-next-text{
     font-size:14px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     background:white;
     padding-left:10px;
     padding-right:10px;
     padding-top:5px;
     padding-bottom:5px;
     border-radius:5px;
     color:black;
     
 }


  
  
  /* Live Auction 3st Block */
  
 .gallery-image-header{
     font-size:12px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}
  
}


@media (max-width: 720px) {
  /* For tablets: */
  
  .live-auction-header{
      display:none;
  }
  
  .live-header-btn-group{
      
  }
  .live-auction-header-text-button{
    font-size: 12px;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding: 5px;
    height: 30px;
    width: 85px;
  }
  
  #startStopButton, #pauseResumeButton, .mute-button{
    font-size: 10px!important;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding-left: 10px !important;
    padding-right: 10px;
    margin-left: 5px;
    border-radius: 5px;
  }
  
  
  
  /* Live Auction 1st Block */


.live-auction-slider-img{
  height: 200px;  
}

.live-auction-font-tit{
    font-size:12px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}  
 
.live-auction-bid{
     font-size:12px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}  

.buybox-price-num{
    font-size:14px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}

.live-auction-highlights, .upcomingHeading, #liveaAuctionChangetimer{
     font-size:20px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
}


#bidding-box-close{
    position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 100%;
    width: 100%;
    display: none;
    background: #3d3d3df0;
}

#bid-added-middle{
     position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 200px;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;        
    overflow:hidden; 
}

.bid-added-text{
    font-size:18px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     color:white;
     text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
}


#bidding_message_middle{
            
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
    overflow:hidden;        
 }
 
 
 .biding-close-gavel{
     width:40px;
 }
 
 .auction-end-text{
     font-size:18px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     color:white;
     
 }

 .auction-next-text{
     font-size:12px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     background:white;
     padding-left:5px;
     padding-right:5px;
     color:black;
     border-radius:5px;
     font-family: "ITCAvantGardeStd", Sans-serif;
 }

  
  
  
  /* Live Auction 3st Block */
  
 .gallery-image-header{
     font-size:12px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}
  
}

@media (max-width: 400px) {
  /* For tablets: */
  
  
  /* Live Auction Header */
  
  .live-auction-header{
      display:none;
  }
  
  .live-header-btn-group{
      
  }
  
  .live-auction-header-text-button{
    font-size: 10px;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding: 2px;
    height: 30px;
    
  }
  
  #startStopButton, #pauseResumeButton, .mute-button{
    font-size: 8px!important;
    font-family: "ITCAvantGardeStd", Sans-serif;
    padding-left: 4px;
    padding-right: 4px;
    margin-left: 2px;
    border-radius: 5px;
  }
  
  
  
  
  
  

/* Live Auction 1st Block */


.live-auction-slider-img{
  height: 200px;  
}

.live-auction-font-tit{
    font-size:10px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}  
 
.live-auction-bid{
     font-size:10px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}  

.buybox-price-num{
    font-size:12px;
    font-family: "ITCAvantGardeStd", Sans-serif;
}

.live-auction-highlights, .upcomingHeading, #liveaAuctionChangetimer{
     font-size:16px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
}


#bidding-box-close{
    position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 100%;
    width: 100%;
    display: none;
    background: #3d3d3df0;
}

#bid-added-middle{
     position: absolute;
    top: 0%;
    left: 0%;
    z-index: 1000;
    height: 200px;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;        
    overflow:hidden; 
}

.bid-added-text{
    font-size:16px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     color:white;
     text-shadow: 0px 2px 30px rgb(0 0 0 / 64%);
}

#bidding_message_middle{
            
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
            
 }
 
 
 .biding-close-gavel{
     width:30px;
 }
 
 .auction-end-text{
     font-size:18px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     color:white;
     
 }

 .auction-next-text{
     font-size:12px;
     font-weight:bold;
     font-family: "ITCAvantGardeStd", Sans-serif;
     background:white;
     padding-left:5px;
     padding-right:5px;
     color:black;
     border-radius:5px;
     
 }


  /* Live Auction 3st Block */
  
 .gallery-image-header{
     font-size:12px;
     font-family: "ITCAvantGardeStd", Sans-serif;
}
  
}


#twoColumnsBtn, #oneColumnBtn{
    padding-left: 10px;
    padding-right: 10px;
    
}



</style>

  
</div>
            
            
            <?php
            
            
            
            
            
            while ($posts->have_posts()) {
                $posts->the_post();
                $post_count++;
                if ($post_count === 1) {
                    
              global $current_post_id;
            $current_post_id = $post->ID;
            
                   
                _ppt_template( 'framework/design/singlenew/designs/global_design2' );
                
                
             
                
                } 
            }
            
            
            
            
            
            ?>
            <div id="upCommingSide" class="upCommingSide bg-white ">
            <div class="">    
            <a href="javascript:void(0)" class="closebtn" onclick="closeUpCommingSide()">×</a>
            <span class="upcomingHeading pl-3 pb-4">REMAINING AUCTIONS</span>
            
            <?php
            $total_posts = $posts->found_posts;
            $remmening_posts = $total_posts -1;
            
            while ($posts->have_posts()) {
                $posts->the_post();
                $post_countx++;
                
                if ($post_countx === 1) {
                    
                } else {
                    // Remaining posts
                echo '<div class=" d-flex p-2 mb-2">'; 
                
                echo '<div class=" mr-2 "> <span class="p-1 bg-primary text-white rounded-circle" >' . $remmening_posts-- . '</span></div>';
                
                _ppt_template( 'framework/design/singlenew/designs/upcomming_auction' );
                echo '</div>';
               
                
                }
            }
            echo '</div></div>';
            
            
            
            wp_reset_postdata();
        } else {
            echo '<div style="height: 700px; background:#2a2a2a; display: flex;  justify-content: center; flex-direction: column; align-items: center; " class=" col-12   p-6 mt-5 mb-5 ">';
            echo '<h5 class="text-light ">AUCTION IS NOT LIVE YET.</h5><br>';
            
            // Get the next auction time
        $args_next = array(
            'post_type' => 'listing_type',
            'post_status' => 'publish',
            'meta_query' => array(
            array(
                'key' => 'live_auction_start_date',
                'orderby' => 'meta_value',
                'value' => $current_time,
                'compare' => '>',
                'type' => 'DATETIME',
                'posts_per_page' => 1,
                'order' => 'ASC',
            ),
        ),
          
            
        );

        $next_posts = new WP_Query($args_next);

         if ($next_posts->have_posts()) {
            $next_posts->the_post();
            
            
            $next_auction_start = get_post_meta(get_the_ID(), 'live_auction_start_date', true);
            
            // echo do_shortcode('[TITLE]');
            
            $next_auction_start_timestamp = strtotime($next_auction_start);
            
            
            $fiveMinutesAgoTimestamp = strtotime('-5 minutes', $next_auction_start_timestamp);
            // 5 minutes before the start
            
            $remening_countdown_time = date("Y-m-d H:i:s", $fiveMinutesAgoTimestamp);
            
            
           

            $timezone_name = wp_timezone_string();
            
            $current_timestamp = strtotime($current_time);
           
           $remaining_time =  $next_auction_start_timestamp - $current_timestamp  ;
           
           
            
            $remening_count_start_min = date(" i", $remaining_time);
            $remening_count_start_sec = date(" s", $remaining_time);
            
            
            
            
            if ( $remening_countdown_time <= $current_time ) {
                // Display the countdown timer
                
               
                
                echo '<div class="text-light h6" >Auction Start In : <span id="nextauctiontimer"></span></div>';
                
                ?>
                
                
    <script type="text/javascript">
    

    
    // Get the remaining minutes from PHP
    
   
    var remainingMinutes = <?php echo $remening_count_start_min; ?>;
    var remainingSeconds  = <?php echo $remening_count_start_sec; ?>;
    
    
    // Calculate the countdown start time
    var countdownStartTime = new Date();
    countdownStartTime.setMinutes(countdownStartTime.getMinutes() + remainingMinutes);
    countdownStartTime.setSeconds(countdownStartTime.getSeconds() + remainingSeconds);


    
    // Function to update the countdown timer
    function updateCountdown() {
      var now = new Date().getTime();
      var distance = countdownStartTime - now;
      
      // Calculate remaining minutes and seconds
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
      // Display the countdown in the HTML element with id "nextauctiontimer"
      document.getElementById("nextauctiontimer").innerHTML = minutes + "m " + seconds + "s ";
      
      // Check if the countdown is finished
      if (distance < 1  ) {
         document.getElementById("nextauctiontimer").innerHTML = '0'; 
    
        // Stop the countdown interval
        clearInterval(countdownInterval);

        
        refreshPosts();

        
        
      }
      
    }
    
    // Update the countdown every second
    var countdownInterval = setInterval(updateCountdown, 1000);
  </script>
                
                
                <?php
                
                
                
            } else {
                // Display the date and time of the next auction
                echo '<h6 class="text-light ">Next Auction Date & Time ' . date('g:i a \a\t F j, Y', strtotime($next_auction_start)) . ' [' . $timezone_name . ']' . '</h6><br>';
                
            }
            
           
        } else {
            echo '<h6 class="text-light ">No Upcoming Auctions </h6><br>';
            
            echo'<script>
            function hgkjhuvgjh(){
            location.reload();
            
            }
            setInterval(hgkjhuvgjh, 50000);
            
            </script>';
            
        }
            
            echo'</div>';
            
            
        }
    
    
    
 
// Always exit after handling the AJAX request
die();
  




?>