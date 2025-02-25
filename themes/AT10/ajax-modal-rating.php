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
    
   if(!_ppt_checkfile("ajax-modal-rating.php")){
   
   
   if(in_array( THEME_KEY, array("sp","cm","ct","so"))){
   
   $r1 = __("Delivery","premiumpress");
   $r2 = __("Packaging","premiumpress");
   $r3 = __("Quality","premiumpress");
   $r4 = __("Value","premiumpress");
   
   }elseif(in_array( THEME_KEY, array("ph","vt"))){
   
   $r1 = __("Quality","premiumpress");
   $r2 = __("Originality","premiumpress");
   $r3 = __("Creativity","premiumpress");
   $r4 = __("Overall","premiumpress");
  
   }else{
   
   $r1 = __("Location","premiumpress");
   $r2 = __("Service","premiumpress");
   $r3 = __("Staff","premiumpress");
   $r4 = __("Value","premiumpress");
   
   }
   
   ?>
<div class="modal-dialog" role="document">
   <div class="modal-content">
      <div class="loginform ajax_modal" id="loginform">
         <div class="modal-body p-0">
            <style>
               .modal-dialog .rating-item1 .fa { color: orange; cursor:pointer; }
            </style>
            <div class="mb-2">
               <button type="button" class="close modalclose" data-dismiss="modal" aria-label="Close" onclick="jQuery('.modal-backdrop').hide();" style="cursor:pointer; width:40px;">
               <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="title"><?php echo __("Have something to say?","premiumpress") ?></h4>
               <p class="subtitle"><?php echo __("Leave comments below but please be respectful otherwise it will be deleted.","premiumpress"); ?></p>
            </div>
            <?php 
               $formextra = "";
               ob_start();
               ?>
               <input type="hidden" name="nocaptcha" value="1" />
            <div class="ratingbox">
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label><?php echo $r1; ?></label>
                     <div class="clearfix"></div>
                     <div class="rating-item1  mt-2"  style="cursor:pointer;">
                        <input type="hidden" class="rating" data-filled="fa fa-star rating-rated" data-empty="far fa-star" data-fractions="2" value="5" name="rating1"/>
                     </div>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label><?php echo $r2; ?></label>
                     <div class="clearfix"></div>
                     <div class="rating-item1 mt-2"  style="cursor:pointer;">
                        <input type="hidden" class="rating" data-filled="fa fa-star rating-rated" data-empty="far fa-star" data-fractions="2" value="5" name="rating2"/>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label><?php echo $r3; ?></label>
                     <div class="clearfix"></div>
                     <div class="rating-item1 mt-2"  style="cursor:pointer;" >
                        <input type="hidden" class="rating" data-filled="fa fa-star rating-rated" data-empty="far fa-star" data-fractions="2" value="5" name="rating3"/>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label><?php echo $r4; ?></label>
                     <div class="clearfix"></div>
                     <div class="rating-item1 mt-2" style="cursor:pointer;" >
                        <input type="hidden" class="rating" data-filled="fa fa-star rating-rated" data-empty="far fa-star" data-fractions="2" value="5" name="rating4"/>
                     </div>
                  </div>
               </div>
            </div>
            <?php
               $formextra = ob_get_clean(); 
 			  // HIDE RATING FOR SOME THEMES
			  if(in_array(THEME_KEY, array('cp','at')) ){
			   $formextra = "";
			  }
			   
               ?>
            <div class="ppt-comment-form-single">
               <?php
                  $comments_args = array(
                           // change the title of send button 
                           'label_submit'=>'Save Comments',
                            'comment_notes_before' => '',
                           // change the title of the reply section
                           'title_reply'=> '', //__("Comments","premiumpress")." <hr />",
                           // remove "Text or HTML to be displayed after the set of comment fields"
                           'comment_notes_after' => '',
                           // redefine your own textarea (the comment body)
                           'comment_field' => '<textarea id="comment" name="comment" aria-required="true" class="form-control mb-3"></textarea>'.$formextra,
                           'logged_in_as' => '',
                           // FIELDS
                           //'fields' => apply_filters( 'comment_form_default_fields', $fields ),
                   );
                  
                  echo comment_form( $comments_args, $_GET['pid'] ); ?>
            </div>
            <script>
              jQuery(document).ready(function(){  					
               		 
               		jQuery('.submit').addClass('btn btn-primary btn-block rounded-0 font-weight-bold text-uppercase');
               		setTimeout(function(){
               		jQuery('.rating').rating({ 'fractions': 1, 'steps': 5});	
               		}, 1000);
               		
               		});
            </script>       
         </div>
      </div>
   </div>
</div>
<?php } ?>