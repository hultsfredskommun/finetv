<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_header(); ?>

<div id="slide">
<?php 
$global_count = 1;
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php include("slide-content.php");	?>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>