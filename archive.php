<?php
get_header();
?>

<section class="content px-3 py-5 p-md-5">

	<?php
	if (have_posts()) {

		while (have_posts()) {

			the_post();
			if (is_post_type_archive('photo')) {
				//Si c'est posttype 'photo' je prend le template content-photo
				get_template_part('template-parts/content', 'photo');

			} else {
				//Sinon pour tous les autres j'utilise le template content-archive
				get_template_part('template-parts/content', 'archive');

			}

		}
		the_posts_navigation();
	}

	?>

</section>

<?php
get_footer();
?>