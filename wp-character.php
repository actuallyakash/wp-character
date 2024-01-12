<?php
/**
 * Main WP Character plugin file
 *
 * @package Wpcharacter/Main
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Plugin Name: WP Character
 * Plugin URI: https://travelopia.com
 * Description: WP Character creates a 'Character' custom post type and fetches an image from an API.
 * Version: 1.0.0
 * Author: Travelopia
 * Author URI: https://www.travelopia.com/
 * Text Domain: wpcharacter
 * Domain Path: /languages
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 6.0
 * Tested up to: 6.3
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WPCHARACTER_PLUGIN_FILE' ) ) {
	define( 'WPCHARACTER_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'WPCHARACTER_PLUGIN_DIR' ) ) {
	define( 'WPCHARACTER_PLUGIN_DIR', __DIR__ . '/' );
}

if ( ! defined( 'WPCHARACTER_PLUGIN_URL' ) ) {
	define( 'WPCHARACTER_PLUGIN_URL', trailingslashit( plugin_dir_url( WPCHARACTER_PLUGIN_FILE ) ) );
}

require_once WPCHARACTER_PLUGIN_DIR . 'vendor/autoload.php';

/**
 * Returns the main instance of WP Character.
 *
 * @since 1.0.0
 */
function wpcharacter(): wpcharacter\wpcharacter {
	return wpcharacter\wpcharacter::instance();
}
return wpcharacter();
