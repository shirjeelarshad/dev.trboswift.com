<?php

global $settings;
 
  $settings = array("title" => "Framework Basics", "desc" => "Here is an overview of the typography changes within this framework");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <h3 class="my-4"> Bootstrap 4.3.1
      <div class="title-divider-round"></div>
    </h3>
    <p class="lead">All AutoCoin themes and child themes are built using the Bootstrap CSS framework.</p>
    <a href="https://getbootstrap.com/docs/4.3/content/typography/" target="_blank" class="btn btn-admin mb-3 py-3"> <span class="btn-inner-icon"><i class="fas fa-info-circle"></i></span> <span class="btn-inner-text">Bootstrap 4 documentation</span> </a>
    <div class="mt-4"> <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&amp;tid=typography" target="_blank" class="btn btn-admin btn-sm color2">Load Playground</a> </div>
    <h3 class="my-4"> Theme Colors
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
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
