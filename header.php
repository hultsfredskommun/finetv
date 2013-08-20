<html><head>
<title><?php echo $place; ?> InfoTV</title>
<?php 
	wp_head();
?>
</head><body>
<div>
<?php if (isset($_REQUEST["always"])) {
	setcookie( "infotv_redirect", "$place", time() + (10 * 365 * 24 * 60 * 60), "/"); 
} ?>
</div>
<div id="tools" class="hidden">
	<div>Förhandsgranska:</div>
	<div class="forcesize" res="1024x768">1024x768</div>
	<div class="forcesize" res="1920x1080">1920x1080</div>
	<div><a href="<?php echo get_bloginfo("wpurl"); ?>/?reset">Välj ny standard InfoTV</a></div>
</div>
<div id="frame"><img id="frame_image" /></div>
<div id="header"><img id="header_logo" /></div>
<div id="clock"></div>

