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
	endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('colecciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Colecciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName && $authorColeccionesName !== 'Autor no identificado' ){ ?>
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
	<!-- #FEATURED -->
	<!-- \**************************************/ -->
	<?php
	$bgFeatured = '';
	$coleccionFeatured = '';
	$authorFeatured = '';
	$titleFeatured = '';
	$seriesFeatured = '';
	$placeFeatured = '';
	$circaFeatured = 0;
	$dateFeatured = '';
	$args = array(
		'post_type' => 'any',
		'tax_query' => array(
			array(
				'taxonomy'	=> 'category',
				'field'		=> 'slug',
				'terms'		=> array('destacado')
			)
		)
	);
	$queryFeatured = new WP_Query( $args );
	if ( $queryFeatured->have_posts() ) : while ( $queryFeatured->have_posts() ) : $queryFeatured->the_post();

		$bgFeatured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$postTypeFeatured = get_post_type( $post->ID );

		$coleccionFeatured 		= wp_get_post_terms( $post->ID, 'coleccion' );
		$coleccionFeaturedName 	= $coleccionFeatured[0]->name;
		$coleccionFeaturedSlug 	= $coleccionFeatured[0]->slug;

		$authorFeatured 			= wp_get_post_terms( $post->ID, 'fotografo' );
		if ( $authorFeatured ){
			$authorFeaturedName 	= $authorFeatured[0]->name;
			$authorFeaturedSlug 	= $authorFeatured[0]->slug;
		} else {
			$authorFeaturedName 	= 'Autor no identificado';
		}

		$titleFeatured = get_the_title( $post->ID );
		$permalinkFeatured = get_permalink( $post->ID );
		if ( strpos($titleFeatured, 'Sin título') !== false OR $titleFeatured == '' OR strpos($titleFeatured, '&nbsp') !== false ){
			$titleFeatured = NULL;
		}


		$placeFeatured = wp_get_post_terms( $post->ID, 'lugar' );
		$placeFeaturedName = '';
		if ( $placeFeatured ){
			$placeFeaturedName 	= $placeFeatured[0]->name;
		}

		$dateFeatured = wp_get_post_terms( $post->ID, 'año' );
		if ( $dateFeatured ){
			$dateFeaturedName 	= $dateFeatured[0]->name;
		} else {
			$dateFeaturedName 	= 's/f';
		}

		$themesFeatured = wp_get_post_terms( $post->ID, 'tema' );
		if ( ! $themesFeatured ){
			$themesFeaturedName 	= '';
		}
	?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgFeatured[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('colecciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Destacado
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName && $authorColeccionesName == 'Autor no identificado' ){ ?>
						<a href="<?php echo site_url( $authorFeaturedSlug ); ?>" class="[ media--info__author ]"><?php echo $authorFeaturedName;?></a>,
					<?php } ?>

					<!-- TÍTULO -->
					<?php if ( $titleFeatured ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleFeatured; ?></a>,
					<?php } ?>

					<!-- DE LA SERIE -->
					<?php if ( $seriesFeatured ){ ?>
						de la serie <span class="[ media--info__series ]"><?php echo $seriesFeatured; ?></span>,
					<?php } ?>

					<!-- LUGAR -->
					<?php if ( $placeFeatured ){ ?>
						<span class="[ media--info__place ]"><?php echo $placeFeaturedName; ?></span>,
					<?php } ?>

					<!-- CIRCA -->
					<?php if ( $circaFeatured ){ ?>
						<span class="[ media--info__circa ]">circa </span>
					<?php } ?>

					<!-- AÑO -->
					<?php if ( $dateFeatured ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateFeaturedName; ?></span>,
					<?php } ?>

					<!-- COLECCION -->
					<?php if ( $coleccionFeatured ){ ?>
						<br />
						de la colección <a href="<?php echo site_url( $coleccionFeaturedSlugSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>
					<?php } ?>
				</p>
			</div>
		</div>
	</section>

	<!-- /**************************************\ -->
	<!-- #ADQUISICIONES RECIENTES -->
	<!-- \**************************************/ -->
	<?php
	$bgRecientes = '';
	$coleccionRecientes = '';
	$authorRecientes = '';
	$titleRecientes = '';
	$seriesRecientes = '';
	$placeRecientes = '';
	$circaRecientes = 0;
	$dateRecientes = '';
	$args = array(
		'post_type' 		=> 'fotografias',
		'tax_query'   => array(
			array(
				'field'    => 'slug',
				'taxonomy' => 'colecciones',
				'terms'    => 'adquisiciones-recientes'
			),
		),
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryRecientes = new WP_Query( $args );
	if ( $queryRecientes->have_posts() ) : while ( $queryRecientes->have_posts() ) : $queryRecientes->the_post();

		$bgRecientes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$coleccionRecientes 		= wp_get_post_terms( $post->ID, 'coleccion' );
		$coleccionRecientesName 	= $coleccionRecientes[0]->name;
		$coleccionRecientesSlug 	= $coleccionRecientes[0]->slug;

		$authorRecientes 		= wp_get_post_terms( $post->ID, 'fotografo' );
		if ( $authorRecientes ){
			$authorRecientesName 	= $authorRecientes[0]->name;
			$authorRecientesSlug 	= $authorRecientes[0]->slug;
		} else {
			$authorRecientesName 	= 'sin autor';
		}

		$titleRecientes = get_the_title( $post->ID );
		if ( strpos($titleRecientes, 'Sin título') !== false OR $titleRecientes == '' OR strpos($titleRecientes, '&nbsp') !== false ){
			$titleRecientes = NULL;
		}

		$seriesRecientes = 0;

		$placeRecientes = wp_get_post_terms( $post->ID, 'lugar' );
		if ( $placeRecientes ){
			$placeRecientesName 	= $placeRecientes[0]->name;
		}

		$circaRecientes = 0;

		$dateRecientes = wp_get_post_terms( $post->ID, 'año' );
		if ( $dateRecientes ){
			$dateRecientesName 	= $dateRecientes[0]->name;
		} else {
			$dateRecientesName 	= 's/f';
		}

		$themesRecientes = wp_get_post_terms( $post->ID, 'tema' );
		if ( ! $themesRecientes ){
			$themesRecientesName 	= '';
		}

		$permalinkColeccion = get_permalink( $post->ID );
	?>
		<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgRecientes[0]; ?>)">
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

	<?php endwhile; endif; wp_reset_query(); ?>




	<!-- /**************************************\ -->
	<!-- #PROYECTOS -->
	<!-- \**************************************/ -->
	<?php
	$bgProyectos = '';
	$proyectosArgs = array(
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand',
		'post_type' 		=> 'proyectos'
	);
	$queryProyectos = new WP_Query( $proyectosArgs );
	if ( $queryProyectos->have_posts() ) : while ( $queryProyectos->have_posts() ) : $queryProyectos->the_post();
		$bgProyectos = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$titleProyectos = get_the_title( $post->ID );
		$permalinkProyectos = get_permalink( $post->ID );
		if ( strpos($titleProyectos, 'Sin título') !== false OR $titleProyectos == '' OR strpos($titleProyectos, '&nbsp') !== false ){
			$titleProyectos = NULL;
		}

		$themesProyectos = wp_get_post_terms( $post->ID, 'tema' );
		if ( ! $themesProyectos ){
			$themesProyectosName 	= '';
		}
	?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgProyectos[0]; ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('proyecto'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Proyectos
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">

				<!-- TÍTULO -->
				<?php if ( $titleProyectos ){ ?>
					<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleProyectos; ?></a>
				<?php } ?>

				<!-- TAGS -->
				<div class="[ media-info__tags ] [ text-center ]">
					<?php
						$themeCounter = 1;
						if ( $themesProyectosName ){
							foreach ($themesProyectosName as $themeProyectosName) {
								$themeProyectosName = $themeProyectosName->name; ?>
								<a href="<?php echo site_url('$themeProyectosName'); ?>" class="[ tag ]">#<?php echo $themeColeccionesName; ?></a>
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
	<!-- #PUBLICACIONES -->
	<!-- \**************************************/ -->
	<?php
	$bgPublicaciones = '';
	$titlePublicaciones = '';
	$args = array(
		'post_type' 		=> 'publicaciones',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryPublicaciones = new WP_Query( $args );
	if ( $queryPublicaciones->have_posts() ) : while ( $queryPublicaciones->have_posts() ) : $queryPublicaciones->the_post();
		$bgPublicaciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$titlePublicaciones = get_the_title( $post->ID );
		if ( strpos($titlePublicaciones, 'Sin título') !== false OR $titlePublicaciones == '' OR strpos($titlePublicaciones, '&nbsp') !== false ){
			$titlePublicaciones = NULL;
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

					<!-- TÍTULO -->
					<?php if ( $titlePublicaciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titlePublicaciones; ?></a>
					<?php } else { ?>
						<span class="[ media--info__name ]">sin título</span>
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
		<?php
			$bgExposiciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

			$titleExposiciones = get_the_title( $post->ID );
			if ( strpos($titleExposiciones, 'Sin título') !== false OR $titleExposiciones == '' OR strpos($titleExposiciones, '&nbsp') !== false ){
				$titleExposiciones = NULL;
			}
		?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgExposiciones[0] ?>)">
		<div class="[ opacity-gradient square ]">
			<a href="<?php echo site_url('exposiciones'); ?>" class="[ button button--hollow button--large ] [ center-full ]">
				Exposiciones
			</a>
			<div class="[ media-info media-info--large ] [ xmall-12 ]">
				<p class="[ text-center ]">

					<!-- TÍTULO -->
					<?php if ( $titleExposiciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleExposiciones; ?></a>
					<?php } ?>

				</p>
			</div>
		</div>
	</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>