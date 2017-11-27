<?php if( have_rows('accordion') ): ?>
    <?php while( have_rows('accordion') ): the_row(); ?>
    <section class="accordion-item">
        <header class="header"><?php the_sub_field('header'); ?></header>
        <div class="drop">
            <div class="drop-content">
                <?php the_sub_field('content'); ?>
            </div>
        </div>
    </section>
    <?php endwhile; ?>
<?php endif; ?>