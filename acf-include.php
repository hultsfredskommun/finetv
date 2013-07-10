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
		'id' => 'acf_schemal%c3%a4ggning',
		'title' => 'Schemaläggning',
		'fields' => array (
			array (
				'key' => 'field_509cce9650cf5',
				'label' => 'Tidsstyrning?',
				'name' => 'time_settings_choise',
				'type' => 'select',
				'instructions' => 'Om du på något sätt vill tidsstyra sliden',
				'choices' => array (
					'no' => 'Nej',
					'from' => 'Från och med',
					'to' => 'Till och med',
					'interval' => 'Från och med och till och med',
				),
				'default_value' => 'no',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_509cd010aef0a',
				'label' => 'Från',
				'name' => 'from',
				'type' => 'time_picker',
				'instructions' => 'Välj en tidpunkt då sliden/slidesen börjar visas',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cce9650cf5',
							'operator' => '==',
							'value' => 'from',
						),
						array (
							'field' => 'field_509cce9650cf5',
							'operator' => '==',
							'value' => 'interval',
						),
					),
					'allorany' => 'any',
				),
				'timepicker_show_date_format' => 'true',
				'timepicker_date_format' => 'yy-mm-dd',
				'timepicker_time_format' => 'hh:mm',
				'timepicker_show_week_number' => 'true',
			),
			array (
				'key' => 'field_509cd1114e387',
				'label' => 'Till',
				'name' => 'to',
				'type' => 'time_picker',
				'instructions' => 'Välj en tidpunkt då sliden/slidesen slutar visas',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cce9650cf5',
							'operator' => '==',
							'value' => 'to',
						),
						array (
							'field' => 'field_509cce9650cf5',
							'operator' => '==',
							'value' => 'interval',
						),
					),
					'allorany' => 'any',
				),
				'timepicker_show_date_format' => 'true',
				'timepicker_date_format' => 'yy-mm-dd',
				'timepicker_time_format' => 'hh:mm',
				'timepicker_show_week_number' => 'true',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slide',
					'order_no' => '0',
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
		'id' => 'acf_sidfotsinst%c3%a4llningar-f%c3%b6r-slides',
		'title' => 'Sidfotsinställningar för slides',
		'fields' => array (
			array (
				'key' => 'field_50a3703f18ebf',
				'label' => 'Text för sidfot',
				'name' => 'footer_text',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
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
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'Options',
					'order_no' => '0',
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_sidhuvudsinst%c3%a4llningar-f%c3%b6r-slides',
		'title' => 'Sidhuvudsinställningar för slides',
		'fields' => array (
			array (
				'key' => 'field_50a374b0b1d59',
				'label' => 'Logga för slides',
				'name' => 'header_logo',
				'type' => 'image',
				'instructions' => 'Välj en bild för loggan i sidhuvudet',
				'save_format' => 'object',
				'preview_size' => 'medium',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'Options',
					'order_no' => '0',
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_presentation',
		'title' => 'Presentation',
		'fields' => array (
			array (
				'key' => 'field_509cc6b7249c3',
				'label' => 'Typ av slide',
				'name' => 'type_of_slide',
				'type' => 'select',
				'instructions' => 'Välj läge beroende på om du vil ha en grupp av slides (dvs om de hänger ihop, sida 1, 2, 3..) eller en enkel som bara är en sida. Vill du skapa fler slides på vanligt sätt så lägg bara till flera inlägg.',
				'choices' => array (
					'normal' => 'Vanlig slide',
					'group' => 'Slide mer flera sidor',
				),
				'default_value' => 'normal',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_509cf03ddfe5d',
				'label' => 'Fördröjning',
				'name' => 'slide_duraction',
				'type' => 'number',
				'instructions' => 'Hur många sekunder skall sliden visas?',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cc6b7249c3',
							'operator' => '==',
							'value' => 'normal',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 10,
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_509cee6347522',
				'label' => 'Textinnehåll',
				'name' => 'slide_content',
				'type' => 'wysiwyg',
				'instructions' => 'Tänk på att sätta en rubrik eftersom sidnamnet längst uppe på sidan inte kommer med.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cc6b7249c3',
							'operator' => '==',
							'value' => 'normal',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'no',
				'the_content' => 'yes',
			),
			array (
				'key' => 'field_50a4fad3eba7b',
				'label' => 'Bildläge',
				'name' => 'slide_image_mode',
				'type' => 'select',
				'instructions' => 'Välj hur du vill att bilden skall placera sig på sidan.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cc6b7249c3',
							'operator' => '==',
							'value' => 'normal',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'normal-left' => 'Vänsterställd',
					'normal-right' => 'Högerställd',
					'half-left' => 'Halvsida vänsterställd',
					'half-right' => 'Halvsida högerställd',
					'whole' => 'Helsida',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_509cef35ff03b',
				'label' => 'Bild tillhörande slide',
				'name' => 'slide_image',
				'type' => 'image',
				'instructions' => 'Bild som läggs till vänster av slidern',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cc6b7249c3',
							'operator' => '==',
							'value' => 'normal',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_50a0ab8d7909c',
				'label' => 'Fler slides',
				'name' => 'slides',
				'type' => 'repeater',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_509cc6b7249c3',
							'operator' => '==',
							'value' => 'group',
						),
					),
					'allorany' => 'all',
				),
				'sub_fields' => array (
					'field_50a0aba07909d' => array (
						'key' => 'field_50a0aba07909d',
						'label' => 'Fördröjning',
						'name' => 'page_slide_duraction',
						'type' => 'number',
						'instructions' => 'Hur många sekunder skall sliden visas?',
						'column_width' => 8,
						'default_value' => 10,
						'min' => '',
						'max' => '',
						'step' => '',
					),
					'field_50a4fd15b5cf9' => array (
						'key' => 'field_50a4fd15b5cf9',
						'label' => 'Bildläge',
						'name' => 'page_slide_image_mode',
						'type' => 'select',
						'instructions' => 'Välj hur du vill att bilden skall placera sig på sidan.',
						'choices' => array (
							'normal-left' => 'Vänsterställd',
							'normal-right' => 'Högerställd',
							'half-left' => 'Halvsida vänsterställd',
							'half-right' => 'Halvsida högerställd',
							'whole' => 'Helsida',
						),
						'column_width' => 20,
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					'field_50a0ac590ff15' => array (
						'key' => 'field_50a0ac590ff15',
						'label' => 'Bild för slide',
						'name' => 'page_slide_image',
						'type' => 'image',
						'instructions' => 'Välj en bild för sliden',
						'column_width' => 15,
						'save_format' => 'object',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					'field_50a0aca50ff16' => array (
						'key' => 'field_50a0aca50ff16',
						'label' => 'Slide',
						'name' => 'page_slide_content',
						'type' => 'wysiwyg',
						'instructions' => 'Lägg till information på din slide',
						'column_width' => '',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'no',
						'the_content' => 'yes',
					),
				),
				'row_min' => 0,
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Lägg till slide',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slide',
					'order_no' => '0',
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
