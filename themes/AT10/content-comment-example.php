<?php

$commentdata = array(

	1 => array(
	
		"name" => "James Black",
		"photo" => "https://premiumpress.com/_demoimagesv10/user/1.jpg",
		"desc" => "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.",
		
		"img_small" => "https://premiumpress.com/_demoimagesv10/user/attach_1s.jpg",
		"img_big" => "https://premiumpress.com/_demoimagesv10/user/attach_1.jpg",
		
		"rating_num" => "5.0",
		"rating_text" => "Very Good",
	
	),
	
	
	2 => array(
	
		"name" => "Mark Lilly",
		"photo" => "https://premiumpress.com/_demoimagesv10/user/2.jpg",
		"desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc posuere convallis purus non cursus. Cras metus neque, gravida sodales massa ut.",
		
		"img_small" => "https://premiumpress.com/_demoimagesv10/user/attach_2s.jpg",
		"img_big" => "https://premiumpress.com/_demoimagesv10/user/attach_2.jpg",
		
		"rating_num" => "4.8",
		"rating_text" => "Good",
	),
	
	3 => array(
	
		"name" => "Jack Smith",
		"photo" => "https://premiumpress.com/_demoimagesv10/user/3.jpg",
		"desc" => "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.",
		"img_small" => "",
		"img_big" => "",
		
		"rating_num" => "1.2",
		"rating_text" => "Bad",
	),	
	
);
$i=1;
foreach($commentdata as $c){
 
?>

<div class="comment-single">
   <div class="row">
      <div class="col-12">
         <div class="row">
            <div class="col-2 text-center">
              
               
               
                <?php if(THEME_KEY != "pj"){ ?>
                <div class="review-score-user mt-2">
                     <span><?php echo $c['rating_num']; ?></span>
                    <i class="fal <?php if($c['rating_num'] == 5){ ?>fa-laugh-beam<?php }elseif($c['rating_num'] > 2){ ?>fa-smile<?php }else{ ?>fa-frown<?php } ?> thisone"></i>
                    <!--<strong><?php echo $c['rating_text']; ?></strong>-->
                  </div>
                  <?php } ?>
               
            </div>
            <div class="col-10">
               <div class="comment-area">
               
                    <div class="author">
                  <a href="#">
                  <img alt="phoo" src="<?php echo $c['photo']; ?>" class="avatar img-fluid userphoto avatar-65 photo rounded">
                  </a>
               </div>
               
                  <h5 class="pb-0"><?php echo $c['name']; ?></h5>
                  
                  <div class="small">"<?php echo $c['desc']; ?>"</div>
                 
                
                                                                     </div>
               <div class="bottom pt-3">                  
                  <div class="small text-muted"><i class="fal fa-calendar mr-2"></i> 2hrs ago</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $i++; } ?>