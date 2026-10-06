<?php
/**
 * Default page template (fallback for pages without a dedicated template).
 *
 * @package FaithBridgeAcademy
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="fba-content">
		<div class="fba-wrap fba-prose">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
