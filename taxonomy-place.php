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

<div id="black" class="hidden"></div>
<div id="progressbar"></div>
<div id="debug" class="hidden"><div class="slide"></div><div class="update"></div><div class="console"></div><div class="ajax"></div></div>
<div id="slide"></div>
<div id="source" class="hidden">

<div class="settings slide-item">
<?php
	/* get settings depending on place */
	$wpq = array (post_type =>'slide_settings','taxonomy'=>'place','term'=>$place);
	$myquery = new WP_Query ($wpq);
	if ( $myquery->have_posts()) : $myquery->the_post();
		$name = get_the_title();
		$frame_image = get_field('frame');
		$header_logo = get_field('header_logo');
		$footer_text = get_field("footer_text");
		$footer_background_color =  get_field('footer_background_color');
		$footer_text_color = get_field('footer_text_color');
		$blank_screen_from = get_field('blank_screen_from');
		$blank_screen_to = get_field('blank_screen_to');
		$screen_font_scale = get_field('screen_font_scale');
		$screen_background_color = get_field('screen_background_color');
		$screen_text_color = get_field('screen_text_color');
		$clock = get_field('clock');
	endif; 
	wp_reset_query();
?>
	<div class="settings_name"><?php echo $name; ?></div>
	<div class="frame_image"><?php echo $frame_image; ?></div>
	<div class="header_logo"><?php echo $header_logo; ?></div>
	<div class="footer_text"><?php echo $footer_text; ?></div>
	<div class="footer_background_color"><?php echo $footer_background_color; ?></div>
	<div class="footer_text_color"><?php echo $footer_text_color; ?></div>
	<div class="blank_screen_from"><?php echo $blank_screen_from; ?></div>
	<div class="blank_screen_to"><?php echo $blank_screen_to; ?></div>
	<div class="screen_font_scale"><?php echo $screen_font_scale; ?></div>
	<div class="screen_background_color"><?php echo $screen_background_color; ?></div>
	<div class="screen_text_color"><?php echo $screen_text_color; ?></div>
	<div class="clock"><?php echo $clock; ?></div>
	
</div>

<?php /* get slides depending on place */ ?>
<?php $mainquery = new WP_query(array (post_type =>'slide','taxonomy'=>'place','term'=>$place,'posts_per_page'=>1000)); ?>

<?php if ( $mainquery->have_posts() ) while ( $mainquery->have_posts() ) : $mainquery->the_post(); ?>
<?php include("slide-content.php"); ?>
<?php //comments_template( '', true ); ?>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>