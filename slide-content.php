<?php
	$post_id = $post->ID;


	$from_timestamp = $to_timestamp = "";
	
	
	//if(isValidTime($to,$from)) :

	$slide_duration = get_field('slide_duration',$post_id);
	$slide_image_mode =  get_field('slide_image_mode',$post_id);
	$slide_background_color =  get_field('slide_background_color',$post_id);
	$slide_text_color =  get_field('slide_text_color',$post_id);
	$slide_from = infotv_get_field_date('from',$post_id); 
	if (!empty($slide_from)) {
		$from_timestamp = strtotime($slide_from);
	}
	$slide_to =  infotv_get_field_date('to',$post_id); 
	if (!empty($slide_to)) {
		$to_timestamp = strtotime($slide_to);
	}
	$slide_important = get_field('slide_important',$post_id);
	$importantclass = ($slide_important)?" important":" notimportant";

    if ($from_timestamp <= strtotime("now") || empty($from_timestamp) ) : ?>	
	<div data-id="<?php echo $post_id; ?>" class="<?php echo $post_id . $importantclass; ?> slide-item">
		<?php 
		
		echo get_image(get_post_thumbnail_id(),$slide_image_mode); ?>
		<div class="slide_text <?php echo $slide_image_mode; ?>"><div class="content"><?php the_content(); ?></div></div>
		<div class="hidden slide_duration"><?php echo $slide_duration; ?></div>
		<div class="hidden slide_background_color"><?php echo $slide_background_color; ?></div>
		<div class="hidden slide_text_color"><?php echo $slide_text_color; ?></div>
		<div class="hidden slide_to" timestamp="<?php echo $to_timestamp; ?>"><?php echo $slide_to; ?></div>
		<div class="hidden slide_from" timestamp="<?php echo $from_timestamp; ?>"><?php echo $slide_from; ?></div>
	</div>
<?php endif;
 //endif; ?>
