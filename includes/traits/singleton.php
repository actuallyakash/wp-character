<?php
/**
 * WPCharacter trait
 *
 * @package WPCharacter/Traits
 *
 * @since 1.0.0
 * @version 1.0.0
 */

declare( strict_types=1 );

namespace wpcharacter\traits;

/**
 * WPCharacter singleton trait.
 *
 * @since 1.0.0
 */
trait Singleton {

	/**
	 * Singleton instance of the class.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Returns a singleton instance of the class that uses this trait.
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
}
