<?php get_header();
	$bgArchive = '';
	$args = array(
		'post_type' 		=> 'fotografias',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand'
	);
	$queryFotografias = new WP_Query( $args );
	if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post(); ?>
		<?php $bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' ); ?>
	<?php endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				Colecciones <br /><span class="[ sub-title ] [ block xmall-12 ] [ text-center ]">Lorem ipsum dolro sit amet</span>
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]"><a href="#" class="[ media-info__author ]">Gerardo Suter</a>, <a href="#" class="[ media-info__name ]">El trapo negro</a>, <span class="[ media--info__place ]">Egipto</span>, <span class="[ media--info__date ]">1986</span></p>
				<div class="[ media-info__tags ] [ text-center ]">
					<a href="#" class="[ tag ]">#méxico</a>
					<a href="#" class="[ tag ]">#norte</a>
					<a href="#" class="[ tag ]">#transporte</a>
				</div>
			</div>
		</div>
	</section>
	<section class="[ filters ] [ margin-bottom--small ]">
		<div class="[ filters__tabs ] [ clearfix ]">
			<div class="[ wrapper ]">
				<div class="[ row ]">
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="colecciones">Colecciones</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="fotografos">Fotógrafos</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="decada">Década</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="tema">Tema</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="buscar">Buscar</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="opciones">Opciones</a>
				</div><!-- row -->
			</div><!-- wrapper -->
		</div><!-- filters__tabs -->
		<div class="[ filters__content ] [ text-center ]">
			<div class="[ filter-colecciones ]">
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Manuel Álvarez Bravo <span><i class="fa fa-info-circle"></i></span></a>
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Centro Cultural de Arte Contemporáneo <span><i class="fa fa-info-circle"></i></span></a>
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Nuevas adquisiciónes <span><i class="fa fa-info-circle"></i></span></a>
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Favoritas <span><i class="fa fa-info-circle"></i></span></a>
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Foto+media <span><i class="fa fa-info-circle"></i></span></a>
			</div><!-- .filter-colecciones -->
			<div class="[ filter-fotografos ]">
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">A</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">C</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">E</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">G</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">I</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">K</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">M</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">O</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Q</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">S</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">U</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">W</a>
				<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Z</a>
			</div><!-- .filter-fotografos -->
			<div class="[ filter-decada ]">
				<a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">1960</a>
			</div><!-- .filter-decada -->
			<div class="[ filter-tema ]">
				<a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">#méxico</a>
			</div><!-- .filter-tema -->
			<div class="[ filter-buscar ]">
				<form class="[ margin-bottom--small ]" action="">
					<fieldset class="[ row ]">
						<input class="[ columna xmall-10 ]" type="email" placeholder="¿Qué quieres ver?">
						<button class="[ columna xmall-2 ]" type="submit">
							<i class="fa fa-search"></i>
						</button>
					</fieldset>
				</form>
			</div><!-- .filter-buscar -->
			<div class="[ filter-opciones ]">
			</div><!-- .filter-opciones -->
		</div><!-- filters__content -->
		<div class="[ filters__results ] [ padding--small text-center ]">
			<p class="[ uppercase ]">2,396 resultados con los filtros:</p>
			<a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">#méxico</a>
			<a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">1960</a>
		</div>
	</section><!-- .filters -->
	<section class="[ results ] [ row ] [ margin-bottom ]">
	<?php
		$args = array(
			'post_type' 		=> 'fotografias',
			'posts_per_page' 	=> 22,
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
				$authorColeccionesName 	= NULL;
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
			<article class="[ result ] [ columna xmall-6 medium-4 large-3 ] [ margin-bottom-small ]">
				<div class="[ relative ]">
					<a class="[ block ]" href="<?php ?>">
						<?php the_post_thumbnail('medium', array('class' => '[ image-responsive ]')); ?>
						<span class="[ opacity-gradient--full ]"></span>
						<div class="[ media-info media-info--small ] [ xmall-12 ]">
							<p class="[ text-center ]">

								<!-- NOMBRE APELLIDO -->
								<?php if ( $authorColeccionesName ){ ?>
									<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>
								<?php } else { ?>
									<span>sin autor</span>
								<?php } ?>

								<!-- TÍTULO -->
								<?php if ( $titleColecciones ){ ?>
									, <a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>
								<?php } else { ?>
									, <a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]">sin título</a>
								<?php } ?>

								<!-- DE LA SERIE -->
								<?php if ( $seriesColecciones ){ ?>
									, de la serie <span class="[ media--info__series ]"><?php echo $seriesColecciones; ?></span>
								<?php } ?>

								<!-- LUGAR -->
								<?php if ( $placeColecciones ){ ?>
									, <span class="[ media--info__place ]"><?php echo $placeColeccionesName; ?></span>
								<?php } ?>

								<!-- CIRCA -->
								<?php if ( $circaColecciones ){ ?>
									, <span class="[ media--info__circa ]">circa</span>
								<?php } ?>

								<!-- AÑO -->
								<?php if ( $dateColecciones ){ ?>
									, <span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
								<?php } ?>
							</p>
						</div>
					</a>
				</div><!-- .relative -->
			</article>
		<?php endwhile; endif; wp_reset_query(); ?>
	</section><!-- .results -->
	<div class="[ text-center ] [ margin-bottom ]">
		<a class="[ button button--hollow button--dark ] [ inline-block ]">
			Cargar más
		</a>
	</div><!-- .text-center -->
<?php get_footer(); ?>