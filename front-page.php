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
                <div class="filter-group">
                    <label for="category-select" class="filter-label">Catégories</label>
                    <select name="categories" id="category-select" class="filter-dropdown">
                        <option value="">Toutes</option>
                        <option value="RECEPTION">Réception</option>
                        <option value="MARIAGE">Mariage</option>
                        <option value="CONCERT">Concert</option>
                        <option value="TELEVISION">Télévision</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="format-select" class="filter-label">Formats</label>
                    <select name="formats" id="format-select" class="filter-dropdown">
                        <option value="">Tous</option>
                        <option value="PAYSAGE">Paysage</option>
                        <option value="PORTRAIT">Portrait</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort-select" class="filter-label">Trier par</label>
                    <select name="sort" id="sort-select" class="filter-dropdown">
                        <option value="desc">Plus récentes</option>
                        <option value="asc">Plus anciennes</option>
                    </select>
                </div>
            </form>



        <?php
        $args = array(
            'post_type' => 'photo',
            // Replace with your CPT slug.
            'posts_per_page' => -1,
            // Display all posts initially.
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            ?>
            <div class="row">
                <article class="content px-3 py-5 p-md-5">
                    <!-- Content for the left column -->
                    <div class="photo-gallery">
                        <?php
                        $count = 0;
                        while ($query->have_posts() && $count < 12) {
                            $query->the_post();
                            get_template_part('template-parts/content', 'photo'); // Include the content-photo template part
                    
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
            <?php
        }
        wp_reset_postdata();
        ?>

        <div id="photo-lightbox" class="lightbox">
            <span class="close-lightbox" id="close-lightbox">×</span>
            <img class="lightbox-content" id="lightbox-content" src="" alt="Photo en plein écran">

            <span class="lightbox-arrow lightbox-arrow-prev" id="lightbox-arrow-prev">← Précédente</span>
            <span class="lightbox-arrow lightbox-arrow-next" id="lightbox-arrow-next">Suivante →</span>

            <!-- Place the #lightbox-info element here -->
            <div id="lightbox-info">
                <div id="lightbox-reference"></div>
                <div id="lightbox-category"></div>
            </div>
        </div>
    </div>
</article>

<?php
get_footer();
?>