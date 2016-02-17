<?php


/**
 * Get all the sections HTML to output to the page
 * @param  String $id  This post or page's ID
 * @return String      The final HTML for the page
 */
function get_sections( $id = '' ) {

	global $post;

	if( !$id && isset($post) ) $id = $post->ID;

	if( !$id ) return false;

	$pb = new ACF_Page_Builder();

	$pb->addFieldsToWP();

	$html = $pb->getSectionsHTML( 'acf_page_builder', (string) $id );

	return isset($html) ? $html : '';

}



/**
 * Output all the sections HTML to output to the page
 * @param  String $id  This post or page's ID
 */
function the_sections( $id = '' ) {

	$html = get_sections( $id );

	echo $html;

}


/**
 * Initiate the public side
 */
function acfpg_init_public() {

	if( is_admin() ) return false;

	$pb = new ACF_Page_Builder();

	add_action('wp_enqueue_scripts', array( $pb, 'enqueuePublic') );

}
add_action( 'after_setup_theme', 'acfpg_init_public' );
