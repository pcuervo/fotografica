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
	endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('colecciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Colecciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">

				<!-- NOMBRE APELLIDO -->
				<?php if ( $authorColeccionesName == 'Autor no identificado' ){ ?>
					<span class="[ media--info__author ]"><?php echo $authorColeccionesName; ?></span>,
				<?php } else { ?>
					<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
				<?php } ?>

				<!-- TÍTULO -->
				<?php if ( $titleColecciones ){ ?>
					<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
				<?php } ?>

				<!-- DE LA SERIE -->
				<?php if ( $seriesColecciones ){ ?>
					de la serie <span class="[ media--info__series ]"><?php echo $seriesColecciones; ?></span>,
				<?php } ?>

				<!-- COLECCION -->
				<br /> de la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

				<!-- LUGAR -->
				<?php if ( $placeColecciones ){ ?>
					<span class="[ media--info__place ]"><?php echo $placeColeccionesName; ?></span>,
				<?php } ?>

				<!-- CIRCA -->
				<?php if ( $circaColecciones ){ ?>
					<span class="[ media--info__circa ]">circa </span>
				<?php } ?>

				<!-- AÑO -->
				<?php if ( $dateColecciones ){ ?>
					<span class="[ media--info__date ][ shown--medium shown--medium--inline ]"><?php echo $dateColeccionesName; ?></span>
				<?php } ?>
				</p>

				<!-- TAGS -->
				<div class="[ media-info__tags ] [ text-center ]">
					<?php
						$themeCounter = 1;
						if ( $themesColeccionesName ){
							foreach ($themesColeccionesName as $themeColeccionesName) {
								$themeColeccionesName = $themeColeccionesName->name; ?>
								<a href="<?php echo site_url('$themeColeccionesName'); ?>" class="[ tag ]">#<?php echo $themeColeccionesName; ?></a>
								<?php $themeCounter ++;
								if ( $themeCounter == 3 ){
									break;
								}
							}
						}
					?>
				</div>
			</div>
		</div>
	</section>




	<!-- /**************************************\ -->
	<!-- #SLIDES -->
	<!-- \**************************************/ -->
	<?php
	$bgSlides = '';
	$args = array(
		'post_type' 		=> 'slides',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$querySlides = new WP_Query( $args );
	if ( $querySlides->have_posts() ) : while ( $querySlides->have_posts() ) : $querySlides->the_post(); ?>
		<?php $bgSlides = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' ); ?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgSlides[0]; ?>)">
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
			<a href="<?php echo site_url().'/colecciones/?filtro=nuevas-adquisiciones'; ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Adquisiciones recientes
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
	$coleccionPublicaciones = '';
	$authorPublicaciones = '';
	$titlePublicaciones = '';
	$seriesPublicaciones = '';
	$placePublicaciones = '';
	$circaPublicaciones = 0;
	$datePublicaciones = '';
	$args = array(
		'post_type' 		=> 'publicaciones',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryPublicaciones = new WP_Query( $args );
	if ( $queryPublicaciones->have_posts() ) : while ( $queryPublicaciones->have_posts() ) : $queryPublicaciones->the_post(); ?>
		<?php

			$bgPublicaciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

			$coleccionPublicaciones 		= wp_get_post_terms( $post->ID, 'coleccion' );
			if ( $coleccionPublicaciones ){
				$coleccionPublicacionesName 	= $coleccionPublicaciones[0]->name;
				$coleccionPublicacionesSlug 	= $coleccionPublicaciones[0]->slug;
			}

			$authorPublicaciones 		= wp_get_post_terms( $post->ID, 'fotografo' );
			if ( $authorPublicaciones ){
				$authorPublicacionesName 	= $authorPublicaciones[0]->name;
				$authorPublicacionesSlug 	= $authorPublicaciones[0]->slug;
			} else {
				$authorPublicacionesName 	= 'sin autor';
			}

			$titlePublicaciones = get_the_title( $post->ID );
			if ( strpos($titlePublicaciones, 'Sin título') !== false OR $titlePublicaciones == '' OR strpos($titlePublicaciones, '&nbsp') !== false ){
				$titlePublicaciones = NULL;
			}

			$seriesPublicaciones = 0;

			$placePublicaciones = wp_get_post_terms( $post->ID, 'lugar' );
			if ( $placePublicaciones ){
				$placePublicacionesName 	= $placePublicaciones[0]->name;
			}

			$circaPublicaciones = 0;

			$datePublicaciones = wp_get_post_terms( $post->ID, 'año' );
			if ( $datePublicaciones ){
				$datePublicacionesName 	= $datePublicaciones[0]->name;
			} else {
				$datePublicacionesName 	= 's/f';
			}

			$themesPublicaciones = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesPublicaciones ){
				$themesPublicacionesName 	= '';
			}

			$permalinkPublicacion = get_permalink( $post->ID );
	endwhile; endif; wp_reset_query(); ?>
	<section class="[ publicaciones ] [ bg-image ]" style="background-image: url(<?php echo $bgPublicaciones[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('publicaciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Publicaciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">

				<!-- COLECCION -->
				<?php if ( $coleccionPublicaciones ){ ?>
					De la colección <a href="<?php echo site_url( $coleccionPublicacionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionPublicacionesName; ?></a>,
				<?php } ?>

				<!-- NOMBRE APELLIDO -->
				<?php if ( $authorPublicacionesName == 'sin autor' ){ ?>
					<span><?php echo $authorPublicacionesName; ?></span>,
				<?php } else { ?>
					<a href="<?php echo site_url( $authorPublicacionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorPublicacionesName;?></a>,
				<?php } ?>

				<!-- TÍTULO -->
				<?php if ( $titlePublicaciones ){ ?>
					<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titlePublicaciones; ?></a>,
				<?php } else { ?>
					<span class="[ media--info__name ]">sin título</span>,
				<?php } ?>

				<!-- DE LA SERIE -->
				<?php if ( $seriesPublicaciones ){ ?>
					de la serie <span class="[ media--info__series ]"><?php echo $seriesPublicaciones; ?></span>,
				<?php } ?>

				<!-- LUGAR -->
				<?php if ( $placePublicaciones ){ ?>
					<span class="[ media--info__place ]"><?php echo $placePublicacionesName; ?></span>,
				<?php } ?>

				<!-- CIRCA -->
				<?php if ( $circaPublicaciones ){ ?>
					<span class="[ media--info__circa ]">circa</span>
				<?php } ?>

				<!-- AÑO -->
				<?php if ( $datePublicaciones ){ ?>
					<span class="[ media--info__date ]"><?php echo $datePublicacionesName; ?></span>
				<?php } ?>
				</p>

				<!-- TAGS -->
				<div class="[ media-info__tags ] [ text-center ]">
					<?php
						$themeCounter = 1;
						if ( $themesPublicacionesName ){
							foreach ($themesPublicacionesName as $themePublicacionesName) {
								$themePublicacionesName = $themePublicacionesName->name; ?>
								<a href="<?php echo site_url('$themePublicacionesName'); ?>" class="[ tag ]">#<?php echo $themePublicacionesName; ?></a>
								<?php $themeCounter ++;
								if ( $themeCounter == 3 ){
									break;
								}
							}
						}
					?>
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