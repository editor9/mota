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
    wp_enqueue_style('mota-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), '4.4.1', 'all');
    wp_enqueue_style('mota-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0', 'all');
    wp_enqueue_style('mota-style', get_template_directory_uri() . "/style.css", array('mota-fontawesome'), $version, 'all');
}
add_action('wp_enqueue_scripts', 'mota_style');

function enqueue_jquery()
{
    wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

function mota_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('mota_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'), '4.4.1', true);
    wp_enqueue_script('mota_popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), '1.16.0', true);
    wp_enqueue_script('mota_script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', false);
    wp_localize_script('mota_script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));

}
add_action('wp_enqueue_scripts', 'mota_scripts');


// Define the function for handling the AJAX action
function load_more_photos()
{
    // Get the page number from the AJAX request
    $page = intval($_POST['page']);
    // Define the number of posts per page
    $posts_per_page = 12;
    // Calculate the offset to query the correct posts
    $offset = ($page - 1) * $posts_per_page;
    // Query for more photos
    $args = array(
        'post_type' => 'photo',
        // Replace with your CPT slug.
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Output the HTML for each photo
            ?>
            <div class="col post-photo">
                <img src="<?php the_field('fichier_photo'); ?>" />
            </div>
            <?php
        }
    }
    wp_reset_postdata();

    // Always die at the end to return a proper response
    die();
}
// Hook the above function into WordPress
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');