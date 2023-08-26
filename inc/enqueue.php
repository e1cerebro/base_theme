<?php
function chada_base_theme_scripts() {
	wp_enqueue_style( 'chada-base-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'app-css', get_template_directory_uri().'/dist/app.css', array(), _S_VERSION );
	wp_style_add_data( 'chada-base-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'chada-base-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'app-js', get_template_directory_uri() . '/dist/app.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chada_base_theme_scripts' );