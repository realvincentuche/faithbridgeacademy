<?php
/**
 * Inner-page banner with breadcrumbs.
 *
 * Args: title, sub, img.
 *
 * @package FaithBridgeAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = isset( $args['title'] ) ? $args['title'] : get_the_title();
$sub   = isset( $args['sub'] ) ? $args['sub'] : '';
$img   = isset( $args['img'] ) ? $args['img'] : get_template_directory_uri() . '/assets/images/hero-2.jpg';
$tint  = isset( $args['tint'] ) ? sanitize_key( $args['tint'] ) : '';
if ( ! in_array( $tint, array( '', 'green' ), true ) ) {
	$tint = '';
}
?>

<section class="fba-banner<?php echo 'green' === $tint ? ' fba-banner-green' : ''; ?>">
	<div class="fba-banner-bg" style="background-image:url('<?php echo esc_url( $img ); ?>')" aria-hidden="true"></div>
	<div class="fba-banner-shade" aria-hidden="true"></div>
	<div class="fba-wrap fba-banner-inner">
		<p class="fba-crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'faithbridgeacademy' ); ?></a> &nbsp;/&nbsp; <?php echo esc_html( $title ); ?></p>
		<h1><?php echo esc_html( $title ); ?></h1>
		<?php if ( $sub ) : ?>
			<p><?php echo esc_html( $sub ); ?></p>
		<?php endif; ?>
	</div>
</section>
