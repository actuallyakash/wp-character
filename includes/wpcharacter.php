<?php
/**
 * Main WP Character class file
 *
 * @package WPcharacter/Classes
 *
 * @since 1.0.0
 * @version 1.0.0
 */

declare( strict_types=1 );

namespace wpcharacter;

/**
 * Main WPcharacter Class.
 *
 * @since 1.0.0
 */
final class WPcharacter {

	/**
	 * Singleton instance of the class.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Returns a singleton instance of the class.
	 *
	 * @since 1.0.0
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * WPCharacter Version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public const VERSION = '1.0.0';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		add_action( 'plugins_loaded', array( __CLASS__, 'load' ) );
	}

	/**
	 * Init the plugin.
	 *
	 * @since 1.0.0
	 */
	public static function load(): void {

		// Custom Post Type.
		( new WPCharacterPostType() )->init();

		// API.
		( new WPCharacterAPI() )->init();
	}
}
