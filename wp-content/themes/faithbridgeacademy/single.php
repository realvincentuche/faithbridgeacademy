<?php
/**
 * Single post template (DB-driven Loop).
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

while ( have_posts() ) :
	the_post();
	get_template_part(
		'template-parts/page',
		'banner',
		array(
			'title' => get_the_title(),
			'sub'   => get_the_date(),
			'img'   => $uri . '/assets/images/news-3.jpg',
		)
	);
	?>
	<div class="fba-content">
		<div class="fba-wrap fba-prose">
			<?php the_content(); ?>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
