<?php 
$map_image = get_field('map_image','options'); 
if( $map_image ):
?>
<picture>
    <source media="(min-width: 768px)" srcset="<?php echo $map_image['sizes']['map']; ?>">
    <img src="<?php echo $map_image['sizes']['map-mobile']; ?>" alt="<?php echo $map_image['alt']; ?>">
</picture>
<?php endif; ?>