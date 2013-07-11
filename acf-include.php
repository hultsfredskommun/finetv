<?php
/**
 *  Installera tillägg
 *  
 *  Följande kod kommer att inkludera samtliga fyra premiumtillägg i ditt tema.
 *  Vänligen inkludera inte filer som inte existerar. Detta kommer att resultera i ett felmeddelande.
 *  
 *  Alla fält måste inkluderas under 'acf/register_fields' funktionen.
 *  Andra fälttyper, som inställningssidan, kan läggas till utanför denna funktion.
 *  
 *  Koden antar att du har mappen 'add-ons' i ditt tema.
 *
 *  VIKTIGT
 *  Tillägg kan inkluderas i premiumteman enligt villkoren.
 *  De får dock INTE inkluderas med andra tillägg, varken premium eller gratis.
 *  Läs följande sida för mer information: http://www.advancedcustomfields.com/terms-conditions/
 */ 

// Fält 
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	//include_once('add-ons/acf-repeater/repeater.php');
	//include_once('add-ons/acf-gallery/gallery.php');
	//include_once('add-ons/acf-flexible-content/flexible-content.php');
}

// Inställningssida 
//include_once( 'add-ons/acf-options-page/acf-options-page.php' );


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
				'default_value' => '',
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
				'default_value' => '',
			),
			array (
				'key' => 'field_51dd380128125',
				'label' => 'Textskalning',
				'name' => 'screen_font_scale',
				'type' => 'number',
				'instructions' => 'Skala storleken på text för att passa just denna skärm i förhållande till andra storlekar på skärm',
				'default_value' => 100,
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
		'id' => 'acf_schemal%c3%a4ggning',
		'title' => 'Schemaläggning',
		'fields' => array (
			array (
				'key' => 'field_509cd010aef0a',
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
				'default_value' => '',
			),
			array (
				'key' => 'field_509cd1114e387',
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
				'default_value' => '',
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
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
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
				'min' => 3,
				'max' => 120,
				'step' => 1,
			),
			array (
				'key' => 'field_509cee6347522',
				'label' => 'Textinnehåll',
				'name' => 'slide_content',
				'type' => 'wysiwyg',
				'instructions' => 'Tänk på att sätta en rubrik eftersom sidnamnet längst uppe på sidan inte kommer med.',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'no',
			),
			array (
				'key' => 'field_50a4fad3eba7b',
				'label' => 'Bildläge',
				'name' => 'slide_image_mode',
				'type' => 'select',
				'instructions' => 'Välj hur du vill att bilden skall placera sig på sidan.',
				'choices' => array (
					'normal-left' => 'Helbild vänsterställd',
					'normal-right' => 'Helbild högerställd',
					'half-left' => 'Halvbild vänsterställd',
					'half-right' => 'Halvbild högerställd',
					'whole' => 'Helbild',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_509cef35ff03b',
				'label' => 'Bild',
				'name' => 'slide_image',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
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
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'discussion',
				4 => 'comments',
				5 => 'revisions',
				6 => 'author',
				7 => 'format',
				8 => 'featured_image',
				9 => 'tags',
			),
		),
		'menu_order' => 2,
	));
}
?>