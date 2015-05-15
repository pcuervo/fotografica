<?php
	get_header();

	/*------------------------------------*\
		#PROYECTOS HERO
	\*------------------------------------*/
	$bgProyectos = '';
	$coleccionProyectos = '';
	$authorProyectos = '';
	$authorProyectosName = '';
	$titleProyectos = '';
	$seriesProyectos = '';
	$placeProyectos = '';
	$circaProyectos = 0;
	$dateProyectos = '';
	$imageID = '';
	$args = array(
		'post_type' 		=> 'proyectos',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryProyectos = new WP_Query( $args );
	if ( $queryProyectos->have_posts() ) : while ( $queryProyectos->have_posts() ) : $queryProyectos->the_post();
		$imageID = get_post_id_by_attachment_id( get_post_thumbnail_id( $post->ID ) );
		$bgProyectos = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );
		if ( $imageID->post_id != 0 ){
			$imagePostID = $imageID->post_id;

			$coleccionProyectos 		= wp_get_post_terms( $imagePostID, 'coleccion' );
			if( $coleccionProyectos ){
				$coleccionProyectosName 	= $coleccionProyectos[0]->name;
				$coleccionProyectosSlug 	= $coleccionProyectos[0]->slug;
			}



			$authorProyectos 		= wp_get_post_terms( $imagePostID, 'fotografo' );
			if ( $authorProyectos ){
				$authorProyectosName 	= $authorProyectos[0]->name;
				$authorProyectosSlug 	= $authorProyectos[0]->slug;
			} else {
				$authorProyectosName 	= 'Autor no identificado';
			}

			$titleProyectos = get_the_title( $imagePostID );
			if ( strpos($titleProyectos, 'Sin título') !== false OR $titleProyectos == '' OR strpos($titleProyectos, '&nbsp') !== false ){
				$titleProyectos = NULL;
			}

			$seriesProyectos = 0;

			$placeProyectos = wp_get_post_terms( $imagePostID, 'lugar' );
			if ( $placeProyectos ){
				$placeProyectosName 	= $placeProyectos[0]->name;
			}

			$circaProyectos = 0;

			$dateProyectos = wp_get_post_terms( $imagePostID, 'año' );
			if ( $dateProyectos ){
				$dateProyectosName 	= $dateProyectos[0]->name;
			} else {
				$dateProyectosName 	= 's/f';
			}

			$themesProyectos = wp_get_post_terms( $imagePostID, 'tema' );
			if ( ! $themesProyectos ){
				$themesProyectosName 	= '';
			}

			$permalinkProyectos = get_permalink( $imagePostID );
		}
	endwhile; endif; wp_reset_query();
?>

	<section class="[ proyectos ][ bg-image ][ margin-bottom--small ]" style="background-image: url(<?php echo $bgProyectos[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ][ title ]">
				Proyectos
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<?php if ( $imageID->post_id != 0 ){ ?>
					<p class="[ text-center ]">

						<!-- NOMBRE APELLIDO -->
						<?php if ( $authorProyectosName !== 'Autor no identificado' ){ ?>
							<a href="<?php echo site_url( $authorProyectosSlug ); ?>" class="[ media--info__author ]"><?php echo $authorProyectosName;?></a>,
						<?php } ?>

						<!-- TÍTULO -->
						<?php if ( $titleProyectos ){ ?>
							<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleProyectos; ?></a>,
						<?php } ?>

						<!-- DE LA SERIE -->
						<?php if ( $seriesProyectos ){ ?>
							de la serie <span class="[ media--info__series ]"><?php echo $seriesProyectos; ?></span>,
						<?php } ?>

						<!-- COLECCION -->
						<?php if ( $coleccionProyectos ){ ?>
							<br /> de la colección <a href="<?php echo site_url( $coleccionProyectosSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionProyectosName; ?></a>,
						<?php } ?>

						<!-- LUGAR -->
						<?php if ( $placeProyectos ){ ?>
							<span class="[ media--info__place ]"><?php echo $placeProyectosName; ?></span>,
						<?php } ?>

						<!-- CIRCA -->
						<?php if ( $circaProyectos ){ ?>
							<span class="[ media--info__circa ]">circa </span>
						<?php } ?>

						<!-- AÑO -->
						<?php if ( $dateProyectos ){ ?>
							<span class="[ media--info__date ][ shown--medium shown--medium--inline ]"><?php echo $dateProyectosName; ?></span>
						<?php } ?>
					<?php } ?>
				</p>
			</div>
		</div>
	</section>
	<section class="[ results ][ row row--no-margins ][ margin-bottom ][ text-center ][ wrapper ][ center ]">
	</section><!-- .results -->
	<div class="[ loader ] [ center ] ">
		<div></div>
	</div>
	<div class="[ text-center ] [ margin-bottom ]">
		<a class="[ button button--hollow button--dark ][ inline-block ][ hidden--xmall ][ js-cargar-mas ]">
			Cargar más
		</a>
	</div><!-- .text-center -->
<?php get_footer(); ?>