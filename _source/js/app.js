(function ( $ ) {

	"use strict";

	/**
	** Global Caching
	*/
	var	app = '',
	$html = $('html'),
	$body = $('body'),
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
	** App
	*/
	app = {

		init: function() {

			app.dynamicform();

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
							beforeSend: function(data){},
							success: function(response){}
						});
					}, 1000);

				});
			});
		},

	};

	/**
	** Document Ready
	*/
	$(document).ready(function() {
		app.init();
	});

})( jQuery );
