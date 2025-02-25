<?php global $settings, $CORE; 

$settings['title_show'] 		= "yes";
$settings['title'] 		= "This is a test title";
$settings['subtitle'] 	= "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
$settings['desc'] 		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit.";


$text_styles = array(

				"h1" 			=> "H1 - Style 1",
				"h1-2" 			=> "H1 - Style 2",
				"h1-3" 			=> "H1 - Style 3",
				"h1-4" 			=> "H1 - Style 4",
			
				"h1-33" 		=> "--------",
							
				"h2" 			=> "H2 - Style 1",
				"h2-2" 			=> "H2 - Style 2",
				"h2-3" 			=> "H2 - Style 3",
				"h2-4" 			=> "H2 - Style 4",
				
				"h2-33" 		=> "--------",
							
				"h3" 			=> "H3 - Style 1",
				"h3-2" 			=> "H3 - Style 2",
				"h3-3" 			=> "H3 - Style 3",				
				"h3-4" 			=> "H3 - Style 4",
				
				"h3-33" 		=> "--------",	
										
				"h4" 			=> "H4 - Style 1",
				"h4-2" 			=> "H4 - Style 2",
				"h4-3" 			=> "H4 - Style 3",	
				"h4-4" 			=> "H4 - Style 4",								
									
				"h4-33" 		=> "--------",	
				
				"left" 		=> "Title Only - Left",
				"right" 	=> "Title Only -  Right",
				"center" 	=> "Title Only - Center", 
 

);

$card_sizes = array('blank','info','small',  'list','list','list','list-small','list-small','list-small','list-small', 'list-xsmall', 'list-xsmall', 'list-xsmall', 'list-xsmall', 'list-xsmall', 'list-xsmall');

?>

<section class="section-80">
<div class="container">

<h1>Image Setup</h1>

<p>Here we can manage our images.</p>




<?php echo do_shortcode('[IMAGE pid=6693]'); ?>

<hr />

<?php echo do_shortcode('[IMAGE pid=6693 w=300 h=300]'); ?>

<hr />

<?php echo do_shortcode('[IMAGE pid=6693 h=100 w=100]'); ?>

<hr />


</div>
</section>

<section class="section-80">
<div class="container">

<h1>Listing Status Values</h1>

<p>Here is what the listing status values look like.</p>

<?php 


$s =  $CORE->PACKAGE("get_status",  array() ); 

foreach($s  as $status){

echo  '<span class="inline-flex items-center font-weight-bold order-status-icon '.$status['css'].' mr-2"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap">'.$status['name'].'</span> </span>';

}


?> 


</div>
</section>


<section class="section-80">
<div class="container">

<h1>Card Styles</h1>

<p>All themes have 5 basic sizes.  (list-xsmall, list-small, small, blank & info )</p>


<style>
.block-header{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;margin-bottom:24px; font-size:28px;font-weight:700; }
.block-header__title{margin-bottom:0;font-size:20px;}
.block-header__divider{-ms-flex-positive:1;flex-grow:1;height:2px;background:#ebebeb;}
.block-header__title+.block-header__divider{margin-left:16px;}
@media (max-width:767px){
.block-header{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;}
}
</style>


  <div class="container px-0 mt-4">
    <div class="row">
      <div class="col-12">
        <div class="block-header">
          <h3 class="block-header__title">Card X Small</h3>
          <div class="block-header__divider"></div>
        </div>
        <?php 
		
		$settings['card'] = "list-xsmall";
		echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=12 card_class="col-lg-4 col-6"  ]');  ?>
        </div>
    </div>
  </div>



  <div class="container px-0 mt-4">
    <div class="row">
      <div class="col-12">
        <div class="block-header">
          <h3 class="block-header__title">Card Small</h3>
          <div class="block-header__divider"></div>
        </div>
        <?php 
		
		$settings['card'] = "list-small";
		echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=12 card_class="col-6"  ]');  ?>
        </div>
    </div>
  </div>



  <div class="container px-0 mt-4">
    <div class="row">
    
      <div class="col-12">
      
        <div class="block-header">
          <h3 class="block-header__title">Card List</h3>
          <div class="block-header__divider"></div>
        </div>
        <?php 
		
		$settings['card'] = "list";
		echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=5 card_class="col-12"  ]');  ?>
        </div>
    </div>
  </div>




  <div class="container px-0 mt-4">
    <div class="row">
    
      <div class="col-12">
      
        <div class="block-header">
          <h3 class="block-header__title">Card Small</h3>
          <div class="block-header__divider"></div>
        </div>
        <?php 
		
		$settings['card'] = "small";
		echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=4 card_class="col-3"  ]');  ?>
        </div>
    </div>
  </div>
  
  
  
 
  <div class="container px-0 mt-4">
    <div class="row">
    
      <div class="col-12">
      
        <div class="block-header">
          <h3 class="block-header__title">Card Info</h3>
          <div class="block-header__divider"></div>
        </div>
        <?php 
		
		$settings['card'] = "info";
		echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=4 card_class="col-3"  ]');  ?>
        </div>
    </div>
  </div> 
  
  
  
  
  <div class="container px-0 mt-4">
    <div class="row">
    
      <div class="col-12">
      
        <div class="block-header">
          <h3 class="block-header__title">Card Blank</h3>
          <div class="block-header__divider"></div>
        </div>
        <?php 
		
		$settings['card'] = "blank";
		echo do_shortcode('[LISTINGS dataonly=1 nav=0 show=4 card_class="col-3"  ]');  ?>
        </div>
    </div>
  </div>  
  
  
  
<hr />

 

</div>

</section> 


 
 

<section class="section-80">

<div class="container">
<h1>Basic Colors</h1>

<h3 class="my-4">
                        Theme Colors
                        <div class="title-divider-round"></div>
                    </h3>

                    <div class="lead">
                        <p>Here is a sample of the core colors used within Bootstrap and throughout the theme.</p>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-primary rounded text-white">Primary</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-secondary rounded text-white">Secondary</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-success rounded text-white">Success</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-danger rounded text-white">Danger</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-warning rounded text-white">Warning</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-info rounded text-white">Info</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-light rounded text-dark">Light</div>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="p-4 mb-4 bg-dark rounded text-white">Dark</div>
                        </div>
                    </div>

             
</div>


<div class="container">
<h3 class="my-4">Theme Buttons</h3>
        <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-primary mb-4 text-white">Primary</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-secondary mb-4 text-white">Secondary</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-success mb-4 text-white">Success</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-danger mb-4 text-white">Danger</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-warning mb-4 text-white">Warning</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-info mb-4 text-white">Info</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-light mb-4 text-dark">Light</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-dark mb-4 text-white">Dark</a>
                        </div>
                    </div>

</div>

<div class="container">
<h3 class="my-4">Button Styles</h3>
        <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                        
                        <h5>Style 1 - normal</h5>
                        <hr />
                            
                            
                            <a href="#" class="btn-block btn btn-primary mb-4 btn-border-2">primary</a>
                            
                            <a href="#" class="btn-block btn btn-secondary mb-4 btn-border-2">secondary</a>
                            
                             <a href="#" class="btn-block btn btn-dark mb-4 btn-border-2">dark</a>
                            
                            <a href="#" class="btn-block btn btn-light mb-4 btn-border-2">light</a>
                             
                            <a href="#" class="btn-block btn btn-dark btn-border-2"> With Icon <i class="fa fa-long-arrow-right "></i></a>
                           
                           
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                        
                         <h5>Style 2 - outlined</h5>
                        <hr />
                            
                            
                             <a href="#" class="btn-block btn btn-outline-primary mb-4 btn-border-2">primary</a>
                            
                            <a href="#" class="btn-block btn btn-outline-secondary mb-4 btn-border-2">secondary</a>
                            
                             <a href="#" class="btn-block btn btn-outline-dark mb-4 btn-border-2">dark</a>
                            
                            <a href="#" class="btn-block btn btn-outline-light mb-4 btn-border-2">light</a>
                             
                            <a href="#" class="btn-block btn btn-outline-dark btn-border-2"> With Icon <i class="fa fa-long-arrow-right "></i></a>
                           
                            
                            
                        </div>
                        
                        
                        <div class="col-sm-6 col-md-4 col-lg-3">
                        
                         <h5>Style 3 - normal rounded</h5>
                        <hr />
                            
                        
                            <a href="#" class="btn-block btn btn-primary btn-rounded-25 mb-4 btn-border-2">primary</a>
                            
                            <a href="#" class="btn-block btn btn-secondary btn-rounded-25  mb-4 btn-border-2">secondary</a>
                            
                             <a href="#" class="btn-block btn btn-dark btn-rounded-25  mb-4 btn-border-2">dark</a>
                            
                            <a href="#" class="btn-block btn btn-light btn-rounded-25  mb-4 btn-border-2">light</a>
                             
                            <a href="#" class="btn-block btn btn-dark btn-rounded-25  btn-border-2"> With Icon <i class="fa fa-long-arrow-right "></i></a>
                           
                            
                        
                        
                        
                        </div>

  <div class="col-sm-6 col-md-4 col-lg-3">
                        
                         <h5>Style 4 - outlined rounded</h5>
                        <hr />
                            
                        
                         
                            <a href="#" class="btn-block btn btn-outline-primary btn-rounded-25 mb-4 btn-border-2">primary</a>
                            
                            <a href="#" class="btn-block btn btn-outline-secondary btn-rounded-25  mb-4 btn-border-2">secondary</a>
                            
                             <a href="#" class="btn-block btn btn-outline-dark btn-rounded-25  mb-4 btn-border-2">dark</a>
                            
                            <a href="#" class="btn-block btn btn-outline-light btn-rounded-25  mb-4 btn-border-2">light</a>
                             
                            <a href="#" class="btn-block btn btn-outline-dark btn-rounded-25  btn-border-2"> With Icon <i class="fa fa-long-arrow-right "></i></a>
                         
                        
                        
                        </div>




                       
                    </div>

</div>





<div class="container mt-5">
<h3 class="my-4">System Style Buttons</h3>
        <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-2">
                            
                            <div class=" mb-4"><a class="btn-sm btn btn-system"><i class="fa fa-cog"></i> Small</a> </div>
                            
                            
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-2">
                            <a class=" btn btn-system">Normal</a>
                        </div>
                        
                         <div class="col-sm-6 col-md-4 col-lg-2">
                            <a class=" btn btn-md btn-system">Medium</a>
                        </div>

                          <div class="col-sm-6 col-md-4 col-lg-2">
                            <a class=" btn btn-lg btn-system">Large</a>
                        </div>
                        
                          <div class="col-sm-6 col-md-4 col-lg-2">
                            <a class=" btn btn-xl btn-system">Extra Large</a>
                        </div>

                       
                    </div>

</div>

<div class="container">
<h3 class="my-4">Button Sizes</h3>
        <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-sm btn btn-primary mb-4 text-white">Small</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class=" btn btn-secondary mb-4 text-white">Normal</a>
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-lg btn btn-success mb-4 text-white">Large</a>
                        </div>
                        
                          <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-xl btn btn-success mb-4 text-white">Extra Large</a>
                        </div>

                       
                    </div>

</div>

<div class="container">
<h3 class="my-4">Button Icons</h3>
        <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-sm btn btn-primary mb-4 text-white btn-icon"><i class="fa fa-cog"></i> Small</a>
                            
                        <hr />
                            
                            <a class="btn-sm btn btn-primary mb-4 text-white btn-icon icon-before mt-3"><i class="fa fa-cog"></i> Icon Left </a>
                            
                             <a class="btn-sm btn btn-primary mb-4 text-white btn-icon btn-block mt-3 icon-before"><i class="fa fa-cog"></i> Icon Left Block</a>
                            
                            <hr />
                            
                             <a class="btn-sm btn btn-primary mb-4 text-white btn-icon  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right</span> </a>
                          
                           <a class="btn-sm btn btn-primary mb-4 text-white btn-icon btn-block  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right Block</span> </a>
                          
                            
                            
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class=" btn btn-secondary mb-4 text-white btn-icon"><i class="fa fa-cog"></i> Normal</a>
                            
                            <hr />
                            
                            <a class="btn btn-secondary mb-4 text-white btn-icon icon-before mt-3"><i class="fa fa-cog"></i> Icon Left </a>
                            
                             <a class="btn btn-secondary mb-4 text-white btn-icon btn-block mt-3 icon-before"><i class="fa fa-cog"></i> Icon Left Block</a>
                            
                            <hr />
                            
                             <a class="btn btn-secondary mb-4 text-white btn-icon  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right</span> </a>
                          
                           <a class="btn btn-secondary mb-4 text-white btn-icon btn-block  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right Block</span> </a>
                          
                            
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-lg btn btn-success mb-4 text-white btn-icon"><i class="fa fa-cog"></i> Large</a>
                            
                            
                            <hr />
                            
                            <a class="btn-lg btn btn-success mb-4 text-white btn-icon icon-before mt-3"><i class="fa fa-cog"></i> Icon Left </a>
                            
                             <a class="btn-lg btn btn-success mb-4 text-white btn-icon btn-block mt-3 icon-before"><i class="fa fa-cog"></i> Icon Left Block</a>
                            
                            <hr />
                            
                             <a class="btn-lg btn btn-success mb-4 text-white btn-icon  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right</span> </a>
                          
                           <a class="btn-lg btn btn-success mb-4 text-white btn-icon btn-block  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right Block</span> </a>
                           
                        </div>
                        
                          <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-xl btn btn-success mb-4 text-white btn-icon"><i class="fa fa-cog"></i> Extra Large</a>
                            
                            <hr />
                      
                            
                            <a class="btn-xl btn btn-success mb-4 text-white btn-icon icon-before mt-3"><i class="fa fa-cog"></i> Icon Left </a>
                            
                             <a class="btn-xl btn btn-success mb-4 text-white btn-icon btn-block mt-3 icon-before"><i class="fa fa-cog"></i> Icon Left Block</a>
                            
                            <hr />
                            
                             <a class="btn-xl btn btn-success mb-4 text-white btn-icon  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right</span> </a>
                          
                           <a class="btn-xl btn btn-success mb-4 text-white btn-icon btn-block  mt-3 icon-after"><i class="fa fa-cog"></i> <span>Icon Right Block</span> </a>
                           
                        </div>

                       
                    </div>

</div>

 
<div class="container">
<h3 class="my-4">Admin Buttons</h3>
        <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <a class="btn-block btn btn-admin mb-4 text-white">Primary</a>
                        </div>
                      

<div class="col-sm-6 col-md-4 col-lg-3">
<a class="btn-block btn btn-admin color1 mb-4 text-white">Color 1</a>
</div>

<div class="col-sm-6 col-md-4 col-lg-3">
<a class="btn-block btn btn-admin color2 mb-4 text-white">Color 2</a>
</div>                        
                        
<div class="col-sm-6 col-md-4 col-lg-3">
<a class="btn-block btn btn-admin color3 mb-4 text-white">Color 3</a>
</div>



 
                        
                    </div>

</div>



  </div> </div>
</section>
























<section class="section-80">

<div class="container">
<h1>Theme UI</h1>

<h3 class="my-4">
                        Global UI Elements
                        <div class="title-divider-round"></div>
                    </h3>

                    <div class="lead">
                        <p>Here is a sample of the core colors used within Bootstrap and throughout the theme.</p>
                    </div>
 

<div class="row mt-4">

<div class="col-md-6 pr-lg-5">

<form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Example select</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Example multiple select</label>
    <select multiple class="form-control" id="exampleFormControlSelect2">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  
  <button class="btn btn-primary">Primary Button</button>
</form>
</div>

<div class="col-md-6 pl-lg-5">

<form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Nice Select</label>
    <select class="nice-select wide" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Example multiple select</label>
    <select multiple class="form-control" id="exampleFormControlSelect2">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  
  <button class="btn btn-primary">Primary Button</button>
</form>



</div>

</div>


             
</div>
  </div> </div>
</section>
