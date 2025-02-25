             
            
  <label class="mb-4"><span><?php echo __("Currency Exchange Rates","premiumpress"); ?></span></label>
     
    
    <?php 
	
    $df = array();
	$df['symbol1'] = "&pound;";
	$df['code1'] = "GBP";
	$df['rate1'] = "1.6799";
	
	$df['symbol2'] = "&euro;";
	$df['code2'] = "EUR";
	$df['rate2'] = "1.3849";
	
	$df['symbol3'] = "C$";
	$df['code3'] = "CAD";
	$df['rate3'] = "0.9175";
	
	$df['symbol4'] = "$";
	$df['code4'] = "AUD";
	$df['rate4'] = "0.9371";
	
	$df['symbol5'] = "&yen;";
	$df['code5'] = "JPY";
	$df['rate5'] = "0.0098";
	
			
	$df['symbol6'] = "fal fa-rupee-sign";
	$df['code6'] = "INR";
	$df['rate6'] = "1";	
	
	$df['symbol7'] = "fal fa-ruble-sign";
	$df['code7'] = "RUB";
	$df['rate7'] = "0.013"; 
	 
	$df['symbol8'] = "fal fa-lira-sign";
	$df['code8'] = "TRY";
	$df['rate8'] = "0.014";
	
	$df['symbol9'] = "&#8359;";
	$df['code9'] = "PTS";
	$df['rate9'] = "1141.78";
	
	$df['symbol10'] = "fab fa-bitcoin";
	$df['code10'] = "BTC";
	$df['rate10'] = "11,481.50";
	
	
	
	$i=1; while($i < 11){ ?>
    
	<div class="row mb-2 position-relative" id="crow<?php echo $i; ?>">
    
    <div class="col-md-4">
     
        <label class="small text-uppercase txt500" for="normal-field" rel="tooltip" data-original-title="Example $" data-placement="top"><?php echo __("Symbol","premiumpress"); ?></label>
        <div >
            <input type="text" name="admin_values[cc][symbol<?php echo $i; ?>]" class="form-control btn-block" value="<?php if(_ppt(array('cc','symbol'.$i)) == ""){ echo $df['symbol'.$i]; }else{ echo _ppt(array('cc','symbol'.$i)); } ?>">
        </div>
        
    </div>
    
    <div class="col-md-4">
        
        <label class="small text-uppercase txt500" for="normal-field"><?php echo __("Code","premiumpress"); ?></label>
        <div >
            <input type="text" name="admin_values[cc][code<?php echo $i; ?>]" class="form-control btn-block" value="<?php if(_ppt(array('cc','code'.$i)) == ""){ echo $df['code'.$i]; }else{ echo _ppt(array('cc','code'.$i)); } ?>">
        </div>
     
    </div> 
    
    <div class="col-md-4">
    
        <label class="small text-uppercase txt500" for="normal-field"><?php echo __("Rate","premiumpress"); ?></label>
        <div >
            <input type="text" name="admin_values[cc][rate<?php echo $i; ?>]" class="form-control btn-block" value="<?php if(_ppt(array('cc','rate'.$i)) == ""){ echo $df['rate'.$i]; }else{ echo _ppt(array('cc','rate'.$i)); } ?>">
        </div>
      
    </div>  
    <?php if(_ppt(array('cc','symbol'.$i)) != " "){ ?>
     <div class="position-absolute" style="bottom: 10px; font-size:12px; right:30px; cursor:pointer; color:red; z-index:100" onclick="jQuery('#crow<?php echo $i; ?> input').val(' ');"><i class="fa fa-times"></i> </div>   
      <?php } ?>
    </div>
    <?php $i++; } ?>
 
 
 
<div class="bg-light p-4 mt-3">

<p><?php echo __("Please remember the base currency rate is always set to 1 therefore you should ensure your rates below reflect the price against your base currency.","premiumpress"); ?></p>

<p><?php echo __("For example, if your base currency is GBP. Then the USD rate would be compared against the GBP. Check the latest rates here:","premiumpress"); ?> <a href="https://finance.yahoo.com/currency-converter/#from=GBP;to=USD;amt=1" target="_blank" style="text-decoration:underline;">here</a></p>
   
</div>
     


