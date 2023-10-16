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
    wp_deregister_script('jquery');
    wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), false, null, true);
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

function mota_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('mota_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'), '4.4.1', true);
    wp_enqueue_script('mota_popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), '1.16.0', true);
    wp_enqueue_script('natmota_script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', false);

    // Localize the ajaxurl variable
    wp_localize_script('natmota_script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
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

// Add this code to your theme's functions.php file

function filter_sort_photos()
{
    // Get the page number from the AJAX request
    $cat = intval($_POST['category']);
    $format = intval($_POST['format']);
    $sortOrder = intval($_POST['sort']);

    // Query for more photos
    $args = array(
        'post_type' => 'photo',
        // Replace with your CPT slug.
        'posts_per_page' => -1
        // 'offset' => $offset,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $title = the_title();
            $annee = the_field('annee');

            // Get the main category for the post
            $categories = get_the_terms(get_the_ID(), 'categories');

            if ($categories && !is_wp_error($categories)) {
                $main_cat = reset($categories); // Get the first category (main category)
            } else {
                // Handle the case where no categories are assigned
                $main_cat = ''; // You can set a default value or handle it as needed
            }

            $category = '';
            if ($main_cat) {
                $category = esc_html($main_cat->name);
                if ($category == $cat) {

                    // Get the formats for the current post from the custom taxonomy 'formats'
                    $formats = get_the_terms(get_the_ID(), 'formats');

                    // Check if there are formats and not an error
                    if ($formats && !is_wp_error($formats)) {
                        foreach ($formats as $format) {
                            $img_format = esc_html($format->name);

                            if ($img_format == $format) {
                                // Output the HTML for each photo
                                ?>
                                <div class="col post-photo">
                                    <img src="<?php the_field('fichier_photo'); ?>" />
                                </div>
                                <?php
                            }

                        }
                    }


                }


            }
        }
        wp_reset_postdata();

        // Always die at the end to return a proper response
        die();
    }
    /*
        // Replace with the base URL of the photos
        $baseUrl = "http://localhost:81/mota/photo/";

        // Define the total number of photos
        $totalPhotos = 16;

        // Initialize an array to store the photo URLs
        $photoUrls = array();

        // Loop through the range of photos
        for ($i = 1; $i <= $totalPhotos; $i++) {
            // Construct the URL by concatenating the base URL with the photo number
            $photoName = "photo" . $i;
            $photoUrl = $baseUrl . $photoName;

            // Get the HTML content of the constructed URL
            $html = file_get_contents($photoUrl);

            // Create a DOMDocument
            $dom = new DOMDocument;
            @$dom->loadHTML($html);

            // Find the image tag
            $imgTag = $dom->getElementsByTagName('img')->item(0); // Assuming there is only one image on the page

            if ($imgTag) {
                $src = $imgTag->getAttribute('src');
                $photoUrls[] = $src;
            }
        }

        // Sort or filter the $photoUrls array as needed
        // For example, you can sort the URLs alphabetically:
        // sort($photoUrls);

        // Return the sorted or filtered URLs
        return $photoUrls;
        */
}

// You can then call the function and use the returned URLs as needed in your templates or pages.


add_action('wp_ajax_filter_sort_photos', 'filter_sort_photos');
add_action('wp_ajax_nopriv_filter_sort_photos', 'filter_sort_photos');