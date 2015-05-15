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

	if( $postType == 'fotografos' ){
		$fotografiaArgs = array(
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
		$fotografiaQuery = new WP_Query( $fotografiaArgs );
		if( $fotografiaQuery->have_posts() ) : $fotografiaQuery->the_post();

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

			$detalleColecciones = get_post_meta( $post->ID, '_detalles_fotografia_meta', TRUE );

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

			$themesTrabajo = wp_get_post_terms( $post->ID, 'tema' );
			if ( ! $themesTrabajo ){
				$themesTrabajoName 	= '';
			}

			$permalinkTrabajo = get_permalink( $post->ID );
	?>
		<div class="[ full-height ][ margin-bottom ]">
			<?php the_post_thumbnail('full', array('class' => 'full-height-centered') ); ?>
		</div>
	<?php
		endif; wp_reset_query();
	} else {
	?>
		<div class="[ full-height ][ margin-bottom ]">
			<?php the_post_thumbnail('full', array('class' => 'full-height-centered')); ?>
		</div>
	<?php
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
			$authorColeccionesName 	= 'Autor no identificaco';
		}

		$detalleColecciones = get_post_meta( $post->ID, '_detalles_fotografia_meta', TRUE );


		$titleColecciones = get_the_title( $post->ID );
		if ( strpos($titleColecciones, 'Sin título') !== false OR $titleColecciones == '' OR strpos($titleColecciones, '&nbsp') !== false ){
			$titleColecciones = NULL;
		}

		$seriesColecciones = '';
		$serie = wp_get_post_terms( $post->ID, 'serie' );

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
	}

?>


	<section class="[ margin-bottom--large ]">
		<div class="[ media-info media-info__dark ] [ relative ] [ xmall-12 ]">
			<p class="[ text-center ]">

				<!--  /********************************\ -->
					<!-- #FOTOGRAFÍAS -->
				<!--  \**********************************/ -->
				<?php if ( $postType == 'fotografias' || $postType == 'fotografos' ){ ?>

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName !== 'Autor no identificado' ){ ?>
						<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
					<?php } ?>

					<!-- TÍTULO -->
					<?php if ( $titleColecciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
					<?php } ?>

					<!-- DETALLE -->
					<?php if ( $detalleColecciones ){ ?>
						<?php echo $detalleColecciones;?>,
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
					<?php if ( $dateColecciones && $dateColeccionesName !== 's/f' ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>,
					<?php } ?>

					<!-- COLECCION -->
					<br />
					de la colección <a href="<?php echo site_url() ?>/colecciones?coleccion=<?php echo $coleccionColeccionesSlug ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>

				<?php } ?>





				<!--  /********************************\ -->
					<!-- #PROYECTOS -->
				<!--  \**********************************/ -->
				<?php if ( $postType === 'proyectos'){ ?>
					<span class="[ media--info__name]"> <?php the_title( ); ?></span>
				<?php } ?>



				<!--  /********************************\ -->
					<!-- #FOTÓGRAFOS -->
				<!--  \**********************************/ -->
				<?php if ( $postType === 'fotografos' || $postType === 'carteleras'  ){ ?>
					<h2 class="[ title ][ text-center ]"> <?php the_title(); ?></h2>
				<?php } ?>

			</p>
		</div>
	</section>
	<section class="[ share ] [ margin-bottom--large ]">
		<div class="[ wrapper ][ clearfix ]">
			<div class="[ clearfix ][ columna medium-8 large-4 center ]">
				<a href="https://twitter.com/share?url=<?php echo $current_link; ?>&via=fotograficamx" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="[ button button--dark button__share button--twitter ] [ columna <?php echo $postType == 'fotografias' ? 'xmall-4' : 'xmall-6' ?> ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-twitter"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-tweet-count ]"></span>
				</a>
				<div class="[ button button--dark button__share button--facebook ] [ columna <?php echo $postType == 'fotografias' ? 'xmall-4' : 'xmall-6' ?> ]">
					<i class="[ xmall-3 inline-block align-middle ] fa fa-facebook-square"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-share-count ]"></span>
				</div>
				<?php
					if( $postType == 'fotografias') {
						$num_likes_meta = get_post_meta( $post->ID, 'num_likes', TRUE );
				?>
					<div class="[ button button--dark button__share button--heart ] [ columna xmall-4 ]" data-post-id="<?php echo $post->ID ?>">
						<i class="[ xmall-3 inline-block align-middle ] fa fa-heart"></i><span class="[ xmall-2 ]">&nbsp;</span><span class="[ xmall-7 inline-block align-middle ][ js-num-likes ]"><?php echo ($num_likes_meta == '') ? 0 : $num_likes_meta; ?></span>
					</div>
				<?php } ?>
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

							if ( ! empty( $fecha_inicial ) && ! empty( $fecha_final ) ){

						?>
								<p>Del <?php echo get_formatted_event_date( $fecha_inicial ) ?> <br /> al <?php echo get_formatted_event_date( $fecha_final ) ?></p>
								<div class="[ clear ]"></div>
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
							}

							$themesTrabajo = wp_get_post_terms( $post->ID, 'tema' );
							if ( ! $themesTrabajo ){
								$themesTrabajoName 	= '';
							}

							$permalinkTrabajo = get_permalink( $post->ID );


						?>
						<div class="[ result ] [ columna xmall-12 small-ls-6 medium-4 large-3 ] [ margin-bottom-small ]" data-id="2379">
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
			<div class="[ wrapper ]">
				<div class="[ row ]">
					<?php

					$extraPostType = array('proyectos', 'publicaciones', 'exposiciones');
					$postTypeRand = rand(0, count($extraPostType)-1);
					$args = array(
						'post_type' 		=> $postTypeRand,
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
						$coleccionRandomName 	= $coleccionRandom[0]->name;
						$coleccionRandomSlug 	= $coleccionRandom[0]->slug;

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
						<h2 class="[ title ] [ text-center ]">Te puede interesar</h2>
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
								'posts_per_page' 	=> 2,
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
										'terms'		=> $terms[$random_term]
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
											<br /> de la colección <a href="<?php echo site_url().'/colecciones?coleccion='.$coleccionColeccionesSlug; ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>
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
	<?php }
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