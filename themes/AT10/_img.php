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

 
global $CORE, $userdata, $settings;

 	$te = explode("wp-content",$_SERVER['SCRIPT_FILENAME']);
	$SERVER_PATH_HERE = $te[0];
	
	if(file_exists($SERVER_PATH_HERE.'/wp-config.php')){
				 
		require( $SERVER_PATH_HERE.'/wp-config.php' );
	
	}else{
	
		die('<h1>Server Path Incorrect</h1>
		<p>The script could not generate the correct server path to your invoice file.</p>
		<p>Please edit the file below and manually set the correct server path.</p>
		<p>'.$_SERVER['SCRIPT_FILENAME'].'</p>');
	
	}
	
	if(!isset($_GET['pid']) && !is_numeric($_GET['pid']) && !isset($_GET['aid']) && !is_numeric($_GET['aid']) ){
	
	die("who are you?");
	
	}


$path = "";

$g = get_post_meta($_GET['pid'], 'image_array', true);

// GET FILE PATH FROM ARRAY
if(is_array($g)){

	foreach($g as $file){
	
		if($file['id'] == $_GET['aid']){
			 
			$path = $file['filepath'];	
			$type = $file['type'];
		
		}	
	}

}

// NO IMAGE FOUND
if($path == ""){
	die("whopps, I dont know you..");
}

// DEFAULTS
$constrain = 0;  $perc = 0;

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

$resize = new ResizeImage($path);

// TT = TYPE
if(isset($_GET['tt']) && is_numeric($_GET['tt'])){
	
	switch($_GET['tt']){
	
		case "1": { // LISTING IMAGES / CAROUE/ SEARCH ETC		
		
		
		// RESIZE FOR FITBOX 		 
		$resize->resizeTo(800, 600, 'fitbox'); 
		
		
		if(isset($_GET['max']) && is_numeric($_GET['max'])){
		$resize->resize($_GET['max'], true); 
		}else{
		
		$resize->resize(600, true); 
		}
		 
		
		} break;	
	
	}

}else{

	// MAX WIDTH FOR THUMBS IS 600PX	
	$resize->resizeTo(600,'','maxwidth'); // exact
	


}

//max
if(isset($_GET['max']) && is_numeric($_GET['max'])){
$resize->resize($_GET['max']); 
}
$resize->saveImage();


////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////




class ResizeImage
{
	private $ext;
	private $image;
	private $newImage;
	private $imgResized;
	private $origWidth;
	private $origHeight;
	private $resizeWidth;
	private $resizeHeight;
	private $canvusHeight;
	private $canvusWidth;
	
 
	public function __construct( $filename )
	{
		if(file_exists($filename))
		{
			$this->setImage( $filename );
			
		} else {
			throw new Exception('Image ' . $filename . ' can not be found, try another image.');
		}
	}
 
	private function setImage( $filename )
	{
		$size = getimagesize($filename);
		
		$this->ext = $size['mime'];
		$this->origWidth = $size[0];
		$this->origHeight = $size[1];
	  
		switch($this->ext){
		
	    	// Image is a JPG
	        case 'image/jpg':
	        case 'image/jpeg':
	        	// create a jpeg extension
	            $this->image = imagecreatefromjpeg($filename);
	            break;

	        // Image is a GIF
	        case 'image/gif':
	            $this->image = @imagecreatefromgif($filename);
	            break;

	        // Image is a PNG
	        case 'image/png':
	            $this->image = @imagecreatefrompng($filename);
	            break;

	        // Mime type not found
	        default:
	            throw new Exception("File is not an image, please use another file type.", 1);
	    }

	    $this->origWidth = imagesx($this->image);
	    $this->origHeight = imagesy($this->image);
	} 
	
	public function saveImage()
	{	    
		
		header("Content-type: image/jpeg");
		imagejpeg( $this->newImage, null, 70);
		die();	 
		
	}
	
	function resize($maxwidth, $fixedbox = false){
		 
		
		$resized_canvus_w = $maxwidth;
		
		if($fixedbox){
		
			$resized_canvus_h = floor((600/800)*$maxwidth);
			$ssw = 800; 
			$ssh = 600; 			
		
		}else{
		
			$resized_canvus_h = floor(($this->resizeHeight/$this->resizeWidth)*$maxwidth);
			$ssw = $this->resizeWidth;
			$ssh = $this->resizeHeight;			
		} 
			
		
		//die($resized_canvus_h." //".$this->resizeHeight." // ".$this->resizeWidth);	
		
	 	$resized_w = $maxwidth;
		$resized_h = $resized_canvus_h;	  
	 	
		$this->imgResized = imagecreatetruecolor($resized_canvus_w,$resized_canvus_h);
		
		// ATTACH IMAGE
    	imagecopyresampled($this->imgResized, $this->newImage, 	
		$new_w = 0, // a
		$new_h = 0, // b
		$crop_w = 0, // c
		$crop_h = 0, // d
		$resized_w,
		$resized_h, 
		$ssw, 
		$ssh);	
		
		header("Content-type: image/jpeg");
		imagejpeg( $this->imgResized, null, 70);
		die();	 
		 
	
	}
 
 
	public function resizeTo( $width = "", $height = "", $resizeOption = 'default' )
	{
		
		if($width == ""){
		$width = $this->origWidth;
		}
		
		if($height == ""){
		$height = $this->origHeight;
		}
	
		$new_w = 0; // a
		$new_h = 0; // b
		$crop_w = 0; // c
		$crop_h = 0; // d
	
		switch(strtolower($resizeOption))
		{
		
			case 'fitbox': {
				
				$this->canvusHeight = $height; // 800
				$this->canvusWidth = $width; // 600				
			  
			 	if($this->origWidth > $width){	
				
					$this->resizeWidth  = $width;
					$this->resizeHeight = $this->resizeHeightByWidth($width);						
					
					// CENTER IMAGE									 
					$new_h = -($this->resizeHeight - $height ) /2;					 
					$new_w = 0;										 									 
					
				}else{
					
					$this->resizeWidth  = $this->resizeWidthByHeight($height);
					$this->resizeHeight = $height;
					
					// CENTER IMAGE
					$new_w =  -($this->resizeWidth - $width) / 2;					
					$new_h = 0;			
				}
			 
				
			} break;
			
			case 'exact': {
				$this->resizeWidth = $width;
				$this->resizeHeight = $height;
				
				$this->canvusHeight = $this->resizeWidth;
				$this->canvusWidth = $this->resizeHeight;
				
			} break;

			case 'maxwidth': {
				
				
				$this->canvusHeight = $this->resizeHeightByWidth($width);
				$this->canvusWidth = $width;			
			
				$this->resizeWidth  = $width;
				$this->resizeHeight = $this->resizeHeightByWidth($width);
				
				
			} break;

			case 'maxheight': {
			
				$this->resizeWidth  = $this->resizeWidthByHeight($height);
				$this->resizeHeight = $height;
				
				$this->canvusHeight = $this->resizeWidth;
				$this->canvusWidth = $this->resizeHeight;
				
			} break;

			default: {
			
				$this->canvusHeight = $height;
				$this->canvusWidth = $width;
				
				$this->resizeWidth  = $width;
				$this->resizeHeight = $height;
			
			
			} break;
		}		 
		 
		
		 
		// CREATE NEW CANBUS	
		$this->newImage = imagecreatetruecolor($this->canvusWidth,$this->canvusHeight);
			
		// WHITE BACKGROUND
		$g = _ppt(array('lst', 'default_crop_bg'));
		if($g == 1){ }else{
			imagefill($this->newImage, 0, 0, imagecolorallocate($this->newImage, 255, 255, 255));  // white background;
		}		 
		
		// ATTACH IMAGE
    	imagecopyresampled($this->newImage, $this->image, 	
		$new_w, // a
		$new_h, // b
		$crop_w, // c
		$crop_h, // d
		$this->resizeWidth,
		$this->resizeHeight, 
		$this->origWidth, 
		$this->origHeight);		
		
		 /*
		 a,b - start pasting the new image into the top-left of the destination image
		c,d - start sucking pixels out of the original image at 200,134
		e,f - make the resized image 75x75 (fill up the thumbnail)
		g,h - stop copying pixels at 600x402 in the original image
		*/
 
		
	}

 
	private function resizeHeightByWidth($width)
	{
		return floor(($this->origHeight/$this->origWidth)*$width);
	}
 
	private function resizeWidthByHeight($height)
	{
		return floor(($this->origWidth/$this->origHeight)*$height);
	}
}
?>