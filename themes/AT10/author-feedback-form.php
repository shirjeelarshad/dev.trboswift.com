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

global $CORE, $userdata, $authorID;

$unidi =  uniqid();
  
if($userdata->ID){

   $r1 = __("Quality","premiumpress");
   $r2 = __("Originality","premiumpress");
   $r3 = __("Creativity","premiumpress");
   $r4 = __("Overall","premiumpress");
 
?>
<form id="addfeedbackform<?php echo $unidi; ?>" name="addfeedbackform" method="post" action="" onsubmit="return CHECKFEEDBACK<?php echo $unidi; ?>();"  class="mb-4">
   <input type="hidden" name="action" value="addfeedback" />  
   
   <input type="hidden" name="replyid" value="" />  
   <?php if(isset($_GET['pid']) && is_numeric($_GET['pid']) ){ ?>
   <input type="hidden" name="pid" value="<?php echo esc_attr($_GET['pid']); ?>" />  
   <?php } ?>
   <?php if(isset($_GET['orderid']) && is_numeric($_GET['orderid']) ){ ?>
   <input type="hidden" name="orderid" value="<?php echo esc_attr($_GET['orderid']); ?>" />  
   <?php } ?>   
   <?php if(isset($_GET['extraid']) && is_numeric($_GET['extraid']) ){ ?>
   <input type="hidden" name="extraid" value="<?php echo esc_attr($_GET['extraid']); ?>" />  
   <?php } ?>
   <?php if(isset($_GET['uid']) && is_numeric($_GET['uid']) ){ ?>
   <input type="hidden" name="uid" value="<?php echo esc_attr($_GET['uid']); ?>" />  
   <?php } ?>
   
   <?php if(isset($_GET['sellerid']) && is_numeric($_GET['sellerid']) ){ ?>
   <input type="hidden" name="sellerid" value="<?php echo esc_attr($_GET['sellerid']); ?>" />  
   <?php } ?>
   
   <?php if(isset($_GET['buyerid']) && is_numeric($_GET['buyerid']) ){ ?>
   <input type="hidden" name="buyerid" value="<?php echo esc_attr($_GET['buyerid']); ?>" />  
   <?php } ?> 
   
   
   <div class="card card-feedback border-0 bg-light">
      <div class="card-body">
         <div class="form-group">
            <label class="font-weight-bold "><?php echo __("Short Description","premiumpress"); ?></label>
            <input type="text" name="subject" value="<?php if(isset($_POST['subject'])){ echo strip_tags(strip_tags($_POST['subject'])); } ?>" class="form-control sub" placeholder="A++ Very Good" >
         </div>
          
         <div class="form-group mt-4">
            <label class="font-weight-bold "><?php echo __("Description","premiumpress"); ?></label>
            <textarea rows="3" class="form-control msg"  style="height:200px;" name="message"><?php if(isset($_POST['message'])){ echo strip_tags(strip_tags($_POST['message'])); } ?></textarea>               
         </div>
         
         <input type="hidden" name="nocaptcha" value="1" />
         
         
       <?php
	  
	  $gg = array(
	  
	  "5" =>  __('Perfect',"premiumpress"),
	   "4" =>  __('Above Average',"premiumpress"),
	   "3" =>  __('Average',"premiumpress"),
	   "2" =>  __('Below Average',"premiumpress"),	   
	  "1" => __('Very Poor',"premiumpress"),
	  
	  );
	  
	  ?>
      
      <p><?php echo __("How would you rate the overall transaction.","premiumpress"); ?></p>
      
      <select class="form-control" name="score">
      
      <?php $i=1; foreach($gg as $kk => $g){ ?>
      
      <option value="<?php echo $kk; ?>"><?php echo $g; ?></option>
      
      <?php $i++; } ?>  
          
      </select>
          
          
         <div class="pt-3 border-top mt-3">
            <button class="btn btn-lg btn-dark rounded-0" type="submit"><?php echo __("Submit Feedback","premiumpress"); ?></button>
         </div>
         
      </div>
   </div>
</form>
<script> 
   function CHECKFEEDBACK<?php echo $unidi; ?>()
   { 
   	
   	var f1 	= jQuery("#addfeedbackform<?php echo $unidi; ?>.sub").val(); 
   	var f2 	= jQuery("#addfeedbackform<?php echo $unidi; ?>.msg").val(); 
   	   	
   	if(f1 == '')
   	{
   		alert('<?php echo __("Please complete all fields.","premiumpress"); ?>');
   		return false;
   	}
   	if(f2 == '')
   	{
   		alert('<?php echo __("Please complete all fields.","premiumpress"); ?>');
   		return false;
   	} 		   		
   	
   	return true;
   }
</script>
<?php } ?>