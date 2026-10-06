<?php
/**
 * Single post template (DB-driven Loop).
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
			<p class="fba-post-meta"><?php echo esc_html( get_the_date() ); ?></p>
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
