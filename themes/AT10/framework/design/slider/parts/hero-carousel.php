<?php

global $settings;

 
 
?><div class="carousel slide carousel-fade slide-right hero-slider" data-ride="carousel" id="<?php echo $settings['sliderID']; ?>">            
                <div class="carousel-inner bg-light">                
                <?php $i=1; while($i < 4){	
				
					if(!isset($settings['image'.$i]) || isset($settings['image'.$i]) && strlen($settings['image'.$i]) < 5){ $i++; continue; }	
					
					 
					 
					if($settings['image'.$i.'_txtcolor'] == ""){ $settings['image'.$i.'_txtcolor'] = "dark"; }
					
					// DEFAULTS
					$div_size = "col-md-6 col-lg-4";
					$btnmargin = "mt-lg-4 py-lg-3 px-lg-5"; 
				
					if($settings['sliderID'] == "hero_transparent"){
					
					$text_size = "text-xl";	
					$div_size = "col-md-6 col-lg-5";
					
					}elseif($settings['sliderID'] == "hero_search1"){
					
					$text_size = "text-m"; 	
					$btnmargin = "mt-lg-2"; 	
							 
					}else{
					$text_size = "text-l";
					
					
					}			
					
					
					// TEXT DIRECTION
					if(isset($settings['image'.$i.'_txtdir']) && $settings['image'.$i.'_txtdir'] == "center"){	
									
						$txtdir = "justify-content-center";	
						$txts = "text-center ";	
						
						if( in_array($settings['sliderID'], array("hero_full" )) ){
						
 						$div_size = "col-md-6 col-lg-5";
						
						
						}
						
									
					}elseif( isset($settings['image'.$i.'_txtdir']) && $settings['image'.$i.'_txtdir'] == "right"){					
						$txtdir = "justify-content-end";	
						
						$txts = "text-center text-md-left";	
						
						
						if( in_array($settings['sliderID'], array("hero_inline" )) ){
 						$div_size = "col-md-6 col-lg-5 pr-lg-51";
						
						}elseif( in_array($settings['sliderID'], array("hero_search1" )) ){
 						$div_size = "col-md-6 col-lg-5 pr-lg-51";
						}
						
							
									
					}else{					
						$txtdir = "justify-content-start";	
						$txts = "text-center text-md-left";	
						
						if( in_array($settings['sliderID'], array("hero_inline")) ){
 						$div_size = "col-md-6 col-lg-4 offset-lg-1";
						
						}elseif( in_array($settings['sliderID'], array("hero_search1")) ){
 						$div_size = "col-md-6 col-lg-5 offset-lg-1";
						}
										
					} 	
					
					
					 
				?><div class="carousel-item <?php if($i == 1){ ?>active<?php } ?>">
                         
                            <div class="single-slide-item <?php echo $text_size; ?>" >
                            
                            <img src="<?php echo $settings['image'.$i]; ?>" class="d-block w-100" />
                            
                            <div class="hero-content">
                            <div class="container">
                            <div class="row <?php echo $txtdir; ?>">
                            <div class="<?php echo $div_size; ?> <?php echo $txts; ?>">
                             
                             
                               <div class="hero-content <?php echo $txts; ?> text-<?php echo $settings['image'.$i.'_txtcolor']; ?>">
                                               
                                               <?php if(isset($settings['image'.$i.'_title']) && strlen($settings['image'.$i.'_title']) > 2){ ?>
                                                <h1 <?php if($i == 1){ ?>class="flipInX animated"<?php } ?>>
                                                 <?php echo $settings['image'.$i.'_title']; ?>  
                                                </h1>
                                                <?php } ?>
                                                
                                                <?php if(strlen($settings['image'.$i.'_desc']) > 2){ ?>
                                                <p <?php if($i == 1){ ?>class="fadeInUp animated delay-03"<?php } ?>><?php echo $settings['image'.$i.'_desc']; ?></p>
                                                <?php } ?> 
                                                
                                                <?php if(strlen($settings['image'.$i.'_btn_link']) > 1){ ?>
                                                <a href="<?php echo $settings['image'.$i.'_btn_link']; ?>" 
                                                class="btn btn-outline-<?php echo $settings['image'.$i.'_txtcolor']; ?> <?php if($i == 1){ ?>zoomIn animated delay-06<?php } ?> font-weight-bold rounded-0 text-uppercase <?php echo $btnmargin; ?>"><?php if($settings['image'.$i.'_btn_text'] == ""){ echo "Search Website"; }else{ echo $settings['image'.$i.'_btn_text']; } ?></a>
                                                <?php } ?>
                                                
                                                
                                                
                                                
                                            </div>
                            
                            
                            </div>
                            </div>
                            </div>   
                            </div>   
                                               
                        </div>
                    </div>
                    
                    <?php $i++; } ?>          
                    
                </div>
               
               
           <?php if( !in_array($settings['sliderID'], array("hero_inline","hero_search1")) ){ ?> 
            <a class="carousel-control-prev" href="#<?php echo $settings['sliderID']; ?>" role="button" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#<?php echo $settings['sliderID']; ?>" role="button" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
            <?php } ?>
            
                
                
                <ol class="carousel-indicators">
                  <?php $i=0; $g = 1; 
				  
				  while($i < 4){ 
				  
				  if(isset($settings['image'.$i]) && strlen($settings['image'.$i]) > 5){ 			
				?>
                    <li data-target="#<?php echo $settings['sliderID']; ?>" data-slide-to="<?php echo $g; ?>" <?php if($g == 1){ ?>class="active"<?php } ?>></li>
                
                <?php $g ++; }  $i++;  } ?>
                    
                 </ol>            
                
</div>
<!-- end carousel -->