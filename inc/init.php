<?php
// Register settings
function pdf_export_on_post_update_settings_init() {
    register_setting( 'pdf-export-settings-group', 'pdf_export_post_status', array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'publish',
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_font', array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Arial',
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_font_size', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
        'default'           => 16,
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_show_author', array(
        'type'              => 'boolean',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => false,
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_show_date', array(
        'type'              => 'boolean',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => false,
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_show_category', array(
        'type'              => 'boolean',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => false,
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_download_text', array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Download PDF',
    ) );
    register_setting( 'pdf-export-settings-group', 'pdf_export_show_file_size', array(
        'type'              => 'boolean',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => true,
    ) );
}

add_action( 'admin_init', 'pdf_export_on_post_update_settings_init' );

// Add download button to post list
add_filter('post_row_actions', 'add_download_button_to_post_list', 10, 2);

function add_download_button_to_post_list($actions, $post) {
    // Check if we are on the post list screen
    if (get_current_screen()->base == 'edit' && $post->post_type == 'post') {

        // Get the PDF URL for this post
        $pdf_url = get_post_meta($post->ID, '_pdf_url', true);

        // Get the download button text from the settings
        $button_text = get_option( 'pdf_export_download_text', 'Download PDF' );

        // Add the download button
        if (!empty($pdf_url)) {
            $download_link = '<a href="' . $pdf_url . '" download>' . esc_html( $button_text ) . '</a>';

            if ( get_option( 'pdf_export_show_file_size' ) ) {
      $pdf_url = get_post_meta( $post->ID, '_pdf_url', true );
      $response = wp_remote_head( $pdf_url );
      if ( ! is_wp_error( $response ) ) {
          $file_size = (int) wp_remote_retrieve_header( $response, 'content-length' );
          $download_link .= ' <span class="pdf-export-file-size">(' . size_format( $file_size ) . ')</span>';
      }
  }

            // Add the download button to the post actions
            $actions['pdf_export_download'] = $download_link;
        }
    }

    return $actions;
}
