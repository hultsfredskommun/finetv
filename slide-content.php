<?php
	$post_id = $post->ID;

	$from = get_field('from',$post_id);
	$to = get_field('to',$post_id);

	
	//if(isValidTime($to,$from)) :

	$slide_duration = get_field('slide_duration',$post_id);
	$slide_image_mode =  get_field('slide_image_mode',$post_id);
	$slide_background_color =  get_field('slide_background_color',$post_id);
	$slide_text_color =  get_field('slide_text_color',$post_id);
	$slide_from =  get_field('from',$post_id); // TODO
	$slide_to =  get_field('to',$post_id); // TODO
	$slide_important = get_field('slide_important',$post_id);
	$importantclass = ($slide_important)?" important":" notimportant";
?>
	
	<div data-id="<?php echo $post_id; ?>" class="<?php echo $post_id . $importantclass; ?> slide-item">
		<?php 
		$from_timestamp = $to_timestamp = "";
		if($from != "") {
			$from_timestamp = strtotime($from);
		}
		if($to != "") {
			$to_timestamp = strtotime($to);
		}
		echo get_image(get_post_thumbnail_id(),$slide_image_mode); ?>
		<div class="slide_text <?php echo $slide_image_mode; ?>"><div class="content"><?php the_content(); ?></div></div>
		<div class="hidden slide_duration"><?php echo $slide_duration; ?></div>
		<div class="hidden slide_background_color"><?php echo $slide_background_color; ?></div>
		<div class="hidden slide_text_color"><?php echo $slide_text_color; ?></div>
		<div class="hidden slide_to" timestamp="<?php echo $to_timestamp; ?>"><?php echo $slide_to; ?></div>
		<div class="hidden slide_from" timestamp="<?php echo $from_timestamp; ?>"><?php echo $slide_from; ?></div>
	</div>
<?php //endif; ?>