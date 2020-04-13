<?php
/*
Plugin Name: Disable Yoast SEO Redirects
Description: Disables Yoast SEO Premium's redirection manager, including automatic redirection generation and notifications.
Version: 0.0.0
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: UCF/Disable-Yoast-SEO-Redirects
*/

namespace DisableYoastSEORedirects;


if ( ! defined( 'WPINC' ) ) {
    die;
}


/**
 * Removes the Redirects subpage from the WordPress admin menu.
 *
 * @since 1.0.0
 * @author Jo Dickson
 */
function remove_redirects_submenu_page() {
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_redirects' );
}

add_action( 'admin_menu', __NAMESPACE__ . '\remove_redirects_submenu_page' );


/**
 * Yoast SEO Disable Automatic Redirects for
 * Posts And Pages
 * Credit: Yoast Development Team
 * Last Tested: May 09 2017 using Yoast SEO Premium 4.7.1 on WordPress 4.7.4
 */
add_filter( 'wpseo_premium_post_redirect_slug_change', '__return_true' );


/**
 * Yoast SEO Disable Automatic Redirects for
 * Taxonomies (Category, Tags, Etc)
 * Credit: Yoast Development Team
 * Last Tested: May 09 2017 using Yoast SEO Premium 4.7.1 on WordPress 4.7.4
 */
add_filter( 'wpseo_premium_term_redirect_slug_change', '__return_true' );


/**
 * Yoast SEO Disable Redirect Notifications for
 * Posts or Pages: Moved to Trash
 * Credit: Yoast Development Team
 * Last Tested: May 09 2017 using Yoast SEO Premium 4.7.1 on WordPress 4.7.4
 */
add_filter( 'wpseo_enable_notification_post_trash', '__return_false' );


/**
 * Yoast SEO Disable Redirect Notifications for
 * Posts and Pages: Change URL
 * Credit: Yoast Development Team
 * Last Tested: May 09 2017 using Yoast SEO Premium 4.7.1 on WordPress 4.7.4
 */
add_filter( 'wpseo_enable_notification_post_slug_change', '__return_false' );


/**
 * Yoast SEO Disable Redirect Notifications for
 * Taxonomies: Moved to Trash
 * Credit: Yoast Development Team
 * Last Tested: May 09 2017 using Yoast SEO Premium 4.7.1 on WordPress 4.7.4
 */
add_filter( 'wpseo_enable_notification_term_delete', '__return_false' );


/**
 * Yoast SEO Disable Redirect Notifications for
 * Taxonomies: Change URL
 * Credit: Yoast Development Team
 * Last Tested: May 09 2017 using Yoast SEO Premium 4.7.1 on WordPress 4.7.4
 */
add_filter( 'wpseo_enable_notification_term_slug_change', '__return_false' );
