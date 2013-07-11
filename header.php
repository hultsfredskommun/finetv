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
<div id="header"><img id="header_logo" /></div>

