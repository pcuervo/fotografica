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
	if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post(); ?>
		<?php

			$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

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
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType; ?> <br /><span class="[ sub-title ] [ block xmall-12 ] [ text-center ]">Lorem ipsum dolro sit amet</span>
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]">

				<!-- COLECCION -->
				De la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

				<!-- NOMBRE APELLIDO -->
				<?php if ( $authorColeccionesName == 'sin autor' ){ ?>
					<span><?php echo $authorColeccionesName; ?></span>,
				<?php } else { ?>
					<a href="<?php echo site_url( $authorColeccionesSlug ); ?>" class="[ media--info__author ]"><?php echo $authorColeccionesName;?></a>,
				<?php } ?>

				<!-- TÍTULO -->
				<?php if ( $titleColecciones ){ ?>
					<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleColecciones; ?></a>,
				<?php } else { ?>
					<span class="[ media--info__name ]">sin título</span>,
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
					<span class="[ media--info__circa ]">circa</span>
				<?php } ?>

				<!-- AÑO -->
				<?php if ( $dateColecciones ){ ?>
					<span class="[ media--info__date ]"><?php echo $dateColeccionesName; ?></span>
				<?php } ?>
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


	<section class="[ filters ] [ margin-bottom--small ]">
		<div class="[ filters__tabs ] [ clearfix ]">
			<div class="[ wrapper ]">
				<div class="[ row ]">
					<!--  /********************************\ -->
						<!-- #FOTOGRAFOS -->
					<!--  \**********************************/ -->
					<?php if ( $postType == 'fotografos' ){ ?>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="colecciones">Colecciones</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="pais">País</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="decada">Década</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="tema">Tema</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="apellido">Apellido</a>
					<?php } ?>
				</div><!-- row -->
			</div><!-- wrapper -->
		</div><!-- filters__tabs -->
		<div class="[ filters__content ] [ text-center ]">
			<!--  /********************************\ -->
				<!-- #FOTOGRAFOS -->
			<!--  \**********************************/ -->
			<?php if ( $postType == 'fotografos' ){ ?>
				<div class="[ filter-colecciones ]">
					<?php
						$args = array(
							'orderby'		=> 'name',
							'order'         => 'ASC',
							'hide_empty'    => true
						);
						$terms = get_terms('coleccion', $args);
						foreach ($terms as $key => $term) {
					?>
							<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $term->slug ?>"><?php echo $term->name ?><span><i class="fa fa-info-circle"></i></span></a>
					<?php
						}
					?>
				</div><!-- .filter-colecciones -->
			<?php } ?>
			<div class="[ filter-pais ]">
			</div><!-- .filter-pais -->
			<div class="[ filter-decada ]">
				<?php
					$args = array(
					    'orderby'		=> 'name',
					    'order'         => 'ASC',
					    'hide_empty'    => true,
					);
					$terms = get_terms('año', $args);
					$decadas = array();
					foreach ($terms as $key => $term) {
						if (strpos($term->name,'/') !== false) {
							$decada = 'sin fecha';
						} else if (strpos($term->name,'-') !== false) {
						    $rango_fechas = explode('-', $term->name);
						    $ano_inicial = substr(trim($rango_fechas[0]), 0, -1);
						    $ano_inicial = $ano_inicial.'0';
						    $ano_final = substr(trim($rango_fechas[1]), 0, -1);
						    $ano_final = $ano_final.'0';
						    array_push($decadas, $ano_inicial);
						    array_push($decadas, $ano_final);
						} else {
							$decada = substr($term->name, 0, -1);
							$decada = $decada.'0';
							array_push($decadas, $decada);
						}
					}
					$decadas = array_unique($decadas);
					foreach ($decadas as $decada) {
				?>
						<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="año" data-value="<?php echo $decada ?>"><?php echo $decada ?></a>
				<?php
					}
				?>
			</div><!-- .filter-decada -->
			<div class="[ filter-tema ]">
				<a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">#méxico</a>
			</div><!-- .filter-tema -->
			<div class="[ filter-apellido ]">
				<!-- <a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">Z</a> -->
			</div><!-- .filter-apellido -->
		</div><!-- filters__content -->
		<div class="[ filters__results ] [ padding--small text-center ]">
			<p class="[ uppercase ] [ js-num-resultados ]"><span></span> resultados con los filtros:</p>
		</div>
	</section><!-- .filters -->
	<div class="[ loader ] [ center ]">
		<div></div>
	</div>
	<section class="[ results ] [ row ] [ margin-bottom ]">
	</section><!-- .results -->
	<div class="[ text-center ] [ margin-bottom ]">
		<a class="[ button button--hollow button--dark ] [ inline-block ]">
			Cargar más
		</a>
	</div><!-- .text-center -->
<?php get_footer(); ?>