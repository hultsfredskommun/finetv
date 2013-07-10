<?php
	$post_id = $post->ID;

	$from = get_field('from',$post_id);
	$to = get_field('to',$post_id);

	if(isValidTime($to,$from)) :

	$slide_duration = get_field('slide_duration',$post_id);
	$slide_content = get_field('slide_content',$post_id);
	$slide_image =  get_field('slide_image',$post_id);
	$slide_image_mode =  get_field('slide_image_mode',$post_id);
?>
	<div class="item-<?php echo $global_count++; ?> <?php echo $post_id; ?> slide-item">
		<?php echo extract_image_tag($slide_image,$slide_image_mode); ?>
		<div class="slide_text <?php echo $slide_image_mode; ?>"><div class="content"><?php echo $slide_content; ?></div></div>
		<div class="hidden slide_duration"><?php echo $slide_duration; ?></div>
	</div>
<?php endif; ?>