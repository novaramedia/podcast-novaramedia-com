<?php
add_filter( 'cmb2_admin_init', 'cmb_post_metaboxes' );

function cmb_post_metaboxes() {
	$prefix = '_cmb_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'postype_metabox',
		'title'         => __( 'Post Meta', 'cmb2' ),
		'object_types'  => array( 'post', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	// Regular text field
	$cmb->add_field( array(
		'name' => 'Main Site URL',
		'desc' => 'Link to the post for this podcast on the main website',
		'id'   => $prefix . 'redirect',
		'type' => 'text_url',
	) );
}
?>