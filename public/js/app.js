(function ( $ ) {

	"use strict";

	/**
	** Global Caching
	*/
	var preload = '',
	app = '',
	$app = $('.app'),
	$html = $('html'),
	$body = $('body'),
	$siteHeader = $('.header'),
	$siteMain = $('.site-main'),
	$siteFooter = $('.site-footer'),
	$window = $(window);

	/**
	** Is Mobile
	*/
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iOS|iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};


	/**
	** Pre-load
	** Code to be executed before the app init
	*/
	preload = {

		init: function() {

			preload.load();

		},

		load: function() {

			var $siteHeaderHeight = $siteHeader.outerHeight();

			/* Check Header Classes */
			if ( $body.hasClass( 'header-is-sticky' ) ) {
				$siteMain.css('padding-top', $siteHeaderHeight);
			}

			if ( $body.hasClass( 'header-is-sticky-resize-on-scroll' ) ) {
				$siteMain.css('padding-top', $siteHeaderHeight);
			}

			/* Init the site */
			app.init();

		}

	};

	/**
	** App
	*/
	app = {

		init: function() {

			app.load();
			app.header();
			app.navigation();
			app.infinitescroll();
			app.dynamicform();
			app.ui();

		},

		load: function() {

			setTimeout(
				function(){
					$siteMain.addClass('loaded');
					$siteFooter.addClass('loaded');
				}, 750
			);

		},

		header: function() {

			var $sidebar = '';
			var $nav = '.nav';
			var $hamburger = '.hamburger';
			
			$sidebar = new TimelineMax({
				paused: true,
				reversed: true
			});

			$sidebar
				.add(TweenMax.to('#sidebar', 0.1, { visibility:'visible' } ))
				.add(TweenMax.to('body, html', 0.1, { overflow:'hidden' } ))
				.add(TweenMax.to('body', 0.1, { className:'+=nav--is-open' } ))
				.add(TweenMax.to('#sidebar', 0.55, { x:0, ease: Power4.easeInOut } ), '=-0.1')
				.add(TweenMax.staggerTo('.menu-item a', 0.15, { y:'0%', ease: Power4.easeInOut }, 0), '=-0.15');
			
			$(document).on('click', $hamburger, function(e) {
				if ( !$body.hasClass( 'nav--is-open' ) ) {
					$sidebar.reversed() ? $sidebar.play().timeScale(1) : $sidebar.reverse();
				}
			} );
			
			$(document).on('click', '.app', function(e) {
				if ( $body.hasClass( 'nav--is-open' ) ) {
					$sidebar.reversed() ? $sidebar.play().timeScale(1) : $sidebar.reverse();
				}
			} );

			$(document).on('keyup',function(e) {
				if (e.keyCode == 27) {
					if ( $body.hasClass( 'nav--is-open' ) ) {
						$sidebar.reversed() ? $sidebar.play().timeScale(1) : $sidebar.reverse();
					}
				}
			});

		},

		navigation: function() {

			var 	navListItems = $( '.menu > li' ),
				hoverIntentconfig = {
					sensitivity: 3,
					interval: 150,
					over: open,
					timeout: 150,
					out: close
				};

			$.fn.toggle  = function(speed, easing) {
				return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing);
			};
			
			function open() {
				$(this).toggleClass('menu-open');
				$(this).find('.sub-menu').toggle(300,'easeInOutExpo');
			}

			function close() {
				$(this).toggleClass('menu-open');
				$(this).find('.sub-menu').toggle(300,'easeInOutExpo');
			}

			/* Mobile Support */
			if ( ! isMobile.any() ) {
				navListItems.hoverIntent(hoverIntentconfig);
			} else {
				navListItems.on('tap', function(e) {
					e.preventDefault();
					$(this).toggleClass('menu-open');
					$(this).find('.sub-menu').toggle(300,'easeInOutExpo');
				});
			}		

		},

		woocommerce: function() {

			// Login/register
			$('.account-tab-list').on('click','.account-tab-link',function(){
				
				if ( $('.account-tab-link').hasClass('registration_disabled') ) {
					return false;
				} else {
				
					var that = $(this),
						target = that.attr('href');
					
					that.parent().siblings().find('.account-tab-link').removeClass('current');
					that.addClass('current');
					
					$('.account-forms').find($(target)).siblings().stop().fadeOut(function(){
						$('.account-forms').find($(target)).fadeIn();
					});
					
					return false;
				}
			});
			
			// Login/register mobile
			$('.account-tab-link-register').on('click',function(){
				$('.login-form').stop().fadeOut(function(){
					$('.register-form').fadeIn();
				})
				return false;
			})
			
			$('.account-tab-link-login').on('click',function(){
				$('.register-form').stop().fadeOut(function(){
					$('.login-form').fadeIn();
				})
				return false;
			})

			/**
			 *
			 * Quantity
			 *
			 */
			$('.quantity .plus').on('click', function(e) {
				var $input = $(this).prev('.qty'),
					$val = parseInt($input.val());
				$input.val( $val+1 ).change();
			});
			
			$('.quantity .minus').on('click', function(e) {
				var $input = $(this).next('.qty'),
					$val = parseInt($input.val());
				if ($val > 0) {
					$input.val( $val-1 ).change();
				} 
			});	


		},

		minicart: function() {

			//	Build dynamic add to cart message		
			var notificationContent = '';

			$('body').on('click', '.ajax_add_to_cart', function(){
				
				$('.woocommerce-message').remove();
				
				var imgSrc = $(this).parents('li').find('img.attachment-large').attr('src');
				var prodTitle = $(this).parents('li').find('.woocommerce-loop-product__title').html();

				if ( typeof imgSrc != 'undefined' && typeof prodTitle != 'undefined' ) {
					notificationContent = '<div class="woocommerce-message"><div class="product_notification_wrapper"><div class="product_notification_background" style="background-image:url(' + imgSrc + ')"></div><div class="product_notification_text">&quot;' + prodTitle + '&quot;' + vars.addedToCartMessage +'</div></div></div>';
				} else {
					notificationContent = false;
				}

			});

			//  Display notification on ajax add to cart
			$(document).on('added_to_cart', function(event, data) {
				if (notificationContent != false) {
					$('.app').prepend(notificationContent);
				}
			});

		},

		infinitescroll: function() {

			var $container = $('.grid-layout');

			if( $container.length ){
				$container.imagesLoaded( function () {
					$container.masonry({
						itemSelector: '.grid-item',
						columnWidth: '.grid-sizer',
						percentPosition: true
					});
				});
			}

			$container.infinitescroll({
				navSelector: '.navigation',
				nextSelector: '.navigation a',
				itemSelector: '.grid-item',
				isAnimated: false,
				debug: true,
				loading: {
					finished: undefined,
					finishedMsg: null,
					msg: null,
					img: vars.home+'/public/svg/loading.svg',
					msgText: vars.loadingText,
					selector: null,
					speed: 'fast',
					start: undefined
				},
			}, 

			function (newElements) {
				var $newElems = $(newElements).css({
					'opacity' : 0
				});
				$newElems.imagesLoaded(function () {
					$newElems.animate({
						opacity: 1
					});
					$container.masonry('appended', $newElems, true);
				});
			});

			$(document).ajaxError(function (e, xhr, opt) {
				if (xhr.status == 404) jQuery('.navigation a').remove();
			});  

		},

		dynamicform: function() {

			$(document).on( 'nfFormReady', function( e, layoutView ) {

				var dynamicform_timer = 0

				$('.nf-form-wrap form').on( 'focusout', '.ninja-forms-field', function(){

					var dynamicform_array = {};

					$(this).closest('form').find('.ninja-forms-field').each(function(){

						dynamicform_array[ $(this).attr('name') ] = $(this).val();

					});

					clearTimeout(dynamicform_timer);

					dynamicform_timer = setTimeout(function(){

						$.ajax({
							type : 'post',
							dataType : 'json',
							url: vars[ 'ajax' ],
							data : {
								'action' : 'ajaxEventDynamicForm',
								'nonce' : vars[ 'nonce' ],
								'dynamicform' : dynamicform_array
							},
							beforeSend: function(data){
						
							},
							success: function(response){
						
							}
						});

					}, 1000);

				});

			});

		},

		ui: function() {

			/* Fetch all data-image selector and use them as a background-image */
			var list = document.querySelectorAll("div[data-image]");

			for (var i = 0; i < list.length; i++) {
				var url = list[i].getAttribute('data-image');
				list[i].style.backgroundImage="url('" + url + "')";
			}

			/* Scroll to Top */
			var offset = 100,
			offsetOpacity = 1200,
			scrollTopDuration = 500,
			$btt = $('.ui-to-top');

			$window.scroll( function() { (
				$(this).scrollTop() > offset ) ? $btt.addClass('is--visible') : $btt.removeClass('is--visible fade--out');
				if( $(this).scrollTop() > offsetOpacity ) {
					$btt.addClass('fade--out');
				}
			});

			$btt.on('click', function(event){
				event.preventDefault();
				$('html, body').animate({
					scrollTop: 0 ,
				}, scrollTopDuration
				);
			});

		},

		/**
		 *
		 * On resize
		 *
		*/
		resize: function() {

			/* Set is-mobile on the body */
			if ( $window.width() < 1280 ) {
				$body.addClass('is-mobile');
			} else {
				$body.removeClass('is-mobile');
			}

		},

		/**
		 *
		 * On scroll
		 *
		*/
		scroll: function() {

			var scroll = $(window).scrollTop();

			if ( scroll >= 250 ) {
				$body.addClass('device--has-scrolled');
			} else {
				$body.removeClass('device--has-scrolled');
			}

		},

	};

	// Windows on Resize / Load
	$(window).on("resize", function () {
		app.resize();
	}).resize();
	
	// Windows Scroll
	$(window).scroll(function() {
		app.scroll();
	});

	// Document Ready
	$(document).ready(function() {
		preload.init();
	});

})( jQuery );

//# sourceMappingURL=app.js.map