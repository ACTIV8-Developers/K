/*
* Author: Wisely Themes
* Author URI: 
* Theme Name: Mochito
* Theme URI: 
* Version: 1.0.0
*/

/* global less:true */

var templateSettings = {

	initialized: false,

	init: function() {
		"use strict";
		
		var $tis = this;

		if ($tis.initialized){ 
			return;
		}
		
		$tis.initialized = true;

		/**
		 * Append minicolors CSS
		 */
		$('head').append('<link href="css/jquery.minicolors.css" rel="stylesheet" type="text/css" />');
		
		/**
		 * Get minicolors Script
		 */
		$.getScript("js/jquery.minicolors.js", function() {
			$tis.construct();
			$tis.events();
		}).fail(function() {
			alert( "Failed to load Template Settings Panel!" );
		});
	},

	construct: function() {
		"use strict";
		
		var $tis = this;
		
		$('.minicolors').minicolors({
			theme: 'bootstrap',
			change: function(hex){ 
						$tis.configColor(hex); 
					}
		});
	},

	events: function() {
		"use strict";
		
		var $tis = this;
		
		/**
		 * Template Settings Panel Open/Close
		 */
		var opened = false;
		$("#template-settings>i").click(function(){
			if (opened){
				$('#template-settings').animate({left: '-185px'}, 400, 'easeInExpo');
				opened = false;
			}else{
				$('#template-settings').animate({left: '0px'}, 400, 'easeOutExpo');
				opened = true;
			}
		});
		
		/**
		 * Patterns
		 */
		$(".settings-pattern span").click(function(){
			$tis.setPattern($(this), $(this).attr("id"));
		});
		
		/**
		 * Theme Style
		 */
		$('select[name=theme]').change(function() {
			$tis.setTheme($(this).find('option:selected').val());
		});
	},

	configColor: function(clr) {
		"use strict";
		
		less.modifyVars({
			'color': clr
		}, true);
	},

	setPattern: function(obj, pattern) {
		"use strict";
		
		$(".settings-pattern span").removeClass("selected");
		$(obj).addClass("selected");
		$("#header, #contacts").css('background-image', 'url(img/patterns/' + pattern + '.png)');
	},
	
	setTheme: function(val){
		"use strict";
		
		if(val === 'darktheme'){
			$('head').append('<link href="css/darktheme.css" rel="stylesheet" type="text/css" id="darktheme" />');
		}
		else {
			$('#darktheme').remove();
		}
	}
};

templateSettings.init();