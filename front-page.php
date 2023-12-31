<?php
get_header();
?>

<article>
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>

    <div class="container  px-3 py-5 p-md-5">
        <div class="row">
            <div class="col">
                <form id="filter-form">
                    <div class="filter-group">

                        <select name="categories" id="category-select" class="filter-dropdown">
                            <option value="">CATÉGORIES</option>
                            <option value="RECEPTION">Réception</option>
                            <option value="MARIAGE">Mariage</option>
                            <option value="CONCERT">Concert</option>
                            <option value="TELEVISION">Télévision</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <select name="formats" id="format-select" class="filter-dropdown">
                            <option value="">FORMATS</option>
                            <option value="PAYSAGE">Paysage</option>
                            <option value="PORTRAIT">Portrait</option>
                        </select>
                    </div>
                </form>
            </div>

            <form id="filter-form">
                <div class="filter-group">

                    <select name="sort" id="sort-select" class="filter-dropdown">
                        <option value="desc">TRIER PAR</option>
                        <option value="desc">Plus récentes</option>
                        <option value="asc">Plus anciennes</option>
                    </select>
                </div>
            </form>
        </div>

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
                <article class="content">
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
                </article>
                <div class="col-md-4 text-center">
                    <div class="load-more-button">
                        <button id="load-more">Charger plus</button>
                    </div>
                </div>
            </div>

            <?php
        }
            wp_reset_postdata();
            ?>

                
    </div>
</article>

<?php
get_footer();
?>