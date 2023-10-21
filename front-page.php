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
        <form id="filter-form">
            <label for="category-select">Catégories:</label>
            <select name="categories" id="category-select">
                <option value="">Toutes</option>
                <option value="Reception">Réception</option>
                <option value="Mariage">Mariage</option>
                <option value="Concert">Concert</option>
                <option value="Television">Télévision</option>
            </select>

            <label for="format-select">Formats:</label>
            <select name="formats" id="format-select">
                <option value="">Tous</option>
                <option value="paysage">Paysage</option>
                <option value="portrait">Portrait</option>
            </select>

            <label for="sort-select">Trier par:</label>
            <select name="sort" id="sort-select">
                <option value="desc">Plus récentes</option>
                <option value="asc">Plus anciennes</option>
            </select>

            <input type="submit" value="Filtrer les photos">
        </form>


        <?php
        $args = array(
            'post_type' => 'photo',
            // Replace with your CPT slug.
            'posts_per_page' => 12,
            // Display 12 posts initially.
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
                                    <div class="photo-card" data-image-url="<?php the_field('fichier_photo'); ?>">
                                        <img src="<?php the_field('fichier_photo'); ?>" />
                                        <i class="fas fa-eye fa-2x"></i>
                                    </div>
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
    <div id="photo-lightbox" class="lightbox">
        <span class="close-lightbox" id="close-lightbox">×</span>
        <img class="lightbox-content" id="lightbox-content" src="" alt="Photo en plein écran">
        <span class="lightbox-arrow lightbox-arrow-prev" id="lightbox-arrow-prev">← Precedente</span>
        <span class="lightbox-arrow lightbox-arrow-next" id="lightbox-arrow-next">Suivante →</span>
    </div>

</article>

<?php
get_footer();
?>