<?php
/**
 * Partner page (slug: partner). Standalone sponsorship flow —
 * separate from student registration. Bank transfer only.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri   = get_template_directory_uri();
$state = isset( $_GET['sp'] ) ? sanitize_key( wp_unslash( $_GET['sp'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- status display.
$ref   = isset( $_GET['ref'] ) ? sanitize_text_field( wp_unslash( $_GET['ref'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- status display.
$rates = fba_sponsor_rates();
$cats  = fba_sponsor_categories();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Partner With FaithBridge Academy — Sponsor a Child, Support a Future.', 'faithbridgeacademy' ),
		'sub'   => __( 'No child to register? You can still raise one.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/slide-4.jpg',
	)
);

$programmes = new WP_Query(
	array(
		'post_type'      => 'programme',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap">

		<?php if ( 'done' === $state ) : ?>
			<div class="fba-notice fba-notice-ok reveal" role="status">
				<h2><?php esc_html_e( 'Thank you — your pledge is recorded.', 'faithbridgeacademy' ); ?></h2>
				<p><?php echo esc_html( sprintf( __( 'Your reference is %s. Please transfer your gift to %s · %s · %s, then message us on WhatsApp so we can confirm it personally.', 'faithbridgeacademy' ), $ref, fba_get_option( 'bank_name' ), fba_get_option( 'bank_number' ), fba_get_option( 'bank_bank' ) ) ); ?></p>
			</div>
		<?php elseif ( $state ) : ?>
			<div class="fba-notice reveal" role="alert">
				<p><?php esc_html_e( 'Something is missing or below the minimum — please check the form and try again.', 'faithbridgeacademy' ); ?></p>
			</div>
		<?php endif; ?>

		<div class="fba-prose reveal">
			<h2><?php esc_html_e( 'Where your gift goes', 'faithbridgeacademy' ); ?></h2>
			<p><?php esc_html_e( 'Every naira is tied to a child or a classroom — never overhead first. Sponsorship fees pay facilitators, learning materials and class recordings for the sponsored children; general gifts fund learning resources, programme development and the faith-based initiatives that keep the academy growing.', 'faithbridgeacademy' ); ?></p>
		</div>

		<div class="fba-sp-cards">
			<article class="fba-sp-card reveal">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-book-open-text"></i></span>
				<h3><?php echo esc_html( $cats['bible'] ); ?></h3>
				<p><?php esc_html_e( 'Cover fees for a child whose family cannot afford them — Scripture, memory verses, character lessons and spiritual growth.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-fee-line"><?php echo esc_html( sprintf( __( '₦%1$s per child per session (3 months) · ₦%2$s per child per year (4 sessions)', 'faithbridgeacademy' ), number_format( $rates['bible_session'] ), number_format( $rates['bible_year'] ) ) ); ?></p>
			</article>
			<article class="fba-sp-card reveal">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-graduation-cap"></i></span>
				<h3><?php echo esc_html( $cats['academic'] ); ?></h3>
				<p><?php esc_html_e( 'Fund tutoring for a child who needs financial help — pick a programme or let us place your gift where most needed.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-fee-line"><?php echo esc_html( sprintf( __( '₦%1$s per child per session (3 months) · ₦%2$s per child per year (4 sessions)', 'faithbridgeacademy' ), number_format( $rates['academic_session'] ), number_format( $rates['academic_year'] ) ) ); ?></p>
			</article>
			<article class="fba-sp-card reveal">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-heart"></i></span>
				<h3><?php echo esc_html( $cats['general'] ); ?></h3>
				<p><?php esc_html_e( 'For individuals, churches and organisations: back learning resources, programme development and faith-based initiatives.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-fee-line"><?php echo esc_html( sprintf( __( 'Any amount from ₦%s', 'faithbridgeacademy' ), number_format( $rates['general_min'] ) ) ); ?></p>
			</article>
		</div>

		<div class="fba-apply-grid">
			<form class="fba-form reveal" id="fbaSponsorForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate
				data-bible-session="<?php echo esc_attr( (string) $rates['bible_session'] ); ?>"
				data-bible-year="<?php echo esc_attr( (string) $rates['bible_year'] ); ?>"
				data-academic-session="<?php echo esc_attr( (string) $rates['academic_session'] ); ?>"
				data-academic-year="<?php echo esc_attr( (string) $rates['academic_year'] ); ?>"
				data-general-min="<?php echo esc_attr( (string) $rates['general_min'] ); ?>">
				<input type="hidden" name="action" value="fba_sponsor">
				<?php wp_nonce_field( 'fba_sponsor', 'fba_sponsor_nonce' ); ?>

				<fieldset class="fba-step active">
					<legend><?php esc_html_e( 'Your details', 'faithbridgeacademy' ); ?></legend>
					<p><label for="fbaSpName"><?php esc_html_e( 'Full name', 'faithbridgeacademy' ); ?></label>
					<input id="fbaSpName" name="fba_sp_name" type="text" autocomplete="name" required></p>
					<p><label for="fbaSpPhone"><?php esc_html_e( 'Phone / WhatsApp', 'faithbridgeacademy' ); ?></label>
					<input id="fbaSpPhone" name="fba_sp_phone" type="tel" autocomplete="tel" required></p>
					<p><label for="fbaSpEmail"><?php esc_html_e( 'Email', 'faithbridgeacademy' ); ?></label>
					<input id="fbaSpEmail" name="fba_sp_email" type="email" autocomplete="email" required></p>
				</fieldset>

				<fieldset class="fba-step active">
					<legend><?php esc_html_e( 'Your gift', 'faithbridgeacademy' ); ?></legend>
					<p><span class="fba-label"><?php esc_html_e( 'Sponsorship category', 'faithbridgeacademy' ); ?></span></p>
					<label class="fba-radio"><input type="radio" name="fba_sp_category" value="bible" checked> <?php echo esc_html( $cats['bible'] ); ?></label>
					<label class="fba-radio"><input type="radio" name="fba_sp_category" value="academic"> <?php echo esc_html( $cats['academic'] ); ?></label>
					<label class="fba-radio"><input type="radio" name="fba_sp_category" value="general"> <?php echo esc_html( $cats['general'] ); ?></label>

					<div class="fba-sp-plan">
						<p><span class="fba-label"><?php esc_html_e( 'Duration', 'faithbridgeacademy' ); ?></span></p>
						<label class="fba-radio"><input type="radio" name="fba_sp_duration" value="session" checked> <?php esc_html_e( 'One session (3 months)', 'faithbridgeacademy' ); ?></label>
						<label class="fba-radio"><input type="radio" name="fba_sp_duration" value="year"> <?php esc_html_e( 'One full year (4 sessions)', 'faithbridgeacademy' ); ?></label>
						<p><label for="fbaSpChildren"><?php esc_html_e( 'Number of children', 'faithbridgeacademy' ); ?></label>
						<select id="fbaSpChildren" name="fba_sp_children">
							<?php for ( $i = 1; $i <= 20; $i++ ) : ?>
								<option value="<?php echo esc_attr( (string) $i ); ?>"><?php echo esc_html( sprintf( _n( '%d child', '%d children', $i, 'faithbridgeacademy' ), $i ) ); ?></option>
							<?php endfor; ?>
						</select></p>
						<p class="fba-sp-academic-only"><label for="fbaSpProgramme"><?php esc_html_e( 'Designate to a programme (academic only)', 'faithbridgeacademy' ); ?></label>
						<select id="fbaSpProgramme" name="fba_sp_programme">
							<option value="needed"><?php esc_html_e( 'Where most needed', 'faithbridgeacademy' ); ?></option>
							<?php if ( $programmes->have_posts() ) : ?>
								<?php
								while ( $programmes->have_posts() ) :
									$programmes->the_post();
									?>
									<option value="<?php echo esc_attr( (string) get_the_ID() ); ?>"><?php the_title(); ?></option>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							<?php endif; ?>
						</select></p>
					</div>

					<div class="fba-sp-general" hidden>
						<p><label for="fbaSpAmount"><?php echo esc_html( sprintf( __( 'Amount in naira (minimum ₦%s)', 'faithbridgeacademy' ), number_format( $rates['general_min'] ) ) ); ?></label>
						<input id="fbaSpAmount" name="fba_sp_amount" type="number" min="<?php echo esc_attr( (string) $rates['general_min'] ); ?>" step="1000" placeholder="<?php echo esc_attr( (string) $rates['general_min'] ); ?>"></p>
					</div>

					<div class="fba-sp-total" role="status" aria-live="polite">
						<span><?php esc_html_e( 'Total payable', 'faithbridgeacademy' ); ?></span>
						<strong id="fbaSpTotal">₦<?php echo esc_html( number_format( $rates['bible_session'] ) ); ?></strong>
					</div>

					<div class="fba-bank-box">
						<strong><?php esc_html_e( 'Pay by bank transfer after submitting', 'faithbridgeacademy' ); ?></strong>
						<span><?php echo esc_html( fba_get_option( 'bank_name' ) . ' · ' . fba_get_option( 'bank_number' ) . ' · ' . fba_get_option( 'bank_bank' ) ); ?></span>
					</div>
					<p class="fba-form-nav"><button class="fba-btn fba-btn-green" type="submit"><?php esc_html_e( 'Pledge this gift', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></button></p>
				</fieldset>
			</form>

			<aside class="fba-side-card">
				<h3><?php esc_html_e( 'Sponsorship enquiries', 'faithbridgeacademy' ); ?></h3>
				<p><a href="mailto:<?php echo esc_attr( fba_get_option( 'email' ) ); ?>"><?php echo esc_html( fba_get_option( 'email' ) ); ?></a><br>
				<a href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php echo esc_html( fba_get_option( 'phone' ) ); ?></a></p>
				<p><?php esc_html_e( 'Share this page directly: friends, churches and organisations can sponsor without registering any child.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-fee-line"><?php echo esc_url( home_url( '/partner/' ) ); ?></p>
				<div class="fba-bank-box">
					<strong><?php esc_html_e( 'Bank transfer only', 'faithbridgeacademy' ); ?></strong>
					<span><?php echo esc_html( fba_get_option( 'bank_name' ) . ' · ' . fba_get_option( 'bank_number' ) . ' · ' . fba_get_option( 'bank_bank' ) ); ?></span>
				</div>
			</aside>
		</div>

	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
