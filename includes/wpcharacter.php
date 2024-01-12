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

	use Traits\Singleton;

	/**
	 * WPcharacter Version.
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

		\add_action( 'plugins_loaded', array( __CLASS__, 'load' ) );
	}

	/**
	 * Init the plugin.
	 *
	 * @since 1.0.0
	 */
	public static function load(): void {
		
	}
}
