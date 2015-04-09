<?php


// DEFINIR LOS PATHS A LOS DIRECTORIOS DE JAVASCRIPT Y CSS ///////////////////////////



	define( 'JSPATH', get_template_directory_uri() . '/js/' );
	define( 'CSSPATH', get_template_directory_uri() . '/css/' );
	define( 'THEMEPATH', get_template_directory_uri() . '/' );
	define( 'SITEURL', site_url('/') );



// FRONT END SCRIPTS AND STYLES //////////////////////////////////////////////////////



	add_action( 'wp_enqueue_scripts', function(){

		// scripts
		wp_enqueue_script( 'plugins', JSPATH.'plugins.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'functions', JSPATH.'functions.js', array('plugins'), '1.0', true );


		// localize scripts
		wp_localize_script( 'functions', 'ajax_url', admin_url('admin-ajax.php') );
		wp_localize_script( 'functions', 'post_type', get_post_type() );
		wp_localize_script( 'functions', 'site_url', site_url() );

		// styles
		wp_enqueue_style( 'styles', get_stylesheet_uri() );

	});

	// FRONT END SCRIPTS FOOTER //////////////////////////////////////////////////////
	function footerScripts(){
		if( wp_script_is( 'functions', 'done' ) ) {

			$postConservacionIDArray 	= get_post_ID_by_slug('conservacion', 'nuestro-trabajo');
			$postConservacionID 		= $postConservacionIDArray[0]->ID;

			$postType 					= get_post_type();
			?>

			<script type="text/javascript">
				(function( $ ) {
					"use strict";
					$(function(){

						/*------------------------------------*\
							#GLOBAL
						\*------------------------------------*/

						/**
						 * On load
						**/
						setHeightMinusElement('.overflow-scroll', '.mp-level', 'h2');


						/**
						 * Triggered events
						**/

						$('.content-wrapper').scroll(function(){
							fixedHeader();
						});

						$('.js-toggle-iframe').on('click', function(){
							toggleiFrame();
						});

						new UISearch( document.getElementById( 'sb-search' ) );




						/**
						 * Responsive
						**/
						$(window).resize(function(){
							fixedHeader();
						});


						<?php if ( is_home() ) { ?>
							/*------------------------------------*\
								#HOME
							\*------------------------------------*/
						<?php }






						if ( is_archive() ) { ?>
							/*------------------------------------*\
								#ARCHIVE
							\*------------------------------------*/
							var existing_ids = 0;


							/**
							 * Triggered events
							**/

							$('.tab-filter').on('click', function(){
								showFilters( this );
							});

							$('.filters__content').on('click', '.filter', function(){
								addFilter( this );
								//existing_ids = getExistingIds();
								clearGrid();
								showTotalResults( '<?php echo $postType ?>', getFilters(false) );
								advancedSearch('<?php echo $postType ?>', getFilters(false), 20, existing_ids);
							});

							$('.filters__results').on('click', '.filter', function(){
								removeFilter( this );
								//existing_ids = getExistingIds();
								clearGrid();
								showTotalResults( '<?php echo $postType ?>', getFilters(false) );
								advancedSearch('<?php echo $postType ?>', getFilters(false), 20, existing_ids);
							});

							$('.filter--info span').on('click', function(event) {
								var coleccion_id = $(this).data('coleccion-term-id');
								var descripcion = getDescripcionColeccion(coleccion_id, $(this) );
							});

							$('.js-cargar-mas').on('click', function(e){
								e.preventDefault();
								existing_ids = getExistingIds();
								advancedSearch('<?php echo $postType ?>', getFilters(true), 20, existing_ids);
							})

							$('.filter-buscar button').on('click', function(e){
								e.preventDefault();
								var filter_value = $('.filter-buscar input').val();
								$('.filter-buscar input').val('');
								removeSearchFilters();
								addSearchFilter( filter_value );
								clearGrid();
								advancedSearch('<?php echo $postType ?>', getFilters(false), 20, existing_ids);
							});

							/**
							 * If the postType is "publicaciones" show filters opened
							**/
							<?php if ( $postType == 'publicaciones' || $postType == 'carteleras' ){ ?>
								$('.tab-filter').click();
							<?php } ?>

							advancedSearch('<?php echo $postType ?>', getFilters(false), 20, existing_ids);
						<?php }





						if ( is_post_type_archive('fotografos') ) { ?>
							/*------------------------------------*\
								#ARCHIVE FOTOGRAFOS
							\*------------------------------------*/
							$('.close-modal').on('click', function(event) {
								closeModal( $(this) );
							});
						<?php }






						if ( get_post_type() == 'post-type') { ?>
							/*------------------------------------*\
								#POST TYPE
							\*------------------------------------*/
						<?php }





						if ( is_page('colecciones') ) { ?>
							/*------------------------------------*\
								#PAGE COLECCIONES
							\*------------------------------------*/

							/**
							 * On load
							**/
							var existing_ids = 0;
							<?php
								global $coleccion;
								global $filtro;

								if($coleccion != '' && $coleccion != 'adquisiciones-recientes') {
							?>
									var filter = $('.filter[data-value="<?php echo $coleccion; ?>"]');
									addFilter( filter );
									advancedSearch('fotografias', getFilters(false), 20, existing_ids);
							<?php
								} else if ($coleccion == 'adquisiciones-recientes'){
							?>
									var filter = $('.filter[data-value="nuevas-adquisiciones"]');
									addFilter(filter);
									advancedSearch('nuevas-adquisiciones', getFilters(false), 20, existing_ids);
									showTotalResults( 'nuevas-adquisiciones', getFilters(false) );
							<?php
								} else if ($filtro == 'favoritos'){
							?>
									var filter = $('.filter[data-value="favoritos"]');
									addFilter(filter);
									advancedSearch('favoritos', getFilters(false), 20, existing_ids);
									showTotalResults( 'favoritos', getFilters(false) );
							<?php
								}
							?>

							/**
							 * Triggered events
							**/

							/**
							 * If the postType is "proyecto" there are no filters
							**/
							<?php if ( $postType !== 'proyecto' ){ ?>

								$('.tab-filter').on('click', function(){
									showFilters( this );
								});

								$('.filters__content').on('click', '.filter', function(e){
									console.log(e.target);
									addFilter( this );
									//existing_ids = getExistingIds();
									clearGrid();
									showTotalResults( 'fotografias', getFilters(false) );
									advancedSearch('fotografias', getFilters(false), 20, existing_ids);
								});

								$('.filters__results').on('click', '.filter', function(){
									removeFilter( this );
									clearGrid();
									showTotalResults( 'fotografias', getFilters(false) );
									advancedSearch('fotografias', getFilters(false), 20, existing_ids);
								});

							<?php } ?>




							$('.js-cargar-mas').on('click', function(e){
								e.preventDefault();
								existing_ids = getExistingIds();
								advancedSearch('fotografias', getFilters(true), 20, existing_ids);
							});

							$('.filter-buscar button').on('click', function(e){
								e.preventDefault();
								var filter_value = $('.filter-buscar input').val();
								$('.filter-buscar input').val('');
								removeSearchFilters();
								addSearchFilter( filter_value );
								clearGrid();
								advancedSearch('fotografias', getFilters(false), 20, existing_ids);
							});

							<?php if ($filtro == '' && $coleccion == '') { ?>
								advancedSearch('fotografias', getFilters(false), 15, existing_ids);
								showTotalResults( 'fotografias', getFilters(false) );
							<?php } ?>

							$('.filter--info span').on('click', function(event) {
								var coleccion_id = $(this).data('coleccion-term-id');
								var descripcion = getDescripcionColeccion(coleccion_id, $(this) );
							});

							$('.close-modal').on('click', function(event) {
								closeModal( $(this) );
							});
						<?php }





						if ( is_single() ) { ?>
							/*------------------------------------*\
								#SINGLE
							\*------------------------------------*/

							/**
							 * On load
							**/
							<?php global $current_link; ?>
							<?php if ( $postType === 'fotografos'){ ?>
								runMasonry('.results', '.result' );
							<?php } ?>

							<?php if ( $postType === 'exposiciones' OR $postType === 'publicaciones' OR $postType === 'nuestro-trabajo' OR $postType === 'proyectos' ){ ?>
								runFitVids('.fit-vids-wrapper');
							<?php } ?>

							<?php
								$tweets = json_decode(file_get_contents('http://cdn.api.twitter.com/1/urls/count.json?url='.$current_link));
							?>
							$('.js-tweet-count').text('<?php echo $tweets->count ?>');

							<?php if ( $postType === 'proyectos'){ ?>

								$('.final-tiles-gallery').each(function(index) {
									$(this).finalTilesGallery({
										gridSize: 24
									});
								});

							<?php } ?>

							/**
							 * Triggered events
							**/

							$('.single-content').on('click','.tile-inner', function(e){
								e.preventDefault();
								var imagenNumber = $(this).data('number');
								var lightboxNumber = $(this).closest('.final-tiles-gallery').data('gallery-number');
								openLightbox(lightboxNumber, imagenNumber);
							});

							$('.button--heart').on('click', function(e){
								e.preventDefault();
								if( ! $(this).hasClass('active') ){
									var post_id = $(this).data('post-id');
									addLike(post_id);
								}
							});

							$('.button--facebook').on('click', function(){
								console.log('sharing is caring...');
								shareOnFacebook('<?php echo $current_link ?>');
							});

							var scrolled = false;
							$('.content-wrapper').scroll(function(){
								if( ! scrolled ){
									showNumberShares('<?php echo $current_link ?>');
									scrolled = true;
								}
							});

							$('.close-modal').on('click', function(event) {
								closeModal( $(this) );
								destroyCycle();
							});
							$('.modal--lightbox').on('click', function(event) {
								if ( ! $(event.target).closest('.image-single img').length ) {
									closeModal( $('.close-modal') );
									destroyCycle();
								}
							});
						<?php }



						if ( is_single('conservacion') ) { ?>
							/*------------------------------------*\
								#SINGLE CONSERVACION
							\*------------------------------------*/

							/**
							 * On load
							**/
							runFitVids('.fit-vids-wrapper');

						<?php } ?>






						<?php if( is_page('contactanos') ) { ?>
							/*------------------------------------*\
								#PAGE CONTACTANOS
							\*------------------------------------*/
							$('.js-contact button').on('click', function(e){
								e.preventDefault();
								var data = $('.js-contact').serialize()
								saveContact(data);
							});
						<?php } ?>

					});
				}(jQuery));
			</script>

		<?php }
		}
	add_action( 'wp_footer', 'footerScripts', 21 );



// ADMIN SCRIPTS AND STYLES //////////////////////////////////////////////////////////



	add_action( 'admin_enqueue_scripts', function(){

		// scripts
		wp_enqueue_script( 'jquery-ui-datepicker');
		wp_enqueue_script( 'admin-js', JSPATH.'admin.js', array('jquery'), '1.0', true );

		// localize scripts
		wp_localize_script( 'admin-js', 'ajax_url', admin_url('admin-ajax.php') );

		// styles
		wp_enqueue_style( 'admin-css', CSSPATH.'admin.css' );
		wp_enqueue_style('jquery-ui-datepicker-css', CSSPATH.'jquery-ui.css' );

	});



// FRONT PAGE DISPLAYS A STATIC PAGE /////////////////////////////////////////////////



	/*add_action( 'after_setup_theme', function () {

		$frontPage = get_page_by_path('home', OBJECT);
		$blogPage  = get_page_by_path('blog', OBJECT);

		if ( $frontPage AND $blogPage ){
			update_option('show_on_front', 'page');
			update_option('page_on_front', $frontPage->ID);
			update_option('page_for_posts', $blogPage->ID);
		}
	});*/



// REMOVE ADMIN BAR IN FRONT END ///////////////////////////////////////////////////


	show_admin_bar( false );



// CAMBIAR EL CONTENIDO DEL FOOTER EN EL DASHBOARD ///////////////////////////////////



	add_filter( 'admin_footer_text', function() {
		echo 'Creado por <a href="http://pcuervo.com">Pequeño Cuervo</a>. ';
		echo 'Powered by <a href="http://www.wordpress.org">WordPress</a>';
	});



// POST THUMBNAILS SUPPORT ///////////////////////////////////////////////////////////



	if ( function_exists('add_theme_support') ){
		add_theme_support('post-thumbnails');
	}

	if ( function_exists('add_image_size') ){

		// add_image_size( 'size_name', 200, 200, true );

		// cambiar el tamaño del thumbnail
		/*
		update_option( 'thumbnail_size_h', 100 );
		update_option( 'thumbnail_size_w', 200 );
		update_option( 'thumbnail_crop', false );
		*/
	}



// POST TYPES, METABOXES, TAXONOMIES AND CUSTOM PAGES ////////////////////////////////



	require_once('inc/post-types.php');
	require_once('inc/metaboxes.php');
	require_once('inc/taxonomies.php');
	require_once('inc/pages.php');
	require_once('inc/users.php');



// MODIFICAR EL MAIN QUERY ///////////////////////////////////////////////////////////



	add_action( 'pre_get_posts', function($query){
		if ( $query->is_main_query() and ! is_admin() ) {
		}
		return $query;
	});





// THE EXECRPT FORMAT AND LENGTH /////////////////////////////////////////////////////



	/*add_filter('excerpt_length', function($length){
		return 20;
	});*/


	/*add_filter('excerpt_more', function(){
		return ' &raquo;';
	});*/



// REMOVE ACCENTS AND THE LETTER Ñ FROM FILE NAMES ///////////////////////////////////



	add_filter( 'sanitize_file_name', function ($filename) {
		$filename = str_replace('ñ', 'n', $filename);
		return remove_accents($filename);
	});


// CLEAR AND CLASSIFY IMAGES UPLOAD TO THE POST CONTENT ///////////////////////////////////

	/**
	 * Add class to the images uploaded to the content
	**/
	function image_tag_class($class) {
		$class .= ' single-content-image';
		return $class;
	}
	add_filter('get_image_tag_class', 'image_tag_class' );


	/**
	 * Remove <p> tags around the image
	**/
	function filter_ptags_on_images($content){
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
	add_filter('the_content', 'filter_ptags_on_images');


	/**
	 * Remove <a> tags around the image
	**/
	function attachment_image_link_remove_filter( $content ) {
		$content =
		preg_replace(
			array('{<a(.*?)(wp-att|wp-content\/uploads)[^>]*><img}', '{ wp-image-[0-9]*" /></a>}'),
			array('<img','" />'),
			$content
		);
		return $content;
	}
	add_filter( 'the_content', 'attachment_image_link_remove_filter' );


// MANAGE DASHBOARD MENUS //////////////////////////////////////////////////////

	add_action( 'admin_menu', 'manage_dashboard_menus');
	function manage_dashboard_menus(){
		// Editar información de contacto
		add_options_page('orden-home', 'Orden en el home', 'publish_posts', 'ajustes-home-orden', 'show_home_orden_menu');

		//Quitar el menu de Herramientas
		$remove = array(__('Tools'));
		remove_dashboard_menus($remove);
	}

	/**
	 * Quita elementos del sidebar dentro del dashboard
	 *
	 * @param  remove : (Array) Arreglo con los elementos que se omitiran
	 *
	 **/
	function remove_dashboard_menus($remove){
			global $menu; end($menu);
		while(prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL ? $value[0] : '' , $remove)){
				unset( $menu[key($menu)] );
			}
		}
	}

	function show_home_orden_menu(){
		require_once 'inc/order-home.php';
	}

	function menu_contacto_save(){
		$direccion_mexico  = (isset($_POST['direccion_mexico']))  ? $_POST['direccion_mexico']  : '';
		$telefono_mexico   = (isset($_POST['telefono_mexico']))   ? $_POST['telefono_mexico']   : '';
		$fax_mexico        = (isset($_POST['fax_mexico']))        ? $_POST['fax_mexico']        : '';
		$direccion_morelia = (isset($_POST['direccion_morelia'])) ? $_POST['direccion_morelia'] : '';
		$telefono_morelia  = (isset($_POST['telefono_morelia']))  ? $_POST['telefono_morelia']  : '';
		$results[] = update_option( 'direccion_mexico', $direccion_mexico, '', 'yes' );
		$results[] = update_option( 'telefono_mexico', $telefono_mexico, '', 'yes' );
		$results[] = update_option( 'fax_mexico', $fax_mexico, '', 'yes' );
		$results[] = update_option( 'direccion_morelia', $direccion_morelia, '', 'yes' );
		$results[] = update_option( 'telefono_morelia', $telefono_morelia, '', 'yes' );

		echo json_encode( $results );
		exit;
	}
	add_action('wp_ajax_menu_contacto_save', 'menu_contacto_save');
	add_action('wp_ajax_nopriv_menu_contacto_save', 'menu_contacto_save');


// HELPER METHODS AND FUNCTIONS //////////////////////////////////////////////////////



	/**
	 * Print the <title> tag based on what is being viewed.
	 * @return string
	 */
	function print_title(){
		global $page, $paged;

		wp_title( '|', true, 'right' );
		bloginfo( 'name' );

		// Add a page number if necessary
		if ( $paged >= 2 || $page >= 2 ){
			echo ' | ' . sprintf( __( 'Página %s' ), max( $paged, $page ) );
		}
	}



	/**
	 * Imprime una lista separada por commas de todos los terms asociados al post id especificado
	 * los terms pertenecen a la taxonomia especificada. Default: Category
	 *
	 * @param  int     $post_id
	 * @param  string  $taxonomy
	 * @return string
	 */
	function print_the_terms($post_id, $taxonomy = 'category'){
		$terms = get_the_terms( $post_id, $taxonomy );

		if ( $terms and ! is_wp_error($terms) ){
			$names = wp_list_pluck($terms ,'name');
			echo implode(', ', $names);
		}
	}



	/**
	 * Regresa la url del attachment especificado
	 * @param  int     $post_id
	 * @param  string  $size
	 * @return string  url de la imagen
	 */
	function attachment_image_url($post_id, $size){
		$image_id   = get_post_thumbnail_id($post_id);
		$image_data = wp_get_attachment_image_src($image_id, $size, true);
		echo isset($image_data[0]) ? $image_data[0] : '';
	}



	/**
	 * Imprime active si el string coincide con la pagina que se esta mostrando
	 * @param  string $string
	 * @return string
	 */
	function nav_is($string = ''){
		$query = get_queried_object();

		if( isset($query->slug) AND preg_match("/$string/i", $query->slug)
			OR isset($query->name) AND preg_match("/$string/i", $query->name)
			OR isset($query->rewrite) AND preg_match("/$string/i", $query->rewrite['slug'])
			OR isset($query->post_title) AND preg_match("/$string/i", remove_accents(str_replace(' ', '-', $query->post_title) ) ) )
			echo 'active';
	}

// AJAX FUNCTIONS //////////////////////////////////////////////////////

	/**
	 * Búsqueda avanzada basada en filtros.
	 * @param  string $string
	 * @return string
	 */
	function advanced_search(){
		$post_type = $_POST['post_type'];
		$filters = $_POST['filters'];
		$limit = $_POST['limit'];
		$existing_ids = $_POST['existing_ids'];

		$advanced_search_results = array();

		switch ($post_type) {
			case 'fotografias':
				$advanced_search_results = advanced_search_colecciones($filters, $limit, $existing_ids);
				break;
			case 'fotografos':
				$advanced_search_results = advanced_search_fotografos($filters, $limit, $existing_ids);
				break;
			case 'carteleras':
				$advanced_search_results = advanced_search_carteleras($filters, $limit, $existing_ids);
				break;
			case 'proyectos':
				$advanced_search_results = advanced_search_proyectos($filters, $limit, $existing_ids);
				break;
			case 'exposiciones':
				$advanced_search_results = advanced_search_exposiciones($filters, $limit, $existing_ids);
				break;
			case 'publicaciones':
				$advanced_search_results = advanced_search_publicaciones($filters, $limit, $existing_ids);
				break;
			case 'nuevas-adquisiciones':
				$advanced_search_results = advanced_search_nuevas_adquisiciones($filters, $limit, $existing_ids);
				break;
			case 'favoritos':
				$advanced_search_results = advanced_search_favoritos($filters, $limit, $existing_ids);
				break;
		}// switch

		echo json_encode($advanced_search_results , JSON_FORCE_OBJECT);
		exit();
	}// advanced_search
	add_action("wp_ajax_advanced_search", "advanced_search");
	add_action("wp_ajax_nopriv_advanced_search", "advanced_search");

	function advanced_search_colecciones($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;
		if ($filtros == ''){
			$query = "
				SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografias'";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND P.id NOT IN ('".$existing_ids_in."')";
			}

			$query .= " AND P.post_status = 'publish' ORDER BY RAND() LIMIT ".$limit;
			$posts_info = $wpdb->get_results( $query, OBJECT );
		} else {

			$query = "
				SELECT id, COUNT(id)  FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografias'";

			$filter_type_count = -1;
			$taxonomies = array();
			$is_coleccion = false;
			$coleccion_terms = array();
			$is_ano = false;
			$ano_terms = array();
			$is_fotografo = false;
			$fotografo_terms = array();
			$is_tema = false;
			$tema_terms = array();
			$is_busqueda = false;
			$busqueda_term = '';
			foreach ($filtros as $key => $filtro) {
				array_push($taxonomies, $filtro['type']);

				if( $filtro['type'] == 'coleccion' ) {
					$is_coleccion = true;
					array_push($coleccion_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'año' ) {
					$is_ano = true;
					array_push($ano_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'fotografo' ) {
					$is_fotografo = true;
					array_push($fotografo_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'tema' ) {
					$is_tema = true;
					array_push($tema_terms, '#'.$filtro['value']);
				}
				if( $filtro['type'] == 'buscar' ) {
					$is_busqueda = true;
					$busqueda_term = $filtro['value'];
					array_pop($taxonomies);
				}
			}
			$taxonomies = array_unique($taxonomies);
			$taxonomies_in = implode("', '", $taxonomies);

			// Add taxonomies to query
			if( ! $is_busqueda || ( $is_coleccion || $is_ano || $is_fotografo || $is_tema) )
				$query = $query." AND TT.taxonomy IN ('".$taxonomies_in."')";

			// If the filters include terms, open condition
			if($is_coleccion || $is_ano || $is_fotografo || $is_tema) $query = $query." AND ( ";

			// Add filtering terms for colecciones
			if($is_coleccion){
				$filter_type_count++;
				$coleccion_terms_in = implode("', '", $coleccion_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$coleccion_terms_in."') ) ";
			}

			// Add filtering terms for años
			if($is_ano){
				$filter_type_count++;
				if($is_coleccion) $query = $query." OR";

				$query = $query."  T.slug IN ( SELECT slug FROM wp_terms WHERE";
				foreach ($ano_terms as $key => $ano) {
					$initial_year = $ano;
					$final_year = strval(intval($ano) + 10);
					if($key == 0) {
						$query .= " slug  BETWEEN '".$initial_year."' AND '".$final_year."'";
						continue;
					}
					$query .= " OR slug BETWEEN '".$initial_year."' AND '".$final_year."'";
				}
				$query .= ")";
			}

			// Add filtering terms for años
			if($is_fotografo){
				$filter_type_count++;
				if($is_coleccion || $is_ano) $query = $query." OR";

				$query .= "  T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE (";

				foreach ($fotografo_terms as $key => $letter) {
					if($key == 0) {
						$query .= " slug LIKE '".$letter."%'";
						continue;
					}
					$query .= " OR slug LIKE '".$letter."%'";
				}
				$query .= ") AND taxonomy = 'fotografo' )";
			}

			// Add filtering terms for colecciones
			if($is_tema){
				if($is_coleccion || $is_ano || $is_fotografo) $query = $query." OR";
				$filter_type_count++;
				$tema_terms_id = implode("', '", $tema_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE name IN ('".$tema_terms_id."') ) ";
			}

			// Close filtering terms if  they exist
			if($is_coleccion || $is_ano || $is_fotografo || $is_tema) $query = $query." )";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}

			// Add filtering terms for busqueda
			if($is_busqueda) $query .= " AND post_title LIKE '%".$busqueda_term."%'";

			$query = $query." AND P.post_status = 'publish' GROUP BY id HAVING COUNT(id) > ".$filter_type_count." ORDER BY RAND() LIMIT ".$limit;
			$posts_info = $wpdb->get_results( $query );
		}
		//echo $query;
		$info_colecciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->id );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'medium' );
			$url = $thumb['0'];
			// Autor
			$authorColecciones = wp_get_post_terms( $post->id, 'fotografo' );
			if ( $authorColecciones ){
				$authorColeccionesName 	= $authorColecciones[0]->name;
				$authorColeccionesSlug 	= $authorColecciones[0]->slug;
			} else {
				$authorColeccionesName 	= '';
				$authorColeccionesSlug = '-';
			}
			// Año
			$anoFotos = wp_get_post_terms( $post->id, 'año' );
			if ( $anoFotos ){
				$anoFotosName 	= $anoFotos[0]->name;
				$anoFotosSlug 	= $anoFotos[0]->slug;
			} else {
				$anoFotosName 	= 'Sin fecha';
			}
			// Lugar
			$lugar = wp_get_post_terms( $post->id, 'lugar' );
			if ( $lugar ){
				$lugarName 	= $lugar[0]->name;
				$lugarSlug 	= $lugar[0]->slug;
			} else {
				$lugarName 	= 'Sin lugar';
			}
			// Coleccion
			$coleccionName 	= 'Sin coleccion';
			$coleccionSlug = '';
			$coleccion = wp_get_post_terms( $post->id, 'coleccion' );
			if ( $coleccion ){
				$coleccionName 	= $coleccion[0]->name;
				$coleccionSlug 	= $coleccion[0]->slug;
			}
			// Series
			$coleccionSerie = '';
			$serie = wp_get_post_terms( $post->id, 'serie' );
			if ( $serie ){
				$coleccionSerie = $serie[0]->name;
			}

			// Se arma el objecto que se regresa
			$info_colecciones[$key] = array(
				'id'				=> $post->id,
				'permalink'			=> get_permalink( $post->id ),
				'titulo'			=> $titleColecciones,
				'img_url'			=> $url,
				'autor'				=> $authorColeccionesName,
				'url_autor'			=> $authorColeccionesSlug,
				'ano'				=> $anoFotosName,
				'lugar'				=> $lugarName,
				'coleccion'			=> $coleccionName,
				'coleccion_slug'	=> $coleccionSlug,
				'serie'				=> $coleccionSerie,
				);
		}

		return $info_colecciones;
	} // advanced_search_colecciones

	function advanced_search_fotografos($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		if ($filtros == ''){
			$query = "
				SELECT P.id FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografos'";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND P.id NOT IN ('".$existing_ids_in."')";
			}

			$query .= " AND P.post_status = 'publish' AND P.post_content <> '' GROUP BY P.id ORDER BY RAND() LIMIT ".$limit;

			$posts_info = $wpdb->get_results( $query, OBJECT );
		} else {

			// SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
			$query = "
				SELECT id, COUNT(id)  FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografos'";

			$filter_type_count = -1;
			$taxonomies = array();
			$is_coleccion = false;
			$coleccion_terms = array();
			$is_decada = false;
			$decada_terms = array();
			$is_pais = false;
			$pais_terms = array();
			$is_tema = false;
			$tema_terms = array();
			$is_apellido = false;
			$apellido_terms = array();
			$is_busqueda = false;
			$busqueda_term = '';
			foreach ($filtros as $key => $filtro) {
				array_push($taxonomies, $filtro['type']);

				if( $filtro['type'] == 'coleccion' ) {
					$is_coleccion = true;
					array_push($coleccion_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'pais' ) {
					$is_pais = true;
					array_push($pais_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'decada-de-nacimiento' ) {
					$is_decada = true;
					array_push($decada_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'apellido' ) {
					$is_apellido = true;
					array_push($apellido_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'tema' ) {
					$is_tema = true;
					array_push($tema_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'buscar' ) {
					$is_busqueda = true;
					$busqueda_term = $filtro['value'];
					array_pop($taxonomies);
				}

			}
			$taxonomies = array_unique($taxonomies);
			$taxonomies_in = implode("', '", $taxonomies);

			// Add taxonomies to query
			if( ! $is_busqueda || ( $is_coleccion || $is_decada || $is_pais || $is_tema || $is_apellido ) )
				$query = $query." AND TT.taxonomy IN ('".$taxonomies_in."')";

			// If the filters include terms, open condition
			if($is_coleccion || $is_decada || $is_pais || $is_tema || $is_apellido ) $query = $query." AND ( ";

			// Add filtering terms for colecciones
			if($is_coleccion){
				$filter_type_count++;
				$coleccion_terms_in = implode("', '", $coleccion_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$coleccion_terms_in."') ) ";
			}

			// Add filtering terms for años
			if($is_decada){
				$filter_type_count++;
				if($is_coleccion) $query = $query." OR";

				$query = $query."  T.slug IN ( SELECT slug FROM wp_terms WHERE";
				foreach ($decada_terms as $key => $decada) {
					$initial_year = $decada;
					$final_year = strval(intval($decada) + 9);
					if($key == 0) {
						$query .= " slug  BETWEEN '".$initial_year."' AND '".$final_year."'";
						continue;
					}
					$query .= " OR slug BETWEEN '".$initial_year."' AND '".$final_year."'";
				}
				$query .= ")";
			}

			// Add filtering terms for años
			if($is_pais){
				$filter_type_count++;
				$pais_terms_in = implode("', '", $pais_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$pais_terms_in."') ) ";
			}
			// Add filtering terms for temas
			if($is_tema){
				if($is_coleccion || $is_decada || $is_pais) $query = $query." OR";
				$filter_type_count++;
				$tema_terms_id = implode("', '", $tema_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE name IN ('".$tema_terms_id."') ) ";
			}

			// Add filtering terms for apellidos
			if($is_apellido){
				$filter_type_count++;
				if($is_coleccion || $is_decada || $is_pais || $is_tema) $query = $query." OR";

				$query .= "  T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE (";

				foreach ($apellido_terms as $key => $letter) {
					if($key == 0) {
						$query .= " slug LIKE '".$letter."%'";
						continue;
					}
					$query .= " OR slug LIKE '".$letter."%'";
				}
				$query .= ") AND taxonomy = 'apellido' )";
			}

			// Close filtering terms if  they exist
			if($is_coleccion || $is_decada || $is_pais || $is_tema || $is_apellido) $query = $query." )";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}

			// Add filtering terms for busqueda
			if($is_busqueda) $query .= " AND post_title LIKE '%".$busqueda_term."%'";

			$query = $query." AND post_status = 'publish' AND post_content <> '' GROUP BY id HAVING COUNT(id) > ".$filter_type_count." ORDER BY RAND() LIMIT ".$limit;
			$posts_info = $wpdb->get_results( $query );
		}

		$info_colecciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$fotografo = get_the_title( $post->id );
			// URL fotografo
			$url = get_permalink( $post->id );
			// Se arma el objecto que se regresa
			$info_colecciones[$key] = array(
				'id'		=> $post->id,
				'fotografo'	=> $fotografo,
				'url'		=> $url,
				);
		}

		//echo $query;

		return $info_colecciones;
	} // advanced_search_fotografos

	function advanced_search_carteleras($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		$hoy = date('Y-m-d');
		if ($filtros == ''){
			$query = "
				SELECT id FROM wp_posts P INNER JOIN wp_postmeta PM ON PM.post_id = P.id
				WHERE post_type = 'carteleras'";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}
			//$query .= " AND post_status = 'publish' AND meta_value = '".$hoy."' GROUP BY id ORDER BY RAND() LIMIT ".$limit;
			$query .= " AND post_status = 'publish' GROUP BY id ORDER BY RAND() LIMIT ".$limit;

			$posts_info = $wpdb->get_results( $query, OBJECT );
		} else {

			// SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
			$query = "
				SELECT id FROM wp_posts P
				INNER JOIN wp_postmeta PM ON PM.post_id = P.id
				WHERE post_type = 'carteleras'
				AND meta_key IN ('_evento_fecha_final_meta', '_evento_fecha_inicial_meta') AND (";

			//$inicioHoy = strtotime("midnight", $hoy);
			//$finHoy = strtotime("tomorrow", $inicioHoy) - 1;
			foreach ($filtros as $key => $filtro) {
				if($key != 0) $query .= ' OR';

				if($filtro['value'] == 'anteriores') {
					$query .= " meta_value < '".$hoy."'";
				}
				if($filtro['value'] == 'proximos') {
					$query .= " meta_value > '".$hoy."'";
				}
				if($filtro['value'] == 'hoy') {
					$query .= " meta_value = '".$hoy."'";
				}
			}
			$query .= ')';

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}
			$query .= " AND post_status = 'publish' GROUP BY id ORDER BY RAND() LIMIT ".$limit;

			$posts_info = $wpdb->get_results( $query );
		}

		$info_colecciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->id );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'medium' );
			$url = $thumb['0'];

			$fec_ini = get_post_meta( $post->id, '_evento_fecha_inicial_meta', true );
			$fec_fin = get_post_meta( $post->id, '_evento_fecha_final_meta', true );

			//if($fec_ini !== '') $fec_ini = date('d/m/Y', $fec_ini);
			//if($fec_fin !== '') $fec_fin = date('d/m/Y', $fec_fin);

			// Se arma el objecto que se regresa
			$info_colecciones[$key] = array(
				'id'		=> $post->id,
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'fec_ini'	=> $fec_ini,
				'fec_fin'	=> $fec_fin,
				'permalink'	=> get_permalink( $post->id ),
				);
		}

		return $info_colecciones;
	} // advanced_search_carteleras

	function advanced_search_proyectos($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		$query = "
			SELECT DISTINCT id FROM wp_posts P
			INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
			INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
			WHERE post_type = 'proyectos'";

		if($existing_ids != '0'){
			$existing_ids_in = implode("', '", $existing_ids);
			$query .= " AND id NOT IN ('".$existing_ids_in."')";
		}
		$query .= "
			AND id NOT IN
				(SELECT id FROM wp_posts P INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				WHERE taxonomy = 'archivo-proyecto')
			AND post_status = 'publish'
			ORDER BY RAND()
			LIMIT ".$limit;
		$posts_info = $wpdb->get_results( $query, OBJECT );


		$info_colecciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->id );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'large' );
			$url = $thumb['0'];


			// Se arma el objecto que se regresa
			$info_colecciones[$key] = array(
				'id'		=> $post->id,
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'permalink'	=> get_permalink( $post->id )
				);
		}

		return $info_colecciones;
	} // advanced_search_proyectos

	function advanced_search_exposiciones($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		$query = "
			SELECT id FROM wp_posts
			WHERE post_type = 'exposiciones'";

		if($existing_ids != '0'){
			$existing_ids_in = implode("', '", $existing_ids);
			$query .= " AND id NOT IN ('".$existing_ids_in."')";
		}
		$query .= " AND post_status = 'publish' ORDER BY post_date DESC LIMIT ".$limit;
		$posts_info = $wpdb->get_results( $query, OBJECT );


		$info_exposiciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->id );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'medium' );
			$url = $thumb['0'];


			// Se arma el objecto que se regresa
			$info_exposiciones[$key] = array(
				'id'		=> $post->id,
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'permalink'	=> get_permalink( $post->id )
				);
		}

		return $info_exposiciones;
	} // advanced_search_exposiciones

	function advanced_search_publicaciones($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		$query = "
			SELECT id FROM wp_posts
			WHERE post_type = 'publicaciones'";

		if($existing_ids != '0'){
			$existing_ids_in = implode("', '", $existing_ids);
			$query .= " AND id NOT IN ('".$existing_ids_in."')";
		}
		$query .= " AND post_status = 'publish' ORDER BY post_date DESC LIMIT ".$limit;
		$posts_info = $wpdb->get_results( $query, OBJECT );

		$info_publicaciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->id );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'medium' );
			$url = $thumb['0'];


			// Se arma el objecto que se regresa
			$info_publicaciones[$key] = array(
				'id'		=> $post->id,
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'permalink'	=> get_permalink( $post->id )
				);
		}

		return $info_publicaciones;
	} // advanced_search_publicaciones

	function advanced_search_nuevas_adquisiciones($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		$query = "
			SELECT id FROM wp_posts
			WHERE post_type = 'fotografias'";

		if($existing_ids != '0'){
			$existing_ids_in = implode("', '", $existing_ids);
			$query .= " AND id NOT IN ('".$existing_ids_in."')";
		}
		$query .= " AND post_status = 'publish' ORDER BY post_date LIMIT ".$limit;
		$posts_info = $wpdb->get_results( $query, OBJECT );

		$info_nuevas_adquisiciones = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->id );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->id ), 'medium' );
			$url = $thumb['0'];
			// Autor
			$authorColecciones = wp_get_post_terms( $post->id, 'fotografo' );
			if ( $authorColecciones ){
				$authorColeccionesName 	= $authorColecciones[0]->name;
				$authorColeccionesSlug 	= $authorColecciones[0]->slug;
			} else {
				$authorColeccionesName 	= 'Sin autor';
				$authorColeccionesSlug = '-';
			}
			// Año
			$anoFotos = wp_get_post_terms( $post->id, 'año' );
			if ( $anoFotos ){
				$anoFotosName 	= $anoFotos[0]->name;
				$anoFotosSlug 	= $anoFotos[0]->slug;
			} else {
				$anoFotosName 	= 'Sin fecha';
			}
			// Lugar
			$lugar = wp_get_post_terms( $post->id, 'lugar' );
			if ( $lugar ){
				$lugarName 	= $lugar[0]->name;
				$lugarSlug 	= $lugar[0]->slug;
			} else {
				$lugarName 	= 'Sin lugar';
			}
			// Coleccion
			$coleccionName 	= 'Sin coleccion';
			$coleccion = wp_get_post_terms( $post->id, 'coleccion' );
			if ( $coleccion ){
				$coleccionName 	= $coleccion[0]->name;
				$coleccionSlug 	= $coleccion[0]->slug;
			}

			// Se arma el objecto que se regresa
			$info_nuevas_adquisiciones[$key] = array(
				'id'		=> $post->id,
				'permalink'	=> get_permalink( $post->id ),
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'autor'		=> $authorColeccionesName,
				'url_autor'	=> $authorColeccionesSlug,
				'ano'		=> $anoFotosName,
				'lugar'		=> $lugarName,
				'coleccion'	=> $coleccionName,
				);
		}

		return $info_nuevas_adquisiciones;
	} // advanced_search_nuevas_adquisiciones

	function advanced_search_favoritos($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		$query = "
			SELECT P.ID FROM wp_posts P
			INNER JOIN wp_postmeta PM ON PM.post_id = P.ID
			WHERE meta_key = 'num_likes'";

		if($existing_ids != '0'){
			$existing_ids_in = implode("', '", $existing_ids);
			$query .= " AND id NOT IN ('".$existing_ids_in."')";
		}
		$query .= " AND post_status = 'publish' ORDER BY meta_value DESC LIMIT ".$limit;
		$posts_info = $wpdb->get_results( $query, OBJECT );

		$info_favoritos = array();
		foreach ($posts_info as $key => $post) {
			// Título
			$titleColecciones = get_the_title( $post->ID );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = 'Sin título';
			}
			// URL imagen
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			$url = $thumb['0'];
			// Autor
			$authorColecciones = wp_get_post_terms( $post->ID, 'fotografo' );
			if ( $authorColecciones ){
				$authorColeccionesName 	= $authorColecciones[0]->name;
				$authorColeccionesSlug 	= $authorColecciones[0]->slug;
			} else {
				$authorColeccionesName 	= 'Sin autor';
				$authorColeccionesSlug = '-';
			}
			// Año
			$anoFotos = wp_get_post_terms( $post->ID, 'año' );
			if ( $anoFotos ){
				$anoFotosName 	= $anoFotos[0]->name;
				$anoFotosSlug 	= $anoFotos[0]->slug;
			} else {
				$anoFotosName 	= 'Sin fecha';
			}
			// Lugar
			$lugar = wp_get_post_terms( $post->ID, 'lugar' );
			if ( $lugar ){
				$lugarName 	= $lugar[0]->name;
				$lugarSlug 	= $lugar[0]->slug;
			} else {
				$lugarName 	= 'Sin lugar';
			}
			// Coleccion
			$coleccionName 	= 'Sin coleccion';
			$coleccion = wp_get_post_terms( $post->ID, 'coleccion' );
			if ( $coleccion ){
				$coleccionName 	= $coleccion[0]->name;
				$coleccionSlug 	= $coleccion[0]->slug;
			}

			// Se arma el objecto que se regresa
			$info_favoritos[$key] = array(
				'id'		=> $post->ID,
				'permalink'	=> get_permalink( $post->ID ),
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'autor'		=> $authorColeccionesName,
				'url_autor'	=> $authorColeccionesSlug,
				'ano'		=> $anoFotosName,
				'lugar'		=> $lugarName,
				'coleccion'	=> $coleccionName,
				);
		}

		return $info_favoritos;
	} // advanced_search_favoritos

	function get_descripcion_coleccion(){
		$term_id_coleccion = $_POST['id_coleccion'];
		$descripcion = term_description( $term_id_coleccion, 'coleccion' );
		$term = get_term( $term_id_coleccion, 'coleccion' );

		$info_coleccion = array(
			'title'			=> $term->name,
			'description'	=> $descripcion
			);

		echo json_encode($info_coleccion , JSON_FORCE_OBJECT);
		exit();
	} // get_descripcion_coleccion
	add_action("wp_ajax_get_descripcion_coleccion", "get_descripcion_coleccion");
	add_action("wp_ajax_nopriv_get_descripcion_coleccion", "get_descripcion_coleccion");

	function add_like(){
		$post_id = $_POST['post_id'];
		$key = 'num_likes';

		$num_likes_meta = get_post_meta( $post_id, $key, TRUE );

		if($num_likes_meta == '0') {
			add_post_meta($post_id, $key, 0, TRUE);
			$num_likes = 0;
		} else {
			$num_likes = intval($num_likes_meta) + 1;
			update_post_meta($post_id, $key, $num_likes);
		}

		echo json_encode($num_likes, JSON_FORCE_OBJECT);
		exit();
	}
	add_action("wp_ajax_add_like", "add_like");
	add_action("wp_ajax_nopriv_add_like", "add_like");

	function update_featured_post( $post_id ){

		$terms = wp_get_post_terms( $post_id, 'category' );
		$is_destacado = false;
		foreach ($terms as $key => $term) {
			if ( $term->slug == 'destacado' ) {
				$is_destacado = true;
				break;
			}
		}

		if( $is_destacado ){
			removeFeatured( $post_id );
		}

	}// update_featured_post
	add_action('save_post', 'update_featured_post');

	function removeFeatured( $excluded_post_id ){

		$post_types = get_post_types( '', 'names' );
		$featured_posts_args = array(
			'post_type' 	=> $post_types,
			'tax_query' 	=> array(
							array(
								'taxonomy'	=> 'category',
								'field'		=> 'slug',
								'terms'		=> array('destacado')
							)
						),
			'post__not_in'	=> array( $excluded_post_id )
		);
		$featured_posts = get_posts( $featured_posts_args );

		foreach ($featured_posts as $key => $post) wp_remove_object_terms( $post->ID, 'destacado', 'category');

	}// removeFeatured

	function get_post_id_by_attachment_id( $attachment_id ){
		global $wpdb;

		$query = "
			SELECT post_parent AS post_id
			FROM wp_postmeta AS pm
			INNER JOIN wp_posts AS p ON pm.meta_value=p.ID
			WHERE ID = ".$attachment_id."
			AND pm.meta_key = '_thumbnail_id' LIMIT 1";
		$post_id_results = $wpdb->get_results( $query, OBJECT );

		if ( empty($post_id_results) ){
			return 0;
		}

		return $post_id_results[0];
	}// get_post_id_by_attachment_id


	function get_total_results(){
		$filters = $_POST['filters'];
		$post_type = $_POST['post_type'];

		switch ($post_type) {
			case 'fotografias':
				$num_results = get_num_results_colecciones($filters);
				break;
			case 'fotografos':
				$num_results = get_num_results_fotografos($filters);
				break;
			case 'carteleras':
				$num_results = get_num_results_carteleras($filters);
				break;
			case 'nuevas-adquisiciones':
				$num_results = get_num_results_nuevas_adquisiciones($filters);
				break;
			case 'favoritos':
				$num_results = get_num_results_favoritos($filters);
				break;
			default:
				$num_results = 0;
		}// switch

		echo json_encode($num_results , JSON_FORCE_OBJECT);
		exit();
	}// get_total_results
	add_action("wp_ajax_get_total_results", "get_total_results");
	add_action("wp_ajax_nopriv_get_total_results", "get_total_results");

	function save_contact(){
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$mensaje = $_POST['mensaje'];

		$contact_post = array(
		  'post_title' 		=> $nombre,
		  'post_content' 	=> 'Nombre: '.$nombre."\r\n".'Email: '.$correo."\r\n".'Mensaje: '.$mensaje,
		  'post_status'   	=> 'draft',
		  'post_type'   	=> 'contacto',
		);

		// Insert the post into the database
		wp_insert_post( $contact_post );

		echo json_encode($nombre , JSON_FORCE_OBJECT);
		exit();
	}// save_contact
	add_action("wp_ajax_save_contact", "save_contact");
	add_action("wp_ajax_nopriv_save_contact", "save_contact");

	function get_num_results_colecciones($filtros){
		global $wpdb;

		if ($filtros == ''){
			$query = "
				SELECT P.id AS total FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografias' AND P.post_status = 'publish'";

		} else {
			$query = "
				SELECT id, COUNT(id) AS total  FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografias'";

			$filter_type_count = -1;
			$taxonomies = array();
			$is_coleccion = false;
			$coleccion_terms = array();
			$is_ano = false;
			$ano_terms = array();
			$is_fotografo = false;
			$fotografo_terms = array();
			$is_tema = false;
			$tema_terms = array();
			$is_busqueda = false;
			$busqueda_term = '';
			foreach ($filtros as $key => $filtro) {
				array_push($taxonomies, $filtro['type']);

				if( $filtro['type'] == 'coleccion' ) {
					$is_coleccion = true;
					array_push($coleccion_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'año' ) {
					$is_ano = true;
					array_push($ano_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'fotografo' ) {
					$is_fotografo = true;
					array_push($fotografo_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'tema' ) {
					$is_tema = true;
					array_push($tema_terms, '#'.$filtro['value']);
				}
				if( $filtro['type'] == 'buscar' ) {
					$is_busqueda = true;
					$busqueda_term = $filtro['value'];
					array_pop($taxonomies);
				}
			}
			$taxonomies = array_unique($taxonomies);
			$taxonomies_in = implode("', '", $taxonomies);


			// Add taxonomies to query
			if( ! $is_busqueda || ( $is_coleccion || $is_ano || $is_fotografo || $is_tema) )
				$query = $query." AND TT.taxonomy IN ('".$taxonomies_in."')";

			// If the filters include terms, open condition
			if($is_coleccion || $is_ano || $is_fotografo || $is_tema) $query = $query." AND ( ";

			// Add filtering terms for colecciones
			if($is_coleccion){
				$filter_type_count++;
				$coleccion_terms_in = implode("', '", $coleccion_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$coleccion_terms_in."') ) ";
			}

			// Add filtering terms for años
			if($is_ano){
				$filter_type_count++;
				if($is_coleccion) $query = $query." OR";

				$query = $query."  T.slug IN ( SELECT slug FROM wp_terms WHERE";
				foreach ($ano_terms as $key => $ano) {
					$initial_year = $ano;
					$final_year = strval(intval($ano) + 10);
					if($key == 0) {
						$query .= " slug  BETWEEN '".$initial_year."' AND '".$final_year."'";
						continue;
					}
					$query .= " OR slug BETWEEN '".$initial_year."' AND '".$final_year."'";
				}
				$query .= ")";
			}

			// Add filtering terms for años
			if($is_fotografo){
				$filter_type_count++;
				if($is_coleccion || $is_ano) $query = $query." OR";

				$query .= "  T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE (";

				foreach ($fotografo_terms as $key => $letter) {
					if($key == 0) {
						$query .= " slug LIKE '".$letter."%'";
						continue;
					}
					$query .= " OR slug LIKE '".$letter."%'";
				}
				$query .= ") AND taxonomy = 'fotografo' )";
			}

			// Add filtering terms for colecciones
			if($is_tema){
				if($is_coleccion || $is_ano || $is_fotografo) $query = $query." OR";
				$filter_type_count++;
				$tema_terms_id = implode("', '", $tema_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE name IN ('".$tema_terms_id."') ) ";
			}

			// Close filtering terms if  they exist
			if($is_coleccion || $is_ano || $is_fotografo || $is_tema) $query = $query." )";

			// Add filtering terms for busqueda
			if($is_busqueda) $query .= " AND post_title LIKE '%".$busqueda_term."%'";

			$query = $query." AND P.post_status = 'publish' GROUP BY id HAVING COUNT(id) > ".$filter_type_count;
		}
		$results = $wpdb->get_results( $query );
		$total_results = $wpdb->num_rows;

		return $total_results;
	}// get_num_results_colecciones

	function get_num_results_fotografos($filtros){
		global $post;
		global $wpdb;

		if ($filtros == ''){
			$query = "
				SELECT P.id FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografos' AND P.post_status = 'publish' AND P.post_content <> '' GROUP BY P.id";
		} else {

			// SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
			$query = "
				SELECT id, COUNT(id)  FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografos'";

			$filter_type_count = -1;
			$taxonomies = array();
			$is_coleccion = false;
			$coleccion_terms = array();
			$is_ano = false;
			$ano_terms = array();
			$is_pais = false;
			$pais_terms = array();
			$is_tema = false;
			$tema_terms = array();
			$is_apellido = false;
			$apellido_terms = array();
			foreach ($filtros as $key => $filtro) {
				array_push($taxonomies, $filtro['type']);

				if( $filtro['type'] == 'coleccion' ) {
					$is_coleccion = true;
					array_push($coleccion_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'pais' ) {
					$is_pais = true;
					array_push($pais_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'apellido' ) {
					$is_apellido = true;
					array_push($apellido_terms, $filtro['value']);
				}
				if( $filtro['type'] == 'tema' ) {
					$is_tema = true;
					array_push($tema_terms, $filtro['value']);
				}
			}
			$taxonomies = array_unique($taxonomies);
			$taxonomies_in = implode("', '", $taxonomies);

			// Add taxonomies to query
			$query = $query." AND TT.taxonomy IN ('".$taxonomies_in."')";

			// If the filters include terms, open condition
			if($is_coleccion || $is_ano || $is_pais || $is_tema || $is_apellido) $query = $query." AND ( ";

			// Add filtering terms for colecciones
			if($is_coleccion){
				$filter_type_count++;
				$coleccion_terms_in = implode("', '", $coleccion_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$coleccion_terms_in."') ) ";
			}

			// Add filtering terms for años
			if($is_ano){
				$filter_type_count++;
				if($is_coleccion) $query = $query." OR";

				$query = $query."  T.slug IN ( SELECT slug FROM wp_terms WHERE";
				foreach ($ano_terms as $key => $ano) {
					$initial_year = $ano;
					$final_year = strval(intval($ano) + 9);
					if($key == 0) {
						$query .= " slug  BETWEEN '".$initial_year."' AND '".$final_year."'";
						continue;
					}
					$query .= " OR slug BETWEEN '".$initial_year."' AND '".$final_year."'";
				}
				$query .= ")";
			}

			// Add filtering terms for años
			if($is_pais){
				$filter_type_count++;
				$pais_terms_in = implode("', '", $pais_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$pais_terms_in."') ) ";
			}
			// Add filtering terms for temas
			if($is_tema){
				if($is_coleccion || $is_ano || $is_pais) $query = $query." OR";
				$filter_type_count++;
				$tema_terms_id = implode("', '", $tema_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE name IN ('".$tema_terms_id."') ) ";
			}
			// Add filtering terms for apellidos
			if($is_apellido){
				$filter_type_count++;
				if($is_coleccion || $is_ano || $is_pais || $is_tema) $query = $query." OR";

				$query .= "  T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE (";

				foreach ($apellido_terms as $key => $letter) {
					if($key == 0) {
						$query .= " slug LIKE '".$letter."%'";
						continue;
					}
					$query .= " OR slug LIKE '".$letter."%'";
				}
				$query .= ") AND taxonomy = 'apellido' )";
			}

			// Close filtering terms if  they exist
			if($is_coleccion || $is_ano || $is_pais || $is_tema || $is_apellido) $query = $query." )";

			$query = $query." AND post_status = 'publish' AND post_content <> '' GROUP BY id HAVING COUNT(id) > ".$filter_type_count;
		}

		$results = $wpdb->get_results( $query );
		$total_results = $wpdb->num_rows;

		return $total_results;
	}// get_num_results_fotografos

	function get_num_results_carteleras($filtros){
		global $post;
		global $wpdb;

		$hoy = date('Y-m-d');
		if ($filtros == ''){
			$query = "
				SELECT id FROM wp_posts P INNER JOIN wp_postmeta PM ON PM.post_id = P.id
				WHERE post_type = 'carteleras'";
			$query .= " AND post_status = 'publish' GROUP BY id";

		} else {
			$query = "
				SELECT id FROM wp_posts P
				INNER JOIN wp_postmeta PM ON PM.post_id = P.id
				WHERE post_type = 'carteleras'
				AND meta_key IN ('_evento_fecha_final_meta', '_evento_fecha_inicial_meta') AND (";

			foreach ($filtros as $key => $filtro) {
				if($key != 0) $query .= ' OR';

				if($filtro['value'] == 'anteriores') {
					$query .= " meta_value < '".$hoy."'";
				}
				if($filtro['value'] == 'proximos') {
					$query .= " meta_value > '".$hoy."'";
				}
				if($filtro['value'] == 'hoy') {
					$query .= " meta_value = '".$hoy."'";
				}
			}
			$query .= ')';
			$query .= " AND post_status = 'publish' GROUP BY id";

		}

		$results = $wpdb->get_results( $query );
		$total_results = $wpdb->num_rows;

		return $total_results;
	} // get_num_results_carteleras

	function get_num_results_nuevas_adquisiciones($filtros = ''){
		global $post;
		global $wpdb;

		$query = "
			SELECT id FROM wp_posts
			WHERE post_type = 'fotografias'
			AND post_status = 'publish' ORDER BY post_date LIMIT 20";
		$posts_info = $wpdb->get_results( $query, OBJECT );
		$results = $wpdb->get_results( $query );
		$total_results = $wpdb->num_rows;

		return $total_results;
	} // get_num_results_nuevas_adquisiciones

	function get_num_results_favoritos($filtros = ''){
		global $post;
		global $wpdb;

		$query = "
			SELECT P.ID FROM wp_posts P
			INNER JOIN wp_postmeta PM ON PM.post_id = P.ID
			WHERE meta_key = 'num_likes'
			AND post_status = 'publish'
			ORDER BY meta_value DESC";

		$results = $wpdb->get_results( $query );
		$total_results = $wpdb->num_rows;

		return $total_results;
	} // get_num_results_favoritos

	function get_decadas_nacimiento(){
		global $wpdb;
		$decadas = array();

		$query = "
				SELECT meta_value
				FROM wp_postmeta
				WHERE meta_key = '_fecha_nacimiento_meta' ";
		$results = $wpdb->get_results( $query );
		foreach ($results as $fecha) {
			$decada = get_decada_por_fecha( $fecha->meta_value );
			array_push($decadas, $decada);
		}
		return array_unique($decadas);
	}// get_decadas_nacimiento

	function get_decada_por_fecha( $fecha ){
		$rango_fechas = explode('-', $fecha);
		$ano_inicial = substr(trim($rango_fechas[0]), 0, -1);
		$decada = $ano_inicial.'0';

		return $decada;
	}// get_decada_por_fecha

	function add_decade_to_photographer( $post_id ){
		$fecha = get_post_meta( $post_id, '_fecha_nacimiento_meta', TRUE );
		$decada = get_decada_por_fecha( $fecha );

		add_decade_term( $decada );
		wp_set_object_terms( $post_id, $decada, 'decada-de-nacimiento', FALSE );
	}
	add_action('save_post', 'add_decade_to_photographer');

	function add_decade_term( $decada ){
		$term = term_exists($decada, 'decada-de-nacimiento');
		if ($term !== 0 && $term !== null) return;
		wp_insert_term($decada, 'decada-de-nacimiento');
	}// add_decade_term

	/* Devuelve la url del video de acuerdo al host.
	 * @param string $advisor_data
	 * @return int $advisor_id or FALSE
	 */
	function get_video_src($url, $host){
		if($url == '-')
			return 0;
		if($host == 'vimeo'){
			$id = (int) substr(parse_url($url, PHP_URL_PATH), 1);
			return '//player.vimeo.com/video/'.$id;
		}

		$id = explode('v=', $url)[1];
		$ampersand_position = strpos($id, '&');
		if( $ampersand_position > 0 )
			$id = substr($id, $ampersand_position);

		parse_str( parse_url( $url, PHP_URL_QUERY ), $url_array );
		$id = $url_array['v'];
		return '//www.youtube.com/embed/'.$id;
	}// get_video_src


	function get_post_ID_by_slug($page_slug, $post_type) {
		global $wpdb;

		$postQuery = "
			SELECT ID FROM wp_posts
			WHERE post_name ='".$page_slug."'
			AND post_type ='".$post_type."'
			AND post_status = 'publish'";

		$postID = $wpdb->get_results($postQuery);

		if ($postID) {
			return $postID;
		} else {
			return null;
		}
	}

	function set_detalle_meta(){
		global $wpdb;

		$postQuery = "
			SELECT ID FROM wp_posts
			WHERE post_type = 'fotografias'";

		$results = $wpdb->get_results($postQuery);

		foreach ($results as $result) {
			update_post_meta($result->ID, '_detalles_fotografia_meta', '');
		}
	}
	//add_action('init', 'set_detalle_meta');

	function create_table_orden_home(){
		global $wpdb;
		$table_name = "wp_orden_home";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		    // Crear tabla
			$sql_create_table = "CREATE TABLE wp_orden_home (
					orden_home_id bigint(20) UNSIGNED NOT NULL auto_increment,
					seccion varchar(30) NOT NULL,
					posicion integer NOT NULL,
					PRIMARY KEY  (orden_home_id)
		     	)";
			$wpdb->query( $sql_create_table );

			// Rellenar tabla
			$sql_insert = "
				INSERT INTO wp_orden_home
					(seccion, posicion)
				VALUES
					('colecciones', 1),
					('destacado', 2),
					('proyectos', 3),
					('publicaciones', 4),
					('exposiciones', 5),
					('nuevas adquisiciones', 6)";
			$wpdb->query( $sql_insert );
		}
	}// create_table_orden_home
	add_action('init', 'create_table_orden_home');

	function create_table_secciones_home(){
		global $wpdb;
		$table_name = "wp_secciones_home";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		    // Crear tabla
			$sql_create_table = "CREATE TABLE wp_secciones_home (
					seccion_id bigint(20) UNSIGNED NOT NULL auto_increment,
					seccion varchar(30) NOT NULL,
					PRIMARY KEY  (seccion_id)
		     	)";
			$wpdb->query( $sql_create_table );

			// Rellenar tabla
			$sql_insert = "
				INSERT INTO wp_secciones_home
					(seccion)
				VALUES
					('colecciones'),
					('destacado'),
					('proyectos'),
					('publicaciones'),
					('exposiciones'),
					('nuevas adquisiciones')";
			$wpdb->query( $sql_insert );
		}
	}// create_table_secciones_home
	add_action('init', 'create_table_secciones_home');

	function get_secciones_orden_home(){
		global $wpdb;
		$query = "
				SELECT * FROM wp_orden_home
				ORDER BY posicion";
		$orden_secciones_home = $wpdb->get_results( $query, OBJECT );

		return $orden_secciones_home;
	}// get_secciones_orden_home

	function get_seccion_orden_home( $posicion ){
		global $wpdb;
		$query = "
				SELECT * FROM wp_orden_home
				WHERE posicion = $posicion";
		$orden_secciones_home = $wpdb->get_results( $query, OBJECT );

		return $orden_secciones_home[0];
	}// get_seccion_orden_home

	function get_secciones_home(){
		global $wpdb;
		$query = "SELECT * FROM wp_secciones_home";
		$secciones_home = $wpdb->get_results( $query, OBJECT );

		return $secciones_home;
	}// get_secciones_home

	function save_secciones_orden_home() {
		global $wpdb;
		if ( isset( $_POST['posicion_1'] )  ) {
			// Rellenar tabla
			$sql_insert = "TRUNCATE TABLE wp_orden_home";
			$wpdb->query( $sql_insert );

			$posicion_1 =  $_POST['posicion_1'];
			$posicion_2 =  $_POST['posicion_2'];
			$posicion_3 =  $_POST['posicion_3'];
			$posicion_4 =  $_POST['posicion_4'];
			$posicion_5 =  $_POST['posicion_5'];
			$posicion_6 =  $_POST['posicion_6'];

			// Rellenar tabla
			$sql_insert = "
				INSERT INTO wp_orden_home
					(seccion, posicion)
				VALUES
					('$posicion_1', 1),
					('$posicion_2', 2),
					('$posicion_3', 3),
					('$posicion_4', 4),
					('$posicion_5', 5),
					('$posicion_6', 6)";
			$wpdb->query( $sql_insert );
		} // end if

	} // end my_theme_send_email
	add_action( 'init', 'save_secciones_orden_home' );

	function update_orden_home($posicion, $seccion){
		global $wpdb;
		$wpdb->update(
			'wp_orden_home',
			array( 'posicion' => $posicion ),
			array( 'seccion' => $seccion ),
			array( '%d' ),
			array( '%s' )
		);
	}// update_orden_home

	function get_html_seccion( $seccion ){

		switch( $seccion ){
			case 'colecciones':
				return get_html_home_colecciones();
				break;
			case 'proyectos':
				return get_html_home_proyectos();
				break;
			case 'publicaciones':
				return get_html_home_publicaciones();
				break;
			case 'exposiciones':
				return get_html_home_exposiciones();
				break;
			case 'nuevas adquisiciones':
				return get_html_home_adquisiciones_recientes();
				break;
			case 'destacado':
				return get_html_home_destacado();
				break;
			return 1;
		}// switch
	}// get_html_seccion

	function get_html_home_colecciones(){
		global $post;

		$bgColecciones = '';
		$coleccionColecciones = '';
		$authorColecciones = '';
		$titleColecciones = '';
		$seriesColecciones = '';
		$placeColecciones = '';
		$circaColecciones = 0;
		$dateColecciones = '';
		$args = array(
			'post_type' 		=> 'fotografias',
			'posts_per_page' 	=> 1,
			'orderby' 			=> 'rand'
		);
		$queryFotografias = new WP_Query( $args );
		if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post();

			$bgColecciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

			$coleccionColecciones 		= wp_get_post_terms( $post->ID, 'coleccion' );
			$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
			$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;

			$authorColecciones 		= wp_get_post_terms( $post->ID, 'fotografo' );
			if ( $authorColecciones ){
				$authorColeccionesName 	= $authorColecciones[0]->name;
				$authorColeccionesSlug 	= $authorColecciones[0]->slug;
			} else {
				$authorColeccionesName 	= 'sin autor';
			}

			$titleColecciones = get_the_title( $post->ID );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = NULL;
			}

			$seriesColecciones = 0;

			$placeColecciones = wp_get_post_terms( $post->ID, 'lugar' );
			if ( $placeColecciones ){
				$placeColeccionesName 	= $placeColecciones[0]->name;
			}

			$circaColecciones = 0;

			$dateColecciones = wp_get_post_terms( $post->ID, 'año' );
			if ( $dateColecciones ){
				$dateColeccionesName 	= $dateColecciones[0]->name;
			} else {
				$dateColeccionesName 	= 's/f';
			}

			$themesColecciones = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesColecciones ){
				$themesColeccionesName 	= '';
			}

			$permalinkColeccion = get_permalink( $post->ID );
		endwhile; endif; wp_reset_query();

		$html = '
			<section class="[ colecciones ] [ bg-image ]" style="background-image: url('.$bgColecciones[0].')">
				<div class="[ opacity-gradient square ]">
					<a href="'.site_url('colecciones').'" class="[ button button--hollow button--large ] [ center-full ]">
						Colecciones
					</a>
					<div class="[ media-info media-info--large ] [ xmall-12 ]">
						<p class="[ text-center ]">';
							if ( $authorColeccionesName && $authorColeccionesName !== "Autor no identificado" ){
								$html .= '<a href="'.site_url( $authorColeccionesSlug ).'" class="[ media--info__author ]">'.$authorColeccionesName.'</a>,';
							}

							if ( $titleColecciones ){
								$html .= ' <a href="'.$permalinkColeccion.'" class="[ media--info__name ]">'.$titleColecciones.'</a>,';
							}

							if ( $seriesColecciones ){
								$html .= ' de la serie <span class="[ media--info__series ]">'.$seriesColecciones.'</span>,';
							}

							if ( $placeColecciones ){
								$html .= ' <span class="[ media--info__place ]">'.$placeColeccionesName.'</span>,';
							}

							if ( $circaColecciones ){
								$html .= ' <span class="[ media--info__circa ]">circa </span>';
							}

							if ( $dateColecciones ){
								$html .= ' <span class="[ media--info__date ]">'.$dateColeccionesName.'</span>,';
							}

							$html .= '<br /> de la colección <a href="'.site_url().'/colecciones?coleccion='.$coleccionColeccionesSlug.'" class="[ media--info__colection ]">'.$coleccionColeccionesName.'</a>';
						$html .= '</p>
						<div class="[ media-info__tags ] [ text-center ]">';
								$themeCounter = 1;
								if ( $themesColeccionesName ){
									foreach ($themesColeccionesName as $themeColeccionesName) {
										$themeColeccionesName = $themeColeccionesName->name;
										$html .= '<a href="'.site_url('$themeColeccionesName').' " class="[ tag ]">#'.$themeColeccionesName.'</a>';
										$themeCounter ++;
										if ( $themeCounter == 3 ){
											break;
										}
									}
								}

						$html .= '</div>
					</div>
				</div>
			</section>';
		return $html;
	} // get_html_home_colecciones

	function get_html_home_proyectos(){
		global $post;

		$bgProyectos = '';
		$proyectosArgs = array(
			'posts_per_page' 	=> 1,
			'orderby' 			=> 'rand',
			'post_type' 		=> 'proyectos'
		);
		$queryProyectos = new WP_Query( $proyectosArgs );
		if ( $queryProyectos->have_posts() ) : while ( $queryProyectos->have_posts() ) : $queryProyectos->the_post();
			$bgProyectos = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

			$titleProyectos = get_the_title( $post->ID );
			$permalinkProyectos = get_permalink( $post->ID );
			if ( strpos($titleProyectos, 'Sin título') !== false OR $titleProyectos == '' OR strpos($titleProyectos, '&nbsp') !== false ){
				$titleProyectos = NULL;
			}

			$themesProyectos = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesProyectos ){
				$themesProyectosName 	= '';
			}
		endwhile; endif; wp_reset_query();

		$html = '
		<section class="[ colecciones ] [ bg-image ]" style="background-image: url('.$bgProyectos[0].')">
			<div class="[ opacity-gradient square ]">
				<a href="'.site_url('proyecto').'" class="[ button button--hollow button--large ] [ center-full ]">
					Proyectos
				</a>
				<div class="[ media-info media-info--large ] [ xmall-12 ]">
					<p class="[ text-center ]">';

					if ( $titleProyectos ){
						$html .= '<a href="'.$permalinkProyectos.'" class="[ media--info__name ]">'.$titleProyectos.'</a>';
					}

					$html .= '<div class="[ media-info__tags ] [ text-center ]">';
					$themeCounter = 1;
					if ( $themesProyectosName ){
						foreach ($themesProyectosName as $themeProyectosName) {
							$themeProyectosName = $themeProyectosName->name;
							$html .= '<a href="'.site_url('$themeProyectosName').'" class="[ tag ]">#'.$themeColeccionesName.'</a>';
							$themeCounter ++;
							if ( $themeCounter == 3 ){
								break;
							}
						}
					}
					$html .= '
					</div>
				</div>
			</div>
		</section>';

		return $html;
	} // get_html_home_proyectos

	function get_html_home_publicaciones(){
		global $post;

		$bgPublicaciones = '';
		$titlePublicaciones = '';
		$args = array(
			'post_type' 		=> 'publicaciones',
			'posts_per_page' 	=> 1,
			'orderby' 			=> 'rand'
		);
		$queryPublicaciones = new WP_Query( $args );
		if ( $queryPublicaciones->have_posts() ) : while ( $queryPublicaciones->have_posts() ) : $queryPublicaciones->the_post();
			$bgPublicaciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

			$titlePublicaciones = get_the_title( $post->ID );
			if ( strpos($titlePublicaciones, 'Sin título') !== false OR $titlePublicaciones == '' OR strpos($titlePublicaciones, '&nbsp') !== false ){
				$titlePublicaciones = NULL;
			}

			$themesPublicaciones = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesPublicaciones ){
				$themesPublicacionesName 	= '';
			}

			$permalinkPublicacion = get_permalink( $post->ID );
		endwhile; endif; wp_reset_query();

		$html = '
			<section class="[ publicaciones ] [ bg-image ]" style="background-image: url('.$bgPublicaciones[0].')">
				<div class="[ opacity-gradient square ]">
					<a href="'.site_url('publicaciones').'" class="[ button button--hollow button--large ] [ center-full ]">
						Publicaciones
					</a>
					<div class="[ media-info media-info--large ] [ xmall-12 ]">
						<p class="[ text-center ]">';

						if ( $titlePublicaciones ){
							$html .= '<a href="'.$permalinkPublicacion.'" class="[ media--info__name ]">'.$titlePublicaciones.'</a>';
						}

						$html .= '</p>

						<div class="[ media-info__tags ] [ text-center ]">';

						$themeCounter = 1;
						if ( $themesPublicacionesName ){
							foreach ($themesPublicacionesName as $themePublicacionesName) {
								$themePublicacionesName = $themePublicacionesName->name;
								$html .= '<a href="'.site_url('$themePublicacionesName').'" class="[ tag ]">#'.$themePublicacionesName.'</a>';
								$themeCounter ++;
								if ( $themeCounter == 3 ){
									break;
								}
							}
						}
						$html .= '
						</div>
					</div>
				</div>
			</section>';

		return $html;
	} // get_html_home_publicaciones

	function get_html_home_exposiciones(){
		global $post;

		$bgExposiciones = '';
		$args = array(
			'post_type' 		=> 'exposiciones',
			'posts_per_page' 	=> 1
		);
		$queryExposiciones = new WP_Query( $args );
		if ( $queryExposiciones->have_posts() ) : while ( $queryExposiciones->have_posts() ) : $queryExposiciones->the_post(); ?>
			<?php
				$bgExposiciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

				$titleExposiciones = get_the_title( $post->ID );
				if ( strpos($titleExposiciones, 'Sin título') !== false OR $titleExposiciones == '' OR strpos($titleExposiciones, '&nbsp') !== false ){
					$titleExposiciones = NULL;
				}

				$lugarYFechaExposiciones = get_post_meta($post->ID, '_lugar_y_fecha_exposicion_meta', true );

				$themesExposiciones = wp_get_post_terms( $post->ID, 'tema' );
				if ( ! $themesExposiciones ){
					$themesExposicionesName 	= '';
				}

				$permalinkExposiciones = get_permalink( $post->ID );
		endwhile; endif; wp_reset_query();

		$html = '
		<section class="[ colecciones ] [ bg-image ]" style="background-image: url('.$bgExposiciones[0].')">
			<div class="[ opacity-gradient square ]">
				<a href="'.site_url('exposiciones').'" class="[ button button--hollow button--large ] [ center-full ]">
					Exposiciones
				</a>
				<div class="[ media-info media-info--large ] [ xmall-12 ]">
					<p class="[ text-center ][ ellipsis ]">';

						if ( $titleExposiciones ){
							$html .= '<a href="'.$permalinkExposiciones.'" class="[ media--info__name ]">'.$titleExposiciones.'</a>';
						}

						if ( $lugarYFechaExposiciones ){
							$html .= '<br /><span class="[ media--info__place ]">'.$lugarYFechaExposiciones.'</span>';
						}
					$html .= '
					</p>
				</div>
			</div>
		</section>';

		return $html;
	} // get_html_home_exposiciones

	function get_html_home_adquisiciones_recientes(){
		global $post, $wpdb;

		$bgRecientes = '';
		$coleccionRecientes = '';
		$authorRecientes = '';
		$titleRecientes = '';
		$seriesRecientes = '';
		$placeRecientes = '';
		$circaRecientes = 0;
		$dateRecientes = '';

		$query = "
			SELECT id FROM wp_posts
			WHERE post_type = 'fotografias'
			AND post_status = 'publish'
			ORDER BY post_date LIMIT 1";
		$posts_info = $wpdb->get_results( $query, OBJECT );

		$bgRecientes = wp_get_attachment_image_src( get_post_thumbnail_id( $posts_info[0]->id ),'full' );

		$coleccionRecientes 		= wp_get_post_terms( $posts_info[0]->id, 'coleccion' );
		$coleccionRecientesName 	= $coleccionRecientes[0]->name;
		$coleccionRecientesSlug 	= $coleccionRecientes[0]->slug;

		$authorRecientes 		= wp_get_post_terms( $posts_info[0]->id, 'fotografo' );
		if ( $authorRecientes ){
			$authorRecientesName 	= $authorRecientes[0]->name;
			$authorRecientesSlug 	= $authorRecientes[0]->slug;
		} else {
			$authorRecientesName 	= 'sin autor';
		}

		$titleRecientes = get_the_title( $posts_info[0]->id );
		if ( strpos($titleRecientes, 'Sin título') !== false OR $titleRecientes == '' OR strpos($titleRecientes, '&nbsp') !== false ){
			$titleRecientes = NULL;
		}

		$seriesRecientes = 0;

		$placeRecientes = wp_get_post_terms( $posts_info[0]->id, 'lugar' );
		if ( $placeRecientes ){
			$placeRecientesName 	= $placeRecientes[0]->name;
		}

		$circaRecientes = 0;

		$dateRecientes = wp_get_post_terms( $posts_info[0]->id, 'año' );
		if ( $dateRecientes ){
			$dateRecientesName 	= $dateRecientes[0]->name;
		} else {
			$dateRecientesName 	= 's/f';
		}

		$themesRecientes = wp_get_post_terms( $posts_info[0]->id, 'tema' );
		if ( ! $themesRecientes ){
			$themesRecientesName 	= '';
		}

		$permalinkRecientes = get_permalink( $posts_info[0]->id );

		$html = '
			<section class="[ nuevas-adquisiciones ] [ bg-image ]" style="background-image: url('.$bgRecientes[0].')">
				<div class="[ opacity-gradient square ]">
					<a href="'.site_url().'/colecciones/?coleccion=adquisiciones-recientes" class="[ button button--hollow button--large ] [ center-full ]">
						Adquisiciones recientes
					</a>
					<div class="[ media-info media-info--large ] [ xmall-12 ]">

						<p class="[ text-center ]">';
							if ( $authorRecientesName && $authorRecientesName !== "Autor no identificado" ){
								$html .= '<a href="'.site_url( $permalinkRecientes ).'" class="[ media--info__author ]">'.$authorRecientesName.'</a>,';
							}

							if ( $titleRecientes ){
								$html .= ' <a href="'.$permalinkRecientes.'" class="[ media--info__name ]">'.$titleRecientes.'</a>,';
							}

							if ( $seriesRecientes ){
								$html .= ' de la serie <span class="[ media--info__series ]">'.$seriesRecientes.'</span>,';
							}

							if ( $placeRecientes ){
								$html .= ' <span class="[ media--info__place ]">'.$placeRecientesName.'</span>,';
							}

							if ( $circaRecientes ){
								$html .= ' <span class="[ media--info__circa ]">circa </span>';
							}

							if ( $dateRecientes ){
								$html .= ' <span class="[ media--info__date ]">'.$dateRecientesName.'</span>,';
							}
							$html .= '<br /> de la colección <a href="'.site_url().'/colecciones?coleccion='.$coleccionRecientesSlug.'" class="[ media--info__colection ]">'.$coleccionRecientesName.'</a>';
						$html .= '</p>


					</div>
				</div>
			</section>';

		return $html;
	} // get_html_home_adquisiciones_recientes

	function get_html_home_destacado(){
		global $post;

		$bgFeatured = '';
		$coleccionFeatured = '';
		$authorFeatured = '';
		$titleFeatured = '';
		$seriesFeatured = '';
		$placeFeatured = '';
		$circaFeatured = 0;
		$dateFeatured = '';
		$args = array(
			'post_type' 	=> 'any',
			'show_posts'	=> 1,
			'tax_query' 	=>
				array(
					array(
						'taxonomy'	=> 'category',
						'field'		=> 'slug',
						'terms'		=> array('destacado')
					)
				)
		);
		$queryFeatured = new WP_Query( $args );
		if ( $queryFeatured->have_posts() ) : while ( $queryFeatured->have_posts() ) : $queryFeatured->the_post();

			$postType = get_post_type( $post->ID );

			if( $postType == 'fotografos' ){
				$slugPost = $post->post_name;
				$fotografoArgs = array(
					'post_type'      => 'fotografias',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'field'    => 'slug',
							'taxonomy' => 'fotografo',
							'terms'    => $slugPost
						),
					),
					'post__not_in'		=> array($post->ID)
				);
				$fotografoQuery = new WP_Query( $fotografoArgs );
				if( $fotografoQuery->have_posts() ) : while( $fotografoQuery->have_posts() ) : $fotografoQuery->the_post();
					$bgFeatured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );
				endwhile; endif; wp_reset_postdata();
			} else {
				$bgFeatured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );
			}

			$postTypeFeatured = get_post_type( $post->ID );

			$coleccionFeatured 		= wp_get_post_terms( $post->ID, 'coleccion' );
			if ( ! empty( $coleccionFeatured ) ){
				$coleccionFeaturedName 	= $coleccionFeatured[0]->name;
				$coleccionFeaturedSlug 	= $coleccionFeatured[0]->slug;
			}

			$authorFeatured 			= wp_get_post_terms( $post->ID, 'fotografo' );
			if ( $authorFeatured ){
				$authorFeaturedName 	= $authorFeatured[0]->name;
				$authorFeaturedSlug 	= $authorFeatured[0]->slug;
			}

			$titleFeatured = get_the_title( $post->ID );
			if ( strpos($titleFeatured, 'Sin título') !== false OR $titleFeatured == '' OR strpos($titleFeatured, '&nbsp') !== false ){
				$titleFeatured = NULL;
			}

			$placeFeatured = wp_get_post_terms( $post->ID, 'lugar' );
			$placeFeaturedName = '';
			if ( $placeFeatured ){
				$placeFeaturedName 	= $placeFeatured[0]->name;
			}

			$dateFeatured = wp_get_post_terms( $post->ID, 'año' );
			if ( $dateFeatured ){
				$dateFeaturedName 	= $dateFeatured[0]->name;
			} else {
				$dateFeaturedName 	= 's/f';
			}

			$themesFeatured = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesFeatured ){
				$themesFeaturedName 	= '';
			}

			$permalinkFeatured = get_permalink( $post->ID );
		endwhile; endif; wp_reset_query();

		$url_photo = empty( $bgFeatured ) ? '#' : $bgFeatured[0];

		$html = '
			<section class="[ colecciones ] [ bg-image ]" style="background-image: url('.$url_photo.' )">
				<div class="[ opacity-gradient square ]">
					<a href="'.site_url('colecciones').'" class="[ button button--hollow button--large ] [ center-full ]">
						Destacado
					</a>
					<div class="[ media-info media-info--large ] [ xmall-12 ]">
						<p class="[ text-center ]">';

							if ( $authorFeatured ){
								$html .= '<a href="'.site_url( $authorFeaturedSlug ).'" class="[ media--info__author ]">'.$authorFeaturedName.'</a>,';
							}

							if ( $titleFeatured ){
								$html .= ' <a href="'.$permalinkFeatured.'" class="[ media--info__name ]">'.$titleFeatured.'</a>,';
							}

							if ( $seriesFeatured ){
								$html .= ' de la serie <span class="[ media--info__series ]">'.$seriesFeatured.'</span>,';
							}

							if ( $placeFeatured ){
								$html .= ' <span class="[ media--info__place ]">'.$placeFeaturedName.'</span>,';
							}

							if ( $circaFeatured ){
								$html .= ' <span class="[ media--info__circa ]">circa </span>';
							}

							if ( $dateFeatured ){
								$html .= ' <span class="[ media--info__date ]">'.$dateFeaturedName.'</span>,';
							}

							if ( $coleccionFeatured ){
								$html .= '<br /> de la colección <a href="'.site_url( $coleccionFeaturedSlug ).'" class="[ media--info__colection ]"> '.$coleccionFeaturedName.'</a>';
							}
						$html .= '</p>
					</div>
				</div>
			</section>';

		return $html;
	} // get_html_home_destacado


	require_once('inc/gallery-parse.php');
