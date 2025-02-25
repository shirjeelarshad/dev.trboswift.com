
    function to_change_taxonomy(element)
        {
			jQuery('#chageTaxValue').val(element);
            //select the default category (0)
            //jQuery('#to_form #cat').val(jQuery("#to_form #cat option:first").val());
            jQuery('#to_form').submit();
        }