<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */


function goldmovies_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'goldmovies_upgrade_notice' );
}
add_action( 'after_switch_theme', 'goldmovies_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Twenty Fifteen on WordPress versions prior to 4.1.
 *
 * @since Gold MOVIES 1.0
 */
function goldmovies_upgrade_notice() {
	$message = sprintf( __( 'Gold MOVIES requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'goldmovies' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 *
 * @since Gold MOVIES 1.0
 */
function goldmovies_customize() {
	wp_die( sprintf( __( 'Gold MOVIES requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'goldmovies' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'goldmovies_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 *
 * @since Gold MOVIES 1.0
 */
function goldmovies_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Gold MOVIES requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'goldmovies' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'goldmovies_preview' );
