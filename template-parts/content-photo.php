<!-- content-photo.php -->

<div class="col post-photo">
    <div class="photo-card" data-image-url="<?php the_field('fichier_photo'); ?>"
        data-reference="<?php echo get_field('reference'); ?>" data-category="<?php echo get_category_names(); ?>"
        data-title="<?php echo the_title(); ?>">
        <img src="<?php the_field('fichier_photo'); ?>" />
        <i class="fas fa-eye fa-2x"></i>
        <img src="http://localhost:81/mota/wp-content/uploads/2023/10/Icon_fullscreen.png" class="fullscreen-icon" />
    </div>
</div>

