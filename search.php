<?php get_header(); ?>

	<?php if( !$wp_query->found_posts ): ?>
		<h1>No results</h1>
        <p>We couldn't find anything with that search query, please try again.</p>
    <?php
    else:
    while ( have_posts() ) : the_post();  ?>

		<h1>Search</h1>
		<p><?php echo $wp_query->found_posts; ?> search results for <em><?php the_search_query(); ?></em></p>
		
		<article <?php post_class(); ?>>
			<h1>
				<a href="<?php the_permalink(); ?>">
					<?php
          			$title 	= get_the_title();
          			$keys= explode(" ",$s);
          			echo preg_replace('/('.implode('|', $keys) .')/iu',
          			'<span class="search-excerpt">\0</span>',
          			$title);
          			?>
				</a>
			</h1>
            <p>
      		<?php
      		$excerpt 	= get_the_excerpt();
      		$keys= explode(" ",$s);
      		echo preg_replace('/('.implode('|', $keys) .')/iu',
      			'<span class="search-excerpt">\0</span>',
      			$excerpt);
      			?>
      		</p>
		</article>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>