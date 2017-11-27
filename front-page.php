<?php get_header(); ?>
	
	<?php while ( have_posts() ) : the_post();  ?>
		
		<div class="banner-outer">
			<?php get_template_part('partials/module','banner'); ?>
		</div>

		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
		</article>

		<!-- news feed -->
		<section class="widget">
			<header>Latest news</header>
			<?php 
	        $args = array(
	            'posts_per_page'      => 3,
	            'post__in'            => get_option( 'sticky_posts' ),
	            'ignore_sticky_posts' => 1,
	        );
	        $query = new WP_Query($args);
	        while ($query->have_posts()) : $query->the_post();
	           ?>
				<article>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</article>
	           <?php 
	        endwhile; wp_reset_postdata(); ?>
			<footer><p><a href="<?php echo get_permalink( get_option('page_for_posts') ); ?>">View all news</a></p></footer>
		</section>
		


	<?php endwhile; ?>

<?php get_footer(); ?>