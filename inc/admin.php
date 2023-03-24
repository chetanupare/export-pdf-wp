<?php

function pdf_export_on_post_update_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'pdf-export-settings-group' );
			do_settings_sections( 'pdf-export-settings-group' );
			?>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="pdf-export-post-status">Choose post status:</label>
						</th>
						<td>
							<select name="pdf_export_post_status" id="pdf-export-post-status">
								<option value="publish"<?php selected( get_option( 'pdf_export_post_status' ), 'publish' ); ?>>Publish</option>
								<option value="draft"<?php selected( get_option( 'pdf_export_post_status' ), 'draft' ); ?>>Draft</option>
								<option value="trash"<?php selected( get_option( 'pdf_export_post_status' ), 'trash' ); ?>>Trash</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="pdf-export-font">Choose PDF Font:</label>
						</th>
						<td>
							<select name="pdf_export_font" id="pdf-export-font">
								<option value="Arial"<?php selected( get_option( 'pdf_export_font' ), 'Arial' ); ?>>Arial</option>
								<option value="Times New Roman"<?php selected( get_option( 'pdf_export_font' ), 'Times New Roman' ); ?>>Times New Roman</option>
								<option value="Verdana"<?php selected( get_option( 'pdf_export_font' ), 'Verdana' ); ?>>Verdana</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="pdf-export-size">Choose PDF Font Size:</label>
						</th>
						<td>
							<select name="pdf_export_size" id="pdf-export-size">
								<option value="10"<?php selected( get_option( 'pdf_export_size' ), '10' ); ?>>10</option>
								<option value="12"<?php selected( get_option( 'pdf_export_size' ), '12' ); ?>>12</option>
								<option value="14"<?php selected( get_option( 'pdf_export_size' ), '14' ); ?>>14</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="pdf-export-show-author">Show Author:</label>
						</th>
						<td>
							<input type="checkbox" name="pdf_export_show_author" id="pdf-export-show-author" <?php checked( get_option( 'pdf_export_show_author' ), 'on' ); ?> />
						</td>
					</tr>
          <tr>
    <th scope="row">
        <label for="pdf-export-download-text">Download button text:</label>
    </th>
    <td>
        <input type="text" name="pdf_export_download_text" id="pdf-export-download-text" value="<?php echo esc_attr( get_option( 'pdf_export_download_text', 'Download PDF' ) ); ?>">
    </td>
</tr>
<tr>
    <th scope="row">
        <label for="pdf-export-show-size">Show file size:</label>
    </th>
    <td>
        <input type="checkbox" name="pdf_export_show_file_size" id="pdf-export-show-size" value="1" <?php checked( get_option( 'pdf_export_show_file_size', false ), true ); ?>>
    </td>
</tr>

					<tr>
						<th scope="row">
							<label for="pdf-export-show-date">Show Date:</label>
						</th>
						<td>
							<input type="checkbox" name="pdf_export_show_date" id="pdf-export-show-date" <?php checked(get_option( 'pdf_export_show_date' ), 'on' ); ?> />
</td>
</tr>
<tr>
<th scope="row">
<label for="pdf-export-show-category">Show Category:</label>
</th>
<td>
<input type="checkbox" name="pdf_export_show_category" id="pdf-export-show-category" <?php checked( get_option( 'pdf_export_show_category' ), 'on' ); ?> />
</td>
</tr>
</tbody>
</table>
<?php
 		submit_button( 'Save Settings' );
 		?>
</form>
</div>
<?php
}
