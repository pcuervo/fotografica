<?php get_header();
	the_post(); ?>

	<?php

	// Get number of shares current page
	global $current_link;
	$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$num_shares_url = "http://api.facebook.com/restserver.php?method=links.getStats&urls=".$current_link;
	$fb_stats = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&urls=http://pcuervo.com/fotografica/fotografias/sin-titulo-17/');


	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();

	/*------------------------------------*\
	    #DATOS
	\*------------------------------------*/
	$taxonomia = '';
	switch ( $postType ) {
		case 'fotografias':
			$taxonomia = 'coleccion';
			break;
		case 'proyectos':
			$taxonomia = 'tipo-de-proyecto';
			break;
		default:
	}

	$slugPost = $post->post_name;

	$fotografoArgs = array(
		'post_type' 		=> 'fotografias',
		'posts_per_page' 	=> 1,
		'orderby'			=> 'rand',
		'tax_query'      	=> array(
			array(
				'field'    => 'slug',
				'taxonomy' => 'fotografo',
				'terms'    => $slugPost
			),
		),
		'post__not_in'		=> array($post->ID)
	);
	$fotografoQuery = new WP_Query( $fotografoArgs );
	if( $fotografoQuery->have_posts() ) : while( $fotografoQuery->have_posts() ) : $fotografoQuery->the_post();

		$bgFotografo = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );
		$coleccionFotografo 		= wp_get_post_terms( $post->ID, 'coleccion' );
		$coleccionFotografoName 	= $coleccionFotografo[0]->name;
		$coleccionFotografoSlug 	= $coleccionFotografo[0]->slug;

		$authorFotografo 		= wp_get_post_terms( $post->ID, 'fotografo' );
		if ( $authorFotografo ){
			$authorFotografoName 	= $authorFotografo[0]->name;
			$authorFotografoSlug 	= $authorFotografo[0]->slug;
		} else {
			$authorFotografoName 	= 'Autor no identificado';
		}

		$detalleFotografo = get_post_meta( $post->ID, '_detalles_fotografia_meta', TRUE );

		$titleFotografo = get_the_title( $post->ID );

		if ( strpos($titleFotografo, 'Sin título') !== false OR $titleFotografo == '' OR strpos($titleFotografo, '&nbsp') !== false ){
			$titleFotografo = NULL;
		}

		$seriesFotografo = '';
		$serie = wp_get_post_terms( $post->id, 'serie' );
		if ( $serie ){
			$seriesFotografo = $serie[0]->name;
		}

		$placeFotografo = wp_get_post_terms( $post->ID, 'lugar' );
		if ( $placeFotografo ){
			$placeFotografoName 	= $placeFotografo[0]->name;
		}

		$circaFotografo = 0;

		$dateFotografo = wp_get_post_terms( $post->ID, 'año' );
		if ( $dateFotografo ){
			$dateFotografoName 	= $dateFotografo[0]->name;
		}

		$permalinkFotografo = get_permalink( $post->ID );
	?>
		<div class="[ full-height ][ margin-bottom ]">
			<?php the_post_thumbnail('full', array('class' => 'full-height-centered') ); ?>
		</div>
	<?php endwhile; endif; wp_reset_query(); ?>

	<?php if( $fotografoQuery->have_posts() ) {?>
		<section class="[ margin-bottom--large ]">
			<div class="[ media-info media-info__dark ] [ relative ] [ xmall-12 ]">
				<p class="[ text-center ]">

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorFotografoName !== 'Autor no identificado' ){ ?>
						<a href="<?php echo site_url( $authorFotografoSlug ); ?>" class="[ media--info__author ]"><?php echo $authorFotografoName;?></a>,
					<?php } ?>

					<!-- DETALLE -->
					<?php if ( $detalleFotografo ){ ?>
						<span class="[ media--info__name ]"><?php echo $detalleFotografo;?></span>,
					<?php } ?>

					<!-- TÍTULO -->
					<?php if ( $titleFotografo ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleFotografo; ?></a>,
					<?php } ?>

					<!-- DE LA SERIE -->
					<?php if ( $seriesFotografo ){ ?>
						de la serie <span class="[ media--info__series ]"><?php echo $seriesFotografo; ?></span>,
					<?php } ?>

					<!-- LUGAR -->
					<?php if ( $placeFotografo ){ ?>
						<span class="[ media--info__place ]"><?php echo $placeFotografoName; ?></span>,
					<?php } ?>

					<!-- CIRCA -->
					<?php if ( $circaFotografo ){ ?>
						<span class="[ media--info__circa ]">circa </span>
					<?php } ?>

					<!-- AÑO -->
					<?php if ( $dateFotografo && $dateFotografoName !== 's/f' ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateFotografoName; ?></span>,
					<?php } ?>

					<!-- COLECCION -->
					<br />
					de la colección <a href="<?php echo site_url() ?>/colecciones?coleccion=<?php echo $coleccionFotografoSlug ?>" class="[ media--info__colection ]"> <?php echo $coleccionFotografoName; ?></a>

				</p>
			</div>
		</section>
	<?php } ?>
	<br />
	<h2 class="[ title ][ text-center ]"> <?php the_title(); ?></h2>
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
		<div class="[ wrapper ]">
			<div class="[ row ]">
				<aside class="[ shown--large ][ columna medium-2 large-3 ][ text-right serif--italic ]">
				</aside>
				<div class="[ columna small-12 medium-10 large-6 xxlarge-4 center ]">
					<?php the_content(); ?>
				</div>
			</div>
		</div><!-- .wrapper -->
	</section>


	<?php if( $fotografoQuery->have_posts() ) { ?>
		<section>
			<h2 class="[ title ][ text-center ]">Trabajo</h2>
			<div class="[ wrapper ]">
				<article class="[ results ][ row row--no-margins ][ margin-bottom ]">
					<?php
						$trabajoArgs = array(
							'post_type'      => 'fotografias',
							'posts_per_page' => -1,
							'tax_query'      => array(
								array(
									'field'    => 'slug',
									'taxonomy' => 'fotografo',
									'terms'    => $slugPost
								),
							),
							'post__not_in'		=> array($post->ID)
						);
						$trabajoQuery = new WP_Query( $trabajoArgs );
						if( $trabajoQuery->have_posts() ) : while( $trabajoQuery->have_posts() ) : $trabajoQuery->the_post();

							$coleccionTrabajo 		= wp_get_post_terms( $post->ID, 'coleccion' );
							$coleccionTrabajoName 	= $coleccionTrabajo[0]->name;
							$coleccionTrabajoSlug 	= $coleccionTrabajo[0]->slug;

							$authorTrabajo 		= wp_get_post_terms( $post->ID, 'fotografo' );
							if ( $authorTrabajo ){
								$authorTrabajoName 	= $authorTrabajo[0]->name;
								$authorTrabajoSlug 	= $authorTrabajo[0]->slug;
							} else {
								$authorTrabajoName 	= 'Autor no identificado';
							}

							$titleTrabajo = get_the_title( $post->ID );

							if ( strpos($titleTrabajo, 'Sin título') !== false OR $titleTrabajo == '' OR strpos($titleTrabajo, '&nbsp') !== false ){
								$titleTrabajo = NULL;
							}


							$seriesTrabajo = 0;

							$placeTrabajo = wp_get_post_terms( $post->ID, 'lugar' );
							if ( $placeTrabajo ){
								$placeTrabajoName 	= $placeTrabajo[0]->name;
							}

							$circaTrabajo = 0;

							$dateTrabajo = wp_get_post_terms( $post->ID, 'año' );
							if ( $dateTrabajo ){
								$dateTrabajoName 	= $dateTrabajo[0]->name;
							}

							$themesTrabajo = wp_get_post_terms( $post->ID, 'tema' );
							if ( ! $themesTrabajo ){
								$themesTrabajoName 	= '';
							}

							$permalinkTrabajo = get_permalink( $post->ID );


						?>
						<div class="[ result ] [ columna xmall-6 small-ls-12 medium-4 large-3 ] [ margin-bottom-small ]" data-id="2379">
							<div class="[ relative ]">
								<a class="[ block ]" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('medium', array('class' => '[ image-responsive ]') ); ?>
									<span class="[ opacity-gradient--full ]"></span>
								</a>
								<div class="[ media-info media-info--small ] [ xmall-12 ]">
									<a class="[ block ]" href="http://localhost:8888/fotografica/fotografias/sin-titulo/">
									<p class="[ text-center ]">
										<!-- NOMBRE APELLIDO -->
										<?php if ( $authorTrabajoName != 'Autor no identificado' ){ ?>
											<a href="<?php echo site_url( $authorTrabajoSlug ); ?>" class="[ media--info__author ]"><?php echo $authorTrabajoName;?></a>,
										<?php } ?>

										<!-- TÍTULO -->
										<?php if ( $titleTrabajo ){ ?>
											<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleTrabajo; ?></a>,
										<?php } ?>

										<!-- DE LA SERIE -->
										<?php if ( $seriesTrabajo ){ ?>
											de la serie <span class="[ media--info__series ]"><?php echo $seriesTrabajo; ?></span>
										<?php } ?>

										<!-- CIRCA -->
										<?php if ( $circaTrabajo ){ ?>
											<span class="[ media--info__circa ]">circa </span>,
										<?php } ?>

										<!-- AÑO -->
										<?php if ( $dateTrabajo ){ ?>
											<span class="[ media--info__date ]"><?php echo $dateTrabajoName; ?></span>,
										<?php } ?>

										<!-- COLECCION -->
										<br />
										de la colección <a href="<?php echo site_url( $coleccionTrabajoSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionTrabajoName; ?></a>
									</p>
								</div>
							</div>
						</div>
					<?php endwhile; endif; wp_reset_postdata(); ?>
				</article>
			</div>
		</section>
	<?php } ?>

	<section class="[ margin-bottom ]">
		<div class="[ wrapper ]">
			<div class="[ row ]">
				<?php

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
					if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post();?>

						<?php if ( $counter == 1 ) { ?>
							<h2 class="[ title ] [ text-center ]">Te puede interesar</h2>
						<?php }

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

						$seriesColecciones = '';
						$serie = wp_get_post_terms( $post->id, 'serie' );
						if ( $serie ){
							$seriesColecciones = $serie[0]->name;
						}

						$placeColecciones = wp_get_post_terms( $post->ID, 'lugar' );
						if ( $placeColecciones ){
							$placeColeccionesName 	= $placeColecciones[0]->name;
						}

						$circaColecciones = 0;

						$dateColecciones = wp_get_post_terms( $post->ID, 'año' );
						if ( $dateColecciones ){
							$dateColeccionesName 	= $dateColecciones[0]->name;
						}

						$themesColecciones = wp_get_post_terms( $post->ID, 'tema' );
						if ( ! $themesColecciones ){
							$themesColeccionesName 	= '';
						}

						$permalinkColeccion = get_permalink( $post->ID );
					?>
						<article class="[ relacionadas ][ bg-image ][ span xmall-12 medium-6 ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
							<div class="[ opacity-gradient <?php echo ( $counter == 1 ) ? '[ square square-absolute ]' : '[ rectangle rectangle-absolute ]' ?> ]">
								<a class="[ block ][ media-link ]" href="<?php echo $permalinkColeccion; ?>"></a>
								<div class="[ media-info media-info--small ][ xmall-12 ]">
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

										<!-- CIRCA -->
										<?php if ( $circaColecciones ){ ?>
											<span class="[ media--info__circa ]">circa </span>
										<?php } ?>

										<!-- AÑO -->
										<?php if ( $dateColecciones ){ ?>
											<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>,
										<?php } ?>

										<!-- COLECCION -->
										<br /> de la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>
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
	} ?>
	<script type="text/javascript" src="https://addthisevent.com/libs/ate-latest.min.js"></script>
<?php get_footer(); ?>