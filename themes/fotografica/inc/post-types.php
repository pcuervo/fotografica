<?php


// CUSTOM POST TYPES /////////////////////////////////////////////////////////////////


	add_action('init', function(){

		// FOTOGRAFÍAS
		$labels = array(
			'name'          => 'Fotografías',
			'singular_name' => 'Fotografía',
			'add_new'       => 'Nueva Fotografía',
			'add_new_item'  => 'Nueva Fotografía',
			'edit_item'     => 'Editar Fotografía',
			'new_item'      => 'Nueva Fotografía',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Fotografía',
			'search_items'  => 'Buscar Fotografía',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Fotografías'
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'fotografias' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 6,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'fotografias', $args );

		// FOTOGRÁFOS
		$labels = array(
			'name'          => 'Fotógrafos',
			'singular_name' => 'Fotógrafo',
			'add_new'       => 'Nuevo Fotógrafo',
			'add_new_item'  => 'Nuevo Fotógrafo',
			'edit_item'     => 'Editar Fotógrafo',
			'new_item'      => 'Nuevo Fotógrafo',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Fotógrafo',
			'search_items'  => 'Buscar Fotógrafo',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Fotógrafos'
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'fotografos' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 6,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'fotografos', $args );

		// PROYECTOS
		$labels = array(
			'name'          => 'Proyectos',
			'singular_name' => 'Proyecto',
			'add_new'       => 'Nuevo Proyecto',
			'add_new_item'  => 'Nuevo Proyecto',
			'edit_item'     => 'Editar Proyecto',
			'new_item'      => 'Nuevo Proyecto',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Proyecto',
			'search_items'  => 'Buscar Proyecto',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Proyectos'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'proyecto' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'proyectos', $args );

		// EXPOSICIONES
		$labels = array(
			'name'          => 'Exposiciones',
			'singular_name' => 'Exposición',
			'add_new'       => 'Nueva Exposición',
			'add_new_item'  => 'Nueva Exposición',
			'edit_item'     => 'Editar Exposición',
			'new_item'      => 'Nueva Exposición',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Exposición',
			'search_items'  => 'Buscar Exposición',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Exposiciones'
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'exposiciones' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'exposiciones', $args );

		// PUBLICACIONES
		$labels = array(
			'name'          => 'Publicaciones',
			'singular_name' => 'Publicación',
			'add_new'       => 'Nueva Publicación',
			'add_new_item'  => 'Nueva Publicación',
			'edit_item'     => 'Editar Publicación',
			'new_item'      => 'Nueva Publicación',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Publicación',
			'search_items'  => 'Buscar Publicación',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Publicaciones'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'publicaciones' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'publicaciones', $args );

		// INVESTIGACIONES
		$labels = array(
			'name'          => 'Investigaciones',
			'singular_name' => 'Investigación',
			'add_new'       => 'Nueva Investigación',
			'add_new_item'  => 'Nueva Investigación',
			'edit_item'     => 'Editar Investigación',
			'new_item'      => 'Nueva Investigación',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Investigación',
			'search_items'  => 'Buscar Investigación',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Investigaciones'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'investigaciones' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'investigaciones', $args );		

		// CARTELERA
		$labels = array(
			'name'          => 'Cartelera',
			'singular_name' => 'Cartelera',
			'add_new'       => 'Nueva Cartelera',
			'add_new_item'  => 'Nueva Cartelera',
			'edit_item'     => 'Editar Cartelera',
			'new_item'      => 'Nueva Cartelera',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Cartelera',
			'search_items'  => 'Buscar Cartelera',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Cartelera'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'cartelera' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'carteleras', $args );

		// NUESTRO TRABAJO
		$labels = array(
			'name'          => 'Trabajos',
			'singular_name' => 'Trabajo',
			'add_new'       => 'Nuevo Trabajo',
			'add_new_item'  => 'Nuevo Trabajo',
			'edit_item'     => 'Editar Trabajo',
			'new_item'      => 'Nuevo Trabajo',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Trabajo',
			'search_items'  => 'Buscar Trabajo',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Nuestro Trabajo'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'nuestro-trabajo' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'nuestro-trabajo', $args );

		// CONTACTO
		$labels = array(
			'name'          => 'Contacto',
			'singular_name' => 'Contacto',
			'add_new'       => 'Nuevo Contacto',
			'add_new_item'  => 'Nuevo Contacto',
			'edit_item'     => 'Editar Contacto',
			'new_item'      => 'Nuevo Contacto',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Contacto',
			'search_items'  => 'Buscar Contacto',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Contactos'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'contacto' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'contacto', $args );

	});