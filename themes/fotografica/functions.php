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
		wp_enqueue_script( 'functions', JSPATH.'functions.js', array('masonry'), '1.0', true );


		// localize scripts
		wp_localize_script( 'functions', 'ajax_url', admin_url('admin-ajax.php') );
		wp_localize_script( 'functions', 'post_type', get_post_type() );

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
							#HOME
						\*------------------------------------*/
						<?php if ( is_home() ) { ?>




						/*------------------------------------*\
							#ARCHIVE
						\*------------------------------------*/
						<?php } elseif ( is_archive() ) { ?>

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

							$('.js-cargar-mas').on('click', function(e){
								e.preventDefault();
								existing_ids = getExistingIds();
								advancedSearch('<?php echo $postType ?>', getFilters(true), 20, existing_ids);
							})

							$('.filter-buscar button').on('click', function(e){
								e.preventDefault();
								clearGrid();
								advancedSearch('<?php echo $postType ?>', getFilters(false), 20, existing_ids);
							});

							/**
							 * If the postType is "fotografos" or "proyecto" do not run masonry
							**/
							<?php if ( $postType !== 'fotografos' AND $postType !== 'proyectos' ){ ?>
								runMasonry('.results', '.result' );
							<?php } ?>

							var filter = $('.filter[data-value="hoy"]');
							addFilter( filter );
							advancedSearch('<?php echo $postType ?>', getFilters(false), 20, existing_ids);





						/*------------------------------------*\
							#POST TYPE
						\*------------------------------------*/
						<?php } elseif ( get_post_type() == 'post-type') { ?>





						/*------------------------------------*\
							#PAGE COLECCIONES
						\*------------------------------------*/
						<?php } elseif ( is_page() == 'colecciones') { ?>

							/**
							 * On load
							**/

							runMasonry('.results', '.result' );

							var existing_ids = 0;
							<?php
								global $coleccion;
								global $filtro;
								if($coleccion != '') {
							?>
									var filter = $('.filter[data-value="<?php echo $coleccion; ?>"]');
									addFilter( filter );
							<?php
								} else if ($filtro == 'nuevas-adquisiciones'){
							?>
									var filter = $('.filter[data-value="nuevas-adquisiciones"]');
									addFilter(filter);
									advancedSearch('nuevas-adquisiciones', getFilters(false), 20, existing_ids);
							<?php
								} else if ($filtro == 'favoritos'){
							?>
									var filter = $('.filter[data-value="favoritos"]');
									addFilter(filter);
									advancedSearch('favoritos', getFilters(false), 20, existing_ids);
							<?php
								}
							?>

							/**
							 * Triggered events
							**/

							/**
							 * If the postType is "proyecto" there are no filters
							**/
							<?php if (  $postType !== 'proyecto' ){ ?>

								$('.tab-filter').on('click', function(){
									showFilters( this );
								});

								$('.filters__content').on('click', '.filter', function(){
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
								clearGrid();
								advancedSearch('fotografias', getFilters(false), 20, existing_ids);
							});

							<?php if ($filtro == '') { ?>
								advancedSearch('fotografias', getFilters(false), 15, existing_ids);
							<?php } ?>

							$('.filter--info span').on('click', function(event) {
								var coleccion_id = $(this).data('coleccion-term-id');
								var descripcion = getDescripcionColeccion(coleccion_id);
								openModal( $(this) );

							});

							$('.close-modal').on('click', function(event) {
								closeModal( $(this) );
							});




						/*------------------------------------*\
							#PAGE
						\*------------------------------------*/
						<?php } elseif( is_page('page') ) { ?>





						/*------------------------------------*\
							#SINGLE
						\*------------------------------------*/
						<?php } elseif ( is_single() ) { ?>

							/**
							 * On load
							**/
							<?php if ( $postType === 'fotografos'){ ?>
								//console.log( 'fotografos' );
								runMasonry('.results', '.result' );
							<?php } ?>

							<?php if ( $postType === 'proyectos'){ ?>
								//console.log( 'proyectos' );

								// multiple elements
								var posts = document.querySelectorAll('.final-tiles-gallery');
								imagesLoaded( posts, function() {

									$('.final-tiles-gallery').finalTilesGallery();

								});

							<?php } ?>


							/**
							 * Triggered events
							**/

							$('.single-content').on('click','.single-content-image', function(){
								openLightbox(this);
							});

							$('.button--heart').on('click', function(e){
								e.preventDefault();
								if( ! $(this).hasClass('active') ){
									var post_id = $(this).data('post-id');
									addLike(post_id);
								}
							});




						/*------------------------------------*\
							#SINGLE CONSERVACION
						\*------------------------------------*/
						<?php }

							if ( is_single('conservacion') ) { ?>

							/**
							 * On load
							**/
							runFitVids('.fit-vids-wrapper');

						<?php } ?>





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
							console.log('click');
							toggleiFrame();
						});




						/**
						 * Responsive
						**/
						$(window).resize(function(){

						});

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
				'id'		=> $post->id,
				'permalink'	=> get_permalink( $post->id ),
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'autor'		=> $authorColeccionesName,
				'url_autor'	=> $authorColeccionesSlug,
				'ano'		=> $anoFotosName,
				'lugar'		=> $lugarName,
				'coleccion'	=> $coleccionName,
				'serie'		=> $coleccionSerie,
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
			SELECT id FROM wp_posts P
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
		$query .= " AND post_status = 'publish' ORDER BY RAND() LIMIT ".$limit;
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
		$query .= " AND post_status = 'publish' ORDER BY RAND() LIMIT ".$limit;
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

		echo json_encode($descripcion , JSON_FORCE_OBJECT);
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
			SELECT post_id
			FROM wp_postmeta AS pm
			INNER JOIN wp_posts AS p ON pm.meta_value=p.ID
			WHERE ID = ".$attachment_id."
			AND pm.meta_key = '_thumbnail_id'
			AND post_id IN ( SELECT ID FROM wp_posts WHERE post_type = 'fotografias' )";
		$post_id_results = $wpdb->get_results( $query, OBJECT );

		if ( empty($post_id_results) ){
			return 0;
		}

		return $post_id_results;
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
			default:
				$num_results = 0;
		}// switch

		echo json_encode($num_results , JSON_FORCE_OBJECT);
		exit();
	}// get_total_results
	add_action("wp_ajax_get_total_results", "get_total_results");
	add_action("wp_ajax_nopriv_get_total_results", "get_total_results");

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


	require_once('inc/gallery-parse.php');