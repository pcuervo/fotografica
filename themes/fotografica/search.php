<?php get_header(); ?>

			<div class="main clearfix">
				
				<div <?php body_class('content clearfix col_2 left'); ?> >

					<h4>Tu búsqueda
							<em><?php the_search_query(); ?></em>
						obtuvo
						<?php
							$searchQueryArgs = array(
								"s" 				=> $s,
								"posts_per_page"	=> "-1"
								);
							$allsearch = new WP_Query($searchQueryArgs);
							$key = esc_html($s, 1);
							$count = $allsearch->post_count;
							_e('');
							echo $count . ' ';
							wp_reset_query();?>
						resultados.</h4>

					<?php
					$index = 1;
					if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

						<div class="link_articulo search-results caja left col_1 <?php if ( $index % 2 == 0 ){ echo 'last'; } ?> ">

							<div class="link_articulo_info">
								<h3><a class="exclude" href="<?php the_permalink(); ?>"><?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '\0', $title); echo $title; ?></a></h3>

								<a class="search-results-url exclude" href="<?php the_permalink(); ?>"> <?php the_permalink(); ?> </a>
								<p><?php the_excerpt() ?></p>

							</div><!-- link_articulo_info -->
						</div><!-- link_articulo -->

					<?php endwhile; endif; ?>

					<?php
						global $wp_query;

						$big = 999999999; // need an unlikely integer

						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages
						) );
					?>

				</div><!-- content -->
			</div><!-- main -->
<?php get_footer(); ?>