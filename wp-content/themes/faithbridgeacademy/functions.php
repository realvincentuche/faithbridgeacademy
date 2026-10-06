<?php
/**
 * Faith Bridge Academy theme setup.
 *
 * @package FaithBridgeAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FBA_VERSION', '0.1.0' );

/**
 * Theme setup: menus, title tag, thumbnails, HTML5, feed links.
 */
function fba_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'faithbridgeacademy' ),
			'footer'  => __( 'Footer Menu', 'faithbridgeacademy' ),
		)
	);
}
add_action( 'after_setup_theme', 'fba_setup' );

/**
 * Enqueue theme styles and scripts.
 */
function fba_assets() {
	wp_enqueue_style(
		'fba-style',
		get_stylesheet_uri(),
		array(),
		FBA_VERSION
	);

	wp_enqueue_style(
		'fba-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'fba-style' ),
		FBA_VERSION
	);

	wp_enqueue_script(
		'fba-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		FBA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'fba_assets' );

/**
 * Fallback primary menu (keeps local == live identical before menus exist).
 */
function fba_menu_fallback() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'faithbridgeacademy' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Fallback footer menu (keeps bottom bar populated before a menu exists).
 */
function fba_footer_fallback() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'faithbridgeacademy' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Seed v1 pages on theme activation so local == live on first activate.
 * Never overwrites existing pages.
 */
function fba_seed_on_activate() {
	$pages = array(
		'home' => __( 'Home', 'faithbridgeacademy' ),
	);

	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}
		$new_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $new_id && ! is_wp_error( $new_id ) ) {
			$ids[ $slug ] = $new_id;
		}
	}

	if ( isset( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'fba_seed_on_activate' );

/**
 * One-click page setup for servers where the theme was deployed via FTP
 * (activation hook never fired, so pages/menus may be missing).
 */
function fba_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$missing = array();
	foreach ( array( 'home' ) as $slug ) {
		if ( ! get_page_by_path( $slug ) ) {
			$missing[] = $slug;
		}
	}
	if ( ! $missing ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=fba_setup_pages' ), 'fba_setup_pages' );
	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'Faith Bridge Academy theme: missing pages (', 'faithbridgeacademy' ) . esc_html( implode( ', ', $missing ) ) . esc_html__( '). ', 'faithbridgeacademy' );
	echo '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Create pages now', 'faithbridgeacademy' ) . '</a>';
	echo '</p></div>';
}
add_action( 'admin_notices', 'fba_setup_notice' );

/**
 * Admin-post handler: run the seeder on demand, then flush permalinks.
 */
function fba_setup_pages_handler() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'fba_setup_pages' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'faithbridgeacademy' ) );
	}
	fba_seed_on_activate();
	wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
	exit;
}
add_action( 'admin_post_fba_setup_pages', 'fba_setup_pages_handler' );
