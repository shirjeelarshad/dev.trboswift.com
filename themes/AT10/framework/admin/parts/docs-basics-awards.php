<?php

global $settings, $CORE;
 
  $settings = array("title" => "User Levels", "desc" => "User levels are based on user activity.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  
    
    
    

<table class="table table-bordered bg-white shadow-sm mb-4">
  <thead>
    <tr>
    <th scope="col">Icon</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach($CORE->USER("get_levels", '') as $k => $h){ ?>
 
  
    <tr>
     <td>
     
     <div class="levelicon active current" data-toggle="tooltip" data-placement="top" title="<?php echo $h['name']; ?>"> 
    <?php echo $k; ?>
    </div>
     </td>
  
      <td><div class="p-2"><?php echo $h['name']; ?></div></td>
  
      <td><div class="p-2"><?php echo $h['desc']; ?></div></td>
    </tr>
 
   <?php } ?>



  </tbody>
</table>
 
 

 
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  

<?php

/*

  $settings = array("title" => "User Awards", "desc" => "This is a beta system that's still being implemented.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  
    
    
   
 

<table class="table table-bordered bg-white shadow-sm mb-4">
  <thead>
    <tr>
   	<th scope="col">Icon</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach($CORE->USER("get_awards", $userdata->ID) as $k => $h){ ?>
 
  
    <tr>
     <td>
     <img src="<?php echo get_template_directory_uri(); ?>/framework/images/award/<?php echo "a".$k; ?>.png" alt="<?php echo $h['name']; ?>" class="img-fluid" data-toggle="tooltip" data-placement="top" title="<?php echo $h['name']; ?>" style="max-height:40px;">
     
     </td>
      <td><div class="p-2"><?php echo $h['name']; ?></div></td>
  
      <td><div class="p-2"><?php echo $h['desc']; ?></div></td>
    </tr>
 
   <?php } ?>



  </tbody>
</table>
 
 

 
<?php _ppt_template('framework/admin/_form-wrap-bottom' );

*/ ?>  