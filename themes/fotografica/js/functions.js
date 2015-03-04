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
	var $container = $(container).masonry();
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: item
		});
		$container.masonry( 'reloadItems' );
		$container.masonry( 'layout' );
	});
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

	console.log(filtersLenght);

	if( filtersLenght == 0 ){
		$('.filters__results').hide();
	}

	if( filtersLenght > 0 ){
		$('.filters__results').show();
	}
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

	if( $('.filter-buscar input').val() != '' && typeof $('.filter-buscar input').val() !== 'undefined' ){
		current_filter = {};
		filter_type = 'buscar';
		filter_value = $('.filter-buscar input').val();
		current_filter['type'] = filter_type;
		current_filter['value'] = filter_value;
		search_filters.push(current_filter);
	}

	return search_filters;
}// getFilteredResults

function clearGrid(){
	$('.results').empty();
	runMasonry('.results', '.result' );
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

/**Modal
 * Opens
 * @param element
**/
function openModal(element){
	console.log('openModal');
	var aAbrir = element.data('modal');
	console.log(aAbrir);
	aAbrir = $('#js-'+aAbrir+'.modal-wrapper' );
	aAbrir.removeClass('hide');
}

/**
 * Closes Modal
 * @param element to be closed
**/
function closeModal(element){
	var aCerrar = element.parent().parent();
	aCerrar.addClass('hide');
}

// AJAX
function advancedSearch(post_type, filters, limit, existing_ids){
	var user_data = {};
	user_data['action'] = 'advanced_search';
	user_data['post_type'] = post_type;
	user_data['limit'] = limit;
	user_data['existing_ids'] = existing_ids;

	//console.log(post_type);
	user_data['filters'] = '';
	//console.log(filters);
	if(filters.length > 0)
		user_data['filters'] = filters;
	$.post(
		ajax_url,
		user_data,
		function(response){

			var json_posts = $.parseJSON(response);
			var html_resultados;
			var num_posts = 0;
			$.each(json_posts, function(i, val){

				switch(post_type){
					case 'fotografias':
						html_resultados = getHtmlColecciones(val);
						break;
					case 'fotografos':
						html_resultados = getHtmlFotografos(val);
						break;
					case 'carteleras':
						html_resultados = getHtmlCarteleras(val);
						break;
					case 'proyectos':
						html_resultados = getHtmlProyectos(val);
						break;
					case 'exposiciones':
						html_resultados = getHtmlExposiciones(val);
						break;
					case 'publicaciones':
						html_resultados = getHtmlPublicaciones(val);
						break;
					case 'nuevas-adquisiciones':
						html_resultados = getHtmlColecciones(val);
						break;
					case 'favoritos':
						html_resultados = getHtmlColecciones(val);
						break;
				}
				$(html_resultados).appendTo('.results');
				num_posts = i;
			});

			/**
			 * If the postType is fotografos do not run masonry
			**/
			if ( post_type !== 'fotografos' ){
				runMasonry('.results', '.result' );
			}


			/**
			 * If there are no results show a message staying the fact.
			**/
			if ( num_posts == 0 ){
				var emptyMessage = '<div class="[ wrapper ]"><h2 class="[ padding ][ margin-bottom ][ text-center ][ bg-highlight color-claro ]">Tu búsqueda no generó ningún resultado, elimina alguno de los filtros de arriba hasta obtener resultados.</h2></div>';
				$(emptyMessage).appendTo('.results');
				setTimeout(function() {
					destroyMasonry('.results');
				}, 50);
			}


			// Hide "cargar mas" when there are no more posts to load
			num_posts = parseInt(num_posts) + 1;
			if(parseInt(limit) > parseInt(num_posts))
				$('.js-cargar-mas').hide();
			else
				$('.js-cargar-mas').show();

		}// response
	)
	.fail(function(e){
		console.log(e);
	});
}// searchColeccionesTest

function getDescripcionColeccion(id_coleccion){
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
	if(results.url_autor != '-')
		var html_autor = '<a href="'+results.url_autor+'" class="[ media--info__author ]">'+results.autor+'</a>';
	else
		var html_autor = '<p class="[ media--info__author ]">'+results.autor+'</p>';

	var html_resultados = '<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]">';
						if ( results.autor ){
							//console.log('autor: '+results.autor);
							if ( results.autor == 'Autor no identificado' ){
								html_resultados = html_resultados+'<span class="[ media--info__author ]">'+results.autor+'</span>, ';
							} else {
								html_resultados = html_resultados+'<a href="'+results.url_autor+'" class="[ media--info__author ]">'+results.autor+'</a>, ';
							}
						}
						if ( results.titulo ){
							//console.log('titulo: '+results.titulo);
							if ( results.titulo !== 'Sin título' ){
								html_resultados = html_resultados+'<a href="#" class="[ media--info__name ]">'+results.titulo+'</a>, ';
							}
						}
						if ( results.serie ){
							//console.log('autor: '+results.autor);
							html_resultados = html_resultados+'de la serie <span class="[ media--info__series ]">'+results.serie+'</span>, ';
						}
						if ( results.coleccion ){
							//console.log('coleccion: '+results.coleccion);

							html_resultados = html_resultados+'<br /> de la colección <a href="#" class="[ media--info__colection ]">'+results.coleccion+'</a>, ';
						}
						if ( results.ano ){
							//console.log('ano: '+results.ano);
							html_resultados = html_resultados+'<span class="[ media--info__date ][ shown--large--inline ]">'+results.ano+'</span>';
						}
					html_resultados = html_resultados+'</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}// getHtmlColecciones

function getHtmlFotografos(results){
	var html_resultados = ' <a href="'+results.url+'" class="[ result ][ button button--hollow button--small button--dark ][ inline-block margin-bottom--small ]" data-id="'+results.id+'">'+results.fotografo+'</a> &nbsp;&nbsp;';
	return html_resultados;
}

function getHtmlCarteleras(results){
	var html_resultados = '<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]"> \
						<a href="'+results.permalink+'" class="[ media--info__name ]">'+results.titulo+'</a> \
					</p> \
					<p class="[ text-center ]"> \
						del '+results.fec_ini+' al '+results.fec_fin+' \
					</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}

function getHtmlProyectos(results){
	var html_resultados = '<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]"> \
						<a href="'+results.permalink+'" class="[ media--info__name ]">'+results.titulo+'</a> \
					</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}// getHtmlProyectos

function getHtmlExposiciones(results){
	var html_resultados = '<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]"> \
						<a href="'+results.permalink+'" class="[ media--info__name ]">'+results.titulo+'</a> \
					</p> \
				</div> \
			</a> \
		</div> \
	</article>';
	return html_resultados;
}

function getHtmlPublicaciones(results){
	var html_resultados = '<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="'+results.id+'"> \
		<div class="[ relative ]"> \
			<a class="[ block ]" href="'+results.permalink+'"> \
				<img src="'+results.img_url+'" class="[ image-responsive ]" /> \
				<span class="[ opacity-gradient--full ]"></span> \
				<div class="[ media-info media-info--small ] [ xmall-12 ]"> \
					<p class="[ text-center ]"> \
						<a href="'+results.permalink+'" class="[ media--info__name ]">'+results.titulo+'</a> \
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

/*------------------------------------*\
	#RESPONSIVE
\*------------------------------------*/








