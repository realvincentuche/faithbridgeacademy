<?php
/**
 * Programmes catalogue page (slug: programmes).
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri   = get_template_directory_uri();
$group = isset( $_GET['group'] ) ? sanitize_key( wp_unslash( $_GET['group'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- filter only.
$valid = get_terms(
	array(
		'taxonomy'   => 'programme_group',
		'hide_empty' => false,
		'fields'     => 'slugs',
	)
);
if ( $valid && ! is_wp_error( $valid ) && ! in_array( $group, $valid, true ) ) {
	$group = '';
}

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Our Programmes', 'faithbridgeacademy' ),
		'sub'   => sprintf( __( '%1$d programmes · %2$s', 'faithbridgeacademy' ), fba_programme_count(), fba_get_option( 'session_label' ) . ' · ' . fba_get_option( 'session_period' ) ),
		'img'   => $uri . '/assets/images/slide-4.jpg',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap">
		<?php get_template_part( 'template-parts/programme', 'grid', array( 'group' => $group ) ); ?>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
