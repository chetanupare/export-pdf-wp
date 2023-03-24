<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
Plugin Name: PDF Export on Post Update
Plugin URI: https://your-website.com/
Description: Export a PDF version of a post when it is updated.
Version: 1.0
Author: Chetan Upare
Author URI: https://your-website.com/
License: GPL2
*/

//Load Required Files
require_once('inc/admin.php');
require_once('inc/shortcode.php');
require_once('inc/init.php');

function pdf_export_on_post_update($post_ID, $post, $update) {
   // Get the chosen post status
   $pdf_export_post_status = get_option( 'pdf_export_post_status', 'publish' );

   // Check if this post status should trigger the PDF export
   if ( $post->post_status != $pdf_export_post_status ) {
       return;
   }

    // Check if this post type is allowed to be exported as PDF
    if ( $post->post_type != 'post' ) {
        return;
    }

    // Generate PDF file path and URL
    $pdf_dir = WP_CONTENT_DIR . '/pdfs';
    if (!is_dir($pdf_dir)) {
        mkdir($pdf_dir);
    }

    // Generate PDF file path and URL
    $pdf_path = WP_CONTENT_DIR . '/pdfs/' . $post->post_name . '.pdf';
    $pdf_url = WP_CONTENT_URL . '/pdfs/' . $post->post_name . '.pdf';

    // Load the post content
    $post_content = apply_filters('the_content', $post->post_content);

    // Load the PDF library
    require_once('fpdf/fpdf.php');

    // Create a new PDF object
    $pdf = new FPDF();

    // Set the font and font size
    $pdf->AddPage('P', 'Letter');

    $pdf_font = get_option('pdf_export_font', 'Arial');
    $pdf_font_size = get_option('pdf_export_font_size', 16);
    $pdf->SetFont($pdf_font,'',$pdf_font_size);

    // Write the post title and content to the PDF
    $pdf_show_author = get_option('pdf_export_show_author', false);
    if ($pdf_show_author) {
        $pdf->Cell(0,10,$post->post_title . ' by ' . get_the_author_meta('display_name', $post->post_author),0,1);
    } else {
        $pdf->Cell(0,10,$post->post_title,0,1);
    }
    $pdf->MultiCell(0,10,$post_content,0,1);

    // Output the PDF to a file
    $pdf->Output($pdf_path, 'F');

    // Update the post meta with the PDF URL and other options
    $pdf_show_date = get_option('pdf_export_show_date', false);
    $pdf_show_category = get_option('pdf_export_show_category', false);
    $pdf_meta = array();
    if ($pdf_show_author) {
        $pdf_meta['_pdf_author'] = get_the_author_meta('display_name', $post->post_author);
    }
    if ($pdf_show_date) {
        $pdf_meta['_pdf_date'] = get_the_date('', $post_ID);
    }
    if ($pdf_show_category) {
        $pdf_meta['_pdf_category'] = get_the_category_list(', ', '', $post_ID);
    }
    $pdf_meta['_pdf_url'] = $pdf_url;
    foreach ($pdf_meta as $key => $value) {
        update_post_meta($post_ID, $key, $value);
    }
}
add_action('wp_insert_post', 'pdf_export_on_post_update', 10, 3);


function pdf_export_on_post_update_settings() {
	add_options_page( 'PDF Export Settings', 'PDF Export Settings', 'manage_options', 'pdf-export-settings', 'pdf_export_on_post_update_options_page' );
}
add_action( 'admin_menu', 'pdf_export_on_post_update_settings' );
