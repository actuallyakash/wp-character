<?php
/**
 * Main WP Character Post Type class file
 *
 * @package WPcharacter/Classes
 *
 * @since 1.0.0
 * @version 1.0.0
 */

declare( strict_types=1 );

namespace wpcharacter;

/**
 * Main WPCharacter_Post_Type Class.
 *
 * @since 1.0.0
 */
final class WPCharacterPostType {

	/**
	 * Init the Post Type Class.
	 *
	 * @since 1.0.0
	 */
	public function init(): void {
		// Custom post type 'Character'.
		add_action( 'init', array( $this, 'register_character_post_type' ) );

		// Metabox for Character ID field.
		add_action( 'add_meta_boxes', array( $this, 'add_character_id_metabox' ) );

		// Update post meta when creating or updating the character post.
		add_action( 'save_post', array( $this, 'save_character_id' ), 10, 2 );
	}

	/**
	 * Register post type 'Character'.
	 *
	 * @since 1.0.0
	 */
	public function register_character_post_type(): void {
		// Character.
		$labels = array(
			'name'               => _x( 'Character', 'Post type general name', 'wpcharacter' ),
			'singular_name'      => _x( 'Character', 'Post type singular name', 'wpcharacter' ),
			'menu_name'          => _x( 'Character', 'Admin Menu text', 'wpcharacter' ),
			'name_admin_bar'     => _x( 'Character', 'Add New on Toolbar', 'wpcharacter' ),
			'add_new'            => __( 'Add New', 'wpcharacter' ),
			'add_new_item'       => __( 'Add New Character', 'wpcharacter' ),
			'new_item'           => __( 'New Character', 'wpcharacter' ),
			'edit_item'          => __( 'Edit Character', 'wpcharacter' ),
			'view_item'          => __( 'View Character', 'wpcharacter' ),
			'all_items'          => __( 'All Characters', 'wpcharacter' ),
			'search_items'       => __( 'Search Characters', 'wpcharacter' ),
			'not_found'          => __( 'No characters found.', 'wpcharacter' ),
			'not_found_in_trash' => __( 'No characters found in Trash.', 'wpcharacter' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'This is where you can view all of the characters.', 'wpcharacter' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'character' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'menu_icon'          => 'dashicons-admin-users',
		);

		register_post_type( 'character', $args );
	}

	/**
	 * Add metabox for Character ID field.
	 *
	 * @since 1.0.0
	 */
	public function add_character_id_metabox(): void {
		add_meta_box(
			'character_id',
			__( 'Character ID', 'wpcharacter' ),
			array( $this, 'render_character_id_metabox' ),
			'character',
			'side',
			'default'
		);
	}

	/**
	 * Render Character ID metabox.
	 *
	 * @since 1.0.0
	 */
	public function render_character_id_metabox(): void {
		$character_id = get_post_meta( get_the_ID(), 'character_id', true );
		?>
		<?php wp_nonce_field( 'character_id', 'character_id_nonce' ); ?>
		<p>Character ID:</p>
		<input type="text" name="character_id" value="<?php echo esc_attr( $character_id ); ?>" />
		<?php
	}

	/**
	 * Save Character ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public function save_character_id( $post_id, $post ): void {

		// Verify nonce.
		if ( ! isset( $_POST['character_id_nonce'] ) || ! wp_verify_nonce( $_POST['character_id_nonce'], 'character_id' ) ) {
			return;
		}

		if ( 'character' !== $post->post_type ) {
			return;
		}

		// Do not save meta on trash/untrash event.
		if ( 'trash' === $post->post_status ) {
			return;
		}

		if ( isset( $_POST['character_id'] ) ) {
			update_post_meta( $post_id, 'character_id', sanitize_text_field( wp_unslash( $_POST['character_id'] ) ) );
		}
	}
}
