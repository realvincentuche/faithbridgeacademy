<?php
/**
 * About page (slug: about).
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'About FaithBridge Academy', 'faithbridgeacademy' ),
		'sub'   => __( 'Faith, learning and character — built together, on purpose.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/why-1.jpg',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap fba-homefeel-grid">
		<img class="reveal" src="<?php echo esc_url( $uri . '/assets/images/slide-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Children learning in class', 'faithbridgeacademy' ); ?>" loading="lazy">
		<div class="reveal">
			<h2 class="fba-section-title"><?php esc_html_e( 'Who We Are', 'faithbridgeacademy' ); ?></h2>
			<p class="fba-lead"><?php esc_html_e( 'FaithBridge Academy is a live online academy where children grow in faith, knowledge and character — in partnership with their parents.', 'faithbridgeacademy' ); ?></p>
			<p><?php echo esc_html( fba_get_option( 'footer_tagline' ) ); ?></p>
			<ul class="fba-checklist">
				<li><?php esc_html_e( 'Faith-rooted teaching in every lesson', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'Whole-child development — spirit, mind, character', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'Small live classes on Google Meet, with recordings', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'Parents carried along every step', 'faithbridgeacademy' ); ?></li>
			</ul>
		</div>
	</div>
</div>

<div class="fba-content" style="padding-top:0">
	<div class="fba-wrap">
		<div class="fba-section-head reveal">
			<div>
				<h2 class="fba-section-title"><?php esc_html_e( 'How Learning Works', 'faithbridgeacademy' ); ?></h2>
				<p class="fba-section-desc"><?php echo esc_html( fba_current_session()['label'] . ' · ' . fba_current_session()['period'] . ' · ' . fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) . ' (' . fba_get_option( 'timezone' ) . ')' ); ?></p>
			</div>
		</div>
		<ul class="fba-why-list">
			<li class="reveal">
				<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-book-open"></i></span>
				<div>
					<strong><?php esc_html_e( 'Pick programmes', 'faithbridgeacademy' ); ?></strong>
					<span><?php esc_html_e( 'Choose from 16 programmes — Bible Study, languages, sciences and more.', 'faithbridgeacademy' ); ?></span>
				</div>
			</li>
			<li class="reveal">
				<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-users-three"></i></span>
				<div>
					<strong><?php esc_html_e( 'Choose group or one-on-one', 'faithbridgeacademy' ); ?></strong>
					<span><?php esc_html_e( 'Small groups of 15 or fewer, or focused one-on-one support.', 'faithbridgeacademy' ); ?></span>
				</div>
			</li>
			<li class="reveal">
				<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-video-camera"></i></span>
				<div>
					<strong><?php esc_html_e( 'Learn live, revise with recordings', 'faithbridgeacademy' ); ?></strong>
					<span><?php echo esc_html( fba_get_option( 'recordings_note' ) ); ?></span>
				</div>
			</li>
		</ul>
		<p style="margin-top:2rem"><a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
		<a class="fba-btn fba-btn-navy" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Explore Programmes', 'faithbridgeacademy' ); ?></a></p>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
