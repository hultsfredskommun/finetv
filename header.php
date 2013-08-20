<html><head>
<title><?php echo $place; ?> InfoTV</title>
<?php 
	wp_head();
?>
</head><body <?php post_class(is_home()?"home":""); ?>>
<?php 
if (isset($_REQUEST["reset"])) {
	setcookie( "infotv_redirect", "$place", time() - 60*60, "/"); 
}
if (isset($_REQUEST["always"])) {
	$place = get_term_link($place, 'place' );
	setcookie( "infotv_redirect", "$place", time() + (10 * 365 * 24 * 60 * 60), "/"); 
}
 ?>
<div id="tools" class="hidden">
	<div>Förhandsgranska:</div>
	<div class="forcesize" res="1024x768">1024x768</div>
	<div class="forcesize" res="1280x1024">1280x1024</div>
	<div class="forcesize" res="1920x1080">1920x1080</div>
	<div><span class="back">&lt;&lt;</span>
	<span class="play">play</span>
	<span class="pause">pause</span>
	<span class="forward">&gt;&gt;</span></div>
	<div><a href="<?php echo get_bloginfo("wpurl"); ?>/?reset">V&auml;lj ny InfoTV</a></div>
</div>
<div id="frame"><img id="frame_image" /></div>
<div id="header"><img id="header_logo" /></div>
<div id="clock"></div>

