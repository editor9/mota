<?php

function mota_theme_support()
{
    // adds dynamic title tag support
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

}

add_action('after_setup_theme', 'mota_theme_support');

function mota_menu()
{
    $locations = array(
        'primary' => "Desk Primary",
        'footer' => "Footer Menu Items"
    );

    register_nav_menus($locations);

}

add_action('init', 'mota_menu');

function mota_style()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('mota-style', get_template_directory_uri() . "/style.css", array('mota-fontawesome'), $version, 'all');
    wp_enqueue_style('mota-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), '4.4.1', 'all');
    wp_enqueue_style('mota-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0', 'all');

}

add_action('wp_enqueue_scripts', 'mota_style');

function mota_scripts()
{
    // Enqueue jQuery from WordPress
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', array(), '3.4.1', true);

    // Enqueue your custom script with jQuery as a dependency
    wp_enqueue_script('mota_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'), '4.4.1', true);
    wp_enqueue_script('mota_popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), '1.16.0', true);
    wp_enqueue_script('natmota_script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', false);
}

add_action('wp_enqueue_scripts', 'mota_scripts');

function custom_contact_modal_content($content) {
    // Check if this is one of the specified pages
    $allowed_pages = array('accueil', 'a-propos', 'contact', 'mentions-legales', 'vie-privee');
    if (is_page($allowed_pages)) {
        ob_start(); // Start output buffering
        include(get_template_directory() . '/template-parts/contact-modal.php'); // Include your modified contact modal
        $custom_content = ob_get_clean(); // Get the output and clean the buffer
        return $content .$custom_content;
       
    }

    return $content; // For other pages, return the original content
}
add_filter('the_content', 'custom_contact_modal_content');





//add_filter('wt_crp_subcategory_only', '__return_true');
?>