<?php
 get_template_part('template-parts/contact-modal'); 
 ?>

<footer class="footer text-center py-2 theme-bg-dark">


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