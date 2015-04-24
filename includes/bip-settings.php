<?php

function bip_settings_page() { ?>
	
<div id="poststuff" class="grid">
<div class="whole unit">

<h2>Bulk Images to Posts - Settings</h2>

</div>
<div class="half unit">
    <div class="grid">
        <div class="half unit">
			<form method="post" action="options.php" id="bip-settings-form">
			    <?php settings_fields( 'bip-settings-group' ); ?>
			    <?php do_settings_sections( 'bip-settings-group' ); ?>
			   
			<div class="postbox">
			    <div title="Click to toggle" class="handlediv"><br></div>
			    <h3 class="hndle"><span>Select Post Type</span></h3>
			        <div class="inside">
			                <select id="bip-post-type" name="bip_post_type">
			                    <option style="font-weight:bold;" value="<?php echo get_option('bip_post_type'); ?>">
			                        <?php echo get_option('bip_post_type'); ?>
			                    </option>
			                    <option value="post">
			                        post
			                    </option>
			                    <option value="page">
			                        page
			                    </option>
			                    <?php $args = array( 'public'   => true, '_builtin' => false );
			
			                    $output = 'names'; // names or objects, note names is the default
			                    $operator = 'and'; // 'and' or 'or'
			
			                    $post_types = get_post_types( $args, $output, $operator ); 
			
			                    foreach ( $post_types  as $post_type ) { ?>
			                        <option value="<?php echo $post_type ?>">
			                           <?php echo $post_type ?>
			                        </option>
			                    <?php } ?>
			                </select>
			    </div>
			</div>
			<div class="postbox">
			    <div title="Click to toggle" class="handlediv"><br></div>
			    <h3 class="hndle"><span>Select Taxonomy</span></h3>
			        <div class="inside">
			                <select id="bip-taxonomy" name="bip_taxonomy">
			                    <option style="font-weight:bold;" value="<?php echo get_option('bip_taxonomy'); ?>">
			                        <?php echo get_option('bip_taxonomy'); ?>
			                    </option>                    
				                <?php 
								$args = array(
								  'public'   => true,
								  
								); 
								$output = 'names'; // or objects
								$operator = 'and'; // 'and' or 'or'
								$taxonomies = get_taxonomies( $args, $output, $operator ); 
								if ( $taxonomies ) {
								  foreach ( $taxonomies  as $taxonomy ) {
									  echo '<option value="'. $taxonomy .'">';
								    echo $taxonomy;
								    echo '</option>';
								  }
								}
								?>
			                </select>
			               
			                
			    </div>
			</div>
			<?php submit_button(); ?>
			</form>
        </div>
    </div>
</div>
</div>

<?php }