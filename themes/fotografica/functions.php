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
		wp_enqueue_script( 'mlpushmenu', JSPATH.'/vendor/mlpushmenu.js', array('plugins'), '1.0', true );
		wp_enqueue_script( 'classie', JSPATH.'/vendor/classie.js', array('plugins'), '1.0', true );
		wp_enqueue_script( 'modernizr', JSPATH.'/vendor/modernizr.custom.js', array('plugins'), '1.0', true );
		wp_enqueue_script( 'masonry', JSPATH.'/vendor/masonry.js', array('plugins'), '1.0', true );
		wp_enqueue_script( 'functions', JSPATH.'functions.js', array('masonry'), '1.0', true );


		// localize scripts
		wp_localize_script( 'functions', 'ajax_url', admin_url('admin-ajax.php') );

		// styles
		wp_enqueue_style( 'styles', get_stylesheet_uri() );

	});

	// FRONT END SCRIPTS FOOTER //////////////////////////////////////////////////////
	function footerScripts(){
		if( wp_script_is( 'functions', 'done' ) ) {

			/*------------------------------------*\
			    #HOME
			\*------------------------------------*/
			if ( is_home() ) { ?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){

						});
					}(jQuery));
				</script>





			<!-- /**********************************\ -->
			<!-- #ARCHIVE -->
			<!-- \**********************************/ -->
			<?php } elseif ( is_archive() ) { ?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){

							/*------------------------------------*\
								#Triggered events
							\*------------------------------------*/

							$('.tab-filter').on('click', function(){
								showFilters( this );
							});

							$('.filters__content').on('click', '.filter', function(){
								addFilter( this );
								searchTest('fotografias', getFilteredResults(), 20);
							});

							$('.filters__results').on('click', '.filter', function(){
								removeFilter( this );
								searchTest('fotografias', getFilteredResults(), 20);
							});



						});
					}(jQuery));
				</script>




			<!-- /**********************************\ -->
			<!-- #POST TYPE -->
			<!-- \**********************************/ -->
			<?php } elseif ( get_post_type() == 'post-type') { ?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){

						});
					}(jQuery));
				</script>




			<!-- /**********************************\ -->
			<!-- #PAGE COLECCIONES -->
			<!-- \**********************************/ -->
			<?php } elseif ( is_page() == 'colecciones') { ?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){
							/*------------------------------------*\
								#ON LOAD
							\*------------------------------------*/

							runMasonry('.results', '.result' );

							searchTest('fotografias', getFilteredResults(), 15);

							/*------------------------------------*\
								#Triggered events
							\*------------------------------------*/

							$('.tab-filter').on('click', function(){
								showFilters( this );
							});

							$('.filters__content').on('click', '.filter', function(){
								addFilter( this );
								searchTest('fotografias', getFilteredResults(), 20);
							});

							$('.filters__results').on('click', '.filter', function(){
								removeFilter( this );
								searchTest('fotografias', getFilteredResults(), 20);
							});
						});
					}(jQuery));
				</script>




			<!-- /**********************************\ -->
			<!-- #PAGE -->
			<!-- \**********************************/ -->
			<?php } elseif( is_page('page') ) { ?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){

						});
					}(jQuery));
				</script>
			<?php } ?>





			<!-- /**********************************\ -->
			<!-- #GLOBAL -->
			<!-- \**********************************/ -->
			<script type="text/javascript">
				(function( $ ) {
					"use strict";
					$(function(){
						/*------------------------------------*\
							#ON LOAD
						\*------------------------------------*/
						setHeaderHeightPadding('.main-wrapper', 'top');
						setHeaderHeightPadding('.footer-wrapper', 'bottom');
						setHeightMinusElement('.overflow-scroll', '.mp-level', 'h2');





						/*------------------------------------*\
							#Triggered events
						\*------------------------------------*/

						$('.content-wrapper').scroll(function(){
							fixedHeader();
						});





						/*------------------------------------*\
							#RESPONSIVE
						\*------------------------------------*/
						$(window).resize(function(){
							setHeaderHeightPadding('.main-wrapper', 'top');
							setHeaderHeightPadding('.footer-wrapper', 'bottom');
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
		wp_enqueue_script( 'admin-js', JSPATH.'admin.js', array('jquery'), '1.0', true );

		// localize scripts
		wp_localize_script( 'admin-js', 'ajax_url', admin_url('admin-ajax.php') );

		// styles
		wp_enqueue_style( 'admin-css', CSSPATH.'admin.css' );

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

// ADVANCED SEARCH FOR THEME  //////////////////////////////////////////////////////

	/**
	 * Búsqueda avanzada basada en filtros.
	 * @param  string $string
	 * @return string
	 */
	function advanced_search(){
		$post_type = $_POST['post_type'];
		$filters = $_POST['filters'];
		$limit = $_POST['limit'];

		$advanced_search_results = array();
		if($post_type == 'fotografias') $advanced_search_results = advanced_search_colecciones($filters, $limit);

		echo json_encode($advanced_search_results , JSON_FORCE_OBJECT);
		exit();
	}// advanced_search
	add_action("wp_ajax_advanced_search", "advanced_search");

	function advanced_search_colecciones($filtros = '', $limit){
		global $post;
		global $wpdb;

		$terms = array('fondo-rutilo-patino', 'coleccion-manuel-alvarez-bravo');
		if ($filtros == ''){
			$query = "
	    		SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografias'
				AND TT.taxonomy IN ('coleccion', 'año', 'fotografo', 'tema')
				AND (
					T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('fondo-juan-cachu') )
					OR T.slug IN ( SELECT slug FROM wp_terms WHERE slug BETWEEN '1947' AND '1947')
					OR T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE slug LIKE 'L%' AND taxonomy = 'fotografo' )
					OR T.name IN ( SELECT name FROM wp_terms WHERE name = '#test' )
				)
				ORDER BY RAND()
				LIMIT ".$limit;
			$posts_info = $wpdb->get_results( $query, OBJECT );
		} else {

			// SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
			$query = "
	    		SELECT id, COUNT(id)  FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografias'";

			$taxonomies = array();
			$is_coleccion = false;
			$coleccion_terms = array();
			$is_ano = false;
			$ano_terms = array();
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
			}
			$taxonomies = array_unique($taxonomies);
			$taxonomies_in = implode("', '", $taxonomies);

			// Add taxonomies to query
			$query = $query." AND TT.taxonomy IN ('".$taxonomies_in."')";

			// If the filters include terms, open condition
			if($is_coleccion || $is_ano) $query = $query." AND ( ";

			// Add filtering terms for colecciones
			if($is_coleccion){
				$coleccion_terms_in = implode("', '", $coleccion_terms);
				$query = $query." T.slug IN ( SELECT slug FROM wp_terms WHERE slug IN ('".$coleccion_terms_in."') ) ";
			}

			// Add filtering terms for años
			if($is_ano){
				if($is_coleccion) $query = $query." OR";
				$ano_terms_in = implode("', '", $ano_terms);
				$initial_year = $ano_terms[0];
				$final_year = strval(intval($initial_year) + 10);
				$query = $query."  T.slug IN ( SELECT slug FROM wp_terms WHERE slug BETWEEN '".$initial_year."' AND '".$final_year."')";
			}

			// 	// 	OR T.slug IN ( SELECT slug FROM wp_terms T INNER JOIN wp_term_taxonomy TT ON TT.term_id = T.term_id WHERE slug LIKE 'L%' AND taxonomy = 'fotografo' )
			// 	// 	OR T.name IN ( SELECT name FROM wp_terms WHERE name = '#test' )

			// Close filtering terms if they exist
			if($is_coleccion || $is_ano) $query = $query." )";

			$query = $query." GROUP BY id HAVING COUNT(id) > 0 ORDER BY RAND() LIMIT ".$limit;
			//echo $query;
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
			// Autor
			$authorColecciones = wp_get_post_terms( $post->id, 'fotografo' );
			if ( $authorColecciones ){
				$authorColeccionesName 	= $authorColecciones[0]->name;
				$authorColeccionesSlug 	= $authorColecciones[0]->slug;
			} else {
				$authorColeccionesName 	= 'Sin autor';
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
			$info_colecciones[$key] = array(
				'titulo'	=> $titleColecciones,
				'img_url'	=> $url,
				'autor'		=> $authorColeccionesName,
				'ano'		=> $anoFotosName,
				'lugar'		=> $lugarName,
				'coleccion'	=> $coleccionName,
				);
 		}

		return $info_colecciones;
	} // advanced_search_colecciones



