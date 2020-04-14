<?php
/*
Plugin Name: Disable Yoast SEO Redirects
Description: Disables Yoast SEO Premium's redirection manager, including automatic redirection generation and notifications.
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: UCF/Disable-Yoast-SEO-Redirects
*/

namespace DisableYoastSEORedirects;

if ( ! defined( 'WPINC' ) ) {
    die;
}


/**
 * Registers all actions/filters once plugins have loaded.
 *
 * @since 1.0.0
 * @author Jo Dickson
 */
function init() {
	if ( ! defined( 'WPSEO_VERSION' ) ) return;

	remove_redirects_submenu_page();
	disable_automatic_post_redirects();
	disable_automatic_term_redirects();
	disable_post_trash_notifications();
	disable_term_delete_notifications();
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );


/**
 * Callback that removes the Redirects subpage from the WordPress admin menu.
 *
 * @since 1.0.0
 * @author Jo Dickson
 */
function remove_redirects_submenu_page_callback() {
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_redirects' );
}


/**
 * Registers action that disables the Redirects subpage in the WordPress admin.
 *
 * @since 1.0.0
 * @author Jo Dickson
 */
function remove_redirects_submenu_page() {
	add_action( 'admin_menu', __NAMESPACE__ . '\remove_redirects_submenu_page_callback' );
}


/**
 * Disables automatic redirects for posts/pages.
 *
 * @since 1.0.0
 * @author Jo Dickson
 */
function disable_automatic_post_redirects() {
	if ( ! defined( 'WPSEO_VERSION' ) ) return;

	if ( version_compare( WPSEO_VERSION, '12.9.0', '<' ) ) {
		add_filter( 'wpseo_premium_post_redirect_slug_change', '__return_true' );
	}
	else {
		add_filter( 'Yoast\WP\SEO\post_redirect_slug_change', '__return_true' );
	}
}


/**
 * Disables automatic redirects for terms.
 *
 * @since 1.0.0
 * @author Jo Dickson
 */
function disable_automatic_term_redirects() {
	if ( ! defined( 'WPSEO_VERSION' ) ) return;

	if ( version_compare( WPSEO_VERSION, '12.9.0', '<' ) ) {
		add_filter( 'wpseo_premium_term_redirect_slug_change', '__return_true' );
	}
	else {
		add_filter( 'Yoast\WP\SEO\term_redirect_slug_change', '__return_true' );
	}
}


/**
 * Disables redirect notifications for posts moved to Trash.
 *
 * @author Jo Dickson
 * @since 1.0.0
 */
function disable_post_trash_notifications() {
	if ( ! defined( 'WPSEO_VERSION' ) ) return;

	// NOTE: until a bug in Yoast Premium <=13.4.1 with the
	// `Yoast\WP\SEO\enable_notification_{$this->watch_type}_{$notification_type}`
	// hook is fixed, we have to use deprecated filters:
	add_filter( 'wpseo_enable_notification_post_trash', '__return_false' );
}


/**
 * Disables redirect notifications for deleted terms.
 *
 * @author Jo Dickson
 * @since 1.0.0
 */
function disable_term_delete_notifications() {
	if ( ! defined( 'WPSEO_VERSION' ) ) return;

	// NOTE: until a bug in Yoast Premium <=13.4.1 with the
	// `Yoast\WP\SEO\enable_notification_{$this->watch_type}_{$notification_type}`
	// hook is fixed, we have to use deprecated filters:
	add_filter( 'wpseo_enable_notification_term_delete', '__return_false' );
}

