<?php
global $settings;
 
if(isset($settings['section_pattern']) && is_numeric($settings['section_pattern']) ){ ?>
<div class="bg-pattern" data-bg="<?php echo get_template_directory_uri(); ?>/framework/images/pattern/<?php echo $settings['section_pattern']; ?>.svg"></div>
<?php } ?>