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
        'primary' => "Desk Primary Left Sidebar",
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

    /* wp_enqueue_script('mota_jquery','https://code.jquery.com/jquery-3.4.1.slim.min.js' , array(), '3.4.1',true); */
    wp_enqueue_script('mota_popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array(), '1.16.0', true);
    wp_enqueue_script('mota_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array(), '3.4.1', true);
    wp_enqueue_script('mota_main', get_template_directory_uri('/assets/js/main.js'));
}
add_action('wp_enqueue_scripts', 'mota_scripts');
add_filter('wt_crp_subcategory_only', '__return_true');
/**
 * Remove related products output
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_filter('wp_get_attachment_image_attributes', 'change_attachement_image_attributes', 20, 2);
function change_attachement_image_attributes($attr, $attachment)
{
    // Get post parent
    $parent = get_post_field('post_parent', $attachment);

    // Get post type to check if it's product
    $type = get_post_field('post_type', $parent);
    if ($type != 'product') {
        return $attr;
    }

    /// Get title
    $title = get_post_field('post_title', $parent);

    if ($attr['alt'] == '') {
        $attr['alt'] = $type . ' ' . $title;
        $attr['title'] = $title;
    }

    return $attr;
}

add_filter('woosq_button_html', 'add_arialabel_and_title_to_quick_view_button', 99, 2);
function add_arialabel_and_title_to_quick_view_button($output, $product_id)
{
    $output = '<a href="?quick-view=' . esc_attr($product_id) . '" class="woosq-btn woosq-btn-' . esc_attr($product_id) . ' ' . get_option('woosq_button_class') . '" data-id="' . esc_attr($product_id) . '" data-effect="' . esc_attr(get_option('woosq_effect', 'mfp-3d-unfold')) . '" data-context="default" aria-label="Quick view ' . esc_attr($product_id) . '" title="Quick view ' . esc_attr($product_id) . '" role="link"><span class="woosq-btn-icon woosq-icon-4"></span></a>';
    return $output;
}

?>