(function($){
	"use strict";
	$(function(){

		/*------------------------------------*\
			#ON LOAD
		\*------------------------------------*/
		window.masonryFlag = false;

		/**
		* Menu
		**/
		new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger-xmall' ) );
		new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger-medium' ) );


		/*------------------------------------*\
			#Triggered events
		\*------------------------------------*/

		/**
		 * Show and hide elements with the ajax calls
		**/

		$('.loader')
		.ajaxStart(function() {
			$(this).show();
		})
		.ajaxStop(function() {
			$(this).hide();
		})




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
	var $container = $(container);
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: item
		});
		$container.masonry('reloadItems');
		$container.masonry('layout');
	});
}

/**
* Append elements to Masonry
**/
function appendToMasonry(container, items){
	var $container = $(container);
	$container.masonry( 'appended', items );
}

/**
* Destroy Masonry
**/
function destroyMasonry(container){
	var $container = $(container).masonry('destroy');
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

function runFitVids(selector){
	$(selector).fitVids();
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

/**
 * Toggle filters nav if filters exist
**/
function toggleFiltersNav(){
	var filtersLenght = $('.filters__results .filter').length;

	if( filtersLenght == 0 ){
		$('.filters__results').hide();
	}

	if( filtersLenght > 0 ){
		$('.filters__results').show();
	}
}

/**
 * Toggle iframe in the footer
**/
function toggleiFrame(){
	$('.iframe-fundacion-televisa').toggleClass('hidden--xmall');
	$('.js-toggle-iframe').toggleClass('margin-bottom');
	$('.footer-wrapper').css('margin-bottom', 0);
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

		toggleFiltersNav();

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
	toggleFiltersNav();
}

function addSearchFilter( searchValue ){
	var htmlSearchFilter = '<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ] filter--active" data-type="buscar" data-value="'+searchValue+'">'+searchValue+'</a>'
	$('.filters__results').append(htmlSearchFilter);
	toggleFiltersNav();
}// addSearchFilter

function removeFilter(element){
	//Get its content so we can deactivate it
	// in .filters__content
	var filterContent = $(element).html();

	//Delete it
	$(element).remove();

	//Deactive it in .filters__content
	$('.filters__content .filter:contains('+filterContent+')').removeClass('filter--active');

	toggleFiltersNav();

}

function removeFilters(){
	$('.filters__results .filter--active').remove();
	$('.filter--active').removeClass('filter--active');
}

function removeSearchFilters(){
	$('*[data-type="buscar"]').remove();
	toggleFiltersNav();
}

function getFilters(is_cargando_mas){
	var activos = $('.filters__results .filter--active');
	var search_filters = [];
	$.each(activos, function(i, val){
		var current_filter = {};
		var filter_type = $(val).data('type');
		var filter_value = $(val).data('value');
		current_filter['type'] = filter_type;
		current_filter['value'] = filter_value;
		if( ! is_cargando_mas ) clearGrid();
		search_filters.push(current_filter);
	});

	if( $('.filter-buscar input').val() != '' && typeof $('.filter-buscar input').val() !== 'undefined' ){
		current_filter = {};
		filter_type = 'buscar';
		filter_value = $('.filter-buscar input').val();
		current_filter['type'] = filter_type;
		current_filter['value'] = filter_value;
		search_filters.push(current_filter);
	}

	return search_filters;
}// getFilters

function clearGrid(){
	$('.results').empty();
	if ( post_type !== 'fotografos' && post_type !== 'proyectos' ){
		runMasonry('.results', '.result' );
	}
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
		//Substract the header height from the window height
		//and apply it as its top
		var topHeader =  windowHeight - headerHeight;
		$('.header-wrapper').addClass('header-wrapper--fixed').css('top', topHeader);
		//setHeaderHeightPadding('.footer-wrapper', 'bottom');
	} else {
		$('.header-wrapper').removeClass('header-wrapper--fixed').css('top', 0);
		//setPadding('.footer-wrapper', 'bottom', 0);
	}
}

//Get the scrolled pixels in Y axis
function scrollY() {
	return $('.content-wrapper').scrollTop();
}

//Show lightbox and run cycle
function openLightbox( lightboxNumber, imagenNumber ){
	$('.slideshow-'+lightboxNumber).cycle({
		slides 			: '.image-single',
		fx 				: 'scrollHorz',
		swipe 			: true,
		timeout 		: 0,
		centerHorz 		: true,
		centerVert 		: true,
		startingSlide 	: imagenNumber
	});

	$('.slideshow-'+lightboxNumber).on( 'cycle-update-view', function( e, optionHash, slideOptionsHash, currentSlideEl ) {
		$('.modal-wrapper').addClass('hide');
		$(this).closest('.modal-wrapper').removeClass('hide');
	});

	$(document).on('keydown', function(e) {
		//e.preventDefault();
		if(e.which == 37) { // left
			$('.slideshow-'+lightboxNumber).cycle('prev');
		} else if(e.which == 39) { // right
			$('.slideshow-'+lightboxNumber).cycle('next');
		}
	});
}

function destroyCycle(){
	$('.slideshow').each(function(){
		$(this).cycle('destroy');
	});
}

/**
 * Opens Modal
 * @param element
**/
function openModal(element){
	var aAbrir = element.data('modal');
	aAbrir = $('#js-'+aAbrir+'.modal-wrapper' );
	aAbrir.removeClass('hide');
}

/**
 * Closes Modal
 * @param element to be closed
**/
function closeModal(element){
	var aCerrar = element.closest('.modal-wrapper');
	aCerrar.addClass('hide');
	$(document).unbind('keydown');
}

// AJAX
function advancedSearch(post_type, filters, limit, existing_ids){
	var user_data = {};
	user_data['action'] = 'advanced_search';
	user_data['post_type'] = post_type;
	user_data['limit'] = limit;
	user_data['existing_ids'] = existing_ids;
	user_data['filters'] = '';
	if(filters.length > 0)
		user_data['filters'] = filters;

	var html_resultados = '';
	$.post(
		ajax_url,
		user_data,
		function(response){

			//console.log(response);

			var json_posts = $.parseJSON(response);
			var html_resultado;
			var num_posts = -1;
			$.each(json_posts, function(i, val){
				//console.log(val);
				switch(post_type){
					case 'fotografias':
						html_resultado = getHtmlColecciones(val);
						break;
					case 'fotografos':
						html_resultado = getHtmlFotografos(val);
						break;
					case 'carteleras':
						html_resultado = getHtmlCarteleras(val);
						break;
					case 'proyectos':
						html_resultado = getHtmlProyectos(val);
						break;
					case 'exposiciones':
						html_resultado = getHtmlExposiciones(val);
						break;
					case 'publicaciones':
						html_resultado = getHtmlPublicaciones(val);
						break;
					case 'nuevas-adquisiciones':
						html_resultado = getHtmlColecciones(val);
						break;
					case 'favoritos':
						html_resultado = getHtmlColecciones(val);
						break;
				}

				html_resultados = html_resultados+html_resultado;

				num_posts = i;
			});

			$(html_resultados).appendTo('.results');
			num_posts = parseInt(num_posts) + 1;



			/**
			 * Compare each set of results with total results
			**/

			if ( post_type !== 'fotografos' && post_type !== 'proyectos' ){
				runMasonry( '.results', '.result' );
			}


			// Hide "cargar mas" when there are no more posts to load
			if(parseInt(limit) > parseInt(num_posts))
				$('.js-cargar-mas').addClass('hidden--xmall');
			else
				$('.js-cargar-mas').removeClass('hidden--xmall');

			/**
			 * If there are no results show a message staying the fact.
			**/
			if ( num_posts < 0 ){
				var emptyMessage = '<div class="[ wrapper ]"><h2 class="[ padding ][ margin-bottom ][ text-center ][ bg-highlight color-claro ]">Tu búsqueda no generó ningún resultado, elimina alguno de los filtros de arriba hasta obtener resultados.</h2></div>';
				$(emptyMessage).appendTo('.results');
				setTimeout(function() {
					destroyMasonry('.results');
				}, 50);
			}



		}// response
	)
	.fail(function(e){
		//console.log(e);
	});
}// searchColeccionesTest

function getDescripcionColeccion(id_coleccion, element){
	var coleccion_data = {};
	coleccion_data['action'] = 'get_descripcion_coleccion';
	coleccion_data['id_coleccion'] = id_coleccion;

	$.post(
		ajax_url,
		coleccion_data,
		function(response){
			//console.log(response);
			var html_descripcion_coleccion = $.parseJSON(response);

			$('#js-info-coleccion .modal-body').html(html_descripcion_coleccion.description);
			$('.js-titulo-coleccion').text(html_descripcion_coleccion.title);
			openModal( element );
		}
	);
}// getDescripcionColeccion

function postAjaxForm(form){
	var coleccion_data = {};
	coleccion_data['action'] = 'get_descripcion_coleccion';
	coleccion_data['id_coleccion'] = id_coleccion;

	$.post(
		ajax_url,
		coleccion_data,
		function(response){
			var html_descripcion_coleccion = $.parseJSON(response);
			$('#js-info-coleccion .modal-body').html(html_descripcion_coleccion);
		}
	);
}// getDescripcionColeccion

function getExistingIds(){
	var results = $('body').find('.result');
	var ids = [];
	if (results.length == 0) return 0;
	$.each(results, function(i, result){ ids.push($(result).data('id')); });
	return ids;
}// getExistingIds

function getHtmlColecciones(results){

	var html_resultados = '<article class="[ result ] [ columna xmall-12 small-ls-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'" target="_blank"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
			</a> \
			<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
				<p class="[ text-center ]">';
					if ( results.autor ){
						if ( results.autor != 'Autor no identificado' ){
							html_resultados = html_resultados+'<a href="'+results.url_autor+'" target="_blank" class="[ media--info__author ]">'+results.autor+'</a>, ';
						}
					}
					if ( results.titulo ){
						if ( results.titulo !== 'Sin título' || results.titulo !== 'Sin t\u00edtulo' ){
							html_resultados = html_resultados+'<a href="'+results.permalink+'" class="[ media--info__name ]" target="_blank">'+results.titulo+'</a>, ';
						}
					}
					if ( typeof results.serie !== 'undefined' && results.serie !== 'undefined' && results.serie !== '' ){
						html_resultados = html_resultados+'de la serie <span class="[ media--info__series ]">'+results.serie+'</span>, ';
					}
					if ( results.coleccion ){
						html_resultados = html_resultados+'<br /> de la colección <a href="'+site_url+'/colecciones?coleccion='+results.coleccion_slug+'" class="[ media--info__colection ]" target="_blank">'+results.coleccion+'</a>';
					}
				html_resultados = html_resultados+'</p> \
			</div> \
		</div> \
	</article>';
	return html_resultados;
}// getHtmlColecciones

function getHtmlFotografos(results){
	var html_resultados = ' <a href="'+results.url+'" target="_blank" class="[ result ][ button button--hollow button--small button--dark ][ inline-block margin-bottom--small ]" data-id="'+results.id+'">'+results.fotografo+'</a> &nbsp;&nbsp;';
	return html_resultados;
}

function getHtmlCarteleras(results){
	var html_resultados = '<article class="[ result ][ columna xmall-12 small-ls-6 medium-4 large-3 ][ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'" target="_blank"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]">';
						if ( results.titulo ){
							if ( results.titulo !== 'Sin título' || results.titulo !== 'Sin t\u00edtulo' ){
								html_resultados = html_resultados+'<a href="'+results.permalink+'" class="[ media--info__title ]" target="_blank">'+results.titulo+'</a>';
							}
						}
					html_resultados = html_resultados+'</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}

function getHtmlProyectos(results){

	var html_resultados = '<article class="[ result ][ bg-image ][ columna columna-margin xmall-12 medium-6 ]" data-id="'+results.id+'" style="background-image: url('+results.img_url+')"> \
		<div class="[ opacity-gradient ][ square square-absolute ]">';
			if ( results.term == 'link' ){
				html_resultados = html_resultados+'<a class="[ block ][ media-link ]" href="'+results.link+'" target="_blank"></a>';
			} else {
				html_resultados = html_resultados+'<a class="[ block ][ media-link ]" href="'+results.permalink+'"></a>';
			}
			html_resultados = html_resultados+ '<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
				<p class="[ text-center ]">';
					if ( results.titulo ){
						if ( results.titulo !== 'Sin título' || results.titulo !== 'Sin t\u00edtulo' ){
							if ( results.term == 'link' ){
								html_resultados = html_resultados+'<a href="'+results.link+'" class="[ media--info__title ]">'+results.titulo+'</a>';
							} else {
								html_resultados = html_resultados+'<a href="'+results.permalink+'" class="[ media--info__title ]">'+results.titulo+'</a>';
							}
						}
					}
				html_resultados = html_resultados+'</p> \
			</div> \
		</div> \
	</article>';
	return html_resultados;
}// getHtmlProyectos

function getHtmlExposiciones(results){

	var html_resultados = '<article class="[ result ][ columna xmall-12 small-ls-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]">';
						if ( results.titulo ){
							if ( results.titulo !== 'Sin título' || results.titulo !== 'Sin t\u00edtulo' ){
								html_resultados = html_resultados+'<a href="'+results.permalink+'" class="[ media--info__title ]" target="_blank">'+results.titulo+'</a>';
							}
						}
					html_resultados = html_resultados+'</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}

function getHtmlPublicaciones(results){

	var html_resultados = '<article class="[ result ][ columna xmall-12 small-ls-6 medium-4 large-3 ][ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'" target="_blank"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]"> \
						<a href="'+results.permalink+'" target="_blank" class="[ media--info__title ]">'+results.titulo+'</a> \
					</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}

function addLike( post_id ){
	var data = {};
	data['action'] = 'add_like';
	data['post_id'] = post_id;

	$.post(
		ajax_url,
		data,
		function(response){
			$('.js-num-likes').text(response);
			$('.button--heart').addClass('active');
		}
	);
}

function showTotalResults( post_type, filters ){
	var data = {};
	data['action'] = 'get_total_results';
	data['filters'] = (filters.length > 0) ? filters : '';
	data['post_type'] = post_type;

	$.post(
		ajax_url,
		data,
		function(response){
			console.log(response);
			var json_response = $.parseJSON(response);
			$('.js-num-resultados span').text(json_response);
		}
	);
}

function saveContact(data){
	$.post(
		ajax_url,
		data,
		function(response){
			//console.log(response);
			$('.js-contact').empty();
			$('.js-contact').append('<p>Gracias por contactarnos '+response+'</p>');
		}
	);
}



/*------------------------------------*\
	# FACEBOOK AND TWITTER FUNCTIONS
\*------------------------------------*/

function showNumberTweets(url){
	$.get(
		'http://urls.api.twitter.com/1/urls/count.json?url='+url,
		function( response ){
			//console.log(response);
		}
	);
}// showNumberTweets

function showNumberShares(url){
	try {
		FB.api(
			"/",
			{
				"id": url,
				"access_token": "853048764736608|MaIMwoVY0SKEWJFYfZ7Ga4_NCrk"
			},
			function (response) {
				//console.log(response);
				if (response && !response.error) {
					if(typeof response.share !== 'undefined'){
						var share_count = response.share.share_count;
						$('.js-share-count').text(share_count);
					}
				} else {
					showNumberShares(url);
				}
			}
		);
	} catch(err){
		//console.log(err);
	}
}// showNumberShares

function shareOnFacebook(url){
	FB.ui(
		{
			method: 'share',
			href: url,
		},
		function(response) {
			if (response && !response.error_code) {
				//console.log(response);
			} else {
				//console.log(response.error_code);
			}
		}
	);
}// shareOnFacebook

function fbEnsureInit(callback) {
	if( !window.fbApiInit ) {
		//console.log('no ha cargado FB...');
		setTimeout(function() {fbEnsureInit(callback);}, 50);
	} else {
		// console.log('ya cargó FB...');
		// console.log('callback');
		callback;
	}
}// fbEnsureInit



/*------------------------------------*\
	#RESPONSIVE
\*------------------------------------*/








