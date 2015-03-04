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
			'description'		=> 'ssss',
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

		// ESPACIOS PÚBLICOS
		$labels = array(
			'name'          => 'Espacios Públicos',
			'singular_name' => 'Espacios Público',
			'add_new'       => 'Nuevo Espacios Públicos',
			'add_new_item'  => 'Nuevo Espacios Públicos',
			'edit_item'     => 'Editar Espacios Públicos',
			'new_item'      => 'Nuevo Espacios Públicos',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Espacios Públicos',
			'search_items'  => 'Buscar Espacios Públicos',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Espacios Públicos'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'espacios-publicos' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'espacios-publicos', $args );

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

		// PUBLICACIONES DIGITALES
		$labels = array(
			'name'          => 'Publicaciones digitales',
			'singular_name' => 'Publicación digital',
			'add_new'       => 'Nueva Publicación digital',
			'add_new_item'  => 'Nueva Publicación digital',
			'edit_item'     => 'Editar Publicación digital',
			'new_item'      => 'Nueva Publicación digital',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Publicación digital',
			'search_items'  => 'Buscar Publicación digital',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Publicaciones digitales'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'publicacion-digital' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'publicacion-digital', $args );

		// NOTAS DE PRENSA
		$labels = array(
			'name'          => 'Notas de prensa',
			'singular_name' => 'Nota de prensa',
			'add_new'       => 'Nueva Nota de prensa',
			'add_new_item'  => 'Nueva Nota de prensa',
			'edit_item'     => 'Editar Nota de prensa',
			'new_item'      => 'Nueva Nota de prensa',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Nota de prensa',
			'search_items'  => 'Buscar Nota de prensa',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Notas de prensa'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'nota-prensa' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'notas-prensa', $args );

		// EVENTOS
		$labels = array(
			'name'          => 'Eventos',
			'singular_name' => 'Evento',
			'add_new'       => 'Nuevo Evento',
			'add_new_item'  => 'Nuevo Evento',
			'edit_item'     => 'Editar Evento',
			'new_item'      => 'Nuevo Evento',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Evento',
			'search_items'  => 'Buscar Evento',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Eventos'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'evento' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'eventos', $args );

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

		// NOTICIAS
		$labels = array(
			'name'          => 'Noticias',
			'singular_name' => 'Noticia',
			'add_new'       => 'Nueva Noticia',
			'add_new_item'  => 'Nueva Noticia',
			'edit_item'     => 'Editar Noticia',
			'new_item'      => 'Nueva Noticia',
			'all_items'     => 'Todas',
			'view_item'     => 'Ver Noticia',
			'search_items'  => 'Buscar Noticia',
			'not_found'     => 'No se encontro',
			'menu_name'     => 'Noticias'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'noticia' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'post_tag', 'category' ),
			'menu_position'      => 6,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'noticias', $args );

	});