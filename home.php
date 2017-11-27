<?php get_header(); ?>

	<nav class="resources-navbar">
        <?php
        if (has_nav_menu('resources_navigation')) :
          wp_nav_menu(['theme_location' => 'resources_navigation', 'menu_class' => 'menu']);
        endif;
        ?> 
    </nav>
	
	<?php while ( have_posts() ) : the_post();  ?>
		
		<article <?php post_class(); ?>>

			<h1><?php the_title(); ?></h1>
			<p><?php the_time( get_option('date_format') ); ?></p>
            <?php the_excerpt(); ?>
            <p><a href="<?php the_permalink(); ?>">Read</a></p>
		</article>

	<?php endwhile; ?>

	<navigation class="pagination">
        <?php echo paginate_links(); ?>
    </navigation>

<?php get_footer(); ?>