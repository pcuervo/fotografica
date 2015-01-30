<?php get_header(); ?>

	<!-- /**************************************\ -->
	<!-- #COLECCIONES -->
	<!-- \**************************************/ -->
	<?php
	$bgColecciones = '';
	$coleccionColecciones = '';
	$authorColecciones = '';
	$titleColecciones = '';
	$seriesColecciones = '';
	$placeColecciones = '';
	$circaColecciones = 0;
	$dateColecciones = '';
	$args = array(
		'post_type' 		=> 'fotografias',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryFotografias = new WP_Query( $args );
	if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post(); ?>
		<?php

			$bgColecciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

			$coleccionColecciones 		= wp_get_post_terms( $post->ID, 'coleccion' );
			$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
			$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;

			$authorColecciones 		= wp_get_post_terms( $post->ID, 'fotografo' );
			if ( $authorColecciones ){
				$authorColeccionesName 	= $authorColecciones[0]->name;
				$authorColeccionesSlug 	= $authorColecciones[0]->slug;
			} else {
				$authorColeccionesName 	= 'sin autor';
			}

			$titleColecciones = get_the_title( $post->ID );
			if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
				$titleColecciones = NULL;
			}

			$seriesColecciones = 0;

			$placeColecciones = wp_get_post_terms( $post->ID, 'lugar' );
			if ( $placeColecciones ){
				$placeColeccionesName 	= $placeColecciones[0]->name;
			}

			$circaColecciones = 0;

			$dateColecciones = wp_get_post_terms( $post->ID, 'año' );
			if ( $dateColecciones ){
				$dateColeccionesName 	= $dateColecciones[0]->name;
			} else {
				$dateColeccionesName 	= 's/f';
			}

			$themesColecciones = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesColecciones ){
				$themesColeccionesName 	= '';
			}

			$permalinkColeccion = get_permalink( $post->ID );
		?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('colecciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Colecciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">
					<!-- / -->
						<!-- COLECCION -->
					<!-- / -->
					De la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

					<!-- / -->
						<!-- NOMBRE APELLIDO -->
					<!-- / -->
					<?php if ( $authorColeccionesName == 'sin autor' ){ ?>
						<span class="[ media--info__author ]"><?php echo $authorColeccionesName; ?></span>,
					<?php } else { ?>
						<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
					<?php } ?>

					<!-- / -->
						<!-- TÍTULO -->
					<!-- / -->
					<?php if ( $titleColecciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
					<?php } else { ?>
						<span class="[ media--info__name ]">sin título</span>,
					<?php } ?>


					<!-- / -->
						<!-- DE LA SERIE -->
					<!-- / -->
					<?php if ( $seriesColecciones ){ ?>
						de la serie <span class="[ media--info__series ]"><?php echo $seriesColecciones; ?></span>,
					<?php } ?>

					<!-- / -->
						<!-- LUGAR -->
					<!-- / -->
					<?php if ( $placeColecciones ){ ?>
						<span class="[ media--info__place ]"><?php echo $placeColeccionesName; ?></span>,
					<?php } ?>

					<!-- / -->
						<!-- CIRCA -->
					<!-- / -->
					<?php if ( $circaColecciones ){ ?>
						<span class="[ media--info__circa ]">circa</span>
					<?php } ?>

					<!-- / -->
						<!-- AÑO -->
					<!-- / -->
					<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
				</p>

				<!-- / -->
					<!-- TAGS -->
				<!-- / -->
				<div class="[ media-info__tags ] [ text-center ]">
					<?php
						if ( $themesColeccionesName ){
							foreach ($themesColeccionesName as $themeColeccionesName) {
								$themeColeccionesName = $themeColeccionesName->name;
							}
						}
					?>
					<a href="#" class="[ tag ]">#méxico</a>
					<a href="#" class="[ tag ]">#norte</a>
					<a href="#" class="[ tag ]">#transporte</a>
				</div>
			</div>
		</div>
	</section>




	<!-- /**************************************\ -->
	<!-- #EXTRA -->
	<!-- \**************************************/ -->
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo THEMEPATH; ?>images/test-2.jpg)">
		<div class="[ opacity-gradient square ]">
			<a class="[ button button--hollow button--large ] [ center-full ]">
				<i class="icon-play"></i>
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]"><a href="#" class="[ media-info__author ]">Gerardo Suter</a>, <a href="#" class="[ media-info__name ]">El trapo negro</a>, <span class="[ media--info__place ]">Egipto</span>, <span class="[ media--info__date ]">1986</span>, de la colección <a href="#" class="[ media--info__colection ]">Manuél Álvarez Bravo</a></p>
			</div>
		</div>
	</section>




	<!-- /**************************************\ -->
	<!-- #NUEVAS ADQUISICIONES -->
	<!-- \**************************************/ -->
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo THEMEPATH; ?>images/test-3.jpg)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('nuevas-adquisiciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Nuevas adquisiciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]"><a href="#" class="[ media-info__author ]">Gerardo Suter</a>, <a href="#" class="[ media-info__name ]">El trapo negro</a>, <span class="[ media--info__place ]">Egipto</span>, <span class="[ media--info__date ]">1986</span>, de la colección <a href="#" class="[ media--info__colection ]">Manuél Álvarez Bravo</a></p>
				<div class="[ media-info__tags ] [ text-center ]">
					<a href="#" class="[ tag ]">#méxico</a>
					<a href="#" class="[ tag ]">#norte</a>
					<a href="#" class="[ tag ]">#transporte</a>
				</div>
			</div>
		</div>
	</section>




	<!-- /**************************************\ -->
	<!-- #PROYECTOS -->
	<!-- \**************************************/ -->
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo THEMEPATH; ?>images/test-4.jpg)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('proyectos'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Proyectos
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]"><a href="#" class="[ media-info__author ]">Gerardo Suter</a>, <a href="#" class="[ media-info__name ]">El trapo negro</a>, <span class="[ media--info__place ]">Egipto</span>, <span class="[ media--info__date ]">1986</span>, de la colección <a href="#" class="[ media--info__colection ]">Manuél Álvarez Bravo</a></p>
				<div class="[ media-info__tags ] [ text-center ]">
					<a href="#" class="[ tag ]">#méxico</a>
					<a href="#" class="[ tag ]">#norte</a>
					<a href="#" class="[ tag ]">#transporte</a>
				</div>
			</div>
		</div>
	</section>




	<!-- /**************************************\ -->
	<!-- #PUBLICACIONES -->
	<!-- \**************************************/ -->
	<?php
	$bgPublicaciones = '';
	$args = array(
		'post_type' 		=> 'publicaciones',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryPublicaciones = new WP_Query( $args );
	if ( $queryPublicaciones->have_posts() ) : while ( $queryPublicaciones->have_posts() ) : $queryPublicaciones->the_post(); ?>
		<?php $bgPublicaciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' ); ?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgPublicaciones[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('publicaciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Publicaciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]"><a href="#" class="[ media-info__author ]">Gerardo Suter</a>, <a href="#" class="[ media-info__name ]">El trapo negro</a>, <span class="[ media--info__place ]">Egipto</span>, <span class="[ media--info__date ]">1986</span>, de la colección <a href="#" class="[ media--info__colection ]">Manuél Álvarez Bravo</a></p>
				<div class="[ media-info__tags ] [ text-center ]">
					<a href="#" class="[ tag ]">#méxico</a>
					<a href="#" class="[ tag ]">#norte</a>
					<a href="#" class="[ tag ]">#transporte</a>
				</div>
			</div>
		</div>
	</section>



	<!-- /**************************************\ -->
	<!-- #EXPOSICIONES -->
	<!-- \**************************************/ -->
	<?php
	$bgExposiciones = '';
	$args = array(
		'post_type' 		=> 'exposiciones',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryExposiciones = new WP_Query( $args );
	if ( $queryExposiciones->have_posts() ) : while ( $queryExposiciones->have_posts() ) : $queryExposiciones->the_post(); ?>
		<?php $bgExposiciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' ); ?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgExposiciones[0] ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('exposiciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Exposiciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]"><a href="#" class="[ media-info__author ]">Gerardo Suter</a>, <a href="#" class="[ media-info__name ]">El trapo negro</a>, <span class="[ media--info__place ]">Egipto</span>, <span class="[ media--info__date ]">1986</span>, de la colección <a href="#" class="[ media--info__colection ]">Manuél Álvarez Bravo</a></p>
				<div class="[ media-info__tags ] [ text-center ]">
					<a href="#" class="[ tag ]">#méxico</a>
					<a href="#" class="[ tag ]">#norte</a>
					<a href="#" class="[ tag ]">#transporte</a>
				</div>
			</div>
		</div>
	</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>