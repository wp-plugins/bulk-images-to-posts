	
<form id="the-drop" method="post" action="#" enctype="multipart/form-data"  >
	<div id="the-dropped" class="dropzone">
		<div class="dz-message">
			<span class="upload-icon dashicons dashicons-images-alt2"></span>
			<p>Drops images here or click to upload.</p>
		</div>
		</div>
		  <div class="fallback">
			  <input type="file" name="bipImage" id="bip_upload"  multiple="true" />
    <input class="btn" id="submit_bip_upload" name="submit_bip_upload" type="submit" value="Upload" />
  </div>
	
	<input type="hidden" name="bipSubmitted" id="bipSubmitted" value="true" />
	<?php wp_nonce_field( 'bip_upload', 'bip_upload_nonce' ); ?>
	
</form>
											
<script type="text/javascript">
	jQuery(document).ready(function($) {
		Dropzone.autoDiscover = false;
		new Dropzone("#the-drop", { 
		  paramName: "bipImage",
		  uploadMultiple: false, // The name that will be used to transfer the file
		  previewsContainer: '#the-dropped',
		  clickable: '#the-dropped',
		  method: "post",
		  addRemoveLinks: false,
		  autoProcessQueue: true,
		});
	});
</script>

<?php	
	if ( isset( $_POST['bipSubmitted'] ) 
	&& isset( $_POST['bip_upload_nonce'] ) 
	&& wp_verify_nonce( $_POST['bip_upload_nonce'], 'bip_upload' ) ) { 
	
	    // Let WordPress handle the upload.
		// Remember, 'bip_upload' is the name of our file input in our form above.
		$attachment_id = media_handle_upload( 'bipImage', 0 );
	
	    $attachment = get_post( $attachment_id );
	    $theoriginaltitle = $attachment->post_title;
        $thetitle = str_replace("-"," ",$theoriginaltitle);
        $uploadPostType = get_option('bip_post_type');
        $uploadTaxonomy = get_option('bip_taxonomy');
        $uploadTerms = get_option('bip_terms');

		$post_information = array(
            'post_title' => $thetitle,
            'post_type' => $uploadPostType,
            'post_status' => 'publish',
            'tax_input' => array(
                 $uploadTaxonomy => $uploadTerms,
                 )
		);
        
		$the_post_id = wp_insert_post( $post_information );
    
        // attach media to post
        wp_update_post( array(
            'ID' => $attachment_id,
            'post_parent' => $the_post_id,
        ) );

		set_post_thumbnail( $the_post_id , $attachment_id);
    

		if ( is_wp_error( $attachment_id ) ) {
			echo 'There was an error uploading the bip.';
       	} else {
        	// The bip was uploaded successfully!
        	echo 'success';
    	}
}

?>
