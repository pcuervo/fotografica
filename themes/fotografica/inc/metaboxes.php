<?php


// CUSTOM METABOXES //////////////////////////////////////////////////////////////////



	add_action('add_meta_boxes', function(){

		// add_meta_box( id, title, name_meta_callback, post_type, context, priority );
		add_meta_box( 'evento_fecha_inicial', 'Fecha inicial del evento', 'metabox_evento_fecha_inicial', 'carteleras', 'advanced', 'high' );
		add_meta_box( 'evento_fecha_final', 'Fecha final del evento', 'metabox_evento_fecha_final', 'carteleras', 'advanced', 'high' );
		add_meta_box( 'video_proyecto', 'Video del proyecto', 'metabox_video_proyecto', 'proyectos', 'advanced', 'high' );
		add_meta_box( 'sidebar_trabajo', 'Sidebar de nuestro trabajo', 'metabox_sidebar_trabajo', 'nuestro-trabajo', 'advanced', 'high' );
		add_meta_box( 'video_trabajo', 'Video de nuestro trabajo', 'metabox_video_trabajo', 'nuestro-trabajo', 'advanced', 'high' );
		add_meta_box( 'fecha_nacimiento', 'Fecha de nacimieto', 'metabox_fecha_nacimiento', 'fotografos', 'advanced', 'high' );
		add_meta_box( 'detalles_fotografia', 'Detalles', 'metabox_detalles_fotografia', 'fotografias', 'advanced', 'high' );
		add_meta_box( 'video_exposicion', 'Exposición URL Video', 'metabox_video_exposicion', 'exposiciones', 'advanced', 'high' );
		add_meta_box( 'lugar_y_fecha_exposicion', 'Lugar y fecha', 'metabox_lugar_y_fecha_exposicion', 'exposiciones', 'advanced', 'high' );
		add_meta_box( 'links_exposicion', 'Links', 'metabox_links_exposicion', 'exposiciones', 'advanced', 'high' );
		add_meta_box( 'video_publicacion', 'Publicación URL Video', 'metabox_video_publicacion', 'publicaciones', 'advanced', 'high' );
		add_meta_box( 'info_publicacion', 'Información publicación', 'metabox_info_publicacion', 'publicaciones', 'advanced', 'high' );


	});



// CUSTOM METABOXES CALLBACK FUNCTIONS ///////////////////////////////////////////////

	function metabox_evento_fecha_inicial($post){
		$fecha_inicial = get_post_meta($post->ID, '_evento_fecha_inicial_meta', true);
		//$fecha_inicial = date('Y-m-d', $fecha_inicial);

		wp_nonce_field(__FILE__, '_evento_fecha_inicial_meta_nonce');

echo <<<END

	<label>Fecha inicial (AAAA-MM-DD):</label>
	<input type="text" class="widefat js-datepicker" id="lugar" name="_evento_fecha_inicial_meta" value="$fecha_inicial" />

END;
	}

	function metabox_evento_fecha_final($post){
		$fecha_final = get_post_meta($post->ID, '_evento_fecha_final_meta', true);
		//$fecha_final = date('Y-m-d', $fecha_final);

		wp_nonce_field(__FILE__, '_evento_fecha_final_meta_nonce');

echo <<<END

	<label>Fecha final (AAAA-MM-DD):</label>
	<input type="text" class="widefat js-datepicker" id="lugar" name="_evento_fecha_final_meta" value="$fecha_final" />

END;
	}

	function metabox_video_proyecto($post){
		$video_proyecto = get_post_meta($post->ID, '_evento_video_proyecto_meta', true);
		wp_nonce_field(__FILE__, '_evento_video_proyecto_meta_nonce');

echo <<<END

	<label>URL de video (Vimeo):</label>
	<input type="text" class="widefat" id="lugar" name="_evento_video_proyecto_meta" value="$video_proyecto" />

END;
	}


	function metabox_video_trabajo($post){
		$video_trabajo = get_post_meta($post->ID, '_video_trabajo_meta', true);
		wp_nonce_field(__FILE__, '_video_trabajo_meta_nonce');

echo <<<END

	<label>URL de video (Vimeo):</label>
	<input type="text" class="widefat" id="lugar" name="_video_trabajo_meta" value="$video_trabajo" />

END;
	}

	function metabox_sidebar_trabajo($post){
		$sidebar_trabajo = get_post_meta($post->ID, '_sidebar_trabajo_meta', true);
		wp_nonce_field(__FILE__, '_sidebar_trabajo_meta_nonce');

echo <<<END

	<label>Texto sidebar</label>
	<textarea class="widefat" rows="8" id="sidebar" name="_sidebar_trabajo_meta">$sidebar_trabajo</textarea>

END;
	}

	function metabox_fecha_nacimiento($post){
		$fecha_nacimiento = get_post_meta($post->ID, '_fecha_nacimiento_meta', true);
		wp_nonce_field(__FILE__, '_fecha_nacimiento_meta_nonce');

echo <<<END

	<label>Fecha de nacimiento:</label>
	<input type="text" class="widefat js-datepicker" id="lugar" name="_fecha_nacimiento_meta" value="$fecha_nacimiento" />

END;
	}// metabox_video_proyecto

	function metabox_detalles_fotografia($post){
		$detalles_fotografia = get_post_meta($post->ID, '_detalles_fotografia_meta', true);
		wp_nonce_field(__FILE__, '_detalles_fotografia_meta_nonce');

echo <<<END

	<label>Detalles de la fotografía</label>
	<input type="text" class="widefat" id="detalles" name="_detalles_fotografia_meta" value="$detalles_fotografia" />

END;
	}// metabox_detalles_fotografia

	function metabox_video_exposicion($post){
		$video_exposicion = get_post_meta($post->ID, '_video_exposicion_meta', true);

		wp_nonce_field(__FILE__, '_video_exposicion_meta_nonce');

echo <<<END

	<label>Video URL</label>
	<input type="text" class="widefat" id="video_exposicion" name="_video_exposicion_meta" value="$video_exposicion"></textarea>


END;
	}// metabox_video_exposicion

	function metabox_lugar_y_fecha_exposicion($post){
		$lugar_y_fecha_exposicion = get_post_meta($post->ID, '_lugar_y_fecha_exposicion_meta', true);

		$lugar_y_fecha_exposicion_editor_settings = array('textarea_name'=>'_lugar_y_fecha_exposicion_meta');
		wp_editor( htmlspecialchars_decode($lugar_y_fecha_exposicion), '_lugar_y_fecha_exposicion', $lugar_y_fecha_exposicion_editor_settings );

	}// metabox_lugar_y_fecha_exposicion

	function metabox_links_exposicion($post){
		$links_exposicion = get_post_meta($post->ID, '_links_exposicion_meta', true);

		$links_exposicion_editor_settings = array('textarea_name'=>'_links_exposicion_meta');
		wp_editor( htmlspecialchars_decode($links_exposicion), '_links_exposicion', $links_exposicion_editor_settings );

	}// metabox_links_exposicion

	function metabox_video_publicacion($post){
		$video_publicacion = get_post_meta($post->ID, '_video_publicacion_meta', true);
		wp_nonce_field(__FILE__, '_video_publicacion_meta_nonce');

echo <<<END

	<label>URL de video:</label>
	<input type="text" class="widefat" id="video_publicacion" name="_video_publicacion_meta" value="$video_publicacion" />

END;
	}

	function metabox_info_publicacion($post){
		$info_publicacion = get_post_meta($post->ID, '_info_publicacion_meta', true);

		$info_publicacion_editor_settings = array('textarea_name'=>'_info_publicacion_meta');
		wp_editor( htmlspecialchars_decode($info_publicacion), '_info_publicacion', $info_publicacion_editor_settings );

	}// metabox_links_exposicion

	function name_meta_callback($post){
		// $name = get_post_meta($post->ID, '_name_meta', true);
		// wp_nonce_field(__FILE__, '_name_meta_nonce');
		// echo "<input type='text' class='widefat' id='name' name='_name_meta' value='$name'/>";
	}



// SAVE METABOXES DATA ///////////////////////////////////////////////////////////////



	add_action('save_post', function($post_id){


		if ( ! current_user_can('edit_page', $post_id))
			return $post_id;


		if ( defined('DOING_AUTOSAVE') and DOING_AUTOSAVE )
			return $post_id;


		if ( wp_is_post_revision($post_id) OR wp_is_post_autosave($post_id) )
			return $post_id;


		if ( isset($_POST['_evento_fecha_inicial_meta']) and check_admin_referer(__FILE__, '_evento_fecha_inicial_meta_nonce') ){
			update_post_meta($post_id, '_evento_fecha_inicial_meta', $_POST['_evento_fecha_inicial_meta']);
		}

		if ( isset($_POST['_evento_fecha_final_meta']) and check_admin_referer(__FILE__, '_evento_fecha_final_meta_nonce') ){
			update_post_meta($post_id, '_evento_fecha_final_meta', $_POST['_evento_fecha_final_meta']);
		}

		if ( isset($_POST['_evento_video_proyecto_meta']) and check_admin_referer(__FILE__, '_evento_video_proyecto_meta_nonce') ){
			update_post_meta($post_id, '_evento_video_proyecto_meta', $_POST['_evento_video_proyecto_meta']);
		}

		if ( isset($_POST['_video_trabajo_meta']) and check_admin_referer(__FILE__, '_video_trabajo_meta_nonce') ){
			update_post_meta($post_id, '_video_trabajo_meta', $_POST['_video_trabajo_meta']);
		}

		if ( isset($_POST['_sidebar_trabajo_meta']) and check_admin_referer(__FILE__, '_sidebar_trabajo_meta_nonce') ){
			update_post_meta($post_id, '_sidebar_trabajo_meta', $_POST['_sidebar_trabajo_meta']);
		}

		if ( isset($_POST['_detalles_fotografia_meta']) and check_admin_referer(__FILE__, '_detalles_fotografia_meta_nonce') ){
			update_post_meta($post_id, '_detalles_fotografia_meta', $_POST['_detalles_fotografia_meta']);
		}

		if ( isset($_POST['_video_exposicion_meta']) and check_admin_referer(__FILE__, '_video_exposicion_meta_nonce') ){
			update_post_meta($post_id, '_video_exposicion_meta', $_POST['_video_exposicion_meta']);
		}

		if ( isset($_POST['_lugar_y_fecha_exposicion_meta']) ){
			$data = htmlspecialchars($_POST['_lugar_y_fecha_exposicion_meta']);
			update_post_meta($post_id, '_lugar_y_fecha_exposicion_meta', $data );
		}

		if ( isset($_POST['_links_exposicion_meta']) ){
			$data = htmlspecialchars($_POST['_links_exposicion_meta']);
			update_post_meta($post_id, '_links_exposicion_meta', $data );
		}

		if ( isset($_POST['_video_publicacion_meta']) and check_admin_referer(__FILE__, '_video_publicacion_meta_nonce') ){
			update_post_meta($post_id, '_video_publicacion_meta', $_POST['_video_publicacion_meta']);
		}

		if ( isset($_POST['_info_publicacion_meta']) ){
			$data = htmlspecialchars($_POST['_info_publicacion_meta']);
			update_post_meta($post_id, '_info_publicacion_meta', $data );
		}

	});



// OTHER METABOXES ELEMENTS //////////////////////////////////////////////////////////
