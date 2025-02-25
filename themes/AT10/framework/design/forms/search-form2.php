  <form method="get" action="">
                <input type="hidden" name="s" value="" />
                 <input type="hidden" name="type" value="1" />
               
                
                  <div class="row">
                    <div class="col-12 mt-3">
 
<select name="tax-make" class="form-control" id="reg_field_tax_make" onchange="ChangeSearchValues('',this.value,'model__make','tx_model[]','-1','0', 'reg_field_tax_model')">
<option value="">Any Make</option>
<?php
$count = 1;
$cats = get_terms( 'make', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
<option value="<?php echo $cat->term_id; ?>"> <?php echo $cat->name; ?></option>
<?php $count++; } } ?> 

</select>

<script>
function ChangeSearchValues(e, t, a, o, n, r, i) {	
	
	  jQuery.ajax({
        type: "GET",  
		url: ajax_site_url,	
        data: {
			core_aj: 1,
            action: "ChangeSearchValues",
			val: t,
            key: a,
			cl: o,
			pr: n,
			add: r,
        },
        success: function(r) { 
		
		jQuery('#'+i).html(r);
		jQuery('#'+i).prop('disabled', false);
		
        },
        error: function(e) {
             
        }
    });	
 
} 
</script>
                           
                      
                    </div>
                    <div class="col-12 mt-3">
                    <select name="tax-model" class="form-control"  id="reg_field_tax_model"><option value="">Any Models</option></select>
                    </div>
                    <div class="col-12 mt-3">
                    <?php $prices = array("5000","10000","15000","20000","30000","40000","50000","60000","70000","80000","90000","100000"); ?>
                      <select class="form-control form-control-custom" name="price2">
                        <option value="">Max Price</option>
                        <?php foreach( $prices as $price){ ?>
                        <option value="<?php echo $price; ?>"><?php echo hook_price($price); ?></option>  
                        <?php } ?>                     
                     
                      </select>
                    </div>
                    <div class="col-12 mt-3">
                      <div class="form-group">
                        <input type="text" name="zipcode" class="form-control form-control-custom" placeholder="Enter a location">
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn-block btn btn-primary py-3" type="submit"><i class="flaticon-search"></i> Search</button>
                    </div>
                  </div>
                </form>