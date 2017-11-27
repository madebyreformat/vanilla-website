<?php 
$gmap = get_field('map','options'); 
if( $gmap ):
?>
<div class="gmap" id="gmap" data-lng="<?php echo $gmap['lng']; ?>" data-lat="<?php echo $gmap['lat']; ?>" data-map-style="<?php the_sub_field('map_style_code'); ?>"></div>
<?php endif; ?>