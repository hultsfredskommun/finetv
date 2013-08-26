<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */


	require_once( 'external/starkers-utilities.php' );
	require_once( 'acf-include.php' );

	


	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

	add_filter( 'body_class', 'add_slug_to_body_class' );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function script_enqueuer() {

		wp_register_script( 'transit', get_template_directory_uri().'/js/jquery.transit.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'transit' );

		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_template_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}	


	/*
		Removes the version on the script and the css files
	*/
	function control_wp_url_versioning($src)
	{
	    // $src is the URL that WP has generated for the script or stlye you added 
	    // with wp_enqueue_script() or wp_enqueue_style(). This function currently 
	    // removes the version string off *all* scripts. If you need to do something 
	    // different, then you should do it here.
	    $src = remove_query_arg( 'ver', $src );
	    return $src;
	}

	// The default script priority is 10. We load these filters with priority 15 to 
	// ensure they are run *after* all the default filters have run. 
	add_filter('script_loader_src', 'control_wp_url_versioning', 15); 
	add_filter('style_loader_src', 'control_wp_url_versioning', 15); 



	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}


	function isValidTime($to,$from, $timezone = 'Europe/Stockholm')
	{
		$from_timestamp = "";
		$to_timestamp = "";

		date_default_timezone_set($timezone);

		$isValidTime = false;

		$today_timestamp = time();

		$now = date("Y-m-d h:i:s",$today_timestamp);

		/* If its only time prefix the current date */
		if(is_time24($to))
		{
			$to = date("Y-m-d").' '.$to;
		}

		/* If its only time prefix the current date */
		if(is_time24($from))
		{
			$from = date("Y-m-d").' '.$from;
		}

				
		if($from != "")
		{
			$from_timestamp = strtotime($from);
		}

		if($to != "")
		{
			$to_timestamp = strtotime($to);
		}
		
		if(($from_timestamp == ""|| $from_timestamp == null ) && ($to_timestamp == "" || $to_timestamp == null ))
		{
			$isValidTime = true;
		}
		else if($today_timestamp >= $from_timestamp && $today_timestamp <= $to_timestamp)
		{
			$isValidTime = true;
		} 
		else if($today_timestamp >= $from_timestamp && ($to == "" || $to == null ))
		{
			$isValidTime = true;
		}
		else if($today_timestamp <= $to_timestamp && ($from == null || $from == ""))
		{
			$isValidTime = true;
		}

		return $isValidTime;

	}

	add_action( 'init', 'create_slide_cms_post_types' );

function create_slide_cms_post_types() {
	register_post_type( 'slide',
		array(
			'labels' => array(
			'name' => __( 'Sidor' ),
			'singular_name' => __( 'sida' ),
			'add_new' => __( 'Lägg till ny' ),
			'add_new_item' => __( 'Lägg till ny sida' ),
			'edit' => __( 'Ändra' ),
			'edit_item' => __( 'Ändra sida' ),
			'new_item' => __( 'Ny sida' ),
			'view' => __( 'Se sida' ),
			'view_item' => __( 'Se sida' ),
			'search_items' => __( 'Sök sida' ),
			'not_found' => __( 'Inga sidor hittades' ),
			'not_found_in_trash' => __( 'Inga sidor i papperskorgen' ),
			'parent' => __( 'Förälder till sida' ),
			),
			'public' => true,
			'query_var' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			//'rewrite' => false 
			'rewrite' => array( 'slug' => 'slide', 'with_front' => true )
		)
	);
	register_post_type( 'slide_settings',
		array(
			'labels' => array(
			'name' => __( 'Inställningssidor' ),
			'singular_name' => __( 'Inställningssida' ),
			'add_new' => __( 'Lägg till ny' ),
			'add_new_item' => __( 'Lägg till ny inställningssida' ),
			'edit' => __( 'Ändra' ),
			'edit_item' => __( 'Ändra inställningssida' ),
			'new_item' => __( 'Ny inställningssida' ),
			'view' => __( 'Se inställningssida' ),
			'view_item' => __( 'Se inställningssida' ),
			'search_items' => __( 'Sök inställningssidor' ),
			'not_found' => __( 'Inga inställningssidor hittades' ),
			'not_found_in_trash' => __( 'Inga inställningssidor i papperskorgen' ),
			'parent' => __( 'Förälder till inställningssida' ),
			),
			'public' => true,
			'query_var' => true,
			'has_archive' => true,
			//'rewrite' => false 
			'rewrite' => array( 'slug' => 'settings', 'with_front' => true )
		)
	);

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name' => _x( 'Plats för skärm', 'taxonomy general name' ),
		'singular_name' => _x( 'Plats för skärm', 'taxonomy singular name' ),
		'search_items' =>  __( 'Sök efter skärmar' ),
		'popular_items' => __( 'Populära platser för skärmar' ),
		'all_items' => __( 'Alla skärmar' ),
		'parent_item' => __( 'Förälder skärm' ),
		'parent_item_colon' => __( 'Förälder skärm:' ),
		'edit_item' => __( 'Ändra skärm' ), 
		'update_item' => __( 'Uppdatera skärm' ),
		'add_new_item' => __( 'Lägg till skärm' ),
		'new_item_name' => __( 'Ny skärm' ),
		'menu_name' => __( 'Platser skärm' ),
	); 

	register_taxonomy('place',array('slide','slide_settings'),array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'platser' ),
	));

	}

	add_filter( 'manage_edit-slide_columns', 'my_edit_slide_columns' ) ;

function my_edit_slide_columns( $columns ) {

  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Namn' ),
    'place' => __( 'Skärm' ),
    'from' => __('Visas från'),
    'to' => __('Visas till'),
    'date' => __( 'Datum' )
  );

  return $columns;
}


add_action( 'manage_slide_posts_custom_column', 'my_manage_slide_columns', 10, 2 );

function my_manage_slide_columns( $column, $post_id ) {
  global $post;


  $schedule_mode = get_field('time_settings_choise', $post_id);



   if ( empty( $schedule_mode ) )
   {
   	$schedule_mode = "no";
   }

  switch( $column ) {


/* If displaying the 'annr' column. */
    
    /* If displaying the 'raanr' column. */
    case 'from' :

		/* Get the post meta. */
	  	$from = get_post_meta( $post_id, 'from', true );
		
		if ( empty( $from ) )
			echo __( '-' );
		else
			echo Date("Y-m-d H:i",$from);
		break;

	case 'to' :

		$to = get_post_meta( $post_id, 'to', true );
	  
		if ( empty( $to ) )
			echo __( '-' );
		else
			echo Date("Y-m-d H:i",$to);

		break;


      /* If displaying the 'place' column. */
    case 'place' :

      /* Get the genres for the post. */
      $terms = get_the_terms( $post_id, 'place' );

      /* If terms were found. */
      if ( !empty( $terms ) ) {

        $out = array();

        /* Loop through each term, linking to the 'edit posts' page for the specific term. */
        foreach ( $terms as $term ) {
          $out[] = sprintf( '<a href="%s">%s</a>',
            esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'place' => $term->slug ), 'edit.php' ) ),
            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'place', 'display' ) )
          );
        }

        /* Join the terms, separating them with a comma. */
        echo join( ', ', $out );
      }

      /* If no terms were found, output a default message. */
      else {
        _e( '-' );
      }

      break;

    /* Just break out of the switch statement for everything else. */
    default :
      break;
  }
}

add_filter( 'manage_edit-slide_sortable_columns', 'my_slide_sortable_columns' );

function my_slide_sortable_columns( $columns ) {

  $columns['to'] = 'to';
  $columns['from'] = 'from';

  return $columns;
}


function is_time24($val) 
{ 
	return (bool)preg_match("/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/", $val); 
} 

function get_image($image_id, $image_mode)
{

	$image_size_name = "";
	switch ($image_mode) {
		case 'half-left':
			$image_size_name = "half";
			break;
		case 'half-right':
			$image_size_name = "half";
			break;
		case 'whole':
			$image_size_name = "whole";
			break;
		default:
			return ""; // break and return empty
	}
	// if normal
	if ($image_size_name == "large") {
		$image = wp_get_attachment_image( $image_id, $image_size_name );
		if ($image != "")
			return "<div class='slide_image $image_mode $image_size_name'>$image</div>";
		
		// else try smaller size
		$image_size_name = "medium";
		$image = wp_get_attachment_image( $image_id, $image_size_name );
		if ($image != "")
			return "<div class='slide_image $image_mode $image_size_name'>$image</div>";
	}
	else { // if half or whole
		$image = wp_get_attachment_image( $image_id, $image_size_name );
		if ($image != "")
			return "<div class='slide_image $image_mode $image_size_name'>$image</div>";
		
		// else try smaller size
		$image_size_name .= "2";
		$image = wp_get_attachment_image( $image_id, $image_size_name );
		if ($image != "")
			return "<div class='slide_image $image_mode $image_size_name'>$image</div>";
	}
	$image = wp_get_attachment_image( $image_id, $image_size_name );
	if ($image != "")
		return "<div class='slide_image $image_mode $image_size_name'>$image</div>";

	return "";
}

	function edit_admin_menus() {  
	    global $menu;  
	    global $submenu;  
	    
		remove_menu_page('edit.php'); // Remove the post menu
		remove_menu_page('link-manager.php'); // Remove the link manager menu
	    remove_menu_page('edit.php?post_type=page'); // Remove the page menu
	    remove_menu_page('edit-comments.php'); // Remove the comments Menu
	}  
	add_action( 'admin_menu', 'edit_admin_menus' );  

	function custom_menu_order($menu_ord) {  
		if (!$menu_ord) return true;  
		return array(  
			'index.php', // Dashboard  
			'separator1', // First separator  
			'edit.php?post_type=slide',
			'edit.php?post_type=slide_settings',
			'edit.php', // Posts  
			'upload.php', // Media  
			'link-manager.php', // Links  
			'edit.php?post_type=page', // Pages  
			'edit-comments.php', // Comments  
			'separator2', // Third separator 
			'themes.php', // Appearance
			
			'plugins.php', // Plugins  
			'users.php', // Users  
			'tools.php', // Tools  
			'options-general.php', // Settings  
			'separator-last', // Last separator  
		);  
	} 
	add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order  
	add_filter('menu_order', 'custom_menu_order');

	add_image_size( 'half',960,1080,true ); // Half size
	add_image_size( 'whole',1920,1080,true ); // Full size
	add_image_size( 'half2',512,768,true ); // Half size
	add_image_size( 'whole2',1024,768,true ); // Full size