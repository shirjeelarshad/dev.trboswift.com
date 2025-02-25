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

global $CORE, $userdata;


if(in_array(THEME_KEY, array("mj"))){ ?>
<div class="container">
  <div class="row">
   <?php /* <div class="col-md-4 border-right text-center pr-5"> <?php echo do_shortcode('[SCORE size=big]'); ?> </div> */ ?>
    <div class="col-md-12 mb-4 border bg-white p-3">
      <?php
	   


if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE')){

$data = array("score" => "4.0", "votes" => 3, "data" => array("5" => 1, "4" => 1, "1" => 1 ) );

}else{
$data = $CORE->USER("feedback_score", array( $post->post_author, $post->ID) ); 
}
  
$ratingLabels = array(

	"1" => __('Very Poor',"premiumpress"),
	"2" =>  __('Below Average',"premiumpress"),	
	"3" =>  __('Average',"premiumpress"),
	"4" =>  __('Above Average',"premiumpress"),
	"5" =>  __('Perfect',"premiumpress"),

 );
	   
	    $i=5; while($i > 0){
		 
		 if(isset($data['data'][$i])){  $to = $data['data'][$i]; }else{  $to = 0; } 
		 
		 
		 ?>
      <div class="row">
        <div class="col-11">
          <label class="pb-0 mb-0 small font-weight-bold text-uppercase text-muted mb-2"><?php echo $ratingLabels[$i]; ?></label>
          <div class="progress rounded-0">
            <div class="progress-bar bg-success" role="progressbar" style="width: <?php if($to == 0){ echo 0; }else{ echo $to/$data['votes']*100; } ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="col-1 px-0"> <span class="rating-result-count <?php if($to == 0){ ?>bg-light text-dark<?php } ?>"><?php echo $to; ?></span> </div>
      </div>
      <?php $i--; } ?>
    </div>
  </div>
</div>
<?php } ?>