<?php 
$hero = get_field('hero_strip'); 
if( $hero ):
?>
<section class="hero-strip">
	<picture>
        <source media="(min-width: 768px)" srcset="<?php echo $hero['sizes']['hero']; ?>">
        <img src="<?php echo $hero['sizes']['hero-mobile']; ?>" alt="<?php echo $hero['alt']; ?>">
    </picture>
</section>
<?php endif; ?>