<?php
/**
 * Contact page (slug: contact).
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Contact Us', 'faithbridgeacademy' ),
		'sub'   => __( 'We reply fast — usually within a day.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/slide-2.jpg',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap fba-single-grid">
		<div class="fba-prose reveal">
			<h2><?php esc_html_e( 'Talk to us', 'faithbridgeacademy' ); ?></h2>
			<ul class="fba-why-list">
				<li>
					<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-envelope-simple"></i></span>
					<div>
						<strong><?php esc_html_e( 'Email', 'faithbridgeacademy' ); ?></strong>
						<span><a href="mailto:<?php echo esc_attr( fba_get_option( 'email' ) ); ?>"><?php echo esc_html( fba_get_option( 'email' ) ); ?></a></span>
					</div>
				</li>
				<li>
					<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-phone"></i></span>
					<div>
						<strong><?php esc_html_e( 'Phone / WhatsApp', 'faithbridgeacademy' ); ?></strong>
						<span><a href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php echo esc_html( fba_get_option( 'phone' ) ); ?></a></span>
					</div>
				</li>
				<li>
					<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-video-camera"></i></span>
					<div>
						<strong><?php esc_html_e( 'Classes', 'faithbridgeacademy' ); ?></strong>
						<span><?php echo esc_html( fba_get_option( 'format_note' ) . ' · ' . fba_get_option( 'online_note' ) ); ?></span>
					</div>
				</li>
			</ul>
		</div>
		<aside class="reveal">
			<?php
			$sent = isset( $_GET['sent'] ) ? sanitize_key( wp_unslash( $_GET['sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- status display.
			if ( 'done' === $sent ) :
				?>
				<div class="fba-notice fba-notice-ok" role="status">
					<p><?php esc_html_e( 'Message received — we reply fast, usually within a day.', 'faithbridgeacademy' ); ?></p>
				</div>
				<?php
			elseif ( $sent ) :
				?>
				<div class="fba-notice" role="alert">
					<p><?php esc_html_e( 'Please add your name, a message, and a phone number or email.', 'faithbridgeacademy' ); ?></p>
				</div>
				<?php
			endif;
			if ( function_exists( 'wpcf7_contact_form' ) ) {
				$cf7 = get_page_by_title( 'Contact form 1', OBJECT, 'wpcf7_contact_form' );
				if ( ! $cf7 ) {
					$forms = get_posts( array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => 1 ) );
					$cf7   = $forms ? $forms[0] : null;
				}
				if ( $cf7 ) {
					echo do_shortcode( '[contact-form-7 id="' . (int) $cf7->ID . '"]' );
				}
			}
			if ( ! function_exists( 'wpcf7_contact_form' ) ) :
				?>
				<form class="fba-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="fba_enquiry">
					<?php wp_nonce_field( 'fba_enquiry', 'fba_enquiry_nonce' ); ?>
					<fieldset class="fba-step active">
						<legend><?php esc_html_e( 'Send a message', 'faithbridgeacademy' ); ?></legend>
						<p><label for="fbaEnqName"><?php esc_html_e( 'Full name', 'faithbridgeacademy' ); ?></label>
						<input id="fbaEnqName" name="fba_enquiry_name" type="text" autocomplete="name" required></p>
						<p><label for="fbaEnqPhone"><?php esc_html_e( 'Phone / WhatsApp', 'faithbridgeacademy' ); ?></label>
						<input id="fbaEnqPhone" name="fba_enquiry_phone" type="tel" autocomplete="tel"></p>
						<p><label for="fbaEnqEmail"><?php esc_html_e( 'Email', 'faithbridgeacademy' ); ?></label>
						<input id="fbaEnqEmail" name="fba_enquiry_email" type="email" autocomplete="email"></p>
						<p><label for="fbaEnqMsg"><?php esc_html_e( 'Message', 'faithbridgeacademy' ); ?></label>
						<textarea id="fbaEnqMsg" name="fba_enquiry_message" rows="5" required></textarea></p>
						<p><button class="fba-btn fba-btn-green" type="submit"><?php esc_html_e( 'Send message', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></button></p>
					</fieldset>
				</form>
				<?php
			endif;
			?>
			<div class="fba-side-card" style="margin-top:1.5rem">
				<h3><?php esc_html_e( 'Ready when you are', 'faithbridgeacademy' ); ?></h3>
				<p><?php echo esc_html( fba_get_option( 'session_label' ) . ' · ' . fba_get_option( 'session_period' ) ); ?></p>
				<a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
				<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php esc_html_e( 'Chat on WhatsApp', 'faithbridgeacademy' ); ?></a>
			</div>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
