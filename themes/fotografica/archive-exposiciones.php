<?php
	get_header();

	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();

	/*------------------------------------*\
		#EXPOSICIONES HERO
	\*------------------------------------*/
	$bgArchive = '';
	$coleccionExposiciones = '';
	$authorExposiciones = '';
	$titleExposiciones = '';
	$seriesExposiciones = '';
	$placeExposiciones = '';
	$circaExposiciones = 0;
	$dateExposiciones = '';
	$args = array(
		'post_type' 		=> 'exposiciones',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryExposiciones = new WP_Query( $args );
	if ( $queryExposiciones->have_posts() ) : while ( $queryExposiciones->have_posts() ) : $queryExposiciones->the_post();

		$bgExposiciones = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$titleExposiciones = get_the_title( $post->ID );
		if ( strpos($titleExposiciones, 'Sin título') !== false OR $titleExposiciones == '' OR strpos($titleExposiciones, '&nbsp') !== false ){
			$titleExposiciones = NULL;
		}

		$lugarYFechaExposiciones = get_post_meta($post->ID, '_lugar_y_fecha_exposicion_meta', true );

		$themesExposiciones = wp_get_post_terms( $post->ID, 'tema' );
		if ( ! $themesExposiciones ){
			$themesExposicionesName 	= '';
		}

		$permalinkColeccion = get_permalink( $post->ID );

	endwhile; endif; wp_reset_query();
?>

	<section class="[ exposiciones ][ bg-image ][ margin-bottom--small ] " style="background-image: url(<?php echo $bgExposiciones[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType; ?> <br />
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ][ ellipsis ]">

					<!-- TÍTULO -->
					<?php if ( $titleExposiciones ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleExposiciones; ?></a>,
					<?php } ?>

					<!-- LUGAR Y FECHA -->
					<?php if ( $lugarYFechaExposiciones ){ ?>
						<br /><span class="[ media--info__place ]"><?php echo $lugarYFechaExposiciones; ?></span>
					<?php } ?>

				</p>

			</div>
		</div>
	</section>



	<!-- /** -->
	<!-- * If the post type is different from "fotografias" add wrapper and center it so the results do not use the full width -->
	<!-- **/ -->
	<section class="[ results ] [ row row--no-margins ] [ margin-bottom ] <?php echo ($postType !== 'fotografias' ? '[ text-center ][ wrapper ][ center ]' : ''); ?>">
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