(function($){
	"use strict";
	$(function(){

		/*------------------------------------*\
			#ON LOAD
		\*------------------------------------*/

		/**
		* Menu
		**/
		new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );





		/*------------------------------------*\
			#Triggered events
		\*------------------------------------*/




		/*------------------------------------*\
			#RESPONSIVE
		\*------------------------------------*/

	});
})(jQuery);

/*------------------------------------*\
	#ON LOAD
\*------------------------------------*/

/**
* Get the width of the window and apply it
* as the height to the home secctions ( .square elements )
**/


function setSquareHeight(){
	var windowWidth = $(window).width();
	$('.j-square').height(windowWidth);
}






/*------------------------------------*\
	#Triggered events
\*------------------------------------*/




/*------------------------------------*\
	#RESPONSIVE
\*------------------------------------*/
