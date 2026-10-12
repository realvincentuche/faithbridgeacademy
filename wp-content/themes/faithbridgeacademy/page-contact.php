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
		<aside class="fba-side-card reveal">
			<h3><?php esc_html_e( 'Ready when you are', 'faithbridgeacademy' ); ?></h3>
			<p><?php echo esc_html( fba_get_option( 'session_label' ) . ' · ' . fba_get_option( 'session_period' ) ); ?></p>
			<a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
			<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php esc_html_e( 'Chat on WhatsApp', 'faithbridgeacademy' ); ?></a>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
