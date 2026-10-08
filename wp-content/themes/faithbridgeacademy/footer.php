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
			<p class="fba-kicker"><?php esc_html_e( 'Success stories', 'faithbridgeacademy' ); ?></p>
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

<section class="fba-newsletter" aria-label="<?php esc_attr_e( 'Newsletter', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap fba-newsletter-inner reveal">
		<div class="fba-newsletter-copy">
			<p class="fba-kicker fba-kicker-light"><?php esc_html_e( 'Newsletter', 'faithbridgeacademy' ); ?></p>
			<h2><?php esc_html_e( 'Stay ', 'faithbridgeacademy' ); ?><em><?php esc_html_e( 'Connected', 'faithbridgeacademy' ); ?></em></h2>
			<p><?php esc_html_e( 'Session openings, memory verses, parenting wisdom and academy stories — once a month, no noise.', 'faithbridgeacademy' ); ?></p>
		</div>
		<?php if ( isset( $_GET['subscribed'] ) && 'done' === $_GET['subscribed'] ) : ?>
			<p class="fba-newsletter-done" role="status"><?php esc_html_e( 'Thank you — you are subscribed.', 'faithbridgeacademy' ); ?></p>
		<?php else : ?>
		<form class="fba-newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="fba_subscribe">
			<?php wp_nonce_field( 'fba_subscribe', 'fba_subscribe_nonce' ); ?>
			<label class="fba-sr-only" for="fbaNewsletterEmail"><?php esc_html_e( 'Email address', 'faithbridgeacademy' ); ?></label>
			<input id="fbaNewsletterEmail" type="email" name="fba_email" placeholder="<?php esc_attr_e( 'Enter your email', 'faithbridgeacademy' ); ?>" required>
			<button class="fba-btn fba-btn-gold" type="submit"><?php esc_html_e( 'Subscribe', 'faithbridgeacademy' ); ?></button>
		</form>
		<?php endif; ?>
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
	<div class="fba-wrap"><p class="fba-footer-giant" aria-hidden="true">faithbridge</p></div>
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
		</div>
	</div>
</footer>

<a class="fba-mobile-cta" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>

<button class="fba-totop" id="fbaToTop" aria-label="<?php esc_attr_e( 'Back to top', 'faithbridgeacademy' ); ?>"><i class="ph ph-arrow-up" aria-hidden="true"></i></button>

<?php wp_footer(); ?>
</body>
</html>
