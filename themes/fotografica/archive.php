<?php
	get_header();

	/*------------------------------------*\
	    #GET THE POST TYPE
	\*------------------------------------*/
	$postType = get_post_type();
	if( $postType == 'fotografos' ){
		$postType = 'fotógrafos';
	}
	if( $postType == 'carteleras' ){
		$postType = 'cartelera';
	}

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
	if ( $queryFotografias->have_posts() ) : while ( $queryFotografias->have_posts() ) : $queryFotografias->the_post();

		$bgArchive = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full' );

		$coleccionColecciones 		= wp_get_post_terms( $post->ID, 'coleccion' );
		$coleccionColeccionesName 	= $coleccionColecciones[0]->name;
		$coleccionColeccionesSlug 	= $coleccionColecciones[0]->slug;

		$authorColecciones 		= wp_get_post_terms( $post->ID, 'fotografo' );

		if ( $authorColecciones ){
			$authorColeccionesName 	= $authorColecciones[0]->name;
			$authorColeccionesSlug 	= $authorColecciones[0]->slug;
		}  else {
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
	<section class="[ colecciones ] [ bg-image ] <?php if ( $postType == 'proyectos' OR $postType == 'exposiciones' ){ echo '[ margin-bottom--small ]'; } ?> " style="background-image: url(<?php echo $bgArchive[0]; ?>)">
		<div class="[ opacity-gradient rectangle ]">
			<h2 class="[ center-full ] [ title ]">
				<?php echo $postType == 'fotografias' ? 'fotografías' : $postType; ?> <br />
			</h2>
			<div class="[ media-info media-info--large ] [ xmall-12 ] [ shown--medium ]">
				<p class="[ text-center ]">

					<!-- NOMBRE APELLIDO -->
					<?php if ( $authorColeccionesName !== 'Autor no identificado' ){ ?>
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
								<a href="<?php echo site_url('$themeColeccionesName'); ?>" class="[ tag ]" target="_blank">#<?php echo $themeColeccionesName; ?></a>
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


	<?php

		/*------------------------------------*\
		    #Revert $posttype variable value
		\*------------------------------------*/

		if( $postType == 'carteleras' ){
			$postType = 'cartelera';
		}
	?>


	<!-- /** -->
	<!-- * If the post type is "proyectos" or "exposiciones" the do not display filters at all -->
	<!-- **/ -->
	<?php if ( $postType !== 'proyectos' AND $postType !== 'exposiciones' ){ ?>

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
							<a class="[ tab-filter ] [ text-center ] [ columna xmall-4 medium-2 ]" href="#" data-filter="tema">Tema</a>
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
	<?php } ?>
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