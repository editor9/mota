<?php
get_header();
?>

<article class="photo container px-3 py-5 p-md-5">
	<?php if (have_posts()) {

		// Load posts loop.
		while (have_posts()) {
			the_post();

			// Get the main category for the post
			$categories = get_the_terms(get_the_ID(), 'categories');

			if ($categories && !is_wp_error($categories)) {
				$main_cat = reset($categories); // Get the first category (main category)
			} else {
				// Handle the case where no categories are assigned
				$main_cat = ''; // You can set a default value or handle it as needed
			}

			// Content
			?>

			<div class="row">
				<div class="col main-content">
					<h1>
						<?php the_title(); ?>
					</h1>
					<p class="metas">RÉFÉRENCE :
						<?php the_field('reference'); ?>
					</p>
					<p class="metas">CATÉGORIE :
						<?php
						if ($main_cat) {
							echo esc_html($main_cat->name);
						}
						?>
					</p>
					<p class="metas">FORMAT :
						<?php
						// Get the formats for the current post from the custom taxonomy 'formats'
						$formats = get_the_terms(get_the_ID(), 'formats');

						// Check if there are formats and not an error
						if ($formats && !is_wp_error($formats)) {
							foreach ($formats as $format) {
								echo esc_html($format->name);
							}
						}
						?>
					</p>
					<p class="metas">TYPE :
						<?php the_field('type'); ?>
					</p>
					<p class="metas">ANNÉE :
						<?php the_field('annee'); ?>
					</p>


					<?php
					// Get the categories for the current post
					$categories = get_the_category();

					// Check if there are categories and not an error
					if ($categories && !is_wp_error($categories)) {
						echo '<p class="metas">Catégories : ';
						foreach ($categories as $category) {
							echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>, ';
						}
						echo '</p>';
					}
					?>

				</div>

				<div class="col post-photo">
					<img src="<?php the_field('fichier_photo'); ?>" />
				</div>
			</div>
			<!-- Previous and Next Post Navigation -->


			<!--  ******************  footer   **************** -->

			<footer>
				<div class="row contact">
					<div class="col contact-layout">
						<p>Cette photo vous intéresse ?</p>
						<div class="contact-text">

							<a href="#" class="wp-button_link open-modal">Contact</a>
						</div>
					</div>

					<div class="col post-nav">
						<?php
						$prev_post = get_adjacent_post(false, '', true);
						$next_post = get_adjacent_post(false, '', false);
						?>
						<div class="image-container">
							<img src="<?php echo get_field('fichier_photo', $next_post); ?>" alt="Next Photo" width="87"
								height="71">
						</div>
						<div class="arrows">
							<a href="<?php echo get_permalink($prev_post); ?>">
								<span class="arrow-left">←</span>
							</a>
							<a href="<?php echo get_permalink($next_post); ?>">
								<span class="arrow-right">→</span>
							</a>
						</div>
					</div>

					<?php
					// Display thumbnail of the next post "photo"
			
					// Post navigation of "photo"
					?>

				</div>
				<div class="row other">
					<?php
					// Display the next 2 photos in the same category
					// Custom query
					//recupéré la categorie
					//var_dump(get_the_terms(get_the_ID(),'categories'));
					$categories = get_the_terms(get_the_ID(), 'categories');
					$main_cat = $categories[0]->term_id;
					var_dump($main_cat);

					$args = array(
						'post_type' => 'photo',
						'tax_query' => array(
							array(
								'taxonomy' => 'categories',
								// Use the main category's taxonomy
								'field' => 'term_id',
								'terms' => $main_cat,
								// Use the main category's term ID
							),
						),
						'posts_per_page' => 2,
					);

					$the_query = new WP_Query($args);

					if ($the_query->have_posts()): ?>
						<hr> <!-- Horizontal line -->
						<h2>VOUS AIMEREZ AUSSI</h2>

						<!-- The loop displays 2 items if they exist -->
						<?php while ($the_query->have_posts()):
							$the_query->the_post(); ?>
							<?php
							the_title();

							//get_template_part('template-parts/photo-img'); ?>
							<a href="" class="same_photos">
								<img src="" alt="<?php the_title() ?>" />

							</a>

						<?php endwhile; ?>
						<!-- End of the loop -->

						<?php wp_reset_postdata(); ?>

					<?php endif; ?>
				</div>

			</footer>

			<?php
		}
	}
	?>
</article>

<?php
get_footer();
?>