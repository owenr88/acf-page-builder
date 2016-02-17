<?php


/**
 * Initiate the admin side to show the sections
 */
function acfpg_init_admin() {

	if( !is_admin() ) return false;

	$pb = new ACF_Page_Builder();

	add_action('wp_enqueue_script', array( $pb, 'enqueueAdmin') );

	$pb->addFieldsToWP();

}
add_action( 'after_setup_theme', 'acfpg_init_admin' );
