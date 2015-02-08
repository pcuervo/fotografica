(function($){
	"use strict";
	$(function(){

		/*------------------------------------*\
			#ON LOAD
		\*------------------------------------*/

		/**
		* Menu
		**/
		new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger-xmall' ) );
		new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger-medium' ) );




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
* Declare $
**/
var $=jQuery.noConflict();


/**
* Get the width of the window and apply it
* as the height to the home secctions ( .square elements )
**/

function setSquareHeight(){
	var windowWidth = $(window).width();
	$('.j-square').height(windowWidth);
}


/**
* Masonry layout for results
**/
function runMasonry(container, item){
	var $container = $(container).masonry();
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: item
		});
		$container.masonry( 'reloadItems' );
		$container.masonry( 'layout' );
	});
}

//Get the header height
function getHeaderHeight(){
	return $('.header-wrapper').height();
}

//Get the window height
function getWindowHeight(){
	return $(window).height();
}

//Set the window height to another element
function setWindowHeight(element){
	$(element).height( getWindowHeight() );
}

//Set the padding
function setPadding(element, direction, amount){
	$(element).css('padding-'+direction, amount);
}

//Set the heather height as padding for another element
function setHeaderHeightPadding(element, direction){
	//Get the header height
	var headerHeight = getHeaderHeight();
	//Apply that height to the main wrapper as padding top
	$(element).css('padding-'+direction, headerHeight);
}

// Set the height of an element substracting the
// element's outer wrapper minus it's title
function setHeightMinusElement(element, wrapper, title){
	$.each($(element), function(index, val) {
		var thisWrapper = $(this).closest(wrapper);
		var thisTitle = thisWrapper.find(title+':first');
		var thisWrapperHeight = thisWrapper.outerHeight();
		var thisTitleHeight = thisTitle.outerHeight();
		var heightForElement = getWindowHeight() - thisTitleHeight;
		$(this).height(heightForElement);
	});

}



/*------------------------------------*\
	#Triggered events
\*------------------------------------*/

function showFilters(element){
	//Check if this is already open and close it
	if ( $(element).hasClass('tab-filter--active') ){
		$('.tab-filter').removeClass('tab-filter--active');
		$('.filters__content > div').css('height', '0px').removeClass('padding--small');
		return;
	}

	//Make all .tab-filter un-active
	$('.tab-filter').removeClass('tab-filter--active');
	//Make this active
	$(element).addClass('tab-filter--active');

	//Get the filter category
	var filterCategory = $(element).data('filter');
	//Hide other filters category
	$('.filters__content > div').css('height', '0px').removeClass('padding--small');
	//Show this filter category
	$('.filters__content .filter-'+filterCategory).addClass('padding--small').height('auto');
}

function addFilter(element){
	//Clone this element so it won't get deleted by .append
	// and manipulate it instead of the clicked filter
	var $clone = $(element).clone();

	//If element is already added, then delete it
	if ( $(element).hasClass('filter--active') ){
		//Remove class active
		$(element).removeClass('filter--active');

		//Get its content so we can delete in the selected filters (.filters__results )
		//If element has extra info, delete that info first
		if ( $clone.hasClass('filter--info') ){
			$clone.find('span').remove();
		}
		var filterContent = $clone.html();
		$('.filters__results .filter:contains('+filterContent+')').remove();
		return;
	}

	//Add active class to this element and its clone
	$(element).addClass('filter--active');
	$clone.addClass('filter--active');

	//If element has extra info, delete that info
	if ( $clone.hasClass('filter--info') ){
		//First delete the info class
		$clone.removeClass('filter--info')
		//then delete the info
		$clone.find('span').remove();
	}

	//And add this filter to the set of selected filters (.filters__results )
	$clone.appendTo('.filters__results');
}

function removeFilter(element){
	//Get its content so we can deactivate it
	// in .filters__content
	var filterContent = $(element).html();

	//Delete it
	$(element).remove();

	//Deactive it in .filters__content
	$('.filters__content .filter:contains('+filterContent+')').removeClass('filter--active');
}

function getFilteredResults(){
	var activos = $('.filters__results .filter--active');
	var search_filters = [];
	$.each(activos, function(i, val){
		var current_filter = {};
		var filter_type = $(val).data('type');
		var filter_value = $(val).data('value');
		current_filter['type'] = filter_type;
		current_filter['value'] = filter_value;
		clearGrid();
		search_filters.push(current_filter);
	});
	return search_filters;
}// getFilteredResults

function clearGrid(){
	$('.results').empty();
}// clearGrid

function fixedHeader(){
	//Get the header height so we can now when
	//to change the heade state
	var headerHeight = getHeaderHeight();
	//Scrolled pixels in Y axis
	var sy = scrollY();
	//Compare the two numbers, when they are the same of less
	//add fixed class to the header.
	if ( sy >= headerHeight ) {
		//Get the window height so we now how to position
		//the header at the bottom
		var windowHeight = $(window).outerHeight();
		//Substract the header height feom the window height
		//and apply it as its top
		var topHeader =  windowHeight - headerHeight;
		$('.header-wrapper').addClass('header-wrapper--fixed').css('top', topHeader);
		setHeaderHeightPadding('.footer-wrapper', 'bottom');
	} else {
		$('.header-wrapper').removeClass('header-wrapper--fixed').css('top', 0);
		setPadding('.footer-wrapper', 'bottom', 0);
	}
}

//Get the scrolled pixels in Y axis
function scrollY() {
	return $('.content-wrapper').scrollTop();
}

//Show lightbox and run cycle
function openLightbox(){
	$('.cycle-slideshow').cycle({
		slides 		: ".image-single",
		fx 			: "scrollHorz",
		swipe 		: "true",
		timeout 	: "0",
		centerHorz : "true",
		centerVert : "true"
	});
	$('.lightbox').show();
}

// AJAX para buscadores
function searchTest(post_type, filters, limit){
	var user_data = {};
	user_data['action'] = 'advanced_search';
	user_data['post_type'] = post_type;
	user_data['limit'] = limit;

	user_data['filters'] = '';
	if(filters.length > 0)
		user_data['filters'] = filters;
	$.post(
		ajax_url,
		user_data,
		function(response){
			$('.loader').hide();
			console.log(response);
			var json_posts = $.parseJSON(response);
			$.each(json_posts, function(i, val){
				console.log(val);
				var html_photo = '<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]"> \
					<div class="[ relative ]"> \
						<a class="[ block ]" href="#"> \
							<img src="'+val.img_url+'" class="[ image-responsive ]" /> \
							<span class="[ opacity-gradient--full ]"></span> \
							<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
								<p class="[ text-center ]"> \
									<a href="#" class="[ media--info__author ]">'+val.autor+'</a> \
									, <a href="#" class="[ media--info__name ]">'+val.titulo+'</a> \
									, de la serie <span class="[ media--info__series ]">'+val.coleccion+'</span> \
									, <span class="[ media--info__place ]">'+val.lugar+'</span> \
									, <span class="[ media--info__date ]">'+val.ano+'</span> \
								</p> \
							</div> \
						</a> \
					</div> \
				</article>';
				$(html_photo).appendTo('.results');
			});
			runMasonry('.results', '.result' );

		}// response
	);
}// searchColeccionesTest


/*------------------------------------*\
	#RESPONSIVE
\*------------------------------------*/








