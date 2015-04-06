<?php
	get_header();

	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();
	if( $postType == 'carteleras' ){
		$postType = 'cartelera';
	}

	/*------------------------------------*\
	    #ARCHIVE HERO
	\*------------------------------------*/
	$bgArchive       = '';
	$titleCartelera  = '';
	$inicioCartelera = '';
	$finCartelera = '';
	$args = array(
		'post_type' 		=> 'carteleras',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryCarteleras = new WP_Query( $args );
	if ( $queryCarteleras->have_posts() ) : while ( $queryCarteleras->have_posts() ) : $queryCarteleras->the_post();

		$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$titleCartelera = get_the_title( $post->ID );
		if ( strpos($titleCartelera, 'Sin título') !== false OR $titleCartelera == '' OR strpos($titleCartelera, '&nbsp') !== false ){
			$titleCartelera = NULL;
		}

		$inicioCartelera = get_post_meta($post->ID, '_evento_fecha_inicial_meta', true);
		$finCartelera = get_post_meta($post->ID, '_evento_fecha_final_meta', true);

		$permalinkCartelera = get_permalink( $post->ID );


	endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ] <?php if ( $postType == 'proyectos' OR $postType == 'exposiciones' ){ echo '[ margin-bottom--small ]'; } ?> " style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType; ?> <br />
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]">

					<!-- TÍTULO -->
					<?php if ( $titleCartelera ){ ?>
						<a href="<?php echo $permalinkCartelera; ?>" class="[ media--info__name ]"><?php echo $titleCartelera; ?></a>
					<?php } ?>


					<!-- AÑO -->
					<?php if ( $inicioCartelera && $finCartelera ){ ?>
						<span class="[ media--info__date ]"><?php echo $inicioCartelera.' - '.$finCartelera; ?></span>
					<?php } ?>

				</p>
			</div>
		</div>
	</section>


	<?php

		/*------------------------------------*\
		    #Revert $posttype variable value
		\*------------------------------------*/

		if( $postType == 'carteleras' ){
			$postType = 'cartelera';
		}
	?>

	<section class="[ filters ] [ margin-bottom--small ]">
		<div class="[ filters__tabs ] [ clearfix ]">
			<div class="[ wrapper ]">
				<div class="[ row ]">
					<!--  /********************************\ -->
						<!-- #CARTELERA -->
					<!--  \**********************************/ -->
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="fecha">Fecha</a>
				</div><!-- row -->
			</div><!-- wrapper -->
		</div><!-- filters__tabs -->
		<div class="[ filters__content ] [ text-center ]">

			<!--  /********************************\ -->
				<!-- #CARTELERA -->
			<!--  \**********************************/ -->
			<div class="[ filter-fecha ]">
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ] " data-type="eventos" data-value="anteriores">Eventos anteriores</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="eventos" data-value="hoy">Hoy</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="eventos" data-value="proximos">Próximos eventos</a>
			</div><!-- .filter-fecha -->

		</div><!-- filters__content -->
		<div class="[ filters__results ] [ padding--small text-center ]">
			<p class="[ uppercase ] [ js-num-resultados ]"><span></span> resultados totales con los filtros:</p>
		</div>
	</section><!-- .filters -->
	<!-- /** -->
	<!-- * If the post type is different from "fotografias" add wrapper and center it so the results do not use the full width -->
	<!-- **/ -->
	<section class="[ results ] [ row row--no-margins ] [ margin-bottom ]">
	</section><!-- .results -->
	<div class="[ loader ] [ center ] ">
		<div></div>
	</div>
	<div class="[ text-center ] [ margin-bottom ]">
		<a class="[ button button--hollow button--dark ] [ inline-block ] [ js-cargar-mas ]">
			Cargar más
		</a>
	</div><!-- .text-center -->
<?php get_footer(); ?>