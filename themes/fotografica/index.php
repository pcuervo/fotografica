<?php
	get_header();
?>

<section class="[ colecciones ] [ bg-image ]" style="background-image: url('http://fotografica.mx/juanguzman/wp-content/themes/juan-guzman/img/img1.jpg')">
	<div class="[ opacity-gradient square ]">
		<a href="/juanguzman" class="[ button button--hollow button--large ] [ center-full ]" target="_blank">
			Juan Guzmán
		</a>
		<div class="[ media-info media-info--large ] [ xmall-12 ]">
			<p class="[ text-center ]">La crónica citadina de Juan Guzmán. En donde no cabe un alfiler bien caben dos <span class="[ media--info__circa ]">ruleteros</span></p>
		</div>
	</div>
</section>
<?php
	// Obtener orden de las secciones 
	$secciones = get_secciones_orden_home(); 
	foreach ( $secciones as $key => $seccion ) {
		echo get_html_seccion( $seccion->seccion );
	}// foreach
get_footer();
