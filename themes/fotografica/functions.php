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
		wp_enqueue_script( 'cycle', JSPATH.'/vendor/cycle.js', array('plugins'), '1.0', true );
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
			<?php
			} elseif ( is_archive() ) {
				$postType = get_post_type();
			?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){
							var existing_ids = 0;

							/*------------------------------------*\
								#Triggered events
							\*------------------------------------*/

							$('.tab-filter').on('click', function(){
								showFilters( this );
							});

							$('.filters__content').on('click', '.filter', function(){
								addFilter( this );
								existing_ids = getExistingIds();
								clearGrid();
								advancedSearch('<?php echo $postType ?>', getFilteredResults(), 20, existing_ids);
							});

							$('.filters__results').on('click', '.filter', function(){
								removeFilter( this );
								existing_ids = getExistingIds();
								clearGrid();
								advancedSearch('<?php echo $postType ?>', getFilteredResults(), 20, existing_ids);
							});

							$('.js-cargar-mas').on('click', function(e){
								e.preventDefault();
								existing_ids = getExistingIds();
								advancedSearch('<?php echo $postType ?>', getFilteredResults(), 20, existing_ids);
							})

							/**
							 * If the postType is fotografos do not run masonry
							**/
							<?php if ( $postType !== 'fotografos'){ ?>
								runMasonry('.results', '.result' );
							<?php } ?>


							advancedSearch('<?php echo $postType ?>', getFilteredResults(), 20, existing_ids);

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
							var existing_ids = 0;
							<?php
								global $coleccion;
								if($coleccion != '') {
							?>
									var filter = $('.filter[data-value="<?php echo $coleccion; ?>"]');
									addFilter( filter );
							<?php } ?>



							/*------------------------------------*\
								#Triggered events
							\*------------------------------------*/

							$('.tab-filter').on('click', function(){
								showFilters( this );
							});

							$('.filters__content').on('click', '.filter', function(){
								addFilter( this );
								existing_ids = getExistingIds();
								clearGrid();
								advancedSearch('fotografias', getFilteredResults(), 20, existing_ids);
							});

							$('.filters__results').on('click', '.filter', function(){
								removeFilter( this );
								clearGrid();
								existing_ids = getExistingIds();
								advancedSearch('fotografias', getFilteredResults(), 20, existing_ids);
							});

							$('.js-cargar-mas').on('click', function(e){
								e.preventDefault();
								existing_ids = getExistingIds();
								advancedSearch('fotografias', getFilteredResults(), 20, existing_ids);
							})

							advancedSearch('fotografias', getFilteredResults(), 15, existing_ids);
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


			<!-- /**********************************\ -->
				<!-- #SINGLE -->
			<!-- \**********************************/ -->
			<?php } elseif ( is_single() ) { ?>
				<script type="text/javascript">
					(function( $ ) {
						"use strict";
						$(function(){

							$('.single-content').on('click','.single-content-image', function(){
								openLightbox(this);
							});

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
		$existing_ids = $_POST['existing_ids'];

		$advanced_search_results = array();
		if($post_type == 'fotografias') $advanced_search_results = advanced_search_colecciones($filters, $limit, $existing_ids);
		if($post_type == 'fotografos') $advanced_search_results = advanced_search_fotografos($filters, $limit, $existing_ids);
		if($post_type == 'eventos') $advanced_search_results = advanced_search_eventos($filters, $limit, $existing_ids);

		echo json_encode($advanced_search_results , JSON_FORCE_OBJECT);
		exit();
	}// advanced_search
	add_action("wp_ajax_advanced_search", "advanced_search");

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

			$query .= " ORDER BY RAND() LIMIT ".$limit;
			$posts_info = $wpdb->get_results( $query, OBJECT );
		} else {

			// SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
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
			}
			$taxonomies = array_unique($taxonomies);
			$taxonomies_in = implode("', '", $taxonomies);

			// Add taxonomies to query
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

			$query = $query." GROUP BY id HAVING COUNT(id) > ".$filter_type_count." ORDER BY RAND() LIMIT ".$limit;
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
				);
 		}

		return $info_colecciones;
	} // advanced_search_colecciones

	function advanced_search_fotografos($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		if ($filtros == ''){
			$query = "
	    		SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
				INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
				INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
				INNER JOIN wp_terms T ON T.term_id = TT.term_id
				WHERE P.post_type = 'fotografos'";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND P.id NOT IN ('".$existing_ids_in."')";
			}

			$query .= " ORDER BY RAND() LIMIT ".$limit;

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

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}

			$query = $query." GROUP BY id HAVING COUNT(id) > ".$filter_type_count." ORDER BY RAND() LIMIT ".$limit;
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

		return $info_colecciones;
	} // advanced_search_fotografos

	function advanced_search_eventos($filtros = '', $limit, $existing_ids){
		global $post;
		global $wpdb;

		if ($filtros == ''){
			$query = "
	    		SELECT id FROM wp_posts
				WHERE post_type = 'eventos'";

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}

			$query .= "ORDER BY RAND() LIMIT ".$limit;

			$posts_info = $wpdb->get_results( $query, OBJECT );
		} else {

			// SELECT P.id, P.post_title, T.name, T.slug FROM wp_posts P
			$query = "
	    		SELECT id FROM wp_posts P
	    		INNER JOIN wp_postmeta PM ON PM.post_id = P.id
				WHERE post_type = 'eventos'
				AND meta_key IN ('_evento_fecha_final_meta', '_evento_fecha_inicial_meta')";

			$hoy = date('Y-m-d');

			//$inicioHoy = strtotime("midnight", $hoy);
			//$finHoy = strtotime("tomorrow", $inicioHoy) - 1;
			foreach ($filtros as $key => $filtro) {
				if($key == 0) $query .= ' AND';

				if($filtro['value'] == 'proximos') {
					$query .= " '_evento_fecha_inicial_meta' > ".$hoy;
				}
			}

			if($existing_ids != '0'){
				$existing_ids_in = implode("', '", $existing_ids);
				$query .= " AND id NOT IN ('".$existing_ids_in."')";
			}
			$query .= "ORDER BY RAND() LIMIT ".$limit;

			echo $query;
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
				);
 		}

		return $info_colecciones;
	} // advanced_search_eventos



