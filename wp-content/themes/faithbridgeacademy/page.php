<?php
/**
 * Default page template (fallback for pages without a dedicated template).
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
			'sub'   => '',
			'img'   => $uri . '/assets/images/hero-2.jpg',
		)
	);
	?>
	<div class="fba-content">
		<div class="fba-wrap fba-prose">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;

get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
