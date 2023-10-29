<?php
//the below is to debug 'same as wp-config.php'
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


function mota_theme_support()
{ // adds dynamic title tag support   
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mota_theme_support');

function mota_menu()
{ // adds menu header and footer
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
    wp_localize_script('mota_script', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mota_filter'),
    )
    );
}
add_action('wp_enqueue_scripts', 'mota_scripts');



function load_more_photos() // Define the function for handling the AJAX action
{
    // Get the page number from the AJAX request
    $page = intval($_POST['page']);
    $posts_per_page = 12; // Define the number of posts per page
    $offset = ($page - 1) * $posts_per_page; // Calculate the offset to query the correct posts

    $args = array(
        // Query for more photos
        'post_type' => 'photo',
        // Replace with your CPT slug.
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); // Output the HTML for each photo
            ?>
            <div class="col post-photo">
                <img src="<?php the_field('fichier_photo'); ?>" />
            </div>
            <?php
        }
    }
    wp_reset_postdata();

    die(); // Always die at the end to return a proper response
}

// Hook the above function into WordPress
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');



function generate_photo_cards($query, $selectedCategory, $selectedFormat)
{
    ob_start(); // Start output buffering
    if ($query->have_posts()) {
        $count = 0;
        while ($query->have_posts() && $count < 13) {
            $query->the_post();
            $current_post_category = get_category_names(); // Get the category of the current post
            $current_post_format = get_formats_names(); // Get the format of the current post
            $display_post = false;

            if (!empty($selectedCategory) && !empty($selectedFormat)) {
                // Both category and format are specified
                if ($selectedCategory == $current_post_category && $selectedFormat == $current_post_format) {
                    $display_post = true;
                }
            } elseif (!empty($selectedCategory)) {
                // Only category is specified
                if ($selectedCategory == $current_post_category) {
                    $display_post = true;
                }
            } elseif (!empty($selectedFormat)) {
                // Only format is specified
                if ($selectedFormat == $current_post_format) {
                    $display_post = true;
                }
            } else {
                // Neither category nor format is specified, so display all posts
                $display_post = true;
            }

            if ($display_post) {
                get_template_part('template-parts/content', 'photo');
                $count++;
            }
        }
    }
    wp_reset_postdata();
    $content = ob_get_clean(); // Get the buffered HTML content
    wp_send_json(array('content' => $content));
}


function filter_photos()
{
    if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'mota_filter')) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }
    // Debugging: Output the selected category and other filter parameters
    error_log('Selected Category: ' . $_POST['category']);
    error_log('Other Filter Parameters: ' . json_encode($_POST));


    $selectedCategory = isset($_POST['category']) ? $_POST['category'] : ''; // Selected category
    $selectedFormat = isset($_POST['format']) ? $_POST['format'] : ''; // Selected format
    $selectedSort = isset($_POST['sort']) ? $_POST['sort'] : ''; // Selected sort order

    error_log('Selected Category: ' . $selectedCategory);
    error_log('Selected Format: ' . $selectedFormat);

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1,
        //-1 means all number of posts per page 
        'order' => 'DESC'
    );

    if ($selectedSort === 'asc') {
        // Sort by oldest first
        $args['order'] = 'ASC';
    }

    // Perform the query
    $query = new WP_Query($args);

    // Debugging: Output the generated SQL query
    error_log('Generated SQL Query: ' . $query->request);

    $photo_cards = generate_photo_cards($query, $selectedCategory, $selectedFormat);

    wp_send_json_success(array('content' => $photo_cards));
}

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');


function get_category_names()
{
    $categories = get_the_terms(get_the_ID(), 'categories');
    if (empty($categories)) {
        return ''; // No categories found
    }
    $category_names = array();
    foreach ($categories as $category) {
        $category_names[] = $category->name;
    }
    return implode(', ', $category_names);
}

function get_formats_names()
{
    $formats = get_the_terms(get_the_ID(), 'formats');
    if (empty($formats)) {
        return ''; // No formats found
    }
    $format_names = array();
    foreach ($formats as $format) {
        $format_names[] = $format->name;
    }
    return implode(', ', $format_names);
}


function load_all_photos() {
    // Your WP_Query code to retrieve photo cards
    // ...
    $args = array(
        // Query for more photos
        'post_type' => 'photo',
        'posts_per_page' => -1,
        // Replace with your CPT slug.
       
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); // Output the HTML for each photo
            ?>
            <div class="col post-photo">
                <img src="<?php the_field('fichier_photo'); ?>" />
            </div>
            <?php
        }
    }
   
    wp_reset_postdata();
}

add_action('wp_ajax_load_all_photos', 'load_all_photos');
add_action('wp_ajax_nopriv_load_all_photos', 'load_all_photos');
