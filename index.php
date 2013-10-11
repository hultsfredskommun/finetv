<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
/* ignore all cache */
define('DONOTCACHEPAGE', true);
//Disables page caching for a given page.
define('DONOTCACHEDB', true);
//Disables database caching for given page.
define('DONOTMINIFY', true);
//Disables minify for a given page.
define('DONOTCDN', true);
//Disables content delivery network for a given page.
define('DONOTCACHCEOBJECT', true);
//Disables object cache for a given page.
?>
<?php get_header(); ?>
<div id="primary">
<?php
	echo "<b>Tillg&auml;ngliga sk&auml;rmar</b>";

	$terms = get_terms("place");
	$count = count($terms);
	if ( $count > 0 ){
		echo "<ul>";
		foreach ( $terms as $term ) {
			$url = get_term_link($term->slug, 'place');
			echo "<li><a href='$url?always' title='".$term->name."'>". $term->name . "</a></li>";
		}
		echo "</ul>";
	}
?>
</div>
<?php get_footer(); ?>