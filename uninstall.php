<?php

// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Remove custom post type 'peacock_slider'
function peacock_slider_remove() {
    global $wp_post_types;
    if (isset($wp_post_types['peacock_slider'])) {
        unset($wp_post_types['peacock_slider']);
        return true;
    }
    return false;
}
peacock_slider_remove();

// Remove custom taxonomy 'peacock_slider_category'
function peacock_slider_category_remove() {
    global $wp_taxonomies;
    if (isset($wp_taxonomies['peacock_slider_category'])) {
        unregister_taxonomy('peacock_slider_category');
        return true;
    }
    return false;
}
peacock_slider_category_remove();

// Remove all metadata for the custom post type
$posts = get_posts(array(
    'post_type' => 'peacock_slider',
    'numberposts' => -1
));
foreach ($posts as $post) {
    delete_post_meta($post->ID, '_header');
    delete_post_meta($post->ID, '_image');
}