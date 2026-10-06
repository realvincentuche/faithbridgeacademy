<?php
/**
 * Coming soon homepage.
 *
 * @package FaithBridgeAcademy
 */

get_header();
?>

<section class="fba-coming-soon">
	<div class="fba-wrap fba-coming-soon-inner">
		<p class="fba-kicker"><?php esc_html_e( 'Admissions opening soon', 'faithbridgeacademy' ); ?></p>
		<h1 class="fba-coming-soon-title"><?php esc_html_e( 'Faith Bridge Academy', 'faithbridgeacademy' ); ?></h1>
		<p class="fba-coming-soon-text"><?php esc_html_e( 'A new place to learn, grow, and belong. Our website is under construction — please check back soon for admissions information, programmes, and news.', 'faithbridgeacademy' ); ?></p>
	</div>
</section>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
