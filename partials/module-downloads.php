<?php if( have_rows('downloads') ): ?>
<?php while( have_rows('downloads') ): the_row(); ?>
<div class="download-item">
	<?php $file = get_sub_field('file'); ?>
	<a href="<?php echo $file['url']; ?>">Download <?php echo $file['name']; ?></a>
</div>
<?php endwhile; ?>
<?php endif; ?>