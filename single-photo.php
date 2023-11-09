<?php
get_header();
?>

<article class="photo container px-3 py-5 p-md-5 single-photo">
    <?php if (have_posts()) {

        // Load posts loop.
        while (have_posts()) {
            the_post();

            // Get the main category for the post
            $categories = get_the_terms(get_the_ID(), 'categories');

            if ($categories && !is_wp_error($categories)) {
                $main_cat = reset($categories); // Get the first category (main category)
            } else {
                // Handle the case where no categories are assigned
                $main_cat = '';
            }

            // Content
            ?>

            <div class="row custom-align">
                <div class="col main-content  ">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <p class="metas" id="current-photo-ref">RÉFÉRENCE : <?php the_field('reference'); ?></p>
                    <p class="metas">CATÉGORIE :
                        <?php
                        if ($main_cat) {
                            echo esc_html($main_cat->name);
                        }
                        ?>
                    </p>
                    <p class="metas">FORMAT :
                        <?php
                        // Get the formats for the current post from the custom taxonomy 'formats'
                        $formats = get_the_terms(get_the_ID(), 'formats');

                        // Check if there are formats and not an error
                        if ($formats && !is_wp_error($formats)) {
                            foreach ($formats as $format) {
                                echo esc_html($format->name);
                            }
                        }
                        ?>
                    </p>
                    <p class="metas">TYPE :
                        <?php the_field('type'); ?>
                    </p>
                    <p class="metas">ANNÉE :
                        <?php the_field('annee'); ?>
                    </p>

                    <?php
                    // Get the categories for the current post
                    $categories = get_the_category();

                    // Check if there are categories and not an error
                    if ($categories && !is_wp_error($categories)) {
                        echo '<p class="metas">Catégories : ';
                        foreach ($categories as $category) {
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>, ';
                        }
                        echo '</p>';
                    }
                    ?>
                </div>

                <div class="col post-single-photo">
                    <img src="<?php the_field('fichier_photo'); ?>" />
                </div>
            </div>


            <!-- Previous and Next Post Navigation -->

            <!--  ******************  footer   **************** -->

            <footer>
                <div class="row contact">
                    <div class="col contact-layout">
                        <p>Cette photo vous intéresse ?</p>
                        <div class="contact-text">
                            <a href="#" class="wp-button_link open-modal">Contact</a>
                        </div>
                    </div>

                    <div class="col post-nav">
                        <?php
                        $prev_post = get_adjacent_post(false, '', true);
                        $next_post = get_adjacent_post(false, '', false);
                        ?>
                        <div class="image-container">
                            <img src="<?php echo get_field('fichier_photo', $next_post); ?>" alt="Next Photo" width="87"
                                height="71">
                        </div>
                        <div class="arrows">
                            <a href="<?php echo get_permalink($prev_post); ?>">
                                <span class="arrow-left">←</span>
                            </a>
                            <a href="<?php echo get_permalink($next_post); ?>">
                                <span class="arrow-right">→</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Display the next 2 photos in the same category -->
                <div class="row other">
                    <?php
                    // Custom query
                    $categories = get_the_terms(get_the_ID(), 'categories');
                    $main_cat = $categories[0]->term_id;

                    $args = array(
                        'post_type' => 'photo',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categories',
                                // Use the main category's taxonomy
                                'field' => 'term_id',
                                'terms' => $main_cat,
                                // Use the main category's term ID
                            ),
                        ),
                        'posts_per_page' => -1, // Remove the posts_per_page limit
                    );

                    $the_query = new WP_Query($args);

                    if ($the_query->have_posts()): ?>
                        <hr> <!-- Horizontal line -->
                        <h2>VOUS AIMEREZ AUSSI</h2>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
                <!-- End of "VOUS AIMEREZ AUSSI" section -->

                <!-- Display the next 2 photos in two columns -->
                <?php
                $photos = array(); // Initialize an array to store the next 2 photos
        
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $photo_data = array(
                        'title' => get_the_title(),
                        'image' => get_field('fichier_photo'),
                    );
                    $photos[] = $photo_data;

                    if (count($photos) >= 2) {
                        break; // Limit to 2 photos
                    }
                }
                ?>
                <div class="row">
                    <?php foreach ($photos as $photo): ?>
                        <div class="col post-photo">
                            <div class="photo-card">
                                <img src="<?php echo $photo['image']; ?>" alt="<?php echo $photo['title']; ?>">

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- End of code for displaying the next 2 photos -->


            </footer>
            <!-- Show All Photos Button -->
            <div class="all-photos">
                <a href="<?php echo get_site_url(null, '/photos') ?>">Tous les photos</a>
            </div>
            <?php
        }
    }
    ?>
</article>
<?php
get_footer();
?>