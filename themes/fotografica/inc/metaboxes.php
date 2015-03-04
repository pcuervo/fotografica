<?php


// CUSTOM METABOXES //////////////////////////////////////////////////////////////////



	add_action('add_meta_boxes', function(){

		// add_meta_box( id, title, name_meta_callback, post_type, context, priority );
		add_meta_box( 'evento_fecha_inicial', 'Fecha inicial del evento', 'metabox_evento_fecha_inicial', 'carteleras', 'advanced', 'high' );
		add_meta_box( 'evento_fecha_final', 'Fecha final del evento', 'metabox_evento_fecha_final', 'carteleras', 'advanced', 'high' );
		add_meta_box( 'video_proyecto', 'Video del proyecto', 'metabox_video_proyecto', 'proyectos', 'advanced', 'high' );
		add_meta_box( 'video_trabajo', 'Video de nuestro trabajo', 'metabox_video_trabajo', 'nuestro-trabajo', 'advanced', 'high' );
		add_meta_box( 'fecha_nacimiento', 'Fecha de nacimieto', 'metabox_fecha_nacimiento', 'fotografos', 'advanced', 'high' );

	});



// CUSTOM METABOXES CALLBACK FUNCTIONS ///////////////////////////////////////////////

	function metabox_evento_fecha_inicial($post){
		$fecha_inicial = get_post_meta($post->ID, '_evento_fecha_inicial_meta', true);
		//$fecha_inicial = date('Y-m-d', $fecha_inicial);

		wp_nonce_field(__FILE__, '_evento_fecha_inicial_meta_nonce');

echo <<<END

	<label>Fecha inicial (AAAA-MM-DD):</label>
	<input type="text" class="widefat" id="lugar" name="_evento_fecha_inicial_meta" value="$fecha_inicial" />

END;
	}

	function metabox_evento_fecha_final($post){
		$fecha_final = get_post_meta($post->ID, '_evento_fecha_final_meta', true);
		//$fecha_final = date('Y-m-d', $fecha_final);

		wp_nonce_field(__FILE__, '_evento_fecha_final_meta_nonce');

echo <<<END

	<label>Fecha final (AAAA-MM-DD):</label>
	<input type="text" class="widefat" id="lugar" name="_evento_fecha_final_meta" value="$fecha_final" />

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

	function metabox_fecha_nacimiento($post){
		$fecha_nacimiento = get_post_meta($post->ID, '_fecha_nacimiento_meta', true);
		wp_nonce_field(__FILE__, '_fecha_nacimiento_nonce');

echo <<<END

	<label>Fecha de nacimiento:</label>
	<input type="text" class="widefat js-datepicker" id="lugar" name="_fecha_nacimiento_meta" value="$fecha_nacimiento" />

END;
	}// metabox_video_proyecto

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
			//$timestamp = strtotime($_POST['_evento_fecha_inicial_meta']);
			update_post_meta($post_id, '_evento_fecha_inicial_meta', $_POST['_evento_fecha_inicial_meta']);
		}

		if ( isset($_POST['_evento_fecha_final_meta']) and check_admin_referer(__FILE__, '_evento_fecha_final_meta_nonce') ){
			//$timestamp = strtotime($_POST['_evento_fecha_final_meta']);
			update_post_meta($post_id, '_evento_fecha_final_meta', $_POST['_evento_fecha_final_meta']);
		}

		if ( isset($_POST['_evento_video_proyecto_meta']) and check_admin_referer(__FILE__, '_evento_video_proyecto_meta_nonce') ){
			//$timestamp = strtotime($_POST['_evento_video_proyecto_meta']);
			update_post_meta($post_id, '_evento_video_proyecto_meta', $_POST['_evento_video_proyecto_meta']);
		}

		if ( isset($_POST['_video_trabajo_meta']) and check_admin_referer(__FILE__, '_video_trabajo_meta_nonce') ){
			//$timestamp = strtotime($_POST['_video_trabajo_meta']);
			update_post_meta($post_id, '_video_trabajo_meta', $_POST['_video_trabajo_meta']);
		}


	});



// OTHER METABOXES ELEMENTS //////////////////////////////////////////////////////////
