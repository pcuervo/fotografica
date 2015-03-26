<?php get_header(); ?>
<?php
	// Obtener orden de las secciones 
	$secciones = get_secciones_orden_home(); 
	foreach ( $secciones as $key => $seccion ) {
		echo get_html_seccion( $seccion->seccion );
	}// foreach
?>	

<?php get_sidebar(); ?>
<?php get_footer(); ?>