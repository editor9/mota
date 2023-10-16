<?php
get_header();
?>

<article class="px-3 py-5 p-md-5">

    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>


    <div class="container">
    <div id="photo"> <!-- Add this div element -->
        <!-- Your photos will be displayed here -->
    </div>
    <div class="photo-gallery">

        <label for="categories">Catégories:</label>
        <select id="categories">
            <option value="all">Toutes</option>
            <option value="Reception">Réception</option>
            <option value="Mariage">Mariage</option>
            <option value="Concert">Concert</option>
            <option value="Television">Télévision</option>
        </select>

        <label for="formats">Formats:</label>
        <select id="formats">
            <option value="all">Tous</option>
            <option value="paysage">Paysage</option>
            <option value="portrait">Portrait</option>
        </select>

        <label for="sort">Trier par Date:</label>
        <select id="sort">
            <option value="asc">Plus Anciennes</option>
            <option value="desc">Plus Récentes</option>
        </select>
    </div>

        <?php
        $args = array(
            'post_type' => 'photo', // Replace with your CPT slug.
            'posts_per_page' => 12, // Display 12 posts initially.
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ?>
            <div class="row">
                <div class="content-container">
                    <article class="content px-3 py-5 p-md-5">
                        <!-- Content for the left column -->
                        <div class="photo-gallery">
              
                            <?php
                            $count = 0;
                            while ($query->have_posts() && $count < 12) {
                                $query->the_post();
                                ?>
                                <div class="col post-photo">
                                    <img src="<?php the_field('fichier_photo'); ?>" />
                                </div>
                                <?php
                                $count++;
                            }
                            ?>
                        </div>
                        <?php
                        if ($query->found_posts > 12) {
                            ?>
                            <div class="load-more-button">
                                <button id="load-more">Charger plus</button>
                            </div>
                            <?php
                        }
                        ?>
                    </article>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</article>

<?php
get_template_part('template-parts/contact-modal');
get_footer();
?>
