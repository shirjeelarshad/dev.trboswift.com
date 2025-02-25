<?php

global $settings, $wpdb;
 
  $settings = array("title" => "Database", "desc" => "Here are a list of tables and table values used by the theme.");
   _ppt_template('framework/admin/_form-wrap-top' ); 
   
   
   $g = get_post_types();
   
   ?>

<div class="card card-admin">
  <div class="card-body">
    <table class="table table-bordered bg-white shadow-sm mb-4">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Used By Theme</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($g as $k => $h){ ?>
        <tr>
          <td><?php echo $k; ?> </td>
          <td><div class="p-2"><?php echo $h; ?></div></td>
          <td style="text-align:center;"><div class="p-2">
              <?php if( strpos($h ,"ppt_") === false && $h != "listing_type" ){ ?>
              
              <div class="opacity-5">No</div>
              
              <?php }else{  
			   
			  
			  	$total = 0;
			  	$SQL = "select count(*) AS total FROM ".$wpdb->prefix."posts WHERE ".$wpdb->prefix."posts.post_type='".$h."'";
			 
			  
			  	$result = $wpdb->get_results($SQL);
				$total = $result[0]->total;		 
			  
			  ?>
              
               
                <div class="small text-uppercase"><?php echo number_format( $total); ?> entries</div>
                
                <a href="admin.php?page=docs&deletedb=<?php echo $h; ?>" class="btn btn-system btn-sm mt-2">delete all</a>
              
              <?php } ?>
              
              
              
            </div></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
