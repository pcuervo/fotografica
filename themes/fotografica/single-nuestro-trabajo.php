<?php
	get_header();
	the_post();

	$video_trabajo = get_post_meta($post->ID, '_video_trabajo_meta', true);

	$featuredImageID 			= get_post_thumbnail_id();
	$featuredImagePostIDArray 	= get_post_id_by_attachment_id($featuredImageID);
	$featuredImagePostID 		= $featuredImagePostIDArray[0]->post_id;

	$bgColecciones = wp_get_attachment_image_src( get_post_thumbnail_id( $featuredImagePostID ),'full' );
	$coleccionColecciones 		= wp_get_post_terms( $featuredImagePostID, 'coleccion' );
	$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
	$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;

	$authorColecciones 		= wp_get_post_terms( $featuredImagePostID, 'fotografo' );
	if ( $authorColecciones ){
		$authorColeccionesName 	= $authorColecciones[0]->name;
		$authorColeccionesSlug 	= $authorColecciones[0]->slug;
	} else {
		$authorColeccionesName 	= 'autor no identificado';
	}

	$titleColecciones = get_the_title( $featuredImagePostID );
	if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
		$titleColecciones = NULL;
	}

	$seriesColecciones = 0;

	$placeColecciones = wp_get_post_terms( $featuredImagePostID, 'lugar' );
	if ( $placeColecciones ){
		$placeColeccionesName 	= $placeColecciones[0]->name;
	}

	$circaColecciones = 0;

	$dateColecciones = wp_get_post_terms( $featuredImagePostID, 'año' );
	if ( $dateColecciones ){
		$dateColeccionesName 	= $dateColecciones[0]->name;
	} else {
		$dateColeccionesName 	= 's/f';
	}

	$themesColecciones = wp_get_post_terms( $featuredImagePostID, 'tema' );
	if ( ! $themesColecciones ){
		$themesColeccionesName 	= '';
	}

	$permalinkColeccion = get_permalink( $featuredImagePostID );
?>
	<section class="[ colecciones ][ bg-image ][ margin-bottom ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php the_title(); ?>
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--large ]">
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
					<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
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
	<section class="[ margin-bottom--large ][ single-content ]">
		<div class="[ wrapper ]">
			<div class="[ row ]">
				<aside class="[ shown--large ][ columna medium-2 large-3 ][ text-right serif--italic ]">
					<p><a href="#"><?php echo $video_trabajo; ?></a></p>
				</aside>
				<div class="[ columna small-12 medium-10 large-6 xxlarge-4 center ]">
					<?php the_content(); ?>
				</div>
			</div>
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

					if(empty($tax)){
						$terms = [];
					} else {
						$terms = wp_get_post_terms( $post->ID, $tax[$random_tax] );
						$term_test = wp_get_post_terms( $post->ID, $tax[0] );

						$i = 0;
						while( count($terms) == 0 ) {
							$i++;
							if( $i > 50 ) break;
							$random_tax = rand(0, count($tax)-1);
							$terms = wp_get_post_terms( $post->ID, $tax[$random_tax] );
						}
						$random_term = rand(0, count($terms)-1);
					}


					$counter = 1;
					$bgColecciones = '';
					$coleccionColecciones = '';
					$authorColecciones = '';
					$titleColecciones = '';
					$seriesColecciones = '';
					$placeColecciones = '';
					$circaColecciones = 0;
					$dateColecciones = '';
					if(empty($terms)){
						$args = array(
							'post_type' 		=> 'fotografias',
							'posts_per_page' 	=> 3,
							'orderby' 			=> 'rand',
							'post__not_in'		=> array($post->ID),
						);
					} else {
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
					}

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
							$authorColeccionesName 	= 'autor no identificado';
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

										<!-- CIRCA -->
										<?php if ( $circaColecciones ){ ?>
											<span class="[ media--info__circa ]">circa </span>
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
			//$attachedMedia = get_embedded_media('imsage', $attachedMediaArgs);
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
	<script type="text/javascript" src="https://addthisevent.com/libs/ate-latest.min.js"></script>
<?php get_footer(); ?>