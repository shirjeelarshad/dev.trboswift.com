<?php 
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata;

	switch(THEME_KEY){
		 
		
		case "es": {
		
			 $title = __("When can we meet?","premiumpress"); 
			 
		} break;
		 	
		
		default: {
		
			$title = __("Working Hours","premiumpress");
		 
		} break;
	
	}




 $bh = array();
	if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){
			$bh = get_post_meta($_GET['eid'],'businesshours',true);
	}
	
	 
?>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <h4><?php echo $title; ?></h4>
    <hr class="pb-0 mb-0" />
    <div class="row" id="businessHoursContainer3"></div>
  </div>
</div>
<script>
			
			jQuery(document).ready(function(){  
			
			<?php if(is_array($bh) && !empty($bh) ){ ?>
			var operationTime = [
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][0])){ echo $bh['active'][0]; }else{ echo 0; } ?>,"timeFrom":'<?php echo $bh['start'][0]; ?>',"timeTill":'<?php echo $bh['end'][0]; ?>'},
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][1])){ echo $bh['active'][1]; }else{ echo 0; }  ?>,"timeFrom":'<?php echo $bh['start'][1]; ?>',"timeTill":'<?php echo $bh['end'][1]; ?>'},
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][2])){ echo $bh['active'][2]; }else{ echo 0; }  ?>,"timeFrom":'<?php echo $bh['start'][2]; ?>',"timeTill":'<?php echo $bh['end'][2]; ?>'},
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][3])){ echo $bh['active'][3]; }else{ echo 0; }  ?>,"timeFrom":'<?php echo $bh['start'][3]; ?>',"timeTill":'<?php echo $bh['end'][3]; ?>'},
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][4])){ echo $bh['active'][4]; }else{ echo 0; }  ?>,"timeFrom":'<?php echo $bh['start'][4]; ?>',"timeTill":'<?php echo $bh['end'][4]; ?>'},
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][5])){ echo $bh['active'][5]; }else{ echo 0; }  ?>,"timeFrom":'<?php echo $bh['start'][5]; ?>',"timeTill":'<?php echo $bh['end'][5]; ?>'},
			{"isActive":<?php if(isset($bh['active']) && is_numeric($bh['active'][6])){ echo $bh['active'][6]; }else{ echo 0; }  ?>,"timeFrom":'<?php echo $bh['start'][6]; ?>',"timeTill":'<?php echo $bh['end'][6]; ?>'},
			];
			<?php }else{ ?>
			var operationTime;
			<?php } ?>
			
			
			
			 jQuery("#businessHoursContainer3").businessHours({
			 
			 		operationTime: operationTime,
                    postInit:function(){
                         /*jQuery('.operationTimeFrom, .operationTimeTill').timepicker({
                            'timeFormat': 'H:i',
                            'step': 15
                            });*/
                    },
					 
                    dayTmpl:'<div class="dayContainer col-md-6 col-lg-4"> <input type="hidden" class="isActive form-control" name="isActive" value="1"> <div class="weekday mt-4 py-2"></div>' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                        '' +
                        '<div class="operationDayTimeContaine">' +
                        '<div class="input-group"><div class="operationTime w-100 input-group-prepend"><span class="input-group-addon input-group-text"><i class="fa fa-sun"></i></span><input type="text" name="startTime" class="startTime mini-time form-control rounded-0 operationTimeFrom w-100" value=""></div></div>' +
                        '<div class="input-group"><div class="operationTime w-100 input-group input-group-prepend"><span class="input-group-addon input-group-text"><i class="fa fa-moon"></i></span><input type="text" name="endTime" class="endTime mini-time form-control rounded-0 operationTimeTill w-100" value=""></div></div>' +
                        '</div></div> '
                });
				
			});
 

			(function($) {
    $.fn.businessHours = function(opts) {
        var defaults = {
            preInit: function() {
            },
            postInit: function() {
            },
            inputDisabled: false,
            checkedColorClass: "WorkingDayState",
            uncheckedColorClass: "RestDayState",
            colorBoxValContainerClass: "colorBoxContainer",
            weekdays: ['<?php echo __('Monday',"premiumpress"); ?>', '<?php echo __('Tuesday',"premiumpress"); ?>', '<?php echo __('Wednesday',"premiumpress"); ?>', '<?php echo __('Thursday',"premiumpress"); ?>', '<?php echo __('Friday',"premiumpress"); ?>', '<?php echo __('Saturday',"premiumpress"); ?>', '<?php echo __('Sunday',"premiumpress"); ?>'],
            operationTime: [
                {},
                {},
                {},
                {},
                {},
                {isActive: false},
                {isActive: false}
            ],
            defaultOperationTimeFrom: '9:00',
            defaultOperationTimeTill: '18:00',
            defaultActive: true,
            //labelOn: "Working day",
            //labelOff: "Day off",
            //labelTimeFrom: "from:",
            //labelTimeTill: "till:",
            containerTmpl: '',
            dayTmpl: ''
        };

        var container = $(this);

        function initTimeBox(timeBoxSelector, time, isInputDisabled) {
            timeBoxSelector.val(time);

            if(isInputDisabled) {
                timeBoxSelector.prop('readonly', true);
            }
        }

        var methods = {
            getValueOrDefault: function(val, defaultVal) {
                return (jQuery.type(val) === "undefined" || val == null) ? defaultVal : val;
            },
            init: function(opts) {
                this.options = $.extend(defaults, opts);
                container.html("");

                if(typeof this.options.preInit === "function") {
                    this.options.preInit();
                }

                this.initView(this.options);

                if(typeof this.options.postInit === "function") {
                    //$('.operationTimeFrom, .operationTimeTill').timepicker(options.timepickerOptions);
                    this.options.postInit();
                }

                return {
                    serialize: function() {
                        var data = [];

                        container.find(".operationState").each(function(num, item) {
                            var isWorkingDay = $(item).prop("checked");
                            var dayContainer = $(item).parents(".dayContainer");

                            data.push({
                                isActive: isWorkingDay,
                                timeFrom: isWorkingDay ? dayContainer.find("[name='startTime']").val() : null,
                                timeTill: isWorkingDay ? dayContainer.find("[name='endTime']").val() : null
                            });
                        });

                        return data;
                    }
                };
            },
            initView: function(options) {
                var stateClasses = [options.checkedColorClass, options.uncheckedColorClass];
                var subContainer = container.append($(options.containerTmpl));
                var $this = this;

                for(var i = 0; i < options.weekdays.length; i++) {
                    subContainer.append(options.dayTmpl);
                }

                $.each(options.weekdays, function(pos, weekday) {
                    // populate form
                    var day = options.operationTime[pos];
                    var operationDayNode = container.find(".dayContainer").eq(pos);
                    operationDayNode.find('.weekday').html(weekday);

                    var isWorkingDay = $this.getValueOrDefault(day.isActive, options.defaultActive);
                    operationDayNode.find('.operationState').prop('checked', isWorkingDay);

                    var timeFrom = $this.getValueOrDefault(day.timeFrom, options.defaultOperationTimeFrom);
                    initTimeBox(operationDayNode.find('[name="startTime"]'), timeFrom, options.inputDisabled);

                    var endTime = $this.getValueOrDefault(day.timeTill, options.defaultOperationTimeTill);
                    initTimeBox(operationDayNode.find('[name="endTime"]'), endTime, options.inputDisabled);
                });

                container.find(".operationState").change(function() {
                    var checkbox = $(this);
                    var boxClass = options.checkedColorClass;
                    var timeControlDisabled = false;
					
					
					checkbox.parents(".dayContainer").find(".isActive").val(1);
					
                    if(!checkbox.prop("checked")) {
                        // disabled
                        boxClass = options.uncheckedColorClass;
                        timeControlDisabled = true;
						
						checkbox.parents(".dayContainer").find(".isActive").val(0);
                    }

                    checkbox.parents(".colorBox").removeClass(stateClasses.join(' ')).addClass(boxClass);
                    //checkbox.parents(".dayContainer").find(".operationTime").toggle(!timeControlDisabled);
                }).trigger("change");

                if(!options.inputDisabled) {
                    container.find(".colorBox").on("click", function() {
                        var checkbox = $(this).find(".operationState");
                        checkbox.prop("checked", !checkbox.prop('checked')).trigger("change");
                    });
                }
            }
        };

        return methods.init(opts);
    };
})(jQuery);
			</script>
<style>
 
 
.colorBox {
    cursor: pointer;
    height: 45px;
    border: 2px solid #888;

}

.colorBox.WorkingDayState {
    border: 2px solid #4E8059;
    background-color: #8ade8f;
}

.colorBox.RestDayState {
    border: 2px solid #7a1c44;
    background-color: #de5962;
}

.operationTime .mini-time {
 
    padding: 3px;
    font-size: 12px;
    font-weight: normal;
	text-align:center;
}

.operationDayTimeContaine .form-control , .operationDayTimeContaine .input-group-text { border-radius:0px !important; }

.dayContainer .add-on {
    padding: 4px 2px;
}

.colorBoxLabel {
    clear: both;
    font-size: 12px;
    font-weight: bold;
}

.invisible {
    visibility: hidden;
}

.operationTime {
    margin-top: 5px;
}
.ui-timepicker-wrapper{overflow-y:auto;max-height:150px;width:6.5em;background:#fff;border:1px solid #ddd;-webkit-box-shadow:0 5px 10px rgba(0,0,0,.2);-moz-box-shadow:0 5px 10px rgba(0,0,0,.2);box-shadow:0 5px 10px rgba(0,0,0,.2);outline:0;z-index:10001;margin:0}.ui-timepicker-wrapper.ui-timepicker-with-duration{width:13em}.ui-timepicker-wrapper.ui-timepicker-with-duration.ui-timepicker-step-30,.ui-timepicker-wrapper.ui-timepicker-with-duration.ui-timepicker-step-60{width:11em}.ui-timepicker-list{margin:0;padding:0;list-style:none}.ui-timepicker-duration{margin-left:5px;color:#888}.ui-timepicker-list:hover .ui-timepicker-duration{color:#888}.ui-timepicker-list li{padding:3px 0 3px 5px;cursor:pointer;white-space:nowrap;color:#000;list-style:none;margin:0}.ui-timepicker-list:hover .ui-timepicker-selected{background:#fff;color:#000}li.ui-timepicker-selected,.ui-timepicker-list li:hover,.ui-timepicker-list .ui-timepicker-selected:hover{background:#1980EC;color:#fff}li.ui-timepicker-selected .ui-timepicker-duration,.ui-timepicker-list li:hover .ui-timepicker-duration{color:#ccc}.ui-timepicker-list li.ui-timepicker-disabled,.ui-timepicker-list li.ui-timepicker-disabled:hover,.ui-timepicker-list li.ui-timepicker-selected.ui-timepicker-disabled{color:#888;cursor:default}.ui-timepicker-list li.ui-timepicker-disabled:hover,.ui-timepicker-list li.ui-timepicker-selected.ui-timepicker-disabled{background:#f2f2f2}
 </style>
