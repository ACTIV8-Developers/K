$(function() {
	"use strict";
	
	var $scrollanim	= (function() {
	
			// the portfolio items
		var $items			= $('#folio-items > li'),
			// inviewport rows and the outside viewport rows
			$itemsViewport, $itemsOutViewport,
			// the window element
			$win			= $(window),
			// we will store the window sizes here
			winSize			= {},
			// used in the scroll setTimeout function
			anim			= false,
			// last position of scrollTop
			lastPos = 0,
			// Scroll direction
			dir = "down",
			// initialize function
			init			= function() {
				// get window sizes
				getWinSize();
				// initialize events
				initEvents();
				// define the inviewport selector
				defineViewport();
				// gets the items that match the previous selector
				setViewportItems();
				// set scale for each item
				scaleItems();
			},
		
			// defines a selector that gathers the portfolio items that are initially visible.
			// the item is visible if its top is less than the window's height.
			// these items will not be affected when scrolling the page.
			defineViewport	= function() {					
				if ( $('#folio-items').offset().top < winSize.height ) {
					$items.slice(0, 3).addClass("fixed-folio-item");
				}
			},
			
			// checks which items are initially visible 
			setViewportItems = function() {
				$itemsViewport = $items.filter('.fixed-folio-item');
				$itemsOutViewport = $items.not( $itemsViewport );
			},
			
			// get window sizes
			getWinSize		= function() {
				winSize.width	= $win.width();
				winSize.height	= $win.height();				
			},
			
			// initialize some events
			initEvents		= function() {
						
				$(window).on({
					// on window resize we need to redefine which items are initially visible (this ones we will not animate).
					'resize.Scrolling' : function() {
						// get the window sizes again
						getWinSize();
						// redefine which items are initially visible (:inviewport)
						setViewportItems();
						// show inviewport items
						$itemsViewport.each( function() {
							$(this).css({
								'-webkit-transform' : 'scale(1)',
								'-moz-transform' : 'scale(1)',
								'-o-transform' : 'scale(1)',
								'transform' : 'scale(1)',
								'opacity': 1
							});
						});
					},
					
					// when scrolling the page change the scale of each item
					'scroll.Scrolling' : function() {
						// set a timeout to avoid that the 
						// scaleItems function gets called on every scroll trigger
						if( anim ){ return false; }
						
						anim = true;
						setTimeout( function() {
							scaleItems();
							anim = false;
							lastPos = $(window).scrollTop();
						}, 10 );
					}
				});
			},
			
			// sets the position of the rows (left and right row elements).
			// Both of these elements will start with -50% for the left/right (not visible)
			// and this value should be 0% (final position) when the element is on the
			// center of the window.
			scaleItems		= function() {
				
					// how much we scrolled so far
				var winscroll	= $win.scrollTop(),
					// the y value for the center of the screen
					winCenter	= winSize.height / 2 + winscroll;
				
					if( winscroll > lastPos ){
						dir = "down";
					} else if ( winscroll < lastPos ){
						dir = "up";
					}
								
				// for every item that is not inviewport
				$itemsOutViewport.each( function() {							
					var $item	= $(this),
						// top value
						itemT	= $item.offset().top,
						// item's height
						itemH	= $item.height(),
						viewPP;
								
					if( dir === "down" ){
						viewPP = itemT + itemH /3;
					} else {
						viewPP = itemT + itemH;
					}
					
					// hide the item if it is under the viewport
					if( viewPP > winSize.height + winscroll ) {
						$item.css({
							'-webkit-transform' : 'scale(0)',
							'-moz-transform' : 'scale(0)',
							'-o-transform' : 'scale(0)',
							'transform' : 'scale(0)',
							'opacity': 0
						});
					}
					// if not, the item should become visible (1 of scale/opacity) as it gets closer to the center of the screen.
					else {								
						// the value on each scrolling step will be proporcional to the distance from the center of the screen to its height
						var	factor = ( ( itemH - winCenter ) / ( winSize.height / 2 + itemH / 2 ) );
							
						// set calculated value
						var	val	= Math.min( Math.abs( factor - 1 ), 1 );
						
						$item.css({
							'-webkit-transform' : 'scale(' + val + ')',
							'-moz-transform' : 'scale(' + val + ')',
							'-o-transform' : 'scale(' + val + ')',
							'transform' : 'scale(' + val + ')',
							'opacity': val
						});
					}							
				});
						
			};
				
		return { init : init };
			
	})();

	// Do the scoll animation if not mobile device
	if(!$.browser.mobile){
		$scrollanim.init();
	} else {
		$('#folio-items > li').css({
			'-webkit-transform' : 'scale(1)',
			'-moz-transform' : 'scale(1)',
			'-o-transform' : 'scale(1)',
			'transform' : 'scale(1)',
			'opacity': 1
		});
	}		
});