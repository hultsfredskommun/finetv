<?php 
/**
 *  Install Add-ons
 *  
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *  
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme/plugin as outlined in the terms and conditions.
 *  For more information, please read:
 *  - http://www.advancedcustomfields.com/terms-conditions/
 *  - http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/
 */ 

// Tillägg 
// include_once('add-ons/acf-repeater/acf-repeater.php');
// include_once('add-ons/acf-gallery/acf-gallery.php');
// include_once('add-ons/acf-flexible-content/acf-flexible-content.php');
// include_once( 'add-ons/acf-options-page/acf-options-page.php' );


/**
 *  Registrera fältgrupper
 *
 *  Funktionen register_field_group tar emot en array som innehåller inställningarna för samtliga fältgrupper.
 *  Du kan redigera denna array fritt. Detta kan dock leda till fel om ändringarna inte är kompatibla med ACF.
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_inst%c3%a4llningar',
		'title' => 'Inställningar',
		'fields' => array (
			array (
				'key' => 'field_51dcf5b357202',
				'label' => 'Logga',
				'name' => 'header_logo',
				'type' => 'image',
				'instructions' => 'Loggan kommer att visas i full storlek högst upp till vänster.',
				'save_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
			),
			array (
				'key' => 'field_5211ed629bfcb',
				'label' => 'Ram',
				'name' => 'frame',
				'type' => 'image',
				'instructions' => 'Ramen kommer att visas i full storlek och sträckas ut på skärmen 100% x 100%.',
				'save_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
			),
			array (
				'key' => 'field_50a3703f18ebf',
				'label' => 'Text för sidfot',
				'name' => 'footer_text',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_50a372d865ecc',
				'label' => 'Bakgrundsfärg på sidfot',
				'name' => 'footer_background_color',
				'type' => 'color_picker',
				'default_value' => '#ffffff',
			),
			array (
				'key' => 'field_50a37327399c7',
				'label' => 'Teckenfärg i sidfot',
				'name' => 'footer_text_color',
				'type' => 'color_picker',
				'default_value' => '#000000',
			),
			array (
				'key' => 'field_51dd142ccae2f',
				'label' => 'Blank skärm från',
				'name' => 'blank_screen_from',
				'type' => 'date_time_picker',
				'show_date' => 'false',
				'date_format' => 'yy-mm-dd',
				'time_format' => 'HH:mm',
				'show_week_number' => 'false',
				'picker' => 'slider',
				'save_as_timestamp' => 'true',
			),
			array (
				'key' => 'field_51dd1460cae30',
				'label' => 'Blank skärm till',
				'name' => 'blank_screen_to',
				'type' => 'date_time_picker',
				'show_date' => 'false',
				'date_format' => 'yy-mm-dd',
				'time_format' => 'HH:mm',
				'show_week_number' => 'false',
				'picker' => 'slider',
				'save_as_timestamp' => 'true',
			),
			array (
				'key' => 'field_51dd380128125',
				'label' => 'Textskalning',
				'name' => 'screen_font_scale',
				'type' => 'number',
				'instructions' => 'Skala storleken på text för att passa just denna skärm i förhållande till andra storlekar på skärm',
				'default_value' => 100,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 10,
				'max' => 500,
				'step' => 10,
			),
			array (
				'key' => 'field_51de859fbbbc2',
				'label' => 'Skärmens bakgrundsfärg',
				'name' => 'screen_background_color',
				'type' => 'color_picker',
				'default_value' => '',
			),
			array (
				'key' => 'field_51de85d7bbbc3',
				'label' => 'Skärmens textfärg',
				'name' => 'screen_text_color',
				'type' => 'color_picker',
				'default_value' => '',
			),
			array (
				'key' => 'field_5211f1d36de8c',
				'label' => 'Visa klocka',
				'name' => 'clock',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slide_settings',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'discussion',
				3 => 'comments',
				4 => 'slug',
				5 => 'format',
				6 => 'featured_image',
				7 => 'categories',
				8 => 'tags',
				9 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_presentation',
		'title' => 'Presentation',
		'fields' => array (
			array (
				'key' => 'field_509cf03ddfe5d',
				'label' => 'Fördröjning',
				'name' => 'slide_duration',
				'type' => 'number',
				'instructions' => 'Hur många sekunder skall sliden visas?',
				'default_value' => 10,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 3,
				'max' => 120,
				'step' => 1,
			),
			array (
				'key' => 'field_50a4fad3eba7b',
				'label' => 'Bildläge',
				'name' => 'slide_image_mode',
				'type' => 'select',
				'instructions' => 'Välj hur du vill att bilden skall placera sig på sidan.',
				'choices' => array (
					'normal-left' => 'Vänsterställd - fyll bredd',
					'half-left' => 'Vänsterställd - fyll höjd',
					'normal-right' => 'Högerställd - fyll bredd',
					'half-right' => 'Högerställd - fyll höjd',
					'whole-w' => 'Helbild - fyll bredd',
					'whole-h' => 'Helbild - fyll höjd',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_51dfc170a4c7e',
				'label' => 'Textfärg',
				'name' => 'slide_text_color',
				'type' => 'color_picker',
				'default_value' => '',
			),
			array (
				'key' => 'field_51dfc189a4c7f',
				'label' => 'Bakgrundsfärg',
				'name' => 'slide_background_color',
				'type' => 'color_picker',
				'default_value' => '',
			),
			array (
				'key' => 'field_5211cbf8b591e',
				'label' => 'Från',
				'name' => 'from',
				'type' => 'date_time_picker',
				'instructions' => 'Välj en tidpunkt då sliden börjar visas',
				'show_date' => 'true',
				'date_format' => 'yy-mm-dd',
				'time_format' => 'HH:mm',
				'show_week_number' => 'false',
				'picker' => 'slider',
				'save_as_timestamp' => 'true',
			),
			array (
				'key' => 'field_5211cc41b591f',
				'label' => 'Till',
				'name' => 'to',
				'type' => 'date_time_picker',
				'instructions' => 'Välj en tidpunkt då sliden slutar visas',
				'show_date' => 'true',
				'date_format' => 'yy-mm-dd',
				'time_format' => 'HH:mm',
				'show_week_number' => 'false',
				'picker' => 'slider',
				'save_as_timestamp' => 'true',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slide',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'excerpt',
				1 => 'custom_fields',
				2 => 'discussion',
				3 => 'comments',
				4 => 'author',
				5 => 'format',
				6 => 'tags',
			),
		),
		'menu_order' => 2,
	));
}
?>