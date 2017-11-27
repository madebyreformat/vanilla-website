<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>

    </head>
    <body <?php body_class(); ?>>

    	<h1><a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('title'); ?></a></h1>

    	<nav>
            <?php
            if (has_nav_menu('primary_navigation')) :
              wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu']);
            endif;
            ?>
        </nav>

        <?php get_search_form(); ?>

        <hr>
