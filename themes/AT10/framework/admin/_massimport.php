<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
  


_ppt_template('framework/admin/header' ); 

?>
       
<div class="tab-content">



        <div class="tab-pane active " 
        data-title="Mass Import" 
        data-icon="fa-download" 
        id="massimport" 
        role="tabpanel" aria-labelledby="overview-tab">
        
        
         <?php  _ppt_template('framework/admin/parts/_massimport' ); ?> 
    
         </div>     

 
 

</div>  


    
<?php

_ppt_template('framework/admin/footer' ); 

?>