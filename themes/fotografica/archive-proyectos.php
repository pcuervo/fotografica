<?php
	get_header();

	/*------------------------------------*\
		#GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();

	/*------------------------------------*\
		#PROYECTOS HERO
	\*------------------------------------*/
	$bgArchive = '';
	$coleccionProyectos = '';
	$authorProyectos = '';
	$titleProyectos = '';
	$seriesProyectos = '';
	$placeProyectos = '';
	$circaProyectos = 0;
	$dateProyectos = '';
	$args = array(
		'post_type' 		=> 'proyectos',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand',
		'tax_query' 		=> array(
			array(
				'field' 	=> 'slug',
				'taxonomy' 	=> 'tipo-de-proyecto',
				'terms' 	=> 'individual'
			),
		)
	);
	$queryProyectos = new WP_Query( $args );
	if ( $queryProyectos->have_posts() ) : while ( $queryProyectos->have_posts() ) : $queryProyectos->the_post();
		$pattern = get_shortcode_regex();
		if( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( 'gallery', $matches[2] ) ):

			$keys = array_keys( $matches[2], 'gallery' );

			foreach( $keys as $key ):
				$atts = shortcode_parse_atts( $matches[3][$key] );
				if( array_key_exists( 'ids', $atts ) ):

					$images = new WP_Query(
						array(
							'post_type' => 'attachment',
							'post_status' => 'inherit',
							'post__in' => explode( ',', $atts['ids'] ),
							'orderby' => 'post__in'
						)
					);

					if( $images->have_posts() ):
						// loop over returned images

						$attachmentID 	=  $images->posts[0]->ID;
						//echo '$attachmentID '.$attachmentID.'<br />';
						$postID 		= get_post_id_by_attachment_id($attachmentID);

						//echo '$postID '.$postID.'<br />';
						$post 			= get_post( $postID->post_id );

						$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

						$coleccionProyectos 		= wp_get_post_terms( $post->ID, 'coleccion' );
						if ( $coleccionProyectos ){
							$coleccionProyectosName 	= $coleccionProyectos[0]->name;
							$coleccionProyectosSlug 	= $coleccionProyectos[0]->slug;
						}

						$authorProyectos 		= wp_get_post_terms( $post->ID, 'fotografo' );

						if ( $authorProyectos ){
							$authorProyectosName 	= $authorProyectos[0]->name;
							$authorProyectosSlug 	= $authorProyectos[0]->slug;
						} else {
							$authorProyectosName 	= 'Autor no identificado';
						}

						$titleProyectos = get_the_title( $post->ID );
						if ( strpos($titleProyectos, 'Sin título') !== false OR $titleProyectos == '' OR strpos($titleProyectos, '&nbsp') !== false ){
							$titleProyectos = NULL;
						}

						$seriesProyectos = 0;

						$placeProyectos = wp_get_post_terms( $post->ID, 'lugar' );
						if ( $placeProyectos ){
							$placeProyectosName 	= $placeProyectos[0]->name;
						}

						$circaProyectos = 0;

						$dateProyectos = wp_get_post_terms( $post->ID, 'año' );
						if ( $dateProyectos ){
							$dateProyectosName 	= $dateProyectos[0]->name;
						} else {
							$dateProyectosName 	= 's/f';
						}

						$themesProyectos = wp_get_post_terms( $post->ID, 'tema' );
						if ( ! $themesProyectos ){
							$themesProyectosName 	= '';
						}

						$permalinkColeccion = get_permalink( $post->ID );

					endif;
					wp_reset_query();
				endif;
			endforeach;
		endif;
	endwhile; endif; wp_reset_query();
?>

	<section class="[ proyectos ] [ bg-image ][ margin-bottom--small ]" style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType; ?> <br />
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]">

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorProyectosName == 'Autor no identificado' ){ ?>
						<span class="[ media--info__author ]"><?php echo $authorProyectosName; ?></span>,
					<?php } else { ?>
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