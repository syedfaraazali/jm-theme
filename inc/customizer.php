<?php
/**
 * JM-theme Theme Customizer
 *
 * @package JM-theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function jm_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'jm_theme_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'jm_theme_customize_partial_blogdescription',
			)
		);
	}

	/// ******  Customizer Font Color Setting
	
	$wp_customize->add_panel( 'jm_theme_colors_setting', array(
		'title' => __( 'JMTheme Settings' ),
		'description' => '', 
		'priority' => 10, 
	  ) );

    $wp_customize->add_section( 'jm_theme_font_color' , array(
		'title' => 'Font Color',
		'panel' => 'jm_theme_colors_setting',
	  ) );

	$wp_customize->add_setting( 'jm_theme_font_color', array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'sanitize_hex_color',
	  ));

	  $wp_customize->add_control( 'jm_theme_font_color', array(
		'label' => __( 'Color' ),
		'type' => 'color',
		'section' => 'jm_theme_font_color',
	  ) );
}
add_action( 'customize_register', 'jm_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function jm_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function jm_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function jm_theme_customize_preview_js() {
	wp_enqueue_script( 'jm-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'jm_theme_customize_preview_js' );
