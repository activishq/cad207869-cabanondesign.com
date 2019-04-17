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
			app.tagmanager();

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

		tagmanager: function() {
			if( $('.tagmanager-click').length > 0 ){
				$('.tagmanager-click').each(function() {
					var tagmanagerTarget = $(this).data('tagmanager-target');
					var tagmanagerCategory = $(this).data('tagmanager-category');
					var tagmanagerAction = $(this).data('tagmanager-action');
					var tagmanagerLabel = $(this).data('tagmanager-label');

					if( tagmanagerTarget != '' && tagmanagerCategory != '' && tagmanagerAction != '' && tagmanagerLabel != '' ){
						if( $(this).find(tagmanagerTarget).length > 0 ){
							$(this).find(tagmanagerTarget).click(function(e){
								dataLayer.push({
									'event': 'gaEvent',
									'eventCategory' : tagmanagerCategory,
									'eventAction': tagmanagerAction,
									'eventLabel': tagmanagerLabel
								});
							});
						}
					}
				});
			}

			var activis_submitControllerEvent = Marionette.Object.extend( {

				initialize: function() {
					this.listenTo( Backbone.Radio.channel( 'forms' ), 'submit:response', this.actionSubmit );
				},

				actionSubmit: function( response ) {
					if( response[ 'data' ][ 'form_id' ] == '1' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Contact Me'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '2' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Formulaire de soumission'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '3' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Demande de rendez-vous'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '4' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Devenir un distributeur'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '5' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Demande de rendez-vous - Page'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '7' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Request a quote'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '9' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Book your home appointment'
						});
					}
					else if( response[ 'data' ][ 'form_id' ] == '11' ){
						dataLayer.push({
							'event': 'gaEvent',
							'eventCategory' : 'Form',
							'eventAction': 'Submit',
							'eventLabel': 'Become a distributor'
						});
					}
				},

			});

			new activis_submitControllerEvent();
		}

	};

	/**
	** Document Ready
	*/
	$(document).ready(function() {
		app.init();
	});

})( jQuery );


//# sourceMappingURL=app.js.map