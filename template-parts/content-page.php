<!-- Container for all photos (initially hidden) -->
<div class="all-photos-container">
    <div class="photo-gallery"> <!-- Add this container here -->
        <?php
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => -1,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Display each photo here
                get_template_part('template-parts/content', 'photo');
            }
        }
        wp_reset_postdata();
        ?>
    </div> <!-- Close the "photo-gallery" container here -->
</div>
