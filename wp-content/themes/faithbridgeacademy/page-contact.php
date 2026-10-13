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
						<span><?php echo esc_html( sprintf( __( 'Live online via %s', 'faithbridgeacademy' ), fba_platform_name() ) . ' · ' . fba_get_option( 'online_note' ) ); ?></span>
					</div>
				</li>
			</ul>
		</div>
		<aside class="reveal">
			<?php
			if ( function_exists( 'wpcf7_contact_form' ) ) {
				$cf7 = get_page_by_title( 'Contact form 1', OBJECT, 'wpcf7_contact_form' );
				if ( ! $cf7 ) {
					$forms = get_posts( array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => 1 ) );
					$cf7   = $forms ? $forms[0] : null;
				}
				if ( $cf7 ) {
					echo do_shortcode( '[contact-form-7 id="' . (int) $cf7->ID . '"]' );
				} else {
					?>
					<div class="fba-notice" role="status">
						<p><?php esc_html_e( 'The contact form is being set up — please reach us by email, phone or WhatsApp for now.', 'faithbridgeacademy' ); ?></p>
					</div>
					<?php
				}
			} else {
				?>
				<div class="fba-notice" role="status">
					<p><?php esc_html_e( 'Prefer email or WhatsApp? Our details are on this page — the contact form appears here once Contact Form 7 is installed.', 'faithbridgeacademy' ); ?></p>
				</div>
				<?php
			}
			?>
			<div class="fba-side-card" style="margin-top:1.5rem">
				<h3><?php esc_html_e( 'Ready when you are', 'faithbridgeacademy' ); ?></h3>
				<p><?php echo esc_html( fba_current_session()['label'] . ' · ' . fba_current_session()['period'] ); ?></p>
				<a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
				<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php esc_html_e( 'Chat on WhatsApp', 'faithbridgeacademy' ); ?></a>
			</div>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
