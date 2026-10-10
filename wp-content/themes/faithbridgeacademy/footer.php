<?php
/**
 * Footer template.
 *
 * @package FaithBridgeAcademy
 */

$testimonials = get_posts(
	array(
		'post_type'      => 'testimonial',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
	)
);
?>

</main>

<?php if ( ! empty( $testimonials ) && is_front_page() ) : ?>
<section class="fba-section fba-voices" aria-label="<?php esc_attr_e( 'Success stories', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap">
		<div class="fba-section-head reveal">
			<h2><?php esc_html_e( 'Families Growing With FaithBridge', 'faithbridgeacademy' ); ?></h2>
		</div>
		<div class="fba-voices-grid">
			<?php foreach ( $testimonials as $i => $t ) : ?>
			<figure class="fba-quote-card<?php echo 1 === $i ? ' fba-quote-featured' : ''; ?> reveal">
				<span class="fba-quote-mark" aria-hidden="true">&ldquo;</span>
				<blockquote><?php echo esc_html( get_the_excerpt( $t ) ? get_the_excerpt( $t ) : wp_trim_words( $t->post_content, 32 ) ); ?></blockquote>
				<figcaption>&mdash; <?php echo esc_html( $t->post_title ); ?></figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="fba-footer-cta" aria-label="<?php esc_attr_e( 'Call to action', 'faithbridgeacademy' ); ?>" style="background-image:url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-2.jpg' ); ?>')">
	<div class="fba-footer-cta-overlay" aria-hidden="true"></div>
	<div class="fba-wrap fba-footer-cta-inner reveal">
		<div class="fba-footer-cta-copy">
			<h2><?php esc_html_e( 'Give Your Child a Stronger Foundation.', 'faithbridgeacademy' ); ?></h2>
			<p><?php esc_html_e( 'Faith, values, knowledge and character are built over time. Start intentionally — applications take minutes.', 'faithbridgeacademy' ); ?></p>
			<p class="fba-cta-actions">
				<a class="fba-btn fba-btn-green" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
				<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Explore Programmes', 'faithbridgeacademy' ); ?></a>
			</p>
		</div>
		<aside class="fba-cta-session">
			<p class="fba-cta-session-label"><i class="ph ph-calendar-check" aria-hidden="true"></i> <?php esc_html_e( 'Now enrolling', 'faithbridgeacademy' ); ?></p>
			<p class="fba-cta-session-title"><?php echo esc_html( fba_get_option( 'session_label' ) ); ?></p>
			<p class="fba-cta-session-period"><?php echo esc_html( fba_get_option( 'session_period' ) ); ?></p>
			<p class="fba-cta-session-days"><?php echo esc_html( fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) ); ?></p>
		</aside>
	</div>
</section>

<footer class="fba-footer">
	<div class="fba-wrap fba-footer-grid">
		<div class="fba-footer-col fba-footer-brand">
			<a class="fba-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-white.png' ); ?>" alt="<?php esc_attr_e( 'FaithBridge Academy', 'faithbridgeacademy' ); ?>">
			</a>
			<p><?php echo esc_html( fba_get_option( 'footer_tagline' ) ); ?></p>
			<ul class="fba-socials" aria-label="<?php esc_attr_e( 'Social media', 'faithbridgeacademy' ); ?>">
				<li><a href="<?php echo esc_url( fba_get_option( 'social_instagram' ) ); ?>" aria-label="Instagram"><i class="ph ph-instagram-logo" aria-hidden="true"></i></a></li>
				<li><a href="<?php echo esc_url( fba_get_option( 'social_facebook' ) ); ?>" aria-label="Facebook"><i class="ph ph-facebook-logo" aria-hidden="true"></i></a></li>
				<li><a href="<?php echo esc_url( fba_get_option( 'social_youtube' ) ); ?>" aria-label="YouTube"><i class="ph ph-play-circle" aria-hidden="true"></i></a></li>
				<li><a href="<?php echo esc_url( fba_get_option( 'social_linkedin' ) ); ?>" aria-label="LinkedIn"><i class="ph ph-linkedin-logo" aria-hidden="true"></i></a></li>
				<li><a href="<?php echo esc_url( fba_get_option( 'social_x' ) ); ?>" aria-label="X"><i class="ph ph-globe" aria-hidden="true"></i></a></li>
				<li><a href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>" aria-label="WhatsApp"><i class="ph ph-phone" aria-hidden="true"></i></a></li>
			</ul>
		</div>
		<div class="fba-footer-col">
			<h3><?php esc_html_e( 'Explore', 'faithbridgeacademy' ); ?></h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Programmes', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Admissions', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'faithbridgeacademy' ); ?></a></li>
			</ul>
		</div>
		<div class="fba-footer-col">
			<h3><?php esc_html_e( 'Resources', 'faithbridgeacademy' ); ?></h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/bible-club/' ) ); ?>"><?php esc_html_e( 'Bible Club', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/fees/' ) ); ?>"><?php esc_html_e( 'Fees', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'FAQs', 'faithbridgeacademy' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/resources/' ) ); ?>"><?php esc_html_e( 'Learning Resources', 'faithbridgeacademy' ); ?></a></li>
			</ul>
		</div>
		<div class="fba-footer-col">
			<h3><?php esc_html_e( 'Contact Us', 'faithbridgeacademy' ); ?></h3>
			<ul class="fba-footer-contact">
				<li><a href="mailto:<?php echo esc_attr( fba_get_option( 'email' ) ); ?>"><?php echo esc_html( fba_get_option( 'email' ) ); ?></a></li>
				<li><a href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php echo esc_html( fba_get_option( 'phone' ) ); ?></a></li>
				<li><span><?php echo esc_html( fba_get_option( 'format_note' ) ); ?></span></li>
				<li><span><?php echo esc_html( fba_get_option( 'online_note' ) ); ?></span></li>
			</ul>
		</div>
	</div>
	<div class="fba-wrap"><p class="fba-footer-giant" aria-hidden="true">FAITHBRIDGE ACADEMY</p></div>
	<div class="fba-footer-bottom">
		<div class="fba-wrap fba-footer-bottom-inner">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'FaithBridge Academy. All rights reserved.', 'faithbridgeacademy' ); ?></p>
			<nav aria-label="<?php esc_attr_e( 'Footer', 'faithbridgeacademy' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => 'fba_footer_fallback',
					)
				);
				?>
			</nav>
			<p class="fba-powered"><?php esc_html_e( 'powered with love', 'faithbridgeacademy' ); ?> <i class="ph ph-heart" aria-hidden="true"></i> <?php esc_html_e( 'by', 'faithbridgeacademy' ); ?> <a href="https://octravo.com" target="_blank" rel="noopener">octravo</a></p>
		</div>
	</div>
</footer>

<a class="fba-mobile-cta" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>

<button class="fba-totop" id="fbaToTop" aria-label="<?php esc_attr_e( 'Back to top', 'faithbridgeacademy' ); ?>"><i class="ph ph-arrow-up" aria-hidden="true"></i></button>

<?php wp_footer(); ?>
</body>
</html>
