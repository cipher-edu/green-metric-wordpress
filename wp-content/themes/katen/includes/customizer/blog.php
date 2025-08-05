<?php

// Blog
Kirki::add_field( 'katen_settings', array(
    'type'        => 'switch',
    'settings'    => 'blog_meta',
    'label'       => esc_attr__( 'Meta data', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'katen' ),
        'off' => esc_attr__( 'Disable', 'katen' ),
    ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_date',
    'label'       => esc_attr__( 'Date', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_author',
    'label'       => esc_attr__( 'Author', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_avatar',
    'label'       => esc_attr__( 'Author avatar', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_category',
    'label'       => esc_attr__( 'Category', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_comments_count',
    'label'       => esc_attr__( 'Comments count', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_archive_share',
    'label'       => esc_attr__( 'Social share', 'katen' ),
    'description' => esc_attr__( 'Please make sure to install and activate the "Katen Theme Post Social Share" plugin before using it.', 'katen' ),
    'section'     => 'blog_archive',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'     => 'text',
    'settings' => 'except',
    'label'    => esc_attr__( 'Except length (words)', 'katen' ),
    'section'  => 'blog_archive',
    'default'  => esc_attr__( '30', 'katen' ),
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_single_share',
    'label'       => esc_attr__( 'Social share', 'katen' ),
    'description' => esc_attr__( 'Please make sure to install and activate the "Katen Theme Post Social Share" plugin before using it.', 'katen' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_single_tags',
    'label'       => esc_attr__( 'Tags', 'katen' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_single_sidebar',
    'label'       => esc_attr__( 'Sidebar', 'katen' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_nextprev',
    'label'       => esc_attr__( 'Next & Previous posts', 'katen' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_comment',
    'label'       => esc_attr__( 'Comment', 'katen' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'single_main_content_margin',
		'label'       => esc_html__( 'Main content margin', 'katen' ),
		'section'     => 'blog_single',
		'default'     => [
			'margin-top'  => '60px',
			'margin-bottom' => '60px',
		],
        'output'      => [
			[
				'element' => '.single-post .main-content',
			],
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'post_cover_overlay',
		'label'       => __( 'Cover overlay(rgba)', 'katen' ),
		'section'     => 'blog_single',
		'default'     => 'rgba(32, 54, 86, 0.6)',
		'choices'     => [
			'alpha' => true,
		],
		'output'      => [
			[
				'element' => '.single-cover:after',
				'property' => 'background-color'
			],
		],
	]
);

new \Kirki\Field\Slider(
	[
		'settings'    => 'content_width',
		'label'       => esc_html__( 'Content width', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => 1140,
		'choices'     => [
			'min'  => 500,
			'max'  => 1900,
			'step' => 10,
		],
	]
);

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'blog_sidebar',
    'label'       => esc_attr__( 'Sidebar', 'katen' ),
    'section'     => 'blog_layouts',
    'default'     => '1',
) );

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'main_content_margin',
		'label'       => esc_html__( 'Main content margin', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => [
			'margin-top'  => '60px',
			'margin-bottom' => '60px',
		],
        'output'      => [
			[
				'element' => '.main-content',
			],
		],
	]
);

Kirki::add_field( 'katen_settings', array(
    'type'        => 'toggle',
    'settings'    => 'author_page_bio_box',
    'label'       => esc_attr__( 'Author page bio box', 'katen' ),
    'section'     => 'blog_layouts',
    'default'     => '1',
) );

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'author_page_bio_margin',
		'label'       => esc_html__( 'Author page bio box margin', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => [
			'margin-top'  => '0px',
			'margin-bottom' => '0px',
		],
        'output'      => [
			[
				'element' => '.author-page.about-author',
			],
		],
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'index_layout',
		'label'       => esc_html__( 'Main Index page', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => '1',
		'placeholder' => esc_html__( 'Choose an option', 'katen' ),
		'choices'     => [
			'1' => esc_html__( 'Classic', 'katen' ),
			'2' => esc_html__( 'Grid', 'katen' ),
            '3' => esc_html__( 'List', 'katen' ),
            '4' => esc_html__( 'Wide thumb', 'katen' ),
		],
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'archive_layout',
		'label'       => esc_html__( 'Archive page', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => '1',
		'placeholder' => esc_html__( 'Choose an option', 'katen' ),
		'choices'     => [
			'1' => esc_html__( 'Classic', 'katen' ),
			'2' => esc_html__( 'Grid', 'katen' ),
            '3' => esc_html__( 'List', 'katen' ),
            '4' => esc_html__( 'Wide thumb', 'katen' ),
		],
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'category_layout',
		'label'       => esc_html__( 'Category page', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => '1',
		'placeholder' => esc_html__( 'Choose an option', 'katen' ),
		'choices'     => [
			'1' => esc_html__( 'Classic', 'katen' ),
			'2' => esc_html__( 'Grid', 'katen' ),
            '3' => esc_html__( 'List', 'katen' ),
            '4' => esc_html__( 'Wide thumb', 'katen' ),
		],
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'author_layout',
		'label'       => esc_html__( 'Author page', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => '1',
		'placeholder' => esc_html__( 'Choose an option', 'katen' ),
		'choices'     => [
			'1' => esc_html__( 'Classic', 'katen' ),
			'2' => esc_html__( 'Grid', 'katen' ),
            '3' => esc_html__( 'List', 'katen' ),
            '4' => esc_html__( 'Wide thumb', 'katen' ),
		],
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'tag_layout',
		'label'       => esc_html__( 'Tag page', 'katen' ),
		'section'     => 'blog_layouts',
		'default'     => '1',
		'placeholder' => esc_html__( 'Choose an option', 'katen' ),
		'choices'     => [
			'1' => esc_html__( 'Classic', 'katen' ),
			'2' => esc_html__( 'Grid', 'katen' ),
            '3' => esc_html__( 'List', 'katen' ),
            '4' => esc_html__( 'Wide thumb', 'katen' ),
		],
	]
);