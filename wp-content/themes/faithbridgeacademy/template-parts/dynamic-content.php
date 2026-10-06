<?php
/**
 * Conditional dynamic-content section.
 *
 * Prints the live DB page content (pasted text, shortcodes like
 * Contact Form 7) in a centered container — only when the page
 * actually has content. Baked-in template design always renders above it.
 *
 * @package FaithBridgeAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$content = trim( get_the_content() );
	if ( '' !== $content ) :
		?>
		<section class="fba-dynamic">
			<div class="fba-wrap fba-dynamic-inner">
				<?php the_content(); ?>
			</div>
		</section>
		<?php
	endif;
endwhile;
