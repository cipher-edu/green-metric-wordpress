<?php

add_action( 'cmb2_admin_init', 'katen_post_metabox_register' );

function katen_post_metabox_register() {
	$prefix = 'katen_post_';

	$post_field = new_cmb2_box( array(
		'id'            => $prefix . 'post_metabox',
		'title'         => esc_attr__( 'Additional Options', 'katen' ),
		'object_types'  => array( 'post' ),
	) );

	$post_field->add_field( array(
		'name'         => esc_attr__( 'Gallery', 'katen' ),
		'desc'         => esc_attr__( 'Upload or add multiple images/attachments. (Important: If you use this section below you must select the Gallery Post Format.)', 'katen' ),
		'id'           => $prefix . 'gallery',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$post_field->add_field( array(
		'name' => esc_attr__( 'Embed', 'katen' ),
		'desc' => sprintf(
			/* translators: %s: link to codex.wordpress.org/Embeds */
			esc_attr__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s. (Important: If you use this section below you must select the Video or Audio Post Format.)', 'katen' ),
			'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
		'id'   => $prefix . 'embed',
		'type' => 'oembed',
	) );

}