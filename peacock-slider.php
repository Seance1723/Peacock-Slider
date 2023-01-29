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
      'name'               => _x( 'Peacock Sliders', 'post type general name', 'peacock-slider' ),
      'singular_name'      => _x( 'Peacock Slider', 'post type singular name', 'peacock-slider' ),
      'menu_name'          => _x( 'Peacock Sliders', 'admin menu', 'peacock-slider' ),
      'name_admin_bar'     => _x( 'Peacock Slider', 'add new on admin bar', 'peacock-slider' ),
      'add_new'            => _x( 'Add New', 'peacock slider', 'peacock-slider' ),
      'add_new_item'       => __( 'Add New Peacock Slider', 'peacock-slider' ),
      'new_item'           => __( 'New Peacock Slider', 'peacock-slider' ),
      'edit_item'          => __( 'Edit Peacock Slider', 'peacock-slider' ),
      'view_item'          => __( 'View Peacock Slider', 'peacock-slider' ),
      'all_items'          => __( 'All Peacock Sliders', 'peacock-slider' ),
      'search_items'       => __( 'Search Peacock Sliders', 'peacock-slider' ),
      'parent_item_colon'  => __( 'Parent Peacock Sliders:', 'peacock-slider' ),
      'not_found'          => __( 'No peacock sliders found.', 'peacock-slider' ),
      'not_found_in_trash' => __( 'No peacock sliders found in Trash.', 'peacock-slider' )
    );
  
    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'peacock-slider' ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'peacock-slider' ),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'editor', 'thumbnail' ),
      'taxonomies'         => array( 'peacock_slider_category' )
    );
  
    register_post_type( 'peacock_slider', $args );
}

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

function peacock_slider_meta_box() {
    add_meta_box(
      'peacock_slider_meta_box',
      __( 'Peacock Slider Options', 'peacock-slider' ),
      'peacock_slider_meta_box_callback',
      'peacock_slider',
      'normal',
      'default'
    );
}

function peacock_slider_meta_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'peacock_slider_nonce' );
    $peacock_slider_stored_meta = get_post_meta( $post->ID );
    ?>
    <div>
      <div class="form-group">
        <label for="header"><?php _e( 'Header', 'peacock-slider' )?></label>
        <input type="text" name="header" id="header" value="<?php if ( isset ( $peacock_slider_stored_meta['header'] ) ) echo $peacock_slider_stored_meta['header'][0]; ?>" />
      </div>
      <div class="form-group">
        <label for="image"><?php _e( 'Image', 'peacock-slider' )?></label>
        <input type="text" name="image" id="image" value="<?php if ( isset ( $peacock_slider_stored_meta['image'] ) ) echo $peacock_slider_stored_meta['image'][0]; ?>" />
        <input type="button" id="image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'peacock-slider' )?>" />
      </div>
    </div>
    <?php
}

function peacock_slider_meta_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }
  
    if ( ! isset( $_POST['peacock_slider_meta_nonce'] ) || ! wp_verify_nonce( $_POST['peacock_slider_meta_nonce'], 'peacock_slider_save_meta_data' ) ) {
      return;
    }
  
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  
    if ( isset( $_POST['peacock_slider_header'] ) ) {
      update_post_meta( $post_id, 'peacock_slider_header', sanitize_text_field( $_POST['peacock_slider_header'] ) );
    }
  
    if ( isset( $_POST['peacock_slider_image'] ) ) {
      update_post_meta( $post_id, 'peacock_slider_image', intval( $_POST['peacock_slider_image'] ) );
    }
}

function peacock_slider_enqueue(){
    
}

function peacock_slider_shortcode(){
    
}

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