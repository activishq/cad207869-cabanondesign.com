(function ( $ ) {

	"use strict";

	/**
	** Apps
	*/
	var app = {
		
		init: function() {

			app.example();
		
		},

		resize: function(){

		},

		example: function() {

		}

	};

	// Windows on Resize / Load
	$(window).on('resize', function () {
		app.resize();
	}).resize();

	// Document Ready
	$(document).ready(function() {
		app.init();
	});

})(jQuery);
