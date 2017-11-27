		<?php
		if (has_nav_menu('footer_navigation')) :
		  wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'main-footer-links']);
		endif;
		?>

		<nav class="social-links">
            <ul>
                <?php while( have_rows('social_links','options') ): the_row(); ?>
                <li><a href="<?php the_sub_field('url'); ?>"><i class="fa <?php the_sub_field('icon'); ?>"></i></a></li>
                <?php endwhile; ?>
            </ul>
        </nav>

        <?php wp_footer(); ?>

    </body>
</html>