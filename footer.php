<?php
get_template_part('template-parts/contact-modal');
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

<footer class="footer text-center py-2 theme-bg-dark">

    <hr>
    <nav class="footer-menu">
        <?php
        wp_nav_menu(
            array(
                'menu' => 'footer',
                'container' => '',
                'theme_location' => 'footer',
                'item_wrap' => '<ul class="menu">%3$s</ul>'
            )
        );
        ?>
    </nav>

</footer>

</body>

</html>