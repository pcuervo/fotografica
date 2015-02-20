<?php


// CUSTOM PAGES //////////////////////////////////////////////////////////////////////


	add_action('init', function(){


		// COLECCIONES
		if( ! get_page_by_path('colecciones') ){
			$page = array(
				'post_author' => 1,
				'post_status' => 'publish',
				'post_title'  => 'Colecciones',
				'post_name'   => 'colecciones',
				'post_type'   => 'page'
			);
			wp_insert_post( $page, true );
		}

		// CONTÁCTANOS
		if( ! get_page_by_path('contactanos') ){
			$page = array(
				'post_author' => 1,
				'post_status' => 'publish',
				'post_title'  => 'Contáctanos',
				'post_name'   => 'contactanos',
				'post_type'   => 'page'
			);
			wp_insert_post( $page, true );
		}

		// CONÓCENOS
		if( ! get_page_by_path('conocenos') ){
			$page = array(
				'post_author' => 1,
				'post_status' => 'publish',
				'post_title'  => 'Conócenos',
				'post_name'   => 'conocenos',
				'post_type'   => 'page'
			);
			wp_insert_post( $page, true );
		}

		// CONSERVACIÓN
		if( ! get_page_by_path('conservacion') ){
			$page = array(
				'post_author' => 1,
				'post_status' => 'publish',
				'post_title'  => 'Conservación',
				'post_name'   => 'conservacion',
				'post_type'   => 'page'
			);
			wp_insert_post( $page, true );
		}

		// INVESTIGACIÓN
		if( ! get_page_by_path('investigacion') ){
			$page = array(
				'post_author' => 1,
				'post_status' => 'publish',
				'post_title'  => 'Investigación',
				'post_name'   => 'investigacion',
				'post_type'   => 'page'
			);
			wp_insert_post( $page, true );
		}


	});
