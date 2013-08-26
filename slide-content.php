<?php
	$post_id = $post->ID;

	$from = get_field('from',$post_id);
	$to = get_field('to',$post_id);

	if(isValidTime($to,$from)) :

	$slide_duration = get_field('slide_duration',$post_id);
	$slide_image_mode =  get_field('slide_image_mode',$post_id);
	$slide_background_color =  get_field('slide_background_color',$post_id);
	$slide_text_color =  get_field('slide_text_color',$post_id);
	// for compability
	switch ($slide_image_mode) {
		case 'normal-left':
			$slide_image_mode = "half-left";
			break;
		case 'normal-right':
			$slide_image_mode = "half-right";
			break;
		case 'whole-h':
			$slide_image_mode = "whole";
			break;
		case 'whole-w':
			$slide_image_mode = "whole";
			break;
	}

?>
	<div class="item-<?php echo $global_count++; ?> <?php echo $post_id; ?> slide-item">
		<?php echo get_image(get_post_thumbnail_id(),$slide_image_mode); ?>
		<div class="slide_text <?php echo $slide_image_mode; ?>"><div class="content"><?php the_content(); ?></div></div>
		<div class="hidden slide_duration"><?php echo $slide_duration; ?></div>
		<div class="hidden slide_background_color"><?php echo $slide_background_color; ?></div>
		<div class="hidden slide_text_color"><?php echo $slide_text_color; ?></div>
	</div>
<?php endif; ?>