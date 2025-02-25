<?php

global $settings;



 
?>

             

  <div class="carousel slide carousel-fade slide-right" data-ride="carousel" id="<?php echo $settings['sliderID']; ?>">            
                <div class="carousel-inner">                
                <?php $i=1; while($i < 4){				
					if(strlen($settings['image'.$i]) < 5){ $i++; continue; }	
					
					// TEXT DIRECTION
					if($settings['image'.$i.'_txtdir'] == "center"){					
						$txtdir = "justify-content-center";	
						$txts = "text-center ";	
									
					}elseif($settings['image'.$i.'_txtdir'] == "right"){					
						$txtdir = "justify-content-end";	
						$txts = "text-center text-md-left";		
									
					}else{					
						$txtdir = "justify-content-start";	
						$txts = "text-center text-md-left";					
					} 			
				?>
                
             
                    <div class="carousel-item <?php if($i == 1){ ?>active<?php } ?>">
                          <a href="<?php echo $settings['image'.$i.'_btn_link']; ?>" > 
                             
                        <img src="<?php echo $settings['image'.$i]; ?>" class="img-fluid" />
                        
                        </a>
                    </div>
                    
                    <?php $i++; } ?>          
                    
                </div>
               
               <?php if(strlen($settings['image2']) > 1){ ?>
                <ol class="carousel-indicators">
                  <?php $i=0; $g = 1; while($i < 2){ if(strlen($settings['image'.$g]) < 5){ $g++; $i++; continue; }				
				?>
                    <li data-target="#<?php echo $settings['sliderID']; ?>" data-slide-to="<?php echo $i; ?>" class="active"></li>
                    <?php $g ++; $i++; } ?>
                 </ol>  
                 <?php } ?>          
</div>
<!-- end carousel -->