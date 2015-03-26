<?php

get_header();
	// Obtener orden de las secciones
	$secciones = get_secciones_orden_home( 'ASC' );
	foreach ( $secciones as $key => $seccion ) {
		echo get_html_seccion( $seccion->seccion );
	}// foreach
get_footer();