<?php


// TAXONOMIES ////////////////////////////////////////////////////////////////////////


	add_action( 'init', 'custom_taxonomies_callback', 0 );

	function custom_taxonomies_callback(){

		// COLECCIONES
		if( ! taxonomy_exists('coleccion')){

			$labels = array(
				'name'              => 'Colecciones',
				'singular_name'     => 'Colección',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Colección',
				'update_item'       => 'Actualizar Colección',
				'add_new_item'      => 'Nuevo Colección',
				'new_item_name'     => 'Nombre Nuevo Colección',
				'menu_name'         => 'Colecciones'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'coleccion' ),
			);

			$postTypeColecciones = array(
				'fotografos',
				'fotografias'
				);
			register_taxonomy( 'coleccion', $postTypeColecciones, $args );
		}

		// AÑO
		if( ! taxonomy_exists('año')){

			$labels = array(
				'name'              => 'Años',
				'singular_name'     => 'Año',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Año',
				'update_item'       => 'Actualizar Año',
				'add_new_item'      => 'Nuevo Año',
				'new_item_name'     => 'Nombre Nuevo Año',
				'menu_name'         => 'Años'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'ano' ),
			);

			register_taxonomy( 'año', 'fotografias', $args );
		}

		// FOTÓGRAFO
		if( ! taxonomy_exists('fotografo')){
			$labels = array(
				'name'              => 'Fotógrafos',
				'singular_name'     => 'Fotógrafo',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Fotógrafo',
				'update_item'       => 'Actualizar Fotógrafo',
				'add_new_item'      => 'Nuevo Fotógrafo',
				'new_item_name'     => 'Nombre Nuevo Fotógrafo',
				'menu_name'         => 'Fotógrafos'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'fotografo' ),
			);
			register_taxonomy( 'fotografo', 'fotografias', $args );
		}// taxonomy fotografo

		// PAÍS
		if( ! taxonomy_exists('pais')){
			$labels = array(
				'name'              => 'Países',
				'singular_name'     => 'País',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar País',
				'update_item'       => 'Actualizar País',
				'add_new_item'      => 'Nuevo País',
				'new_item_name'     => 'Nombre Nuevo País',
				'menu_name'         => 'Países'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'pais' ),
			);
			register_taxonomy( 'pais', 'fotografos', $args );
		}// taxonomy pais

		// DÉCADA DE NACIMIENTO
		if( ! taxonomy_exists('decada-de-nacimiento')){
			$labels = array(
				'name'              => 'Décadas de nacimiento',
				'singular_name'     => 'Década de nacimiento',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Década de nacimiento',
				'update_item'       => 'Actualizar Década de nacimiento',
				'add_new_item'      => 'Nuevo Década de nacimiento',
				'new_item_name'     => 'Nombre Nuevo Década de nacimiento',
				'menu_name'         => 'Décadas de nacimiento'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'decada-de-nacimiento' ),
			);
			register_taxonomy( 'decada-de-nacimiento', 'fotografos', $args );
		}// taxonomy decada-de-nacimiento

		// Apellido
		if( ! taxonomy_exists('apellido')){
			$labels = array(
				'name'              => 'Apellido',
				'singular_name'     => 'Apellido',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Apellido',
				'update_item'       => 'Actualizar Apellido',
				'add_new_item'      => 'Nuevo Apellido',
				'new_item_name'     => 'Nombre Nuevo Apellido',
				'menu_name'         => 'Apellido'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'apellido' ),
			);
			register_taxonomy( 'apellido', 'fotografos', $args );
		}// taxonomy apellido

		// Tipo de proyecto
		if( ! taxonomy_exists('tipo-de-proyecto')){
			$labels = array(
				'name'              => 'Tipo de proyecto',
				'singular_name'     => 'Tipo de proyecto',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Tipo de proyecto',
				'update_item'       => 'Actualizar Tipo de proyecto',
				'add_new_item'      => 'Nuevo Tipo de proyecto',
				'new_item_name'     => 'Nombre Nuevo Tipo de proyecto',
				'menu_name'         => 'Tipo de proyecto'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'tipo-de-proyecto' ),
			);
			register_taxonomy( 'tipo-de-proyecto', 'fotografos', $args );
		}// taxonomy apellido

		// Tipo de publicacion
		if( ! taxonomy_exists('tipo-de-publicacion')){
			$labels = array(
				'name'              => 'Tipo de publicaciones',
				'singular_name'     => 'Tipo de publicación',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Tipo de publicación',
				'update_item'       => 'Actualizar Tipo de publicación',
				'add_new_item'      => 'Nuevo Tipo de publicación',
				'new_item_name'     => 'Nombre Nuevo Tipo de publicación',
				'menu_name'         => 'Tipo de publicaciones'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'tipo-de-publicacion' ),
			);
			register_taxonomy( 'tipo-de-publicacion', 'publicaciones', $args );
		}// taxonomy apellido

		// Medio
		if( ! taxonomy_exists('medio')){
			$labels = array(
				'name'              => 'Medio',
				'singular_name'     => 'Medio',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Medio',
				'update_item'       => 'Actualizar Medio',
				'add_new_item'      => 'Nuevo Medio',
				'new_item_name'     => 'Nombre Nuevo Medio',
				'menu_name'         => 'Medio'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'medio' ),
			);
			register_taxonomy( 'medio', 'publicaciones', $args );
		}// taxonomy medio

		// Tipo de trabajo
		if( ! taxonomy_exists('tipo-de-trabajo')){
			$labels = array(
				'name'              => 'Tipos de trabajo',
				'singular_name'     => 'Tipo de trabajo',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Tipo de trabajo',
				'update_item'       => 'Actualizar Tipo de trabajo',
				'add_new_item'      => 'Nuevo Tipo de trabajo',
				'new_item_name'     => 'Nombre Nuevo Tipo de trabajo',
				'menu_name'         => 'Tipo de trabajo'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'tipo-de-trabajo' ),
			);
			register_taxonomy( 'tipo-de-trabajo', 'nuestro-trabajo', $args );
		}// taxonomy medio

		// Tipo de noticia
		if( ! taxonomy_exists('tipo-de-noticia')){
			$labels = array(
				'name'              => 'Tipos de noticia',
				'singular_name'     => 'Tipo de noticia',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Tipo de noticia',
				'update_item'       => 'Actualizar Tipo de noticia',
				'add_new_item'      => 'Nuevo Tipo de noticia',
				'new_item_name'     => 'Nombre Nuevo Tipo de noticia',
				'menu_name'         => 'Tipo de noticia'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'tipo-de-noticia' ),
			);
			register_taxonomy( 'tipo-de-noticia', 'noticias', $args );
		}// taxonomy medio

		// Tema
		if( ! taxonomy_exists('tema')){
			$labels = array(
				'name'              => 'Temas',
				'singular_name'     => 'Tema',
				'search_items'      => 'Buscar',
				'all_items'         => 'Todos',
				'edit_item'         => 'Editar Tema',
				'update_item'       => 'Actualizar Tema',
				'add_new_item'      => 'Nuevo Tema',
				'new_item_name'     => 'Nombre Nuevo Tema',
				'menu_name'         => 'Temas'
			);
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'tema' ),
			);
			$postTypeTema = array(
				'fotografos',
				'fotografias',
				'proyectos',
				'exposiciones',
				'publiaciones',
				'cartelera',
				'nuestro-trabajo',
				'noticias',
				);
			register_taxonomy( 'tema', $postTypeTema, $args );
		}// taxonomy medio

		// Agregar palabras 
		insertYearTaxonomyTerms();
	}

	function insertYearTaxonomyTerms(){
		// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
		global $wpdb;
		$results = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key LIKE "%wpcf-ano%" AND meta_key <> "" ORDER BY meta_value', OBJECT );

		foreach ($results as $year) {
			$term = term_exists($year->meta_value, 'año');
			if ($term !== 0 && $term !== null) continue;

			wp_insert_term($year->meta_value, 'año');
		}
	}// insertYearTaxonomyTerms