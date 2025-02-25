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


$editID=0;
if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
} 

$rec = array(

	1 => array("name" => "jumpshare", "link" => "https://jumpshare.com/"),
	2 => array("name" => "mediafire", "link" => "https://www.mediafire.com/"),
	3 => array("name" => "DropSend", "link" => "https://www.dropsend.com/"),
	4 => array("name" => "Bit.ai", "link" => "https://bit.ai/"),
	5 => array("name" => "Dropbox", "link" => "https://www.dropbox.com/"),
	6 => array("name" => "Hightail", "link" => "https://www.hightail.com/"),
	
);
 
?>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <h4><?php echo __("Course Materials","premiumpress"); ?></h4>
      
        <hr />
      </div> 
  
      <div class="col-12">
      
      
       <p><?php echo __("Course materials are provided to users after they have enrolled.","premiumpress"); ?></p>
       
      
       <p><?php echo __("Please provide a full download link where the course mateirlas can be downloaded.","premiumpress"); ?></p>
       
      
      
        <label class="font-weight-bold"> <?php echo __("Download Link","premiumpress"); ?> </label>
        <div class="input-group">
          <input name="custom[download_path]" class="form-control" value="<?php echo $CORE->get_edit_data('download_path', $editID); ?>" placeholder="https://..." />
        </div> 
        
        
      </div>
      
      <div class="col-12">
      
      <h6 class=" mt-4"><?php echo __("We Recommend","premiumpress"); ?></h6>
      <p><?php echo __("We recommend the following file sharing website for uploading your course materials too.","premiumpress"); ?></p>
      </div>
      
       <?php foreach($rec as $r){ ?>
        <div class="col-md-4 mt-4">
        
        <div class="card p-3 text-center bg-light shadow-sm">
       <a href="<?php echo $r['link']; ?>" target="_blank" class="text-dark"><?php echo $r['name']; ?></a>
        </div>
        
        </div>
        <?php } ?>
      
      
    </div>
  </div>
</div>
