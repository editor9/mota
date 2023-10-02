<?php
get_header();
?>


<article class="content px-3 py-5 p-md-5">

	<?php
	if (have_posts()) {

		while (have_posts()) {

			the_post();
			echo 'monTemplate';
            the_title('<h1>', '</h1>');
		}
	}

	?>



</article>


<?php
get_footer();
?>