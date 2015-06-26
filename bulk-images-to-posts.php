<?php
/*
Plugin Name: Bulk Images to Posts
Plugin URI: http://www.mezzaninegold.com
Description: Bulk upload images to create posts / custom posts with featured images.
Version: 3.3
Author: Mezzanine gold
Author URI: http://mezzaninegold.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


require_once( 'includes/bip-category-walker.php' );
require_once( 'includes/bip-settings.php' );


add_action( 'admin_init', 'bip_admin_init' );
 
   function bip_admin_init() {
       /* Register our stylesheet and javascript. */
       wp_register_style( 'bip-css', plugins_url('css/style.css', __FILE__) );
       wp_register_script( 'bip-js', plugins_url('js/script.js', __FILE__), array( 'jquery' ), '', true );
       wp_register_script( 'dropzone-js', plugins_url('js/dropzone.js', __FILE__), array( 'jquery' ), '', true );     
   }   
   function bip_admin_styles() {
       wp_enqueue_style( 'bip-css' );
       wp_enqueue_script( 'bip-js' );
       wp_enqueue_script( 'dropzone-js' );
	   wp_enqueue_script( 'jquery-form' );
	   wp_enqueue_style( 'dashicons' );
   }

// create plugin settings menu
add_action('admin_menu', 'bip_create_menu');

function bip_create_menu() {

    // create new top-level menu
    global $bip_admin_page;
    $bip_admin_page = add_menu_page('Bulk Images to Posts Uploader', 'Bulk', 'manage_options', 'bulk-images-to-post','bip_upload_page','dashicons-images-alt2');
    // create submenu pages
    add_submenu_page( 'bulk-images-to-post', 'Bulk Images to Post - Upload', 'Uploader', 'manage_options', 'bulk-images-to-post');
	$bip_submenu_page = add_submenu_page( 'bulk-images-to-post', 'Bulk Images to Post - Settings', 'Settings', 'manage_options', 'bip-settings-page', 'bip_settings_page');
    // call register settings function
    add_action( 'admin_init', 'bip_register_settings' );
    // enqueue scripts
    add_action( 'admin_print_styles-' . $bip_admin_page, 'bip_admin_styles' );
    add_action( 'admin_print_styles-' . $bip_submenu_page, 'bip_admin_styles' );
     
}


function bip_register_settings() {
    // register our settings
    register_setting( 'bip-upload-group', 'bip_terms' );
    register_setting( 'bip-settings-group', 'bip_post_type' );
    register_setting( 'bip-settings-group', 'bip_taxonomy' );
}

function bip_upload_page() { ?>

<div id="poststuff" class="grid">
<div class="whole unit">

<h2>Bulk Images to Posts - Upload</h2>
<p>Use the settings page to select/change the post type &amp; taxonomy</p>
</div>
        <div class="one-third unit">
			<form method="post" action="options.php" id="bip-upload-form">
			    <?php settings_fields( 'bip-upload-group' ); ?>
			    <?php do_settings_sections( 'bip-upload-group' ); ?>
			
			

				    <?php
					$selected_tax = get_option('bip_taxonomy','category'); 
					$selected_cats = get_option('bip_terms');
				    $walker = new Walker_Bip_Terms( $selected_cats, 'in-category' ); ?>
				    <div class="postbox">
					  	<div title="Click to toggle" class="handlediv"><br></div>
					  	<h3 class="hndle"><span>Terms</span></h3>
					    <div class="inside">
						    <div class="buttonbox">
						    <p class="uncheck"><input type="button" class="check button button-primary" value="Uncheck All" /></p>
						    <?php submit_button(); ?>
						    </div>
						    <div class="categorydiv">
							    <div class="tabs-panel">
								    <div class="checkbox-container">
									    <ul class="categorychecklist ">
											<?php 
										    $args = array(
										    'descendants_and_self'  => 0,
										    'selected_cats'         => $selected_cats,
										    'popular_cats'          => false,
										    'walker'                => $walker,
										    'taxonomy'              => $selected_tax,
										    'checked_ontop'         => false ); ?>
											<?php wp_terms_checklist( 0, $args ); ?>
									    </ul>
								    </div>
							    </div>
						    </div>
					    </div>
				    </div>

			</form>
			<div id="saveResult"></div>
<script type="text/javascript">
jQuery(document).ready(function() {

});
</script>
</div>
<div class="two-thirds unit">
	<div class="postbox">
		<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Images</span></h3>
			<?php include 'includes/bip-dropzone.php';?>
		</div>
	</div>
</div>
<?php } ?>