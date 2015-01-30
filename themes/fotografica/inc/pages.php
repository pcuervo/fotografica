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


	});
