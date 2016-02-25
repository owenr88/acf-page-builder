<?php

Class ACF_Page_Builder {


	/**
	 * Check if Advanced Custom Fields is Active
	 * @var (Boolean)
	 */
	private $acf_active;


	/**
	 * Check if Simple Contact Forms is Active
	 * @var (Boolean)
	 */
	private $scf_active;


	/**
	 * The final HTML to return with the section data inluded
	 * @var String
	 */
	private $html;


	/**
	 * Formats that can be used in the acfs_add_support and acfs_remove_support functions
	 * @var Array
	 */
	public $supported_formats;


	/**
	 * Variable to declare whether we should use Bootstrap or not
	 * @var Boolean
	 */
	private $use_bs;


	/**
	 * Constructor of the class. Sets some default values
	 */
	function __construct() {

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$this->acf_active = is_plugin_active( 'advanced-custom-fields/acf.php' ) || is_plugin_active( 'advanced-custom-fields-pro/acf.php' );

		$this->scf_active = is_plugin_active( 'simple-contact-forms/simple-contact-forms.php' );

		$this->supported_formats = array('post_type', 'page_template', 'id');

		$this->use_bs = function_exists('get_field') ? get_field('acfpb_use_bootstrap') : false;

	}


	/**
	 * Enqueue the styles and scripts for the public
	 */
	public function enqueuePublic() {

		wp_enqueue_style( 'acfpb-public', plugin_dir_url( __FILE__ ) . '../public/css/acfpb_styles.css', false, NULL, 'all' );

	}


	/**
	 * Enqueue the styles and scripts for the admin
	 */
	public function enqueueAdmin() {



	}


	/**
	 * Retrieves all the section HTML 
	 * @param  String $name The slug used for the sections. Is 'sections' by default
	 * @return String       The final HTML
	 */
	public function getSectionsHTML( $name, $post_id ) {

		if( !$this->acf_active ) return '';

		if( have_rows( $name, $post_id ) ):

			$s = 1;

			$this->html = '<div id="acfpb_sections">';

			while ( have_rows( $name, $post_id ) ) : the_row();

				$layout = get_row_layout();

				if( method_exists(get_class(), 'getSection_' . $layout ) ) :

					$id = 'section_' . $s;

					$class = 'acfpb_section section-' . $layout;

					$style = get_sub_field('bg') ? 'background-color:' . get_sub_field('bg') : '';

					$contained = (boolean) get_sub_field('contained', false);

					if( !$this->use_bs && $contained ) $contained = false;

					$wrapper = get_sub_field('wrapper_class');

					$this->html .= '<div id="' . $id . '" class="' . $class . '" style="' . $style . '">';

						if( $contained ) $this->html .= '<div class="container">';

							if( $contained ) $this->html .= '<div class="row">';

								if( $wrapper !== '' ) $this->html .= '<div class="' . $wrapper . '">';

									$this->html .= $this->{'getSection_' . $layout}();

								if( $wrapper !== '' ) $this->html .= '</div>'; // Wrapper finish

							if( $this->use_bs ) $this->html .= '<div class="clearfix"></div>';

							if( $contained ) $this->html .= '</div>'; // Row finish

						if( $contained ) $this->html .= '</div>'; // Container finish

					$this->html .= '</div>'; // Section finish

					$s++;

				endif;

			endwhile;

			$this->html .= '</div>'; // Main Wrapper finish

			return $this->html;

		else :

			return '';

		endif;

	}


	/**
	 * Admin function to add the fields to wordpress. Also figures out where to show them based on the acfs_add_support and acfs_remove_support functions
	 */
	public function addFieldsToWP() {

		if( !$this->acf_active ) return false;

		if( function_exists('acf_add_local_field_group') ) {

			// Get the exported field data

			$json = file_get_contents( plugin_dir_path(__FILE__) . '../admin/acf-fields.json' );

			$json_to_php = json_decode( $json, true );

			$acf_fields_array = $json_to_php[0]['fields'];

			// Check if SCF is included or leave it out of the list of fields if not

			if( !$this->scf_active ) {

				foreach ($acf_fields_array[1]['layouts'] as $key => $data) {
					
					if( $data['name'] === 'simple_contact_forms' ) {

						unset( $acf_fields_array[1]['layouts'][$key] );

						break;

					}

				}

			}

			// Create the rest of the field group

			$meta = array(
				'key' 					=> 'group_553b8b2752aba_pb10192283',
				'title' 				=> 'Page Builder',
				'fields' 				=> $acf_fields_array,
				'menu_order' 			=> 10,
				'position' 				=> 'normal',
				'style' 				=> 'default',
				'label_placement' 		=> 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' 		=> array (),
				'location' 				=> array(),
				'active'				=> 1,
				'description' 			=> '',

			);

			// Filter to get the locations

			$location = apply_filters( 'acfpb_set_locations', array() );

			$l = 0;

			foreach ($this->supported_formats as $format) {

				if( !isset($location[$format]) || empty($location[$format]) ) continue;
					
				$meta['location'][$l] = array();;

				foreach ($location[$format] as $place) {

					$meta['location'][$l][] = array(
						'param' 	=> $format,
						'operator' 	=> '==',
						'value' 	=> $place,
					);

					$l++;

				}

			}

			acf_add_local_field_group($meta);

		}

	}


	/**
	 * Get the Banner section.
	 * @return String Final string of this section
	 */
	private function getSection_banner() {

		$class = $this->use_bs ? 'img-responsive' : '';

		$html = '<div class="banner-holder">';

			$html .= '<img src="' . get_sub_field('image') . '" class="' . $class . '" />';

			if( get_sub_field('use_text') ) $html .= '<div class="acfpb-hover-text">' . get_sub_field('text_on_image') . '</div>';

		$html .= '</div>';

		return $html;

	}


	/**
	 * Get the button section.
	 * @return String Final string of this section
	 */
	private function getSection_button() {

		$class = get_sub_field('button_class');

		$text = get_sub_field('button_text');

		switch ( get_sub_field('link_to_page') ) {

			case 'anchor':
				$href = '#' . get_sub_field('button_anchor');
				break;

			case 'external':
				$href = get_sub_field('external_link');
				break;

			case 'internal':
				$href = get_sub_field('internal_link');
				break;
			
			default:
				$href = '#';
				break;

		}

		$html = '<a href="' . $href . '" class="' . $class . '">' . $text . '</a>';

		return $html;

	}


	/**
	 * Get the Content Grid section.
	 * @return String Final string of this section
	 */
	private function getSection_content_grid() {

		$blocks = get_sub_field('content_columns');

		$html = '';

		if( count($blocks) > 0 ) :

	        foreach($blocks as $block) {

	            $html .= '<div class="col-sm-' . $block['width'] . ' col-sm-offset-' . $block['offset'] . '">';

	                $html .= $block['content'];

	            $html .= '</div>';

	        }; 

		endif;

		return $html;

	}


	/**
	 * Get the Gallery section.
	 * @return String Final string of this section
	 */
	private function getSection_gallery() {

		$images = get_sub_field('images');

		$html = '';

		switch ( get_sub_field('images_per_row') ) {

			case '2':
				$first_class = 'col-sm-offset-2';
				$class = 'col-sm-4';
				break;

			case '3':
				$first_class = '';
				$class = 'col-sm-4';
				break;

			case '5':
				$first_class = 'col-sm-offset-1';
				$class = 'col-sm-2';
				break;

			case '6':
				$first_class = '';
				$class = 'col-sm-2';
				break;
			
			default:
				$first_class = '';
				$class = 'col-sm-3';
				break;
		}

		if( count($images) > 0 ) :

			$i = 1;

	        foreach($images as $item) {

	        	if( $i === 1 ) $class .= ' ' . $first_class;

	            $html .= '<div class="' . $class . '">';

	                $html .= '<img src="' . $item['image'] . '" class="' . ($this->use_bs ? 'img-responsive' : '') . '" />';

	                if( $item['title'] !== '' ) $html .= '<h4>' . $item['title'] . '</h4>';

	                if( $item['caption'] !== '' ) $html .= '<p>' . $item['caption'] . '</p>';

	            $html .= '</div>';

	            $i++;

	        }; 

		endif;

		return $html;

	}


	/**
	 * Get the Raw HTML section.
	 * @return String Final string of this section
	 */
	private function getSection_raw_html() {

		$html = get_sub_field('html');

		return $html;

	}


	/**
	 * Get the Simple Contact Forms section.
	 * @return String Final string of this section
	 */
	private function getSection_simple_contact_forms() {

		if( !function_exists('simple_contact_form') ) return '';

        $options = array();

        if( get_sub_field('form_title') !== '' ) $options['form_title'] = get_sub_field('form_title');
        
        if( get_sub_field('button') == true ) {

            $options['button'] = true; 
            $options['form_collapsed'] = true;

        	if( get_sub_field('btn_text') !== '' ) $options['btn_text'] = get_sub_field('btn_text');

        }
        
        if( get_sub_field('email_subject') !== '' ) $options['email_subject'] = get_sub_field('email_subject');

        $options['return'] = true;

        $html = simple_contact_form( $options );

		return $html;

	}


	/**
	 * Get the WYSIWYG section.
	 * @return String Final string of this section
	 */
	private function getSection_wysiwyg() {

		$html = get_sub_field('content');

		return $html;

	}


}