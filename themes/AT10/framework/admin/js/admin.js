																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																		 

 
// compatibility for jQuery / jqLite
var bg = bg || false;
if(!bg){
	if(typeof jQuery != 'undefined'){
		bg = jQuery;
	} else if(typeof angular != 'undefined'){
		bg = angular.element;
		bg.extend = angular.extend;	
	
		
		bg.prototype.slideUp = $.prototype.hide = function(){
			var i,that = this;
			for(i=0;i<that.length;i++){
				that[i].style.display = 'none';
			}
			return that;
		}
		
		bg.prototype.slideDown = $.prototype.show = function(){
			var i,that = this;
			for(i=0;i<that.length;i++){
				that[i].style.display = '';
			}
			return that;
		}

		bg.prototype.find = function (selector){
			var context = this[0],matches = [];
			// Early return if context is not an element or document
			if (!context || (context.nodeType !== 1 && context.nodeType !== 9) || typeof selector != 'string') {
				return [];
			}
			
			for(var i=0;i<this.length;i++){
				var elm = this[i],
				nodes = bg(elm.querySelectorAll(selector));
				matches.push.apply(matches, nodes.slice());
			}
			
			return bg(matches);
		};
	}
}

;(function ($) {
    "use strict";

	var pluginName = 'colorPickerByGiro',
	timer = {},
	delay = function(callback, ms, type){
		clearTimeout (timer[type]);
		timer[type] = setTimeout(callback, ms);
	},
	
	fixValue = function(value, min, max){
		if(value < min) value = min;
		if(value > max) value = max;
		
		return value;
	},
	
	addColorPickerContainer = function(){
		var that = this,
		opts = that.settings,
		input = '<input type="text" value="" data-cp-t="',
		html='<div class="cpBG fade">'
				+ '<div class="cp-colors">'
					+ '<div class="cp-white">'
						+ '<div class="cp-black">'
							+ '<div class="cp-cursor"></div>'
						+ '</div>'
					+ '</div>'
					+ '<div class="cp-trigger"></div>'
				+ '</div>'
				
				+ '<div class="cp-hues">'
					+ '<div class="ie-1"></div>'
					+ '<div class="ie-2"></div>'
					+ '<div class="ie-3"></div>'
					+ '<div class="ie-4"></div>'
					+ '<div class="ie-5"></div>'
					+ '<div class="ie-6"></div>'
					+ '<div class="cp-cursor"></div>'
					+ '<div class="cp-trigger" data-cp-t="h"></div>'
				+ '</div>'
				
				+ '<div class="cp-alpha">'
					+ '<div class="cp-chess-bg"><div class="cp-chess"></div></div>'
					+ '<div class="cp-bg"></div>'
					+ '<div class="cp-cursor"></div>'
					+ '<div class="cp-trigger" data-cp-t="a"></div>'
				+ '</div>'
				
				+ '<div class="cp-values">'
					+ '<div class="cp-prev"><i>&nbsp;</i></div>'
					+ '<div class="cp-hex">Hex: '+ input +'" /></div>'
					+ '<div class="cp-r">R: '+ input +'r" /></div>'
					+ '<div class="cp-g">G: '+ input +'g" /></div>'
					+ '<div class="cp-b">B: '+ input +'b" /></div>'
					+ '<div class="cp-a">A: '+ input +'a" /></div>'
				+ '</div>'
				
				+ '<div class="cp-buttons">'
					+ '<div class="btn btn-default btn-none">'+ opts.text.none +'</div>'
					+ '<div class="btn btn-info btn-close">'+ opts.text.close +'</div>'
				+ '</div>'
				+ '<div class="clear"></div>'
            + '</div>';
			
		that.$main.append(html);
	},
	
	move = function(x, y){
		var that = this,
		opts = that.settings,
		dragType = that.dragType,
		dragRect = that.dragRect,
		hsva = that.hsva;

		x = Math.max(Math.min(x, dragRect.width), 0);
		y = Math.max(Math.min(y, dragRect.height), 0);

		if (dragType == 'h'){
			hsva.h = y / dragRect.height;
		} else if (dragType == 'a') {
			hsva.a = Number((y / dragRect.height).toFixed(3));
		} else {		
			hsva.s = x / dragRect.width;
			hsva.v = 1 - y / dragRect.height;
		}

		if (typeof hsva.s !== 'undefined'){
			that.setValue(hsva);
		}		
	},
	
	addEventsHandlers = function(){
		var that = this,
		opts = that.settings,
		dragging = false,
		
		dragStart = function(evt){
			if(dragging) return;
			evt.stopPropagation();
			evt.preventDefault();
			
			var trigger = $(evt.target).parent().find('.cp-trigger'),
			rect = trigger[0].getBoundingClientRect();

			that.dragType = trigger.attr('data-cp-t');
			dragging = true;
			

			that.dragRect = {
				x: rect.left,
				y: rect.top,
				width: rect.right - rect.left,
				height: rect.bottom - rect.top
			};

			move.call(that, evt.offsetX || evt.layerX, evt.offsetY || evt.layerY);
		},
		
		dragStop = function(evt){
			if(!dragging) return;
			evt.stopPropagation();
			
			dragging = false;			
			delete that.dragType;
			delete that.dragRect;			
		},
		rgbEle,
		cpBG = that.$main.find('.cpBG'),
		openPicker;

		that.$main.find('.cp-trigger')
			.on('mousedown touchstart',dragStart)
			.on('mouseup touchend',dragStop);
			
		that.$main.on('mousemove touchmove',function(e){
				if(!dragging) return;
				
				var dragRect = that.dragRect;
				move.call(that,e.clientX - dragRect.x, e.clientY - dragRect.y);			
			});
			
		$('body').on('mouseup touchend',dragStop);
		
		// add events handlers on inputs
		rgbEle = that.$main.find('.cp-values div:not(.cp-hex) [data-cp-t]');
		rgbEle.on('keyup',function(){
			delay(function(){
				var rgba = {};
				for(var i=0;i<rgbEle.length;i++){
					var ele = rgbEle[i],
					type = ele.getAttribute('data-cp-t'),
					val = parseFloat(ele.value);
					rgba[type] = (type != 'a') ? fixValue(val,0,255) : fixValue(val,0,1);
				}
				that.hsva = that.rgb2hsv(rgba.r,rgba.g,rgba.b);
				that.hsva.a = rgba.a;
				that.setValue();
			}, 350, 'r');
		});
		
		that.$main.find('.cp-hex input').on('keyup',function(){
			var $ele = $(this);
			delay(function(){
				that.setValue($ele.val());
			}, 350, 'h');
		});
		
		cpBG.slideUp();
		that.$main.find('.cp-buttons .btn-close').on('click',function(){
			cpBG.slideUp().removeClass('in');
		});
		
		that.$main.find('.cp-buttons .btn-none').on('click',function(){
			that.setValue({h:0, s:0, v:1, a:0});
			that.$eleInput.val('').triggerHandler('input');
			that.$main.find('input').val('');
		});
		
		openPicker = function(){
			cpBG.addClass('in').slideDown();
		}
		that.$eleInput.on('focus',openPicker);		
		that.$element.on('click',openPicker);
	},

    methods = {
        init: function ($element, options) {
            var that = this,
			val, hsva;
			 
            that.$element = $element;
            that.settings = $.extend({}, {
				
				preview: '', // a valid CSS selector / a DOM element / a jQuery-jqLite collection
				showPicker: true,

				format: 'hex',
				
				sliderGap: 6,
				cursorGap: 6,
				
				// internationalization
				text: {
					close: 'Close',
					none: 'None'
				}
            }, options)
			var rgb,opts = that.settings;
			
			opts.format = opts.format.toLowerCase();
			opts.preview = opts.preview.length ? opts.preview : false;
			
			// let's find the input
			that.$eleInput = that.$element.find('input');

			// wrap element into a container
			that.$main = that.$element.wrap('<div class="cp-cont"></div>').parent();
			
			// add colorPicker element
			addColorPickerContainer.call(that); 

			// add eventHandlers
			addEventsHandlers.call(that);
			
			 
			// default value
			/*that.hsva = {
				h: 1,
				s: 1,
				v: 1,
				a: 1
			}*/
			
			that.hsva = jQuery(that.$eleInput).val();
			
			// set initial status color picker
			that.setValue();
        },

		setValue: function(value){		 
			
			var that = this,
			opts = that.settings,
			value2Set = value || that.hsva,
			rgb,hex,bgcolor,inputVal = '',
			sliderGap = opts.sliderGap, cursorGap = opts.cursorGap,
			pickerCursor = that.$main.find('.cp-colors .cp-cursor'),
			hueCursor = that.$main.find('.cp-hues .cp-cursor'),
			alphaCursor = that.$main.find('.cp-alpha .cp-cursor'),
			previewColor;


 
			if(typeof value2Set == 'string'){
				value2Set = that.str2hsva(value2Set);
			}
		 
			that.hsva = value2Set;
			
			rgb = that.hsv2rgb(value2Set.h,value2Set.s,value2Set.v);
			rgb.a = (value2Set.a || value2Set.a === 0) ? value2Set.a : 1;
			bgcolor = that.hsv2rgb(value2Set.h,1,1);
			bgcolor = that.rgb2str(bgcolor.r,bgcolor.g,bgcolor.b);
			previewColor = that.rgb2str(rgb.r,rgb.g,rgb.b,value2Set.a);
			
			hex = that.rgb2hex(rgb.r,rgb.g,rgb.b);
			
			// set current Value in input
			switch(opts.format){					
				case 'hsl':
				case 'hsla':
					inputVal = that.hsv2hsl(value2Set.h,value2Set.s,value2Set.v);
					inputVal = that.hsl2str(inputVal.h,inputVal.s,inputVal.l,value2Set.a);
					break;
					
				case 'rgb':
				case 'rgba':
					inputVal = previewColor;
					break;

				case 'hex':
				default:
					inputVal = hex;
					break;
			}		
			
			
			 	
			// set current Value in input
			that.$eleInput.val(inputVal).triggerHandler('input');
			
			// and the preview
			if(opts.preview) (opts.preview instanceof $ ? opts.preview : that.$element.find(opts.preview)).css('background-color', previewColor);


			// set hexadecimal
			that.$main.find('.cp-values .cp-hex input').val(hex);
			
			// set RGB
			for(var k in rgb){				
				that.$main.find('.cp-values [data-cp-t="'+ k +'"]').val(rgb[k]);
			}
			
			// set hue cursor
			hueCursor.css('background-color',bgcolor);
			
			// set picker cursor background color
			pickerCursor.css('background-color',hex);
			
			// set background color picker
			that.$main.find('.cp-colors').css('background-color',bgcolor);
			
			// set background alpha cursor
			that.$main.find('.cp-alpha .cp-cursor').css('background',previewColor);
			
			// set background alpha
			that.$main.find('.cp-alpha .cp-bg').css('background','linear-gradient(to bottom, transparent, '+ hex +')');
		
			// change color cursor position
			pickerCursor.css({ left: (value2Set.s * 200) - cursorGap + 'px', top: ((1 - value2Set.v) * 200) - cursorGap + 'px' });

			// change hue cursor position
			hueCursor.css('top',(value2Set.h * 200) - sliderGap + 'px');
			
			// change alpha cursor position
			alphaCursor.css('top',(value2Set.a * 200) - sliderGap + 'px');				
			
			// set preview final color
			that.$main.find('.cp-values .cp-prev i').css('background-color',previewColor);
			
			delay(function(){
				that.$element.triggerHandler('selected.colorPickerByGiro', {
					hexadecimal: hex,
					hsva: that.hsva,
					rgba: rgb,
					rgbaStr: previewColor
				});
			},
			400,'c');
			
			if(jQuery(that.$eleInput).val() == "#FFFFFF"){ 
			jQuery(that.$eleInput).val('');
			}
		},
		
		// utilities
		str2hsva: function(colorStr){
			var that=this,str,rgb = {}, hsva = undefined, val;
			function getComponents(substr){
				return substr.replace(/[a-z;\(\)]/g,'').split(',');				
			}
			
			if(!colorStr || colorStr == '') colorStr = '#fff';
			// clean string
			str = colorStr.trim().toLowerCase();			
			
			if(str.indexOf('rgb') >= 0){
				// we have rgb
				str = getComponents(str);
				 
				for(var i=0;i<3;i++){
					val = parseFloat(str[i]);
					if(str[i].indexOf('%') >= 0){						
						// we have a percentage value
						val *= 2.55;
					}
					str[i] = val;
				}
				hsva = that.rgb2hsv(str[0],str[1],str[2]);
				if(str.length == 4)hsva.a = str[3];
			} else if(str.indexOf('hsl') >= 0){
				// we have hsl
				str = getComponents(str);
				hsva = that.hsl2hsv(str[0]/360, str[1]/100, str[2]/100);
				if(str.length == 4)hsva.a = str[3];
			} else { // assume it's hexadecimal with or without '#'
				// we have hex
				rgb = that.hex2rgb(str);
				hsva = that.rgb2hsv(rgb.r,rgb.g,rgb.b);
			}
			
			return hsva;
		},
	
		hsv2rgb: function(h, s, v) {
			var Mathfloor = Math.floor,
				parseFl = parseFloat;
				
			h = parseFl(h) || 0;
			s = parseFl(s) || 0;
			v = parseFl(v) || 0;
			
			var x=255,
				i = Mathfloor(h * 6),
				f = h * 6 - i,
				p = v * (1 - s),
				q = v * (1 - f * s),
				t = v * (1 - (1 - f) * s),
				r, g, b;

			switch (i % 6) {
			case 0:
				r = v;
				g = t;
				b = p;
				break;
			case 1:
				r = q;
				g = v;
				b = p;
				break;
			case 2:
				r = p;
				g = v;
				b = t;
				break;
			case 3:
				r = p;
				g = q;
				b = v;
				break;
			case 4:
				r = t;
				g = p;
				b = v;
				break;
			case 5:
				r = v;
				g = p;
				b = q;
				break;
			}

			return {
				r:Mathfloor(r * x),
				g:Mathfloor(g * x),
				b:Mathfloor(b * x)
			};
		},
		
		rgb2hsv: function(r, g, b) { // 0 >= r, g, b <=255
			var max = Math.max(r, g, b), min = Math.min(r, g, b),
				d = max - min,
				h,
				s = (max === 0 ? 0 : d / max),
				v = max / 255;

			switch (max) {
				case min: h = 0; break;
				case r: h = (g - b) + d * (g < b ? 6: 0); h /= 6 * d; break;
				case g: h = (b - r) + d * 2; h /= 6 * d; break;
				case b: h = (r - g) + d * 4; h /= 6 * d; break;
			}

			return {
				h: h,
				s: s,
				v: v
			};
		},
	
		hex2rgb: function(hex) {
			var h=hex.replace('#', '').slice(0,6);
			 
			h =  h.match(new RegExp('(.{'+h.length/3+'})', 'g'));

			for(var i=0; i<h.length; i++)
				h[i] = parseInt(h[i].length==1? h[i]+h[i]:h[i], 16);

			return {
				r: h[0],
				g: h[1],
				b: h[2]
			};
		},
		
		rgb2str: function(red, green, blue, alpha){
			var type = 'rgb',h = [red,green,blue];
			if (typeof alpha != 'undefined'){
				type += 'a';
				h.push(alpha);
			}

			return type + '('+h.join(',')+')';			
		},

		rgb2hex: function (red, green, blue) {
			return "#" + ((1 << 24) + (red << 16) + (green << 8) + blue).toString(16).slice(1).toUpperCase();
		},
		 
		// if you wanna use percentages for saturation and value, divide / 100, if HUE is a number between 0-360 divide / 360
		hsv2hsl: function(hue,sat,val){
			return{
					//Range should be between 0 - 1
				h: hue, //Hue stays the same

				//Saturation is very different between the two color spaces
				//If (2-sat)*val < 1 set it to sat*val/((2-sat)*val)
				//Otherwise sat*val/(2-(2-sat)*val)
				//Conditional is not operating with hue, it is reassigned!
				s: sat*val/((hue=(2-sat)*val)<1?hue:2-hue), 
				
				l: hue/2 //Lightness is (2-sat)*val/2
				//See reassignment of hue above
			}
		},

		// if you wanna use percentages for saturation and value, divide / 100, if HUE is a number between 0-360 divide / 360
		hsl2hsv: function(hue,sat,light){
			sat*=light<.5?light:1-light;

			return{
			//Range should be between 0 - 1
				
				h: hue, //Hue stays the same
				s: 2*sat/(light+sat), //Saturation
				v: light+sat //Value
			}
		},
		
		hsl2str: function(hue, sat, light, alpha){
			var type = 'hsl',h = [hue*360,(sat*100)+'%',(light*100)+'%'];
			if (typeof alpha != 'undefined'){
				type += 'a';
				h.push(alpha);
			}

			return type + '('+h.join(',')+')';			
		}
    },
	
	main = function (method) {
        var pluginInstance = this.data(pluginName +'_data');
        if (pluginInstance) {
            if (typeof method === 'string' && pluginInstance[method]) {
                return pluginInstance[method].apply(pluginInstance, Array.prototype.slice.call(arguments, 1));
            }
            return console.log('Method ' +  method + ' does not exist on jQuery.'+ pluginName);
        } else {
            if (!method || typeof method === 'object') {
				
				var listCount = this.length;
				for ( var i = 0; i < listCount; i ++) {
					var $this = $(this[i]);
                    pluginInstance = $.extend({}, methods);
                    pluginInstance.init($this, method);
                    $this.data(pluginName +'_data', pluginInstance);
				};

				return this;
            }
            return console.log('jQuery.'+ pluginName +' is not instantiated. Please call $("selector").'+ pluginName +'({options})');
        }
    };

	// plugin integration
	if($.fn){
		$.fn[pluginName] = main;
	} else {
		$.prototype[pluginName] = main;
	}
}(bg));

 