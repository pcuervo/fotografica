<?php
	get_header();

	// Get number of shares current page
	global $current_link;
	$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$num_shares_url = "http://api.facebook.com/restserver.php?method=links.getStats&urls=".$current_link;
	$fb_stats = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&urls=http://pcuervo.com/fotografica/fotografias/sin-titulo-17/');


	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();

	$terms = wp_get_post_terms( $post->ID, 'tipo-de-proyecto' );
	$url_video_proyecto = get_post_meta($post->ID, '_evento_video_proyecto_meta', true);

	if($terms[0]->slug == 'individual'){

		the_post(); ?>
		<div class="[ full-height ][ margin-bottom ]">
			<?php the_post_thumbnail('full', array('class' => 'full-height-centered') ); ?>
		</div>

		<?php
		$taxonomia = '';
		if ( $postType == 'fotografias' ){
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

		$permalinkColeccion = get_permalink( $post->ID ); ?>

		<section class="[ share ] [ margin-bottom--large ]">
			<div class="[ wrapper ][ clearfix ]">
				<div class="[ clearfix ][ columna medium-8 large-4 center ]">
					<a href="https://twitter.com/share?url=<?php echo $current_link; ?>&via=fotograficamx" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="[ button button--dark button__share button--twitter ] [ columna xmall-6 ]">
						<i class="[ xmall-3 inline-block align-middle ] fa fa-twitter"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-tweet-count ]"></span>
					</a>
					<div class="[ button button--dark button__share button--facebook ] [ columna xmall-6 ]">
						<i class="[ xmall-3 inline-block align-middle ] fa fa-facebook-square"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-share-count ]"></span>
					</div>
					
				</div>
			</div><!-- .wrapper -->
		</section><!-- .share -->
		<section class="[ margin-bottom--large ][ single-content ]">
			<div class="[ wrapper ][ ]">
				<div class="[ row ]">
					<aside class="[ shown--large ][ columna medium-2 large-3 ][ text-right serif--italic ]">
						<?php if ( $url_video_proyecto != '' ) { ?>
							<div class="[ url-video ]]"><?php echo $url_video_proyecto ?></div>
						<?php } ?>
					</aside>
					<div class="[ columna small-12 medium-10 large-6 xxlarge-4 center ]">
						<?php the_content(); ?>
					</div>
				</div>
			</div><!-- .wrapper -->
		</section>

		<section class="[ margin-bottom ]">
			<h2 class="[ title ] [ text-center ]">Te puede interesar</h2>

			<div class="[ wrapper ]">
				<div class="[ row ]">
					<?php

					$has_related = false;
					while( ! $has_related ){
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

									?>
										<div class="[ image-single ]" data-number="<?php echo $key+1; ?>">
											<div class="[ full-height ]">
												<a href="<?php echo $permalinkImagePost; ?>" target="_blank">
													<img class="[ full-height-centered ]" src="<?php echo $imageURL; ?>">
												</a>
											</div><!-- full-height -->
										</div>
									<?php } ?>
								</div><!-- slideshow -->
							</div><!-- modal-body -->
						</div><!-- modal-content -->
					</div><!-- modal -->
				</div><!-- modal-wrapper -->
			<?php }
		}

	} else {
		/*------------------------------------*\
		    #ARCHIVE HERO
		\*------------------------------------*/
		$bgArchive = '';
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

				$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

				$coleccionColecciones 		= wp_get_post_terms( $post->ID, 'coleccion' );
				$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
				$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;

				$authorColecciones 		= wp_get_post_terms( $post->ID, 'fotografo' );
				if ( $authorColecciones ){
					$authorColeccionesName 	= $authorColecciones[0]->name;
					$authorColeccionesSlug 	= $authorColecciones[0]->slug;
				}  else {
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
		<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgArchive[0]; ?>)">
			<div class="[ opacity-gradient rectangle ]">
				<h2 class="[ center-full ] [ title ]">
					<?php echo $postType; ?> <br />
				</h2>
				<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
					<p class="[ text-center ]">

					<!-- COLECCION -->
					De la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName !== 'Autor no identificado' ){ ?>
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
		<div class="clear"></div>
		<section class="[ results ] [ row ] [ margin-bottom ] <?php echo ($postType == 'fotografos' ? '[ text-center ]' : ''); ?>">
			<?php
				$args = array(
					'post_type' 		=> 'proyectos',
					'posts_per_page' 	=> -1,
					'taxonomy'			=> 'archivo-proyecto',
					'term'				=> $post->post_name,
					'orderby'			=> 'date',
				);
				$queryFotografias = new WP_Query( $args );
				if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post();
			?>
					<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]">
						<div class="[ relative ]">
							<a class="[ block ]" href="<?php the_permalink() ?>">
								<?php the_post_thumbnail('medium', array( 'class' => 'image-responsive')) ?>
								<span class="[ opacity-gradient--full ]"></span>
								<div class="[ media-info media-info--small ] [ xmall-12 ]">
									<p class="[ text-center ]">
										<a href="<?php echo $url ?>" class="[ media--info__name ]"><?php the_title() ?></a>
									</p>
								</div>
							</a>
						</div>
					</article>
			<?php
				endwhile; endif; wp_reset_query(); ?>
		</section><!-- .results -->
<?php
	}
	get_footer();
?>