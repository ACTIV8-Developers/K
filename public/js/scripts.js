/*
* Author: Wisely Themes
* Author URI: http://themeforest.net/user/wiselythemes
* Theme Name: Mochito
* Theme URI: http://themeforest.net/user/wiselythemes
* Version: 1.2
*/

/* global Modernizr:true, google:true */

var Mochito = {

	initialized: false,
	mobMenuFlag: false,
	wookHandler: null,
	wookOptions: null,
	scrollPos: 0,
	sendingMail: false,
	formType: 0,
	myLatlng: null,

	init: function() {
		"use strict";
		
		var $tis = this;
		
		if ($tis.initialized){
			return;
		}
		
		$tis.initialized = true;
		$tis.construct();
		$tis.events();
	},

	construct: function() {
		"use strict";
		
		var $tis = this;
		
		/**
		 * Navigation
		 */
		$tis.navigation();
		
		/**
		 * Dinamically create the menu for mobile devices
		 */
		$tis.createMobileMenu();
		
		/**
		 * Portfolio
		 */
		$tis.portfolio();
		
		/**
		 * Activate placeholder in older browsers
		 */
		$('input, textarea').placeholder();
	},

	events: function() {
		"use strict";
		var $tis = this;
		
		/**
		 * Check if browser is a mobile device
		 */
		$tis.isMobile();
		
		/**
		 * Functions called on window resize
		 */
		$tis.windowResize();
		
		/**
		 * Resize logo on window resize
		 */
		$tis.resizeLogo();
		
		/**
		 * Portfolio plus button
		 */
		$tis.portfolioButtons();
		
		/**
		 * Parallax
		 */
		$tis.parallaxItems();	
		
		/**
		 * Load more works button
		 */
		$tis.loadWorks();
		
		/**
		 * Progress Bar animation
		 */
		$tis.progressBar();
		
		/**
		 * Contact form submit
		 */
		$tis.contactForm();
		
		/**
		 * Contact form options
		 */
		$tis.contactOpt();
	},
	
	navigation: function() {
		"use strict";
		
		$('#nav li a, .nav-button, #workwithus').bind('click',function(event){
			var navActive = $(this);
			var scroll = 0;
			
			if (navActive.attr('href') !== "#header"){
				scroll = $(navActive.attr('href')).offset().top -76;
			}
			
			$('html, body').stop().animate({
				scrollTop: scroll
			}, 1500,'easeInOutExpo', function(){
				navActive.blur();
			});
			
			event.preventDefault();
		});


		$('.nav-section').waypoint('sticky', {
			handler: function(dir) {
				if(dir === "down"){
					$(".nav-section .nav-button").animate({opacity:1}, 300);
				} else {
					$(".nav-section .nav-button").animate({opacity:0}, 200);
				}
			}
		});
			
		$("section").waypoint(function(direction) {
			var tis = $(this);
			
			if (direction === "up"){ tis = tis.prev(); }
			
			$("#nav a").removeClass("active");
			$('nav a[href="#' + tis.attr("id") + '"]').addClass("active");
		}, { offset: '50%' });
	},
	
	createMobileMenu: function(w) {
		"use strict";
		var $tis = this;
		
		if ( w !== null ){
			w = $(window).innerWidth();
		}
		
		if (w <= 751 && !$tis.mobMenuFlag) {
			var select = document.createElement('select');
			var first = document.createElement('option');

			first.innerHTML = 'Menu';
			first.setAttribute('selected', 'selected');
			select.setAttribute('id', 'mobile-nav');
			select.appendChild(first);

			var nav = document.getElementById('nav');
			var loadLinks = function(element, hyphen, level) {

				var e = element;
				var children = e.children;

				for(var i = 0; i < e.children.length; ++i) {

					var currentLink = children[i];

					switch(currentLink.nodeName) {
						case 'A':
							var option = document.createElement('option');
							if ($(currentLink).hasClass('icon')){
								option.innerHTML = (level++ < 1 ? '' : hyphen) + $(currentLink).data('id');
							} else {
								option.innerHTML = (level++ < 1 ? '' : hyphen) + currentLink.innerHTML;
							}
							option.value = $(currentLink).attr('href');
							select.appendChild(option);
							break;
						default:
							if(currentLink.nodeName === 'UL') {
								if (level >= 2 ){
									hyphen += hyphen;
								}
							}
							loadLinks(currentLink, hyphen, level);
							break;
					}
				}
			};

			loadLinks(nav, '- ', 0);

			nav.appendChild(select);

			var mobileNavChange = function(navActive) {
				var scroll = 0;
					
				if (navActive !== "#header" && navActive !== "Menu"){
					scroll = $(navActive).offset().top -76;
				}
				
				$('html, body').stop().animate({
					scrollTop: scroll
				}, 1500,'easeInOutExpo');
			};
			
			var mobileNav = document.getElementById('mobile-nav');

			if(mobileNav.addEventListener) {
				mobileNav.addEventListener('change', function () {
					mobileNavChange(mobileNav.options[mobileNav.selectedIndex].value);
				});
			} else if(mobileNav.attachEvent) {
				mobileNav.attachEvent('onchange', function () {
					mobileNavChange(mobileNav.options[mobileNav.selectedIndex].value);
				});
			} else {
				mobileNav.onchange = function () {
					mobileNavChange(mobileNav.options[mobileNav.selectedIndex].value);
				};
			}
			
			$tis.mobMenuFlag = true;
		}
	},
	
	portfolio: function() {
		"use strict";
		var $tis = this;
		
		$('#folio-items').imagesLoaded(function() {
			// Prepare layout options.
			$tis.wookOptions = {
				autoResize: true, // This will auto-update the layout when the browser window is resized.
				container: $('#portfolio-grid'), // Optional, used for some extra CSS styling
				offset: 20, // Optional, the distance between grid items
				itemWidth: 300 // Optional, the width of a grid item
			};

			// Get a reference to your grid items.
			$tis.wookHandler = $('#folio-items li');
			var	filters = $('#filters li');

			// Call the layout function.
			$tis.wookHandler.wookmark($tis.wookOptions);

			/**
			 * When a filter is clicked, toggle it's active state and refresh.
			 */
			var onClickFilter = function(event) {
				var item = $(event.currentTarget),
					activeFilters = [],
					items = $('#folio-items li');

				if (!item.hasClass('active')) {
					filters.removeClass('active');
				}
				
				item.toggleClass('active');
				
				// Filter by the currently selected filter
				if (item.hasClass('active')) {
					items.removeClass("fixed-folio-item");
				
					items.filter(function() { 
						return $(this).data('filter-class').toString() === item.data('filter').toString();
					}).slice(0, 3).addClass("fixed-folio-item");
					
					if (item.data('filter') !== ""){
						activeFilters.push(item.data('filter'));
					} else {
						items.slice(0, 3).addClass("fixed-folio-item");
					}
				}

				$tis.wookHandler.wookmarkInstance.filter(activeFilters);
				
				$.waypoints('refresh');
			};

			// Capture filter click events.
			filters.click(onClickFilter);
		});
	},
	
	windowResize:function() {
		"use strict";
		
		var $tis = this;
		
		$(window).resize(function() {
			var w = $(window).innerWidth();
			
			$tis.resizeLogo(w);
			$tis.createMobileMenu(w);
		});
	},
	
	resizeLogo:function(w) {
		"use strict";
		
		if ( w !== null ){
			w = $(window).innerWidth();
		}
		
		$("#logo").css({maxWidth: w + 'px'});
		
	},
	
	portfolioButtons:function() {
		"use strict";
		var $tis = this;
		
		$(".btn-folio").bind("click touchstart", function(e){
			e.preventDefault();
			
			var parent = $(this).closest('li'),
				overview = parent.data('overview'),
				page = $('.project-page');
			
			$tis.scrollPos = $(window).scrollTop();
			
			if(overview !== undefined){
				$('#project-header-bg').attr('src', overview[0].headerBg);
				
				$('.project-desc').html('<img src="' + overview[0].logo + '" alt="" />');
				
				$('.project-desc').append('<p>' + overview[0].description + '</p>');				
				
				if (overview[0].url !== undefined){
					$('.project-desc p').append('<br/><br/><a href="http://' + overview[0].url + '" target="_blank"><i class="icon-globe"></i> ' + overview[0].url + '</a>');
				}
				
				$('.project-overview').html("");
				for(var i=0; i < overview[0].imgs.length; i++){
					
					if (overview[0].imgs[i].title !== undefined){
						$('.project-overview').append('<h3>' + overview[0].imgs[i].title + '</h3>');
					}
					
					if (overview[0].imgs[i].description !== undefined){
						$('.project-overview').append('<p>' + overview[0].imgs[i].description + '</p>');
					}
					
					if (overview[0].imgs[i].img !== undefined){
						$('.project-overview').append('<img src="' + overview[0].imgs[i].img + '" alt="" />');
					}
					
					if (overview[0].imgs[i].vimeo !== undefined){
						$('.project-overview').append('<div class="center clearfix videoEmbed" style="margin-bottom:110px;width:100%;"><iframe src="' + overview[0].imgs[i].vimeo + '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>');
					}
					
					if (overview[0].imgs[i].youtube !== undefined){
						$('.project-overview').append('<div class="center clearfix videoEmbed" style="margin-bottom:110px;width:100%;"><iframe src="' + overview[0].imgs[i].youtube + '?wmode=opaque" frameborder="0" allowfullscreen></iframe></div>');
					}
				}
				
				
				var $allVideos = $("iframe[src^='http://player.vimeo.com'], iframe[src^='http://www.youtube.com'], object, embed"),
					$fluidEl = $(".videoEmbed");
				
				$allVideos.each(function() {
					$(this)
					.attr('data-aspectRatio', $(this).height() / $(this).width())
					.removeAttr('height')
					.removeAttr('width');
				});
				
				$(window).resize(function() {
					var newWidth = $fluidEl.width();
					
					$allVideos.each(function() {
						var $el = $(this);
						$el
						.width(newWidth)
						.height(newWidth * $el.attr('data-aspectRatio'));
					});
				}).resize();
			
				
				var transEndEventNames = {
						'WebkitTransition' : 'webkitTransitionEnd',
						'OTransition' : 'oTransitionEnd',
						'msTransition' : 'MSTransitionEnd',
						'transition' : 'transitionend'
					},
					// animation end event name
					transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ];
					
				if ( transEndEventName === undefined){
					page.addClass('moveFromRight');
					
					$("#header").hide();
					$("#wrap").hide();
						
					$('html, body').animate({scrollTop: 0}, 0);
					page.css({position:'absolute'});
				
				} else {
					page.addClass('moveFromRight').one( transEndEventName, function() {
						$("#header").hide();
						$("#wrap").hide();
						
						$('html, body').animate({scrollTop: 0}, 0);
						$(this).css({position:'absolute'});
					});
				}
			}
		});
		
		$(".portfolio-back").click(function(){
			var page = $('.project-page');
			
			page.css({position:'fixed'});
			
			$("#header").show();
			$("#wrap").show();
			
			$('html, body').animate({scrollTop: $tis.scrollPos}, 0);
			
			page.removeClass('moveFromRight');
			
			$('.project-overview').html("");
		});
	},
	
	parallaxItems:function() {
		"use strict";
		
		if(!$.browser.mobile){
			$('#services-img').parallax("50%", 0.4);
			$('#about-img').parallax("50%", 0.45);
		} else {
			$('.parallax').css({'background-position':'50% 50%'});
		}
	},
	
	loadWorks:function(){
		"use strict";
		var $tis = this;
		
		$("#load-works").click(function(e) {
			e.preventDefault();
			
			var $items = $('#folio-items li.disable').slice(0, 5);
			$items.removeClass('disable');

			// Destroy the old handler
			if ($tis.wookHandler.wookmarkInstance) {
				$tis.wookHandler.wookmarkInstance.clear();
			}

			// Create a new layout handler.
			$tis.wookHandler = $('#folio-items li');
			$tis.wookHandler.wookmark($tis.wookOptions);
			$(this).blur();
			
			$items = $('#folio-items li.disable').slice(0, 5);
			
			if ( $items.length === 0 ){
				$(this).css({visibility: 'hidden' });
			}
			
			$.waypoints('refresh');
		});
	},
	
	isMobile:function(){
		"use strict";
		
		(function(){(jQuery.browser=jQuery.browser||{}).mobile=(/android|webos|iphone|ipad|ipod|blackberry/i.test(navigator.userAgent.toLowerCase()));})(navigator.userAgent||navigator.vendor||window.opera);
	},
	
	progressBar:function(){
		"use strict";
		
		$("#skills").waypoint(function(direction) {
			$('.progress').each(function(){
				var tis = $(this);
				var percentage = $(this).data('percentage');
				
				if ( direction === "down"){
					tis.find('.bar').stop(true,true).animate({ width: percentage + '%' }, 1500, 'easeOutExpo').html(percentage + "%&nbsp;&nbsp;");
				} else {
					tis.find('.bar').stop(true,true).animate({ width: 0 }, 1500, 'easeInExpo').html("");
				}
			});
		}, { offset: '40%' });
	},
	
	contactForm: function() {
		"use strict";
		var $tis = this;
		
		$("#contact_send").click(function(e){
			e.preventDefault();

			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
				name = $('#contact_name').val(),
				email = $('#contact_email').val(),
				budget = $('#contact_budget').val(),
				company = $('#contact_company').val(),
				message = $('#contact_message').val(),
				html = "",
				error = false;
			
			if(name === ""){
				$('#contact_name').addClass('invalid');
				error = true;
			}else{
				$('#contact_name').removeClass('invalid');
				html = "name=" + name;
			}
			
			if ( $tis.formType === 1 ){
				html += "&subject=Ask for proposal";

				if(budget === ""){
					$('#contact_budget').addClass('invalid');
					error = true;
				}else{
					$('#contact_budget').removeClass('invalid');
					html += "&budget=" + budget;
				}
				
				if(company === ""){
					$('#contact_company').addClass('invalid');
					error = true;
				}else{
					$('#contact_company').removeClass('invalid');
					html += "&company=" + company;
				}
			} else {
				html += "&subject=General Contact";
			}

			if(email === ""){
				$('#contact_email').addClass('invalid');
				error = true;
			}else if(re.test(email) === false){
				$('#contact_email').addClass('invalid');
				error = true;
			}else{
				$('#contact_email').removeClass('invalid');
				html += "&email="+ email;
			}
			
			if(message === ""){
				$('#contact_message').addClass('invalid');
				error = true;
			}else{
				$('#contact_message').removeClass('invalid');
				html += "&message="+ message;
			}
			
			if(!error && !$tis.sendingMail) {
				$tis.sendingMail = true;
				$('#contact_send i').addClass('icon-cog icon-spin');
				$('#contact_send').addClass('disabled');
				
				$.ajax({
					type: 'POST',
					url: 'contact.php',
					data: html,
					success: function(msg){
						$('#contact_send i').removeClass('icon-cog icon-spin');
						$('#contact_send').removeClass('disabled');
						
						if (msg === 'ok'){
							$('#contact_send i').addClass('icon-ok').delay(1500).queue(function(next){
								$(this).removeClass('icon-ok');
								next();
							});
							$('#contact_send').addClass('btn-success').delay(1500).queue(function(next){
								$(this).removeClass('btn-success');
								next();
							});
							$('#form-contact')[0].reset();
						}else{
							$('#contact_send i').addClass('icon-remove').delay(1500).queue(function(next){
								$(this).removeClass('icon-remove');
								next();
							});
							$('#contact_send').addClass('btn-danger').delay(1500).queue(function(next){
								$(this).removeClass('btn-danger');
								next();
							});
						}
						
						$tis.sendingMail = false;
					},
					error: function(){
						$('#contact_send i').removeClass('icon-cog icon-spin');
						$('#contact_send').removeClass('disabled');
							
						$('#contact_send i').addClass('icon-remove').delay(1500).queue(function(next){
							$(this).removeClass('icon-remove');
							next();
						});
						$('#contact_send').addClass('btn-danger').delay(1500).queue(function(next){
							$(this).removeClass('btn-danger');
							next();
						});
						
						$tis.sendingMail = false;
					}
				});
			} else{
				$('#contact_send i').removeClass('icon-cog icon-spin');
				$('#contact_send').removeClass('disabled');
						
				$('#contact_send i').addClass('icon-remove').delay(1500).queue(function(next){
					$(this).removeClass('icon-remove');
					next();
				});
				$('#contact_send').addClass('btn-danger').delay(1500).queue(function(next){
					$(this).removeClass('btn-danger');
					next();
				});
			}
			
			return false;
		});
	},
	
	contactOpt: function() {
		"use strict";
		var $tis = this,
			options = $("#form-opt li");
		
		options.click(function(e){
			
			var item = $(e.currentTarget);

			if (!item.hasClass('active')) {
				options.removeClass('active');
			}
			
			if ( item.data("id") === 1) {
				$("#form-contact .input-hide").css({visibility: 'visible'});
				$("#form-contact .input-hide").animate({height: '52px'}, 300);
				$tis.formType = 1;
			} else {
				$("#form-contact .input-hide").animate({height: '0px'}, 300, function(){
					$("#form-contact .input-hide").css({visibility: 'hidden'});
				});
				$tis.formType = 0;
			}
			
			item.toggleClass('active');	
		});
	},
	
	initialize: function(lat, lng, title, address, logo) {
		"use strict";
		
		var $tis = this;
		
		var styles = [
			{
				stylers: [
					{ hue: "#404d75" },
					{ saturation: -30 }
				]
			},{
				featureType: "road",
				elementType: "geometry",
				stylers: [
					{ lightness: -10 },
				]
			}
		];
		
		var styledMap = new google.maps.StyledMapType(styles, {name: "Mochito"});
		
		$tis.myLatlng = new google.maps.LatLng(lat, lng);
		
		var mapOptions = {
			center:  $tis.myLatlng,
			zoom: 15,
			scrollwheel: false,
			panControl:false,
			mapTypeControl:false,
			zoomControl:true,
			zoomControlOptions: {
				position:google.maps.ControlPosition.RIGHT_CENTER
			}
		};
		
		$tis.map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		
		var contentString = '<img src="' + logo + '" alt="" width="195px" /><div class="map-address">' + address + '</div>';

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
		
		var marker = new google.maps.Marker({
			position: $tis.myLatlng,
			map: $tis.map,
			title: title,
			icon: "img/marker.png"
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open($tis.map,marker);
		});
		
		$tis.map.mapTypes.set('map_style', styledMap);
		$tis.map.setMapTypeId('map_style');
	}
	
};

Mochito.init();