<?php

/**
 * Plugin Name: Peacock Slider
 * Plugin URI: 
 * Description: A custom post type plugin for creating a slider using Bootstrap carousel.
 * Version: 1.0
 * Author: 
 * Author URI: 
 * License: GPLv2 or later
 */

// Register custom post type 'peacock_slider'
function peacock_slider_post_type() {
    $labels = array(
      'name' => 'Peacock Sliders',
      'singular_name' => 'Peacock Slider',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Slider',
      'edit_item' => 'Edit Slider',
      'new_item' => 'New Slider',
      'all_items' => 'All Sliders',
      'view_item' => 'View Slider',
      'search_items' => 'Search Sliders',
      'not_found' =>  'No Sliders found',
      'not_found_in_trash' => 'No Sliders found in Trash',
      'parent_item_colon' => '',
      'menu_name' => 'Peacock Sliders'
    );
         
    $args = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => 'peacock-slider' ),
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => null,
      'menu_icon' => 'dashicons-images-alt2',
      'supports' => array( 'title', 'editor', 'thumbnail' ),
      'taxonomies' => array( 'peacock_slider_category' )
    );
    
    register_post_type( 'peacock_slider', $args );
}
add_action( 'init', 'peacock_slider_post_type' );
  
function peacock_slider_category() {
    $labels = array(
      'name'              => _x( 'Peacock Slider Categories', 'taxonomy general name', 'peacock-slider' ),
      'singular_name'     => _x( 'Peacock Slider Category', 'taxonomy singular name', 'peacock-slider' ),
      'search_items'      => __( 'Search Peacock Slider Categories', 'peacock-slider' ),
      'all_items'         => __( 'All Peacock Slider Categories', 'peacock-slider' ),
      'parent_item'       => __( 'Parent Peacock Slider Category', 'peacock-slider' ),
      'parent_item_colon' => __( 'Parent Peacock Slider Category:', 'peacock-slider' ),
      'edit_item'         => __( 'Edit Peacock Slider Category', 'peacock-slider' ),
      'update_item'       => __( 'Update Peacock Slider Category', 'peacock-slider' ),
      'add_new_item'      => __( 'Add New Peacock Slider Category', 'peacock-slider' ),
      'new_item_name'     => __( 'New Peacock Slider Category Name', 'peacock-slider' ),
      'menu_name'         => __( 'Peacock Slider Categories', 'peacock-slider' ),
    );
  
    $args = array(
      'labels'            => $labels,
      'hierarchical'      => true,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'peacock-slider-category' ),
    );
  
    register_taxonomy( 'peacock_slider_category', array( 'peacock_slider' ), $args );
}
  


function peacock_slider_add_meta_boxes() {
      add_meta_box(
        'peacock_slider_image',
        'Slider Image',
        'peacock_slider_image_callback',
        'peacock_slider',
        'normal',
        'default'
      );
      add_meta_box(
        'peacock_slider_header',
        'Slider Header',
        'peacock_slider_header_callback',
        'peacock_slider',
        'normal',
        'default'
      );
}
add_action( 'add_meta_boxes', 'peacock_slider_add_meta_boxes' );
    
function peacock_slider_image_callback( $post ) {
      wp_nonce_field( basename( __FILE__ ), 'peacock_slider_nonce' );
      $peacock_slider_stored_meta = get_post_meta( $post->ID );
      ?>
      <p>
        <label for="peacock-slider-image" class="peacock-slider-row-title">Image</label>
        <input type="text" name="peacock-slider-image" id="peacock-slider-image" value="<?php if ( isset ( $peacock_slider_stored_meta['peacock-slider-image'] ) ) echo $peacock_slider_stored_meta['peacock-slider-image'][0]; ?>" />
      </p>
      <?php
}
    
function peacock_slider_header_callback( $post ) {
      wp_nonce_field( basename( __FILE__ ), 'peacock_slider_nonce' );
      $peacock_slider_stored_meta = get_post_meta( $post->ID );
      ?>
      <p>
        <label for="peacock-slider-header" class="peacock-slider-row-title">Header</label>
        <input type="text" name="peacock-slider-header" id="peacock-slider-header" value="<?php if ( isset ( $peacock_slider_stored_meta['peacock-slider-header'] ) ) echo $peacock_slider_stored_meta['peacock-slider-header'][0]; ?>" />
      </p>
      <?php
}
  
function peacock_slider_meta_save( $post_id ) {
      // verify nonce
      if ( !isset( $_POST['peacock_slider_nonce'] ) || !wp_verify_nonce( $_POST['peacock_slider_nonce'], basename( __FILE__ ) ) ) {
        return;
      }
    
      // check autosave
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
      }
    
      // check permissions
      if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
      }
    
      // save data
      if ( isset( $_POST['peacock-slider-image'] ) ) {
        update_post_meta( $post_id, 'peacock-slider-image', sanitize_text_field( $_POST['peacock-slider-image'] ) );
      }
      if ( isset( $_POST['peacock-slider-header'] ) ) {
        update_post_meta( $post_id, 'peacock-slider-header', sanitize_text_field( $_POST['peacock-slider-header'] ) );
      }
}
add_action( 'save_post', 'peacock_slider_meta_save' );


// Activation function
function peacock_slider_activate() {
    peacock_slider_post_type();
    peacock_slider_category();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'peacock_slider_activate');

// Deactivation function
function peacock_slider_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'peacock_slider_deactivate');
    