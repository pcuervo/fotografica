<?php
	get_header();

	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();

	/*------------------------------------*\
	    #ARCHIVE HERO
	\*------------------------------------*/
	$bgArchive = '';
	$coleccionPublicaciones = '';
	$authorPublicaciones = '';
	$titlePublicaciones = '';
	$seriesPublicaciones = '';
	$placePublicaciones = '';
	$circaPublicaciones = 0;
	$datePublicaciones = '';
	$args = array(
		'post_type' 		=> 'Publicaciones',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryFotografias = new WP_Query( $args );
	if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post();

		$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$titlePublicaciones = get_the_title( $post->ID );
		if ( strpos($titlePublicaciones, 'Sin título') !== false OR $titlePublicaciones == '' OR strpos($titlePublicaciones, '&nbsp') !== false ){
			$titlePublicaciones = NULL;
		}

		$permalinkPublicacion = get_permalink( $post->ID );

	endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType; ?> <br />
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]">
					<!-- TÍTULO -->
					<?php if ( $titlePublicaciones ){ ?>
						<a href="<?php echo $permalinkPublicacion; ?>" class="[ media--info__name ]"><?php echo $titlePublicaciones; ?></a>
					<?php } ?>
				</p>
			</div>
		</div>
	</section>

	<section class="[ filters ] [ margin-bottom--small ]">
		<div class="[ filters__tabs ] [ clearfix ]">
			<div class="[ wrapper ]">
				<div class="[ row ]">
					<!--  /********************************\ -->
						<!-- #PUBLICACIONES -->
					<!--  \**********************************/ -->
					<?php if ( $postType == 'publicaciones' ){ ?>
						<a class="[ tab-filter ][ text-center ][ columna xmall-4 medium-2 ]" href="#" data-filter="publicaciones">Tipo</a>
					<?php } ?>
				</div><!-- row -->
			</div><!-- wrapper -->
		</div><!-- filters__tabs -->
		<div class="[ filters__content ] [ text-center ]">
			<!--  /********************************\ -->
				<!-- #PUBLICACIONES -->
			<!--  \**********************************/ -->
			<?php if ( $postType == 'publicaciones' ){ ?>
				<div class="[ filter-publicaciones ]">
					<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ] " data-type="tipo" data-value="nuestras-publicaciones">Nuestra publicaciones</a>
					<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="tipo" data-value="coediciones">Coediciones</a>
				</div><!-- .filter-fecha -->
			<?php } ?>
		</div><!-- filters__content -->
		<div class="[ filters__results ] [ padding--small text-center ]">
			<p class="[ uppercase ] [ js-num-resultados ]"><span></span> resultados totales con los filtros:</p>
		</div>
	</section><!-- .filters -->

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