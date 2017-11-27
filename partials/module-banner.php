<?php 

/*

Front-end:
- Needs picturefill.js
- Maybe ofi.browser.js if we are using object-fit
- imagesloaded.js
- jquery.cycle.js
- logic

CSS:
- All styles inside scss/components/banner.scss


*/

$images = get_field('banner');
if( $images ):
 ?>
<div class="banner-wrap">
    <div class="banner-preloader">
    	<?php 
        while( have_rows('banner') ): the_row(); 
        	$image = get_sub_field('photo');
        ?>
        <img src="<?php echo $image['sizes']['banner']; ?>" >
        <?php endwhile; ?>
    </div>
    <div class="banner">
        <?php 
        while( have_rows('banner') ): the_row(); 
        	$image = get_sub_field('photo');
        ?>

        <div class="banner-slide">
        	<picture>
                <source media="(min-width: 768px)" srcset="<?php echo $image['sizes']['banner']; ?>">
                <img src="<?php echo $image['sizes']['banner-mobile']; ?>" alt="<?php echo $image['alt']; ?>">
            </picture>
            <?php if( get_sub_field('quote') ): ?>
            <div class="banner-overlay">
            	<blockquote>
            		<p><?php the_sub_field('quote'); ?></p>
            		<footer><?php the_sub_field('cite'); ?></footer>
            	</blockquote>
            </div>
        	<?php endif; ?>
        </div>

        <?php endwhile; ?>
        <?php if( count($images) > 1 ): ?>
        <div class="cycle-pager"></div>
        <div class="cycle-next"></div>
        <div class="cycle-prev"></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
