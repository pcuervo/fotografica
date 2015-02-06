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
				<?php 
					$args = array(
					    'orderby'		=> 'name', 
					    'order'         => 'ASC',
					    'hide_empty'    => true, 
					); 
					$terms = get_terms('coleccion', $args);
					foreach ($terms as $key => $term) {
				?>
						<a class="[ filter filter--info ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]" data-type="coleccion" data-value="<?php echo $term->slug ?>"><?php echo $term->name ?><span><i class="fa fa-info-circle"></i></span></a>
				<?php
					}
				?>
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
			<p class="[ uppercase ] [ js-num-resultados ]"><span></span> resultados con los filtros:</p>
			<!-- a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">#méxico</a>
			<a class="[ filter filter--active ] [ button button--hollow button--small button--dark ] [ inline-block margin-bottom--small ]">1960</a> -->
		</div>
	</section><!-- .filters -->
	<section class="[ results ] [ row ] [ margin-bottom ]">
		
	</section><!-- .results -->
	<div class="[ text-center ] [ margin-bottom ]">
		<a class="[ button button--hollow button--dark ] [ inline-block ]">
			Cargar más
		</a>
	</div><!-- .text-center -->
<?php get_footer(); ?>