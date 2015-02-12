<?php get_header();
	the_post();
	the_post_thumbnail('full', array('class' => '[ margin-bottom ] [ full-height ]'));

	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();

	$taxonomia = '';
	if ( $postType == 'colecciones' ){
		$taxonomia = 'coleccion';
	} elseif ( $postType == 'proyectos' ){
		$taxonomia = 'tipo-de-proyecto';
	}

	if($taxonomia != ''){
		$bgColecciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );
		$coleccionColecciones 		= wp_get_post_terms( $post->ID, $taxonomia );
		$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
		$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;
	}

	$authorColecciones 			= wp_get_post_terms( $post->ID, 'fotografo' );
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


	<section class="[ margin-bottom--large ]">
		<div class="[ media-info media-info__dark ] [ relative ] [ xmall-12 ]">
			<p class="[ text-center ]">

				<!--  /********************************\ -->
					<!-- #COLECCIONES -->
				<!--  \**********************************/ -->
				<?php if ( $postType == 'colecciones' ){ ?>

					<!-- COLECCION -->
					De la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName == 'sin autor' ){ ?>
						<span><?php echo $authorColeccionesName; ?></span>,
					<?php } else { ?>
						<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
					<?php } ?>

					<!-- TÍTULO -->
					<?php if ( $titleColecciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
					<?php } else { ?>
						<span class="[ media--info__name ]">sin título</span>,
					<?php } ?>

					<!-- DE LA SERIE -->
					<?php if ( $seriesColecciones ){ ?>
						de la serie <span class="[ media--info__series ]"><?php echo $seriesColecciones; ?></span>,
					<?php } ?>

					<!-- LUGAR -->
					<?php if ( $placeColecciones ){ ?>
						<span class="[ media--info__place ]"><?php echo $placeColeccionesName; ?></span>,
					<?php } ?>

					<!-- CIRCA -->
					<?php if ( $circaColecciones ){ ?>
						<span class="[ media--info__circa ]">circa</span>
					<?php } ?>

					<!-- AÑO -->
					<?php if ( $dateColecciones ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
					<?php } ?>
				<?php } ?>


				<!--  /********************************\ -->
					<!-- #PROYECTOS -->
				<!--  \**********************************/ -->
				<?php if ( $postType == 'proyectos' ){ ?>
					<span class="[ media--info__name]"> <?php the_title( ); ?></span>
				<?php } ?>
			</p>
		</div>
		<div class="[ filters__results ] [ padding--small text-center ]">
			<a class="[ filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Manuel Álvarez Bravo</a>
			<a class="[ filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">#méxico</a>
			<a class="[ filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">1960</a>
		</div>
	</section>
	<section class="[ share ] [ margin-bottom--large ]">
		<div class="[ wrapper ][ clearfix ]">
			<div class="[ clearfix ][ columna medium-4 center ]">
				<div class="[ button button--dark button__share ] [ columna xmall-3 ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-twitter"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ]">54</span>
				</div>
				<div class="[ button button--dark button__share ] [ columna xmall-3 ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-facebook-square"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ]">399</span>
				</div>
				<div class="[ button button--dark button__share ] [ columna xmall-3 ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-instagram"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ]">9</span>
				</div>
				<div class="[ button button--dark button__share ] [ columna xmall-3 ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-heart"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ]">9999</span>
				</div>
			</div>
		</div><!-- .wrapper -->
	</section><!-- .share -->
	<section class="[ margin-bottom--large ][ single-content ]">
		<div class="[ wrapper ][ ]">
			<?php the_content(); ?>
		</div><!-- .wrapper -->
	</section>
	<?php
	// db563839239
	if( $post_type != 'fotografos') { ?>
		<section class="[ margin-bottom ]">
			<h2 class="[ title ] [ text-center ]">Te puede interesar</h2>

			<div class="[ wrapper ]">
				<div class="[ row ]">
					<?php

					// Jalar taxonomía y termino al azar para fotos relacionadas
					$tax = get_object_taxonomies( $post );
					$random_tax = rand(0, count($tax)-1);
					$terms = wp_get_post_terms( $post->ID, $tax[$random_tax] );

					while( count($terms) == 0 ) {
						$random_tax = rand(0, count($tax)-1);
						$terms = wp_get_post_terms( $post->ID, $tax[$random_tax] );
					} 
					$random_term = rand(0, count($terms)-1);					

					$counter = 1;
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
						'posts_per_page' 	=> 3,
						'orderby' 			=> 'rand',
						'post__not_in'		=> array($post->ID),
						'tax_query'			=> array(
							array(
								'taxonomy'	=> $tax[$random_tax],
								'terms'		=> $terms[$random_term],
							),
						),
					);
					$queryFotografias = new WP_Query( $args );
					if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post();

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
						<article class="[ relacionadas ] [ bg-image ] [ span xmall-12 medium-6 ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
							<div class="[ opacity-gradient <?php echo ( $counter == 1 ) ? '[ square square-absolute ]' : '[ rectangle rectangle-absolute ]' ?> ]">
								<a class="[ block ][ media-link ]" href="<?php echo $permalinkColeccion; ?>"></a>
								<div class="[ media-info media-info--small ] [ xmall-12 ]">
									<p class="[ text-center ]">

										<!-- NOMBRE APELLIDO -->
										<?php if ( $authorColeccionesName == 'sin autor' ){ ?>
											<span><?php echo $authorColeccionesName; ?></span>,
										<?php } else { ?>
											<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
										<?php } ?>

										<!-- TÍTULO -->
										<?php if ( $titleColecciones ){ ?>
											<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
										<?php } else { ?>
											<span class="[ media--info__name ]">sin título</span>,
										<?php } ?>

										<!-- DE LA SERIE -->
										<?php if ( $seriesColecciones ){ ?>
											de la serie <span class="[ media--info__series ]"><?php echo $seriesColecciones; ?></span>,
										<?php } ?>

										<!-- LUGAR -->
										<?php if ( $placeColecciones ){ ?>
											<span class="[ media--info__place ]"><?php echo $placeColeccionesName; ?></span>,
										<?php } ?>

										<!-- CIRCA -->
										<?php if ( $circaColecciones ){ ?>
											<span class="[ media--info__circa ]">circa</span>
										<?php } ?>

										<!-- AÑO -->
										<?php if ( $dateColecciones ){ ?>
											<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
										<?php } ?>
									</p>
								</div>
							</div>
						</article>
					<?php $counter++; endwhile; endif; wp_reset_query(); ?>
				</div><!-- row -->
			</div><!-- wrapper -->
		</section><!-- .results -->
	<?php } ?>
	<div class="[ lightbox ] [ cycle-slideshow ]">

		<?php
			$attachedMediaArgs = array(
				'post_type' => 'attachment',
				'post_mime_type'=>'image',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => $post->ID
			);
			$attachedMedia = get_embedded_media('imsage', $attachedMediaArgs);
			// echo '<pre>';
			// 	print_r($attachedMedia);
			// echo '</pre>';

		?>
		<div class="[ image-single ]">
			<div class="[ wrapper ]">
				<img class="[ image-responsive ]" src="<?php echo THEMEPATH; ?>images/test-9.jpg" alt="">
				<p class="[ image-caption ] [ text-center ]">Retrato de Gerardo Murillo “Dr. atl”, Ciudad de México, ca. 1956</p>
			</div><!-- wrapper -->
		</div>
		<div class="[ image-single ]">
			<div class="[ wrapper ]">
				<img class="[ image-responsive ]" src="<?php echo THEMEPATH; ?>images/test-7.jpg" alt="">
				<p class="[ image-caption ] [ text-center ]">Retrato de Gerardo Murillo “Dr. atl”, Ciudad de México, ca. 1956</p>
			</div><!-- wrapper -->
		</div>
	</div><!-- .lightbox -->
<?php get_footer(); ?>