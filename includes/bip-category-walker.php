<?php

require_once ABSPATH . 'wp-admin/includes/template.php';

class Walker_Bip_Terms extends Walker_Category_Checklist {

  private $name;
  private $id;

  function __construct( $name = '', $id = '' ){
	  $name = 'bip_terms';
      $this->name = $name;
      $this->id = $id;
  }

  function start_el( &$output, $cat, $depth = 0, $args = array(), $id = 0 ) {
    extract($args);
    if ( empty($taxonomy) ) $taxonomy = $selected_cats;
    $class = in_array( $cat->term_id, $popular_cats ) ? ' class="popular-category"' : '';
    $id = $this->id . '-' . $cat->term_id;
    $checked = checked( in_array( $cat->term_id, $selected_cats ), true, false );
    $output .= "\n<li id='{$taxonomy}-{$cat->term_id}'$class>" 
      . '<input value="' 
      . $cat->term_id . '" type="checkbox" name="' . $this->name 
      . '[]" id="in-'. $id . '"' . $checked 
      . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' 
      . esc_html( apply_filters('the_category', $cat->name )) 
      . '';
    }
}
?>