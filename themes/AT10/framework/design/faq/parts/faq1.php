<?php
global $settings;

$milliseconds = rand(0,99999999); 
 
 
?>

<div class="accordion">
  <div class="accordion" id="faq<?php echo $milliseconds; ?>-accodian">
    <?php $i=1; while($i < 7){ if($i > 3 && $settings['faq'.$i.'_title'] == ""){ $i++; continue; } ?>
    <div class="border-0 mb-3">
      <div class="border-bottom pb-3"> <a class="text-dark font-weight-bold collapsed" type="button" data-toggle="collapse" data-target="#collapse-faq1-<?php echo $i.$milliseconds; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>"> <i class="fa fa-info-circle mr-2"></i>
        <?php if($settings['faq'.$i.'_title'] == ""){ ?>
        Example FAQ Title Here
        <?php }else{ ?>
        <?php echo __($settings['faq'.$i.'_title'],"premiumpress");; ?>
        <?php } ?>
        </a> </div>
    </div>
    <div id="collapse-faq1-<?php echo $i.$milliseconds; ?>" class="collapse" aria-labelledby="heading<?php echo $i.$milliseconds; ?>" data-parent="#faq<?php echo $milliseconds; ?>-accodian" style="">
      <div class="pb-3 text-muted">
        <?php if($settings['faq'.$i.'_desc'] == ""){ ?>
        Quidam officiis similique sea ei, vel tollit indoctum efficiendi ei, at nihil tantas platonem eos. Mazim nemore singulis an ius, nullam ornatus nam ei. 
        Ut dicat euismod invidunt pro, ne his dolorum molestie reprehendunt, quo luptatum evertitur ex.
        <?php }else{ ?>
        <?php echo __($settings['faq'.$i.'_desc'],"premiumpress");; ?>
        <?php } ?>
      </div>
    </div>
    <?php $i++; } ?>
  </div>
</div>
<?php  ?>