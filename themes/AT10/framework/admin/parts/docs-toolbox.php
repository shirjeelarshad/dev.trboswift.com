<?php

global $settings;
 
  $settings = array("title" => "Version 9/10", "desc" => "A collection of useful functions for upgrading from v9 themes.");
   _ppt_template('framework/admin/_form-wrap-top' ); 
   
    
   
   ?>

<div class="card card-admin">
  <div class="card-body">
    <h3>Actions</h3>
    <hr />
    
    <div class="bg-light shadow-sm p-4">
      <div class="row">
        <div class="col-md-8">
          <h4>Update Featured Listings</h4>
          <p>This will change all "featured" listings to use the value "1" instead of "yes" which was used in v9.</p>
        </div>
        <div class="col-md-4">
          <form method="post" action="admin.php?page=docs" >
            <input type="hidden" name="page" value="docs" />
            <input type="hidden" name="toolbox" value="v9_featured" />
            <button type="submit" class="alertme btn btn-info float-right" >
            Update Now</a>
          </form>
        </div>
      </div>
    </div>
    
        <hr />
    
    <div class="bg-light shadow-sm p-4">
      <div class="row">
        <div class="col-md-8">
          <h4>Update Expired Listings</h4>
          <p>This will change all "expired" listings to active and set the date +30 days if no package date is found.</p>
        </div>
        <div class="col-md-4">
          <form method="post" action="admin.php?page=docs" >
            <input type="hidden" name="page" value="docs" />
            <input type="hidden" name="toolbox" value="v9_expired" />
            <button type="submit" class="alertme btn btn-info float-right" >
            Update Now</a>
          </form>
        </div>
      </div>
      
    </div>
    
    
   <?php if(THEME_KEY == "cp"){ ?> 
        <hr />
    
    <div class="bg-light shadow-sm p-4">
      <div class="row">
        <div class="col-md-8">
          <h4>Verify All Coupon</h4>
          <p>This will set all coupons to verified.</p>
        </div>
        <div class="col-md-4">
          <form method="post" action="admin.php?page=docs" >
            <input type="hidden" name="page" value="docs" />
            <input type="hidden" name="toolbox" value="cp_verified" />
            <button type="submit" class="alertme btn btn-info float-right" >
            Update Now</a>
          </form>
        </div>
      </div>
    </div>
    
        <hr />
        
        <?php } ?>
    
    <div class="bg-light shadow-sm p-4">
      <div class="row">
        <div class="col-md-8">
          <h4>Verify All Users</h4>
          <p>This will set all user accounts to verified.</p>
        </div>
        <div class="col-md-4">
          <form method="post" action="admin.php?page=docs" >
            <input type="hidden" name="page" value="docs" />
            <input type="hidden" name="toolbox" value="v9_verified" />
            <button type="submit" class="alertme btn btn-info float-right" >
            Update Now</a>
          </form>
        </div>
      </div>
    </div>
    
    
         <hr />
    
    <div class="bg-light shadow-sm p-4">
      <div class="row">
        <div class="col-md-8">
          <h4>Set All User Memberships</h4>
          <p>This will set all usrs to the membership you set below.</p>
        </div>
        <div class="col-md-4">
          <form method="post" action="admin.php?page=docs" >
            <input type="hidden" name="page" value="docs" />
            <input type="hidden" name="toolbox" value="v9_membership" />
            
            <?php

	$status = array( "" => "None");
	// ADD ON MEMBERSHIPS
	$i=1; 
	while($i < 11){ 	
	
	
		if(_ppt('mem'.$i.'_name') == ""){ $n =  ""; }else{ $n =  _ppt('mem'.$i.'_name'); } 			
		if($n == ""){ $i++; continue; }
			
		$status['mem'.$i] = $n;
		$i++;
	}
 
	
	?>
                <select name="membership"   class="form-control" style="widht:100%;">
                  <?php foreach($status as $key => $club){ ?>
                  <option value="<?php echo $key; ?>"><?php echo $club; ?></option>
                  <?php } ?>
                </select>
            
            
            
            
            
            <button type="submit" class="alertme btn btn-info float-right" >
            Update Now</a>
          </form>
        </div>
      </div>
    </div>
    
    
    
    
    
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
