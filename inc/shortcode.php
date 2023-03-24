<?php

// Register shortcode
add_shortcode( 'pdf_download_button', 'pdf_download_button_shortcode' );

// Define shortcode function
function pdf_download_button_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'post_id' => get_the_ID(),
        'button_text' => get_option( 'pdf_export_download_text', 'Download PDF' ),
        'show_file_size' => false,
    ), $atts );

    $pdf_url = get_post_meta( $atts['post_id'], '_pdf_url', true );
    if ( ! $pdf_url ) {
        return '';
    }

    $download_link = '<a href="' . esc_url( $pdf_url ) . '" download>' . esc_html( $atts['button_text'] ) . '</a>';

    if ( $atts['show_file_size'] ) {
        $file_size = filesize( get_attached_file( get_post_meta( $atts['post_id'], '_pdf_attachment_id', true ) ) );
        $download_link .= ' <span class="pdf-export-file-size">(' . size_format( $file_size ) . ')</span>';
    }

    return $download_link;
}
