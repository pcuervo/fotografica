<?php 
	global $post, $wp_query, $query_string;
	get_header(); 
?>
	<div class="wrapper">
		<br />
		<h2 class="[ text-center ]">Tu búsqueda
			<em class="[ color-highlighgt ]"><?php the_search_query(); ?></em>
			obtuvo
			<?php
				add_filter( 'posts_where', 'exclude_empty_title', 10, 2 );
				$searchQueryArgs = array(
					"s" 				=> $s,
					"posts_per_page"	=> "-1"
					);

				$allsearch = new WP_Query( $searchQueryArgs );
				query_posts( $query_string . 'cat=1&tag=apples' );
				$key = esc_html($s, 1);
				$count = $allsearch->post_count;
				_e('');
				echo $count . ' ';
				remove_filter( 'posts_where', 'exclude_empty_title', 10, 2 );
				wp_reset_query();?>
			resultados.</h4>

			<?php
			
			$index = 1;
			$new_count = 0;
			if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
				<?php

					if( $post->post_title == '&nbsp;' ) continue;

					$postType = get_post_type();

					switch ( $postType ) {
						case 'fotografos':
							$postType = 'fotógrafos';
							break;
						case 'carteleras':
							$postType = 'cartelera';
							break;
						case 'espacios-publicos':
							$postType = 'cartelera';
							break;
						case 'fotografias':
							$postType = 'colecciones';
							break;
					}
				?>
				<div class="[]">
					<h3><a class="exclude" href="<?php the_permalink(); ?>"><?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '\0', $title); echo $title; ?></a> <small>- <?php echo $postType; ?></small></h3>
				</div><!-- link_articulo -->

				
			<?php $new_count++; endwhile; endif; ?>

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
	</div><!-- wrapper -->

<?php get_footer(); ?>