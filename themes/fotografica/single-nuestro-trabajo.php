<?php
	get_header();
	the_post();

	// Get number of shares current page
	global $current_link;
	$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$num_shares_url = "http://api.facebook.com/restserver.php?method=links.getStats&urls=".$current_link;
	$fb_stats = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&urls=http://pcuervo.com/fotografica/fotografias/sin-titulo-17/');

	$sidebar_trabajo = get_post_meta($post->ID, '_sidebar_trabajo_meta', true);

	$video_trabajo = get_post_meta($post->ID, '_video_trabajo_meta', true);
	$videoHost = NULL;
	$video_src = '';
	if (strpos($video_trabajo,'youtube') !== false) {
		$videoHost = 'youtube';
	}
	if (strpos($video_trabajo,'vimeo') !== false) {
		$videoHost = 'vimeo';
	}
	if( $videoHost ){
		$video_src = get_video_src($video_trabajo, $videoHost);
	}

	$featuredImagePostID = '';
	$featuredImageID = get_post_thumbnail_id();

	$featuredImagePostIDArray = 0;
	if ( $featuredImageID != '' ){
		$featuredImagePostID = get_post_id_by_attachment_id( $featuredImageID );
	}
	if ( $featuredImagePostID ){
		$bgColecciones = wp_get_attachment_image_src( get_post_thumbnail_id( $featuredImagePostID->post_id ),'full' );
		$coleccionColecciones 		= wp_get_post_terms( $featuredImagePostID->post_id, 'coleccion' );

		if( $coleccionColecciones ){
			$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
			$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;
		}


		$authorColecciones 		= wp_get_post_terms( $featuredImagePostID->post_id, 'fotografo' );
		if ( $authorColecciones ){
			$authorColeccionesName 	= $authorColecciones[0]->name;
			$authorColeccionesSlug 	= $authorColecciones[0]->slug;
		} else {
			$authorColeccionesName 	= 'Autor no identificado';
		}

		$titleColecciones = get_the_title( $featuredImagePostID->post_id );
		if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
			$titleColecciones = NULL;
		}

		$seriesColecciones = 0;

		$placeColecciones = wp_get_post_terms( $featuredImagePostID->post_id, 'lugar' );
		if ( $placeColecciones ){
			$placeColeccionesName 	= $placeColecciones[0]->name;
		}

		if ( in_category('circa', $post->ID ) ){
			$circaColecciones = true;
		}

		$dateColecciones = wp_get_post_terms( $featuredImagePostID->post_id, 'año' );
		if ( $dateColecciones ){
			$dateColeccionesName 	= $dateColecciones[0]->name;
		} else {
			$dateColeccionesName 	= 's/f';
		}

		$themesColecciones = wp_get_post_terms( $featuredImagePostID->post_id, 'tema' );
		if ( ! $themesColecciones ){
			$themesColeccionesName 	= '';
		}

		$permalinkColeccion = get_permalink( $featuredImagePostID->post_id );
	?>
		<section class="[ colecciones ][ bg-image ][ margin-bottom ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
			<div class="[ opacity-gradient rectangle ]">
				<h2 class="[ center-full ] [ title ]">
					<?php the_title(); ?>
				</h2>
				<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--large ]">
					<p class="[ text-center ]">


					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName !== 'Autor no identificado' ){ ?>
						<span class="[ media--info__author ]"><?php echo $authorColeccionesName; ?></span>,
					<?php }  ?>

					<!-- TÍTULO -->
					<?php if ( $titleColecciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
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
					<?php //if ( $circaColecciones ){ ?>
						<!-- <span class="[ media--info__circa ]">ca. </span> -->
					<?php //} ?>

					<!-- AÑO -->
					<?php if ( $dateColecciones ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
					<?php } ?>

					<!-- COLECCION -->
					<?php if ( $coleccionColecciones ){ ?>
						<br /> de la colección <a href="<?php echo site_url() . '/colecciones?coleccion=' . $coleccionColeccionesSlug; ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>
					<?php } ?>

					</p>
				</div>
			</div>
		</section>
	<?php }
	if ( ! empty($video_src) ){ ?>
		<section class="[ margin-bottom--large ][ single-content ]">
			<div class="[ wrapper ]">
				<div class="[ row ]">
					<div class="[ columna small-12 medium-10 large-6 xxlarge-4 center ]">
						<?php if ( $video_src ){ ?>
							<div class="[ margin-bottom ][ fit-vids-wrapper ]">
							<?php if ( $videoHost == 'vimeo' ){ ?>
								<iframe src="https:<?php echo $video_src; ?>?color=1aa2dc&title=0&byline=0&portrait=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							<?php } ?>
							<?php if ( $videoHost == 'youtube' ){ ?>
								<iframe src="https:<?php echo $video_src; ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
							<?php } ?>
							</div>
						<?php }
						the_content(); ?>
					</div>
				</div>
			</div><!-- .wrapper -->
		</section>
	<?php } ?>
	<section class="[ margin-bottom--large ][ single-content ]">
		<div class="[ wrapper ]">
			<div class="[ row ]">
				<aside class="[ shown--large ][ columna medium-2 large-3 ][ text-right serif--italic ]">
					<p><a href="<?php echo $sidebar_trabajo; ?>" target="_blank" ><?php echo $sidebar_trabajo; ?></a></p>
				</aside>
				<div class="[ columna small-12 medium-10 large-6 xxlarge-4 center ]">
					<?php the_content(); ?>
				</div>
			</div>
		</div><!-- .wrapper -->
	</section>
	<section class="[ margin-bottom ]">
		<div class="[ wrapper ]">
			<div class="[ row ]">
				<h2 class="[ title ] [ text-center ]">Te puede interesar</h2>
				<?php

				$extraPostType = array('proyectos', 'publicaciones', 'exposiciones');
				$postTypeRand = rand(0, count($extraPostType)-1);
				$args = array(
					'post_type' 		=> $extraPostType[$postTypeRand],
					'posts_per_page' 	=> 1,
					'orderby' 			=> 'rand'
				);

				$counter = 1;
				$bgRandom = '';
				$coleccionRandom = '';
				$authorRandom = '';
				$titleRandom = '';
				$seriesRandom = '';
				$placeRandom = '';
				$circaRandom = 0;
				$dateRandom = '';

				$queryRandomPost = new WP_Query( $args );
				if ( $queryRandomPost->have_posts() ) : while ( $queryRandomPost->have_posts() ) : $queryRandomPost->the_post();

					$bgRandom = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

					$coleccionRandom 		= wp_get_post_terms( $post->ID, 'coleccion' );
					$coleccionRandomName = '';
					if( ! empty( $coleccionRandom ) ){
						$coleccionRandomName 	= $coleccionRandom[0]->name;
						$coleccionRandomSlug 	= $coleccionRandom[0]->slug;
					}

					$authorRandom 		= wp_get_post_terms( $post->ID, 'fotografo' );
					if ( $authorRandom ){
						$authorRandomName 	= $authorRandom[0]->name;
						$authorRandomSlug 	= $authorRandom[0]->slug;
					} else {
						$authorRandomName 	= 'Autor no identificado';
					}

					$titleRandom = get_the_title( $post->ID );
					if ( strpos($titleRandom, 'Sin título') !== false OR $titleRandom == '' OR strpos($titleRandom, '&nbsp') !== false ){
						$titleRandom = NULL;
					}

					$seriesRandom = '';
					$serie = wp_get_post_terms( $post->id, 'serie' );
					if ( $serie ){
						$seriesRandom = $serie[0]->name;
					}

					$placeRandom = wp_get_post_terms( $post->ID, 'lugar' );
					if ( $placeRandom ){
						$placeRandomName 	= $placeRandom[0]->name;
					}

					$circaRandom = 0;

					$dateRandom = wp_get_post_terms( $post->ID, 'año' );
					if ( $dateRandom ){
						$dateRandomName 	= $dateRandom[0]->name;
					}

					$themesRandom = wp_get_post_terms( $post->ID, 'tema' );
					if ( ! $themesRandom ){
						$themesRandomName 	= '';
					}

					$permalinkColeccion = get_permalink( $post->ID );

				?>
					<article class="[ relacionadas ][ bg-image ][ span xmall-12 medium-6 ]" style="background-image: url(<?php echo $bgRandom[0]; ?>)">
							<div class="[ opacity-gradient <?php echo ( $counter == 1 ) ? '[ square square-absolute ]' : '[ rectangle rectangle-absolute ]' ?> ]">
								<a class="[ block ][ media-link ]" href="<?php echo $permalinkColeccion; ?>"></a>
								<div class="[ media-info media-info--small ][ xmall-12 ]">
									<p class="[ text-center ]">

										<!-- NOMBRE APELLIDO -->
										<?php if ( $authorRandomName != 'Autor no identificado' ){ ?>
											<a href="<?php echo site_url( $authorRandomSlug ); ?>" class="[ media--info__author ]"><?php echo $authorRandomName;?></a>,
										<?php } ?>

										<!-- TÍTULO -->
										<?php if ( $titleRandom ){ ?>
											<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleRandom; ?></a>,
										<?php } ?>

										<!-- DE LA SERIE -->
										<?php if ( $seriesRandom ){ ?>
											de la serie <span class="[ media--info__series ]"><?php echo $seriesRandom; ?></span>,
										<?php } ?>

										<!-- CIRCA -->
										<?php if ( $circaRandom ){ ?>
											<span class="[ media--info__circa ]">circa </span>
										<?php } ?>

										<!-- AÑO -->
										<?php if ( $dateRandom ){ ?>
											<span class="[ media--info__date ]"><?php echo $dateRandomName; ?></span>,
										<?php } ?>

										<!-- COLECCION -->
										<br /> de la colección <a href="<?php echo site_url().'/colecciones?coleccion='.$coleccionRandomSlug; ?>" class="[ media--info__colection ]"> <?php echo $coleccionRandomName; ?></a>
									</p>
								</div>
							</div>
						</article>
				<?php
				endwhile; endif; wp_reset_query();

				$has_related       = false;
				$has_related_limit = 0;
				while( ! $has_related AND $has_related_limit <= 10 ){
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

						$has_related = true;
						$bgColecciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

						$coleccionColecciones 		= wp_get_post_terms( $post->ID, 'coleccion' );
						$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
						$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;

						$authorColecciones 		= wp_get_post_terms( $post->ID, 'fotografo' );
						if ( $authorColecciones ){
							$authorColeccionesName 	= $authorColecciones[0]->name;
							$authorColeccionesSlug 	= $authorColecciones[0]->slug;
						} else {
							$authorColeccionesName 	= 'Autor no identificado';
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

						if ( in_category('circa', $post->ID ) ){
							$circaColecciones = true;
						}

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
										<?php if ( $authorColeccionesName != 'Autor no identificado' ){ ?>
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
										<br /> de la colección <a href="<?php echo site_url().'/colecciones?coleccion='.$coleccionColeccionesSlug; ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

										<!-- CIRCA -->
										<?php if ( $circaColecciones ){ ?>
											<!-- <span class="[ media--info__circa ]">ca. </span> -->
										<?php } ?>

										<!-- AÑO -->
										<?php if ( $dateColecciones ){ ?>
											<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
										<?php } ?>
									</p>
								</div>
							</div>
						</article>
					<?php $counter++; endwhile; endif; wp_reset_query();
				} //while
				?>
			</div><!-- row -->
		</div><!-- wrapper -->
	</section><!-- .results -->

	<?php
	$content = $post->post_content;

	if( has_shortcode( $content, 'gallery' ) ) {
		$galleries = get_galleries_from_content($content);
		foreach ($galleries as $gallery => $galleryIDs) { ?>
			<div class="[ modal-wrapper modal-wrapper-<?php echo $gallery; ?> ][ hide ]">
				<div class="[ modal modal--read-mode modal--lightbox ]">
					<div class="[ close-modal ]">
						<i class="[ icon-close ]"></i>
					</div>
					<div class="[ modal-content ]">
						<div class="[ modal-body ]">
							<div class="[ slideshow slideshow-<?php echo $gallery; ?> ]">
								<?php
								$images = sga_gallery_images('full', $galleryIDs);

								foreach ($images as $key => $image) {
									$imageID         = $image[4];
									$imageURL        = $image[0];
									$imagePostID     = get_post_id_by_attachment_id($imageID);

									if ( $imagePostID ){
										$imagePost       = get_post( $imagePostID->post_id );
										$titleimagePost = get_the_title( $imagePostID->post_id );

										if ( strpos($titleimagePost, 'Sin título') !== false OR $titleimagePost == '' OR strpos($titleimagePost, '&nbsp') !== false ){
											$titleimagePost = NULL;
										}

										$authorImagePost = wp_get_post_terms( $imagePostID->post_id, 'fotografo' );
										if ( $authorImagePost ){
											$authorImagePostName 	= $authorImagePost[0]->name;
											$authorImagePostSlug 	= $authorImagePost[0]->slug;
										} else {
											$authorImagePost 	= 'Autor no identificaco';
										}

										$permalinkImagePost = get_permalink( $imagePostID->post_id );
									}

								?>
									<div class="[ image-single ]" data-number="<?php echo $key+1; ?>">
										<?php if ( $imagePostID ){ ?>
											<div class="[ info-modal ]">
												<a href="<?php echo $permalinkImagePost; ?>" target="_blank">
													<i class="[ icon-info ]"></i>
												</a>
											</div>
										<?php } ?>
										<div class="[ full-height ]">
											<a href="<?php echo $permalinkImagePost; ?>" target="_blank">
												<img class="[ full-height-centered ]" src="<?php echo $imageURL; ?>">
											</a>
										</div><!-- full-height -->
									</div>
								<?php } ?>
								<div class="[ cycle-control cycle-prev ]">
									<i class="icon-chevron-prev"></i>
								</div><!-- cycle-prev  -->
								<div class="[ cycle-control cycle-next ]">
									<i class="icon-chevron-next"></i>
								</div><!-- cycle-next  -->
							</div><!-- slideshow -->
						</div><!-- modal-body -->
					</div><!-- modal-content -->
				</div><!-- modal -->
			</div><!-- modal-wrapper -->
		<?php }
	} ?>
	<script type="text/javascript" src="https://addthisevent.com/libs/ate-latest.min.js"></script>
<?php get_footer(); ?>