<?php get_header(); ?>

	<?php $back_page = get_page_by_path('/news/'); // change this to whatever slug ?>
	
	<?php while ( have_posts() ) : the_post();  ?>
		
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
            <p><a href="<?php echo get_permalink( $back_page ); ?>">Back</a></p>
		</article>

	<?php endwhile; ?>

<?php get_footer(); ?>