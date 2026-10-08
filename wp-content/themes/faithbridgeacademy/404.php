<?php
/**
 * Branded not-found page.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Page Not Found', 'faithbridgeacademy' ),
		'sub'   => __( 'The address may have changed, or the page may no longer be available.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/hero-1.jpg',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap fba-prose">
		<p>
			<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
			<a class="fba-btn fba-btn-navy" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Explore Programmes', 'faithbridgeacademy' ); ?></a>
		</p>
	</div>
</div>

<?php
get_footer();
