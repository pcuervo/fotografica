<?php
	get_header();
	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();
	if( $postType == 'fotografos' ){
		$postType = 'fotógrafos';
	}

	/*------------------------------------*\
	    #ARCHIVE HERO
	\*------------------------------------*/
	$bgArchive = '';
	$coleccionFotografos = '';
	$authorFotografos = '';
	$titleFotografos = '';
	$seriesFotografos = '';
	$placeFotografos = '';
	$circaFotografos = 0;
	$dateFotografos = '';
	$args = array(
		'post_type' 		=> 'fotografias',
		'posts_per_page' 	=> 1,
		'orderby' 			=> 'rand',
		'category_name'		=> 'cover'
	);
	$queryFotografos = new WP_Query( $args );
	if ( $queryFotografos->have_posts() ) : while ( $queryFotografos->have_posts() ) : $queryFotografos->the_post();

		$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$coleccionFotografos 		= wp_get_post_terms( $post->ID, 'coleccion' );
		$coleccionFotografosName 	= $coleccionFotografos[0]->name;
		$coleccionFotografosSlug 	= $coleccionFotografos[0]->slug;

		$authorFotografos 		= wp_get_post_terms( $post->ID, 'fotografo' );

		if ( $authorFotografos ){
			$authorFotografosName 	= $authorFotografos[0]->name;
			$authorFotografosSlug 	= $authorFotografos[0]->slug;
		}  else {
			$authorFotografosName 	= 'Autor no identificado';
		}

		$titleFotografos = get_the_title( $post->ID );
		if ( strpos($titleFotografos, 'Sin título') !== false OR $titleFotografos == '' OR strpos($titleFotografos, '&nbsp') !== false ){
			$titleFotografos = NULL;
		}

		$seriesFotografos = 0;

		$placeFotografos = wp_get_post_terms( $post->ID, 'lugar' );
		if ( $placeFotografos ){
			$placeFotografosName 	= $placeFotografos[0]->name;
		}

		if ( in_category('circa', $post->ID ) ){
			$circaFotografos = true;
		}

		$dateFotografos = wp_get_post_terms( $post->ID, 'año' );
		if ( $dateFotografos ){
			$dateFotografosName 	= $dateFotografos[0]->name;
		} else {
			$dateFotografosName 	= 's/f';
		}

		$themesFotografos = wp_get_post_terms( $post->ID, 'tema' );
		if ( ! $themesFotografos ){
			$themesFotografosName 	= '';
		}

		$permalinkFotografo = get_permalink( $post->ID );

	endwhile; endif; wp_reset_query(); ?>
	<section class="[ fotografos ] [ bg-image ]" style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType; ?> <br />
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]">

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorFotografosName !== 'Autor no identificado' ){ ?>
						<a href="<?php echo site_url( $authorFotografosSlug ); ?>" class="[ media--info__author ]"><?php echo $authorFotografosName;?></a>,
					<?php } ?>

					<!-- TÍTULO -->
					<?php if ( $titleFotografos ){ ?>
						<a href="<?php echo $permalinkColeccion; ?>" class="[ media--info__name ]"><?php echo $titleFotografos; ?></a>,
					<?php } ?>

					<!-- DE LA SERIE -->
					<?php if ( $seriesFotografos ){ ?>
						de la serie <span class="[ media--info__series ]"><?php echo $seriesFotografos; ?></span>,
					<?php } ?>

					<!-- LUGAR -->
					<?php if ( $placeFotografos ){ ?>
						<span class="[ media--info__place ]"><?php echo $placeFotografosName; ?></span>,
					<?php } ?>

					<!-- CIRCA -->
					<?php if ( $circaFotografos ){ ?>
						<span class="[ media--info__circa ]">ca. </span>
					<?php } ?>

					<!-- AÑO -->
					<?php if ( $dateFotografos ){ ?>
						<span class="[ media--info__date ]"><?php echo $dateFotografosName; ?></span>,
					<?php } ?>

					<!-- COLECCION -->
					<br />
					de la colección <a href="<?php echo site_url().'/colecciones?coleccion='.$coleccionFotografosSlug; ?>" class="[ media--info__colection ]"> <?php echo $coleccionFotografosName; ?></a>

				</p>

				<!-- TAGS -->
				<div class="[ media-info__tags ] [ text-center ]">
					<?php
						$themeCounter = 1;
						if ( $themesFotografosName ){
							foreach ($themesFotografosName as $themeFotografosName) {
								$themeFotografosName = $themeFotografosName->name; ?>
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
					<?php if ( $postType == 'fotógrafos' ){ ?>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="apellido">Apellido</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="pais">País</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="decada">Década</a>
						<!-- <a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="tema">Tema</a> -->
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="colecciones">Colecciones</a>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="buscar">Buscar</a>
					<?php } ?>
					<!--  /********************************\ -->
						<!-- #EVENTOS / CARTELERA -->
					<!--  \**********************************/ -->
					<?php if ( $postType == 'eventos' OR $postType == 'carteleras' ){ ?>
						<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="fecha">Fecha</a>
					<?php } ?>
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
				<!-- FOTÓGRAFOS -->
			<!--  \**********************************/ -->
			<?php if ( $postType == 'fotógrafos' ){ ?>
				<div class="[ filter-colecciones ]">
					<?php
						$termManuelAlvarez = get_term_by('slug', '0-coleccion-manuel-alvarez-bravo', 'coleccion');
						$termCCAC = get_term_by('slug', 'coleccion-centro-cultural-arte-contemporaneo', 'coleccion');
						$termFundacionTelevisa = get_term_by('slug', 'coleccion-fundacion-televisa', 'coleccion');
					?>
						<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $termManuelAlvarez->slug ?>" data-coleccion-term-id="<?php echo $termManuelAlvarez->term_id ?>"><?php echo $termManuelAlvarez->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $termManuelAlvarez->term_id ?>"><i class="fa fa-info-circle"></i></span></a>
						<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $termCCAC->slug ?>"><?php echo $termCCAC->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $termCCAC->term_id ?>"><i class="fa fa-info-circle"></i></span></a>
						<div class="[ clear ][ margin-bottom ]"></div>
						<h2 class="[ text-center ]"><?php echo $termFundacionTelevisa->name ?><span data-modal="info-coleccion" data-coleccion-term-id="<?php echo $termFundacionTelevisa->term_id ?>"></span></h2>
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
				<div class="[ filter-pais ]">
					<?php
						$args = array(
							'orderby'		=> 'name',
							'order' 		=> 'ASC',
							'hide_empty' 	=> true,
						);
						$terms = get_terms('pais', $args);
						foreach ($terms as $key => $term) {
					?>
							<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="pais" data-value="<?php echo $term->slug ?>"><?php echo $term->name ?></a>
					<?php
						}
					?>
				</div><!-- .filter-pais -->
				<div class="[ filter-decada ]">
					<?php
						$decadas = get_decadas_nacimiento();
						foreach ($decadas as $decada) {
							if( $decada == '0' ) continue;
					?>
							<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="decada-de-nacimiento" data-value="<?php echo $decada ?>"><?php echo $decada ?></a>
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
				<div class="[ filter-apellido ]">
					<?php
						$query = "
							SELECT DISTINCT LEFT(name, 1) as letter FROM wp_posts P
							INNER JOIN wp_term_relationships TR ON TR.object_id = P.id
							INNER JOIN wp_term_taxonomy TT ON TT.term_taxonomy_id = TR.term_taxonomy_id
							INNER JOIN wp_terms T ON T.term_id = TT.term_id
							WHERE P.post_type = 'fotografos'
							AND taxonomy = 'apellido'
							ORDER BY letter";
						$first_letters = $wpdb->get_results( $query );

						foreach ($first_letters as $letter) {
					?>
						<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="apellido" data-value="<?php echo $letter->letter ?>"><?php echo $letter->letter ?></a>
					<?php
						}
					?>
				</div><!-- .filter-apellido -->
				<div class="[ filter-buscar ]">
					<form class="[ form ]" action="">
						<fieldset class="[ columna xmall-12 medium-8 ][ center ]">
							<div class="input-group">
								<input type="text" placeholder="Buscar por nombre de fotógrafo">
								<span class="input-group-addon">
									<button type="submit"><i class="[ icon-search ]"></i></button>
								</span>
							</div>
						</fieldset>
					</form>
				</div><!-- .filter-buscar -->
			<?php } ?>





			<!--  /********************************\ -->
				<!-- #EVENTOS / CARTELERA -->
			<!--  \**********************************/ -->
			<?php if ( $postType == 'eventos' || $postType == 'carteleras' ){ ?>
				<div class="[ filter-fecha ]">
					<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ] " data-type="eventos" data-value="anteriores">Eventos anteriores</a>
					<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="eventos" data-value="hoy">Hoy</a>
					<a class="[ filter ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="eventos" data-value="proximos">Próximos eventos</a>
				</div><!-- .filter-fecha -->
			<?php } ?>

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
	<section class="[ results ] [ row row--no-margins ][ margin-bottom ][ text-center ][ wrapper ][ center ]">
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