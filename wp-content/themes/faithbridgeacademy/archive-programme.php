<?php
/**
 * Programme archive fallback (same catalogue grid).
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

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
		<?php get_template_part( 'template-parts/programme', 'grid', array( 'group' => '' ) ); ?>
	</div>
</div>

<?php
get_footer();
