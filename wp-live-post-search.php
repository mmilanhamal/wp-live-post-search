<?php
/**
 * My Tickets, Accessible ticket sales for WordPress
 *
 * @package     WP Live Post Search
 * @author      saurav.rox
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: WP Live Post Search
 * Plugin URI:  
 * Description: The plugin provides a search form which provides live search functionality of any posts/pages. 
 * Author:      saurav.rox
 * Author URI:  https://www.saurabadhikari.com.np
 * Text Domain: wp-live-post-search
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/license/gpl-2.0.txt
 * Version:     1.0.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'WP_LIVE_POST_SEARCH', dirname( __FILE__ ) );

require WP_LIVE_POST_SEARCH . '/class-wp-live-post-search.php';

