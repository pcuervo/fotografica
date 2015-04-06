<?php get_header();
	the_post(); ?>
	<div class="[ full-height ][ margin-bottom ]">
		<?php the_post_thumbnail('full'); ?>
	</div>

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

	$detalleColecciones = get_post_meta( $post->ID, '_detalles_fotografia_meta', TRUE );


	$titleColecciones = get_the_title( $post->ID );
	if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
		$titleColecciones = NULL;
	}

	$slugPost = $post->post_name;

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
					<!-- #FOTOGRAFÍAS -->
				<!--  \**********************************/ -->
				<?php if ( $postType == 'fotografias' ){ ?>

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName !== 'Autor no identificado' ){ ?>
						<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
					<?php } ?>

					<!-- DETALLE -->
					<?php if ( $detalleColecciones ){ ?>
						<span class="[ media--info__name ]"><?php echo $detalleColecciones;?></span>,
					<?php } ?>

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
					<?php if ( $circaColecciones ){ ?>
						<span class="[ media--info__circa ]">circa </span>
					<?php } ?>

					<!-- AÑO -->
					<?php if ( $dateColecciones ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>,
					<?php } ?>

					<!-- COLECCION -->
					<br />
					de la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>

				<?php } ?>





				<!--  /********************************\ -->
					<!-- #PROYECTOS -->
				<!--  \**********************************/ -->
				<?php if ( $postType === 'proyectos' ){ ?>
					<span class="[ media--info__name]"> <?php the_title( ); ?></span>
				<?php } ?>



				<!--  /********************************\ -->
					<!-- #FOTÓGRAFOS -->
				<!--  \**********************************/ -->
				<?php if ( $postType === 'fotografos' ){ ?>
					<h2 class="[ title ][ text-center ]"> <?php the_title(); ?></h2>
				<?php } ?>

			</p>
		</div>
	</section>
	<section class="[ share ] [ margin-bottom--large ]">
		<div class="[ wrapper ][ clearfix ]">
			<div class="[ clearfix ][ columna medium-8 large-4 center ]">
				<a href="https://twitter.com/share?url=<?php echo $current_link; ?>&via=fotograficamx" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="[ button button--dark button__share button--twitter ] [ columna xmall-4 ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-twitter"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-tweet-count ]"></span>
				</a>
				<div class="[ button button--dark button__share button--facebook ] [ columna xmall-4 ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-facebook-square"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-share-count ]"></span>
				</div>
				<?php
					$num_likes_meta = get_post_meta( $post->ID, 'num_likes', TRUE );
				?>
				<div class="[ button button--dark button__share button--heart ] [ columna xmall-4 ]" data-post-id="<?php echo $post->ID ?>">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-heart"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-num-likes ]"><?php echo ($num_likes_meta == '') ? 0 : $num_likes_meta; ?></span>
				</div>
			</div>
		</div><!-- .wrapper -->
	</section><!-- .share -->
	<section class="[ margin-bottom--large ][ single-content ]">
		<div class="[ wrapper ]">
			<div class="[ row ]">
				<aside class="[ shown--large ][ columna medium-2 large-3 ][ text-right serif--italic ]">
					<?php
						if ( $postType == 'carteleras' ){
							$fecha_inicial = get_post_meta( $post->ID, '_evento_fecha_inicial_meta', true);
							$fecha_final = get_post_meta( $post->ID, '_evento_fecha_final_meta', true);
						?>
							<p><?php echo 'Del '.$fecha_inicial.' al '.$fecha_final ?></p>
							<div class="[ form-group ] [ margin-bottom ]">
								<a class="[ addthisevent ] [ btn btn-primary btn-go ]" href="#" title="Add to Calendar" data-track="ga('send', 'event', 'solicitudes', 'click', 'ate-calendar');">
									<span>Agregar a mi calendario</span>
									<span class="_start"><?php echo $fecha_inicial ?></span>
									<span class="_end"><?php echo $fecha_final ?></span>
									<span class="_zonecode">12</span>
									<span class="_summary"><?php echo $post->post_title; ?></span>
									<span class="_organizer">Organizer</span>
									<span class="_organizer_email">Organizer e-mail</span>
									<span class="_all_day_event">true</span>
									<span class="_date_format">DD/MM/YYYY</span>
								</a>
							</div><!-- form-group -->
						<?php } ?>
				</aside>
				<div class="[ columna small-12 medium-10 large-6 xxlarge-4 center ]">
					<?php the_content(); ?>
				</div>
			</div>
		</div><!-- .wrapper -->
	</section>


	<?php if( $post_type === 'fotografos' ) { ?>
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
							} else {
								$dateTrabajoName 	= 's/f';
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
	<?php }

	if( $post_type !== 'fotografos') { ?>
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
					<?php $counter++; endwhile; endif; wp_reset_query(); ?>
				</div><!-- row -->
			</div><!-- wrapper -->
		</section><!-- .results -->
	<?php } ?>
	<div class="[ lightbox ] [ slideshow ]">
		<?php
			$attachedMediaArgs = array(
				'post_type' => 'attachment',
				'post_mime_type'=>'image',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => $post->ID
			);

		?>
		<div class="[ image-single ]">
			<div class="[ full-height ]">
				<img class="[  ]" src="<?php echo THEMEPATH; ?>images/test-9.jpg" alt="">
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