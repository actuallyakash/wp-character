<?php
/**
 * Main WP Character API class file
 *
 * @package WPcharacter/Classes
 *
 * @since 1.0.0
 * @version 1.0.0
 */

declare( strict_types=1 );

namespace wpcharacter;

/**
 * Main WPCharacterAPI Class.
 *
 * @since 1.0.0
 */
final class WPCharacterAPI {

    public function init(): void {
        // Running the API request on 'Character' post update.
        add_action( 'save_post', array( $this, 'update_character_via_api' ), 10, 2 );
    }

    /**
     * Update character via API.
     *
     * @since 1.0.0
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     */
    public function update_character_via_api( $post_id, $post ): void {

        if ( 'character' !== $post->post_type ) {
            return;
        }

        // Do not run on trash/untrash event.
        if ( 'trash' === $post->post_status ) {
            return;
        }

        // Get the character ID.
        $character_id = get_post_meta( $post_id, 'character_id', true );

        // If the character ID is empty, don't do anything.
        if ( empty( $character_id ) ) {
            return;
        }

        // Running API call to https://thronesapi.com/api/v2/Characters/<Character ID>.
        $response = wp_remote_get( 'https://thronesapi.com/api/v2/Characters/' . $character_id );

        // If no character found, don't do anything.
        if( 400 === wp_remote_retrieve_response_code( $response ) ) {
            return;
        }

        // Get the character data.
        $character_data = json_decode( wp_remote_retrieve_body( $response ) );

        // Update the character post title.
        wp_update_post( array(
            'ID'         => $post_id,
            'post_title' => $character_data->fullName,
        ) );

        // Update the character featured image.
        $image_id = $this->upload_image_from_url( $character_data->imageUrl, $post_id );
        if ( ! empty( $character_data->imageUrl ) ) {
            set_post_thumbnail( $post_id, $image_id );
        }

    }

    /**
     * Upload image from API's URL.
     *
     * @since 1.0.0
     *
     * @param string $image_url Image URL.
     * @param int    $post_id   Post ID.
     *
     * @return int|WP_Error
     */
    public function upload_image_from_url( $image_url, $post_id ) {

        $file_name     = basename( $image_url );
        $file_type     = wp_check_filetype( $file_name, null );
        $upload_dir    = wp_upload_dir();
        $file_path     = $upload_dir['path'] . '/' . $file_name;
        $file_url      = $upload_dir['url'] . '/' . $file_name;
        $download_file = download_url( $image_url );
        $file_array    = array(
            'name'     => $file_name,
            'tmp_name' => $download_file,
        );

        if ( is_wp_error( $download_file ) ) {
            return $download_file;
        }

        // Uploading the file.
        $id = media_handle_sideload( $file_array, $post_id );

        if ( is_wp_error( $id ) ) {
            @unlink( $file_path );
            return $id;
        }

        // Set the attachment meta.
        wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file_path ) );

        return $id;
    }

}
