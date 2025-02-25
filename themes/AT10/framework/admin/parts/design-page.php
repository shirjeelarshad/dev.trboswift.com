<div class="container px-0">
    <div class="row">
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4">Sidebar Position</h3>        
        <p class="text-muted lead mb-4"> Here you can enter your own custom CSS/meta code.</p>
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">


 
      <?php $ha = array(
	  
         0 => array("id" => "2", "name" => "Left Sidebar", "icon" => "h11.jpg"),
         1 => array("id" => "3", "name" => "Right Sidebar", "icon" => "h12.jpg"),
         2 => array("id" => "1", "name" => "No Sidebar", "icon" => "h1.jpg"),
	  	3 => array("id" => "4", "name" => "3 Columns", "icon" => "h13.jpg"),
      
          
         ); ?>
      <style>
         #page_columns .shadow { border:2px solid #76bd70 !important;     box-shadow: none !important; }
      </style>
      <div class="row" id="page_columns">
         <?php foreach($ha as $key => $h){ ?>
         <div class="col-6 text-center">
            <div class="py-4">
               <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/images/<?php echo $h['icon']; ?>" style="cursor:pointer;" class="border mb-1 img-fluid <?php if(_ppt(array('design','page_columns')) == $h['id']){ echo "shadow"; } ?>" onclick="jQuery('#page_columns img').removeClass('shadow');jQuery(this).addClass('shadow');jQuery('#header_page_columns').val('<?php echo $h['id']; ?>');document.admin_save_form.submit();" />
               <div>
               <small class="text-muted text-uppercase" style="font-size:11px;"><?php echo $h['name']; ?></small>
               </div>
            </div>
         </div>
         <?php } ?>
         <input 
            name="admin_values[design][page_columns]" 
            type="hidden" 
            id="header_page_columns" 
            value="<?php if(_ppt(array('design','page_columns')) != ""){  echo stripslashes(_ppt(array('design','page_columns'))); }else{ echo 0; } ?>" />
        </div>
        
        </div></div>
        </div>
        
        
</div></div>


  
<div class="container px-0">
    <div class="row">
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4">Page Size</h3>        
        <p class="text-muted lead mb-4">Here you can enter your own javascript code.</p>
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">
         
      <?php $ha2 = array(
	  
         0 => array("id" => "1", "name" => "Boxed Layout", "icon" => "boxed.png" ),
         1 => array("id" => "2", "name" => "Fluid Layout", "icon" => "fluid.png"),
		 
		 
		 
         
         ); ?>
      <style>
         #page_layout .shadow { border:2px solid #76bd70 !important;     box-shadow: none !important; }
      </style>
      <div class="row" id="page_layout">
         <?php foreach($ha2 as $key => $h){ ?>
         <div class="col-6">
            <div class="py-4">
               <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/images/<?php echo $h['icon']; ?>" style="cursor:pointer;" class="border mb-1 img-fluid <?php if(_ppt(array('design','page_layout')) == $h['id']){ echo "shadow"; } ?>" onclick="jQuery('#page_layout img').removeClass('shadow');jQuery(this).addClass('shadow');jQuery('#header_page_layout').val('<?php echo $h['id']; ?>'); document.admin_save_form.submit();" />
               <div>
               <small class="text-muted text-uppercase" style="font-size:11px;"><?php echo $h['name']; ?></small>
               </div>
            </div>
         </div>
         <?php } ?>
         
         <input 
            name="admin_values[design][page_layout]" 
            type="hidden" 
            id="header_page_layout" 
            value="<?php if(_ppt(array('design','page_layout')) != ""){  echo _ppt(array('design','page_layout')); }else{ echo 0; } ?>" />
 
        </div>
        
        </div></div>
        </div>
        
        
</div></div>