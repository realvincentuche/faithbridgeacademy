<?php
/**
 * Bible Club page (slug: bible-club). Membership form + annual fee.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri   = get_template_directory_uri();
$state = isset( $_GET['club'] ) ? sanitize_key( wp_unslash( $_GET['club'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- status display.
$fee   = fba_club_fee();
$year  = (int) gmdate( 'Y' );

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Bible Club', 'faithbridgeacademy' ),
		'sub'   => sprintf( __( 'Annual membership · %s · meets %s', 'faithbridgeacademy' ), $year, fba_get_option( 'club_rhythm' ) ),
		'img'   => $uri . '/assets/images/slide-6.jpg',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap fba-apply-grid">

		<?php if ( 'done' === $state ) : ?>
			<div class="fba-notice fba-notice-ok reveal" role="status">
				<h2><?php esc_html_e( 'Welcome to the club family.', 'faithbridgeacademy' ); ?></h2>
				<p><?php echo esc_html( fba_get_option( 'club_welcome' ) ); ?></p>
			</div>
		<?php elseif ( $state ) : ?>
			<div class="fba-notice reveal" role="alert">
				<p><?php esc_html_e( 'Please add your name and phone number, then try again.', 'faithbridgeacademy' ); ?></p>
			</div>
		<?php endif; ?>

		<form class="fba-form reveal" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="fba_club">
			<?php wp_nonce_field( 'fba_club', 'fba_club_nonce' ); ?>
			<fieldset class="fba-step active">
				<legend><?php esc_html_e( 'Join the Bible Club', 'faithbridgeacademy' ); ?></legend>
				<p class="fba-fee-line"><?php esc_html_e( 'Annual fee', 'faithbridgeacademy' ); ?>: <?php echo fba_fee_label( $fee['usd'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> · <?php echo esc_html( (string) $year ); ?></p>
				<p><label for="fbaClubName"><?php esc_html_e( 'Full name', 'faithbridgeacademy' ); ?></label>
				<input id="fbaClubName" name="fba_club_name" type="text" autocomplete="name" required></p>
				<p><label for="fbaClubPhone"><?php esc_html_e( 'Phone / WhatsApp', 'faithbridgeacademy' ); ?></label>
				<input id="fbaClubPhone" name="fba_club_phone" type="tel" autocomplete="tel" required></p>
				<p><label for="fbaClubEmail"><?php esc_html_e( 'Email (optional)', 'faithbridgeacademy' ); ?></label>
				<input id="fbaClubEmail" name="fba_club_email" type="email" autocomplete="email"></p>
				<p><button class="fba-btn fba-btn-green" type="submit"><?php esc_html_e( 'Join the club', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></button></p>
			</fieldset>
		</form>

		<aside class="fba-side-card">
			<h3><?php esc_html_e( 'How membership works', 'faithbridgeacademy' ); ?></h3>
			<p><?php echo esc_html( sprintf( __( 'One payment covers January to December %d. The club meets %s.', 'faithbridgeacademy' ), $year, fba_get_option( 'club_rhythm' ) ) ); ?></p>
			<p class="fba-fee-line"><?php echo fba_fee_label( $fee['usd'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<div class="fba-bank-box">
				<strong><?php esc_html_e( 'Pay by bank transfer', 'faithbridgeacademy' ); ?></strong>
				<span><?php echo esc_html( fba_get_option( 'bank_name' ) . ' · ' . fba_get_option( 'bank_number' ) . ' · ' . fba_get_option( 'bank_bank' ) ); ?></span>
			</div>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
