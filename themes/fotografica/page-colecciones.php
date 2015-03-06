<?php get_header(); ?>

	<!-- /**************************************\ -->
	<!-- #COLECCIONES -->
	<!-- \**************************************/ -->
	<?php
	// ¿Hay algún filtro de colección?
	global $coleccion;
	$coleccion = (isset($_GET['coleccion'])) ? $_GET['coleccion'] : '';
	$filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : '';
	
	//if(isset($_GET['coleccion'])) $coleccion = $_GET['coleccion'];
	//if(isset($_GET['filtro'])) $filtro = $_GET['filtro'];

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
	if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post(); ?>
		<?php

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
	endwhile; endif; wp_reset_query(); ?>
	<section class="[ colecciones ] [ bg-image ]" style="background-image: url(<?php echo $bgColecciones[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				Colecciones
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--large ]">
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

				<!-- COLECCION -->
				<br /> de la colección <a href="<?php echo site_url( $coleccionColeccionesSlug ); ?>" class="[ media--info__colection ]"> <?php echo $coleccionColeccionesName; ?></a>,

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
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="colecciones">Colecciones</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="fotografos">Fotógrafos</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="decada">Década</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="tema">Tema</a>
					<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="buscar">Buscar</a>
				</div><!-- row -->
			</div><!-- wrapper -->
		</div><!-- filters__tabs -->
		<div class="[ filters__content ] [ text-center ]">
			<div class="[ filter-colecciones ]">
				<?php
					$termManuelAlvarez = get_term_by('slug', 'coleccion-manuel-alvarez-bravo', 'coleccion');
					$termCCAC = get_term_by('slug', 'coleccion-centro-cultural-arte-contemporaneo', 'coleccion');
					$termFundacionTelevisa = get_term_by('slug', 'coleccion-fundacion-televisa', 'coleccion');
				?>
					<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $termManuelAlvarez->slug ?>" data-coleccion-term-id="<?php echo $termManuelAlvarez->term_id ?>"><?php echo $termManuelAlvarez->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $termManuelAlvarez->term_id ?>"><i class="fa fa-info-circle"></i></span></a>
					<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $termCCAC->slug ?>"><?php echo $termCCAC->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $termCCAC->term_id ?>"><i class="fa fa-info-circle"></i></span></a>
					<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $termFundacionTelevisa->slug ?>"><?php echo $termFundacionTelevisa->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $termFundacionTelevisa->term_id ?>"><i class="fa fa-info-circle"></i></span></a>
					<div class="[ clear ][ margin-bottom ]"></div>
				<?php
					$args = array(
						'orderby'		=> 'name',
						'order' 		=> 'ASC',
						'hide_empty' 	=> true,
						'exclude'		=> array(
											$termManuelAlvarez->term_id,
											$termCCAC->term_id,
											$termFundacionTelevisa->term_id,
										)
					);
					$terms = get_terms('coleccion', $args);
					foreach ($terms as $key => $term) {
				?>
						<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $term->slug ?>"><?php echo $term->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $term->term_id ?>"><i class="fa fa-info-circle"></i></span></a>
				<?php
					}
				?>
			</div><!-- .filter-colecciones -->
			<div class="[ filter-fotografos ]">
				<?php
					$query = "
						SELECT DISTINCT LEFT(name, 1) as letter FROM wp_posts P
						INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
						INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
						INNER JOIN wp_terms T ON T.term_id = TT.term_id
						WHERE P.post_type = 'fotografias'
						AND taxonomy = 'fotografo'
						ORDER BY letter";
					$first_letters = $wpdb->get_results( $query );

					foreach ($first_letters as $letter) {
				?>
					<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="fotografo" data-value="<?php echo $letter->letter ?>"><?php echo $letter->letter ?></a>
				<?php
					}
				?>
			</div><!-- .filter-fotografos -->
			<div class="[ filter-decada ]">
				<?php
					$args = array(
						'orderby'		=> 'name',
						'order' 		=> 'ASC',
						'hide_empty' 	=> true,
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
				<?php
					$args = array(
						'orderby'		=> 'name',
						'order' 		=> 'ASC',
						'hide_empty' 	=> true,
					);
					$terms = get_terms('tema', $args);
					foreach ($terms as $key => $term) {
				?>
						<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="tema" data-value="<?php echo $term->name ?>"><?php echo $term->name ?></a>
				<?php
					}
				?>
			</div><!-- .filter-tema -->
			<div class="[ filter-buscar ]">
				<form class="[ form ]" action="">
					<fieldset class="[ columna xmall-12 medium-8 ][ center ]">
						<div class="input-group">
							<input type="text" placeholder="Buscar por título de fotografía">
							<span class="input-group-addon">
								<button type="submit"><i class="[ icon-search ]"></i></button>
							</span>
						</div>
					</fieldset>
				</form>
			</div><!-- .filter-buscar -->
			<div class="[ filter-nuevas-adquisiciones ] [ hide ]">
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="tema" data-value="nuevas-adquisiciones">Adquisiciones recientes</a>
			</div><!-- .filter-nuevas-adquisiciones -->
			<div class="[ filter-favoritos ] [ hide ]">
				<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="tema" data-value="favoritos">Favoritos</a>
			</div><!-- .filter-favoritos -->
		</div><!-- filters__content -->
		<div class="[ filters__results ] [ padding--small text-center ]">
			<p class="[ uppercase ] [ js-num-resultados ]"><span></span> resultados totales con los filtros:</p>
		</div>
	</section><!-- .filters -->
	<section class="[ results ] [ row row--no-margins ] [ margin-bottom ]">
	</section><!-- .results -->
	<div class="[ loader ] [ center ] ">
		<div></div>
	</div>
	<div class="clear"></div>
	<div class="[ text-center ] [ margin-bottom ]">
		<a class="[ button button--hollow button--dark ] [ inline-block ] [ js-cargar-mas ]">
			Cargar más
		</a>
	</div><!-- .text-center -->
<?php get_footer(); ?>