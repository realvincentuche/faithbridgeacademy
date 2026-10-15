<?php
/**
 * Application form (slug: apply). Multi-step vanilla JS, bank transfer only.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri   = get_template_directory_uri();
$state = isset( $_GET['fba'] ) ? sanitize_key( wp_unslash( $_GET['fba'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- status display.
$ref   = isset( $_GET['ref'] ) ? sanitize_text_field( wp_unslash( $_GET['ref'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- status display.
$pre   = isset( $_GET['prog'] ) ? (int) $_GET['prog'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- preselect only (`prog`, not `programme`: the latter collides with the CPT rewrite and 404s).

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Apply Now', 'faithbridgeacademy' ),
		'sub'   => fba_current_session()['label'] . ' · ' . fba_current_session()['period'],
		'img'   => $uri . '/assets/images/slide-3.jpg',
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
$sessions = fba_open_sessions();

// Logged-in applicant identity comes from the account (name/email/phone
// collected at registration). Guests type them in step 1.
$fba_user        = is_user_logged_in() ? wp_get_current_user() : false;
$fba_acct_name   = $fba_user ? $fba_user->display_name : '';
$fba_acct_email  = $fba_user ? $fba_user->user_email : '';
$fba_acct_phone  = $fba_user ? (string) get_user_meta( $fba_user->ID, 'fba_phone', true ) : '';
if ( '' === $fba_acct_phone && $fba_user ) {
	$fba_acct_phone = (string) get_user_meta( $fba_user->ID, 'billing_phone', true );
}
?>

<div class="fba-content">
	<div class="fba-wrap fba-apply-grid">

		<div class="fba-apply-main">
		<?php if ( 'done' === $state ) : ?>
			<div class="fba-notice fba-notice-ok" role="status">
				<h2><?php esc_html_e( 'Application received.', 'faithbridgeacademy' ); ?></h2>
				<?php $ref_list = array_filter( array_map( 'trim', explode( ',', $ref ) ) ); ?>
				<?php if ( count( $ref_list ) > 1 ) : ?>
				<p><?php echo esc_html( sprintf( __( 'Your references are %s (one per ward). Transfer fees for each ward to %s · %s · %s, then wait for our confirmation on WhatsApp.', 'faithbridgeacademy' ), implode( ', ', $ref_list ), fba_get_option( 'bank_name' ), fba_get_option( 'bank_number' ), fba_get_option( 'bank_bank' ) ) ); ?></p>
				<?php else : ?>
				<p><?php echo esc_html( sprintf( __( 'Your reference is %s. Transfer your fees to %s · %s · %s, then wait for our confirmation on WhatsApp.', 'faithbridgeacademy' ), $ref, fba_get_option( 'bank_name' ), fba_get_option( 'bank_number' ), fba_get_option( 'bank_bank' ) ) ); ?></p>
				<?php endif; ?>
			</div>
		<?php elseif ( 'duplicate' === $state ) : ?>
			<div class="fba-notice" role="status">
				<h2><?php esc_html_e( 'Already applied.', 'faithbridgeacademy' ); ?></h2>
				<p><?php echo esc_html( sprintf( __( 'This ward already has an application for this session (%s). Contact us if anything needs to change.', 'faithbridgeacademy' ), $ref ) ); ?></p>
			</div>
		<?php elseif ( $state ) : ?>
			<div class="fba-notice" role="alert">
				<p><?php esc_html_e( 'Something is missing or invalid — please check the highlighted fields and try again.', 'faithbridgeacademy' ); ?></p>
			</div>
		<?php endif; ?>

<?php if ( is_user_logged_in() ) : ?>
			<?php $fba_current = wp_get_current_user(); ?>
			<div class="fba-notice fba-notice-ok" role="status">
				<p><?php echo esc_html( sprintf( __( 'Applying as %s (%s). Your application links to your learning account automatically.', 'faithbridgeacademy' ), $fba_current->display_name, $fba_current->user_email ) ); ?></p>
			</div>
		<?php else : ?>
			<div class="fba-auth-strip" role="note">
				<p><strong><?php esc_html_e( 'Have an account? Log in first.', 'faithbridgeacademy' ); ?></strong>
				<?php esc_html_e( 'It links your application to your learning dashboard. Guests can still apply below — we create your account when your application is approved.', 'faithbridgeacademy' ); ?></p>
				<p>
					<a class="fba-btn fba-btn-navy fba-btn-sm" href="<?php echo esc_url( add_query_arg( 'next', rawurlencode( fba_apply_url( $pre ) ), trailingslashit( home_url( '/account/' ) ) ) ); ?>"><?php esc_html_e( 'Log in', 'faithbridgeacademy' ); ?></a>
					<a class="fba-btn fba-btn-outline-dark fba-btn-sm" href="<?php echo esc_url( add_query_arg( 'redirect_to', rawurlencode( fba_apply_url( $pre ) ), trailingslashit( home_url( '/account/signup/' ) ) ) ); ?>"><?php esc_html_e( 'Create account', 'faithbridgeacademy' ); ?></a>
				</p>
			</div>
		<?php endif; ?>

		<form class="fba-form reveal" id="fbaApplyForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-fba-rate="<?php echo esc_attr( fba_get_option( 'exchange_rate' ) ); ?>" novalidate>
			<input type="hidden" name="action" value="fba_apply">
			<?php wp_nonce_field( 'fba_apply', 'fba_apply_nonce' ); ?>

			<ol class="fba-steps" aria-label="<?php esc_attr_e( 'Application steps', 'faithbridgeacademy' ); ?>">
				<li class="active" data-step-dot="1"><?php esc_html_e( 'Applicant', 'faithbridgeacademy' ); ?></li>
				<li data-step-dot="2"><?php esc_html_e( 'Ward', 'faithbridgeacademy' ); ?></li>
				<li data-step-dot="3"><?php esc_html_e( 'Programmes', 'faithbridgeacademy' ); ?></li>
				<li data-step-dot="4"><?php esc_html_e( 'Review', 'faithbridgeacademy' ); ?></li>
			</ol>

			<fieldset class="fba-step active" data-step="1">
				<legend><?php esc_html_e( 'Who is applying?', 'faithbridgeacademy' ); ?></legend>
				<label class="fba-radio"><input type="radio" name="fba_kind" value="self" checked> <?php esc_html_e( 'Myself', 'faithbridgeacademy' ); ?></label>
				<label class="fba-radio"><input type="radio" name="fba_kind" value="sponsor"> <?php esc_html_e( 'A sponsor (applying for a ward)', 'faithbridgeacademy' ); ?></label>
				<?php if ( $fba_user ) : ?>
				<p class="fba-acct-line"><?php echo esc_html( sprintf( __( 'Applying as %s · %s · %s', 'faithbridgeacademy' ), $fba_acct_name, $fba_acct_email, $fba_acct_phone ) ); ?>
				<a href="<?php echo esc_url( home_url( '/account/' ) ); ?>"><?php esc_html_e( 'Edit in account', 'faithbridgeacademy' ); ?></a></p>
				<?php else : ?>
				<p><label for="fbaName"><?php esc_html_e( 'Full name', 'faithbridgeacademy' ); ?></label>
				<input id="fbaName" name="fba_name" type="text" autocomplete="name" required></p>
				<p><label for="fbaPhone"><?php esc_html_e( 'Phone / WhatsApp', 'faithbridgeacademy' ); ?></label>
				<input id="fbaPhone" name="fba_phone" type="tel" autocomplete="tel" required></p>
			<p><label for="fbaEmail"><?php esc_html_e( 'Email (for your learning account)', 'faithbridgeacademy' ); ?></label>
			<input id="fbaEmail" name="fba_email" type="email" autocomplete="email" required></p>
				<?php endif; ?>
				<p class="fba-sponsor-only" hidden><label for="fbaRelation"><?php esc_html_e( 'Relationship to ward', 'faithbridgeacademy' ); ?></label>
				<input id="fbaRelation" name="fba_relation" type="text" placeholder="<?php esc_attr_e( 'e.g. Mother, Uncle, Guardian', 'faithbridgeacademy' ); ?>"></p>
				<p class="fba-form-nav"><button class="fba-btn fba-btn-navy" type="button" data-next><?php esc_html_e( 'Continue', 'faithbridgeacademy' ); ?> →</button></p>
			</fieldset>

			<fieldset class="fba-step" data-step="2">
				<legend><?php esc_html_e( 'Wards (add each child)', 'faithbridgeacademy' ); ?></legend>
				<div id="fbaWards">
					<div class="fba-ward" data-ward="0">
						<h3 class="fba-ward-title"><?php esc_html_e( 'Ward 1', 'faithbridgeacademy' ); ?></h3>
						<p><label><?php esc_html_e( "Ward's full name", 'faithbridgeacademy' ); ?>
						<input name="fba_wards[0][name]" type="text" required></label></p>
						<p><label><?php esc_html_e( 'Date of birth', 'faithbridgeacademy' ); ?>
						<input name="fba_wards[0][dob]" type="date" required></label></p>
						<p><label><?php esc_html_e( 'Current class / grade', 'faithbridgeacademy' ); ?>
						<select name="fba_wards[0][class]">
							<?php foreach ( fba_class_optgroups() as $label => $items ) : ?>
								<optgroup label="<?php echo esc_attr( $label ); ?>">
									<?php foreach ( $items as $item ) : ?>
										<option value="<?php echo esc_attr( $item ); ?>"><?php echo esc_html( $item ); ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						</select></label></p>
						<p><button class="fba-btn fba-btn-outline-dark fba-btn-sm fba-ward-remove" type="button" hidden><?php esc_html_e( 'Remove this ward', 'faithbridgeacademy' ); ?></button></p>
					</div>
				</div>
				<p><button class="fba-btn fba-btn-outline-dark fba-btn-sm" type="button" id="fbaWardAdd">+ <?php esc_html_e( 'Add another ward', 'faithbridgeacademy' ); ?></button></p>
				<p class="fba-form-nav"><button class="fba-btn fba-btn-outline-dark" type="button" data-prev>← <?php esc_html_e( 'Back', 'faithbridgeacademy' ); ?></button>
				<button class="fba-btn fba-btn-navy" type="button" data-next><?php esc_html_e( 'Continue', 'faithbridgeacademy' ); ?> →</button></p>
			</fieldset>

			<fieldset class="fba-step" data-step="3">
				<legend><?php esc_html_e( 'Programmes, style & session', 'faithbridgeacademy' ); ?></legend>
				<p><span class="fba-label"><?php esc_html_e( 'Programmes (pick at least one)', 'faithbridgeacademy' ); ?></span></p>
				<div class="fba-check-grid">
					<?php if ( $programmes->have_posts() ) : ?>
						<?php
						while ( $programmes->have_posts() ) :
							$programmes->the_post();
							$pid   = get_the_ID();
							$fees  = fba_programme_fees( $pid );
							$open  = fba_programme_is_open( $pid );
							?>
							<label class="fba-check<?php echo $open ? '' : ' disabled'; ?>">
								<input type="checkbox" name="fba_programmes[]" value="<?php echo esc_attr( (string) $pid ); ?>" data-group="<?php echo esc_attr( (string) $fees['group'] ); ?>" data-one="<?php echo esc_attr( (string) $fees['one'] ); ?>" data-ngn-group="<?php echo esc_attr( (string) fba_usd_to_ngn( $fees['group'] ) ); ?>" data-ngn-one="<?php echo esc_attr( (string) fba_usd_to_ngn( $fees['one'] ) ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>"<?php echo $pre === $pid ? ' checked' : ''; ?><?php echo $open ? '' : ' disabled'; ?>>
								<span><?php the_title(); ?> <small class="fba-check-fee" data-fee-usd="<?php echo esc_attr( '$' . number_format( $fees['group'] ) . ' / $' . number_format( $fees['one'] ) ); ?>" data-fee-ngn="<?php echo esc_attr( '₦' . number_format( fba_usd_to_ngn( $fees['group'] ) ) . ' / ₦' . number_format( fba_usd_to_ngn( $fees['one'] ) ) ); ?>"><?php echo esc_html( '$' . number_format( $fees['group'] ) . ' / $' . number_format( $fees['one'] ) ); ?></small><?php echo $open ? '' : ' · ' . __( 'full', 'faithbridgeacademy' ); ?></span>
							</label>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					<?php endif; ?>
				</div>
				<p><span class="fba-label"><?php esc_html_e( 'Learning style', 'faithbridgeacademy' ); ?></span></p>
				<label class="fba-radio"><input type="radio" name="fba_style" value="group" checked> <?php esc_html_e( 'Group class', 'faithbridgeacademy' ); ?></label>
				<label class="fba-radio"><input type="radio" name="fba_style" value="one"> <?php esc_html_e( 'One-on-one', 'faithbridgeacademy' ); ?></label>
				<p><label for="fbaSession"><?php esc_html_e( 'Session', 'faithbridgeacademy' ); ?></label>
				<select id="fbaSession" name="fba_session">
					<?php foreach ( $sessions as $s ) : ?>
						<option value="<?php echo esc_attr( $s['year'] . 'Q' . $s['quarter'] ); ?>"><?php echo esc_html( fba_session_option_label( $s['year'], $s['quarter'] ) ); ?></option>
					<?php endforeach; ?>
				</select></p>
				<p class="fba-form-nav"><button class="fba-btn fba-btn-outline-dark" type="button" data-prev>← <?php esc_html_e( 'Back', 'faithbridgeacademy' ); ?></button>
				<button class="fba-btn fba-btn-navy" type="button" data-next><?php esc_html_e( 'Review', 'faithbridgeacademy' ); ?> →</button></p>
			</fieldset>

			<fieldset class="fba-step" data-step="4">
				<legend><?php esc_html_e( 'Review & submit', 'faithbridgeacademy' ); ?></legend>
				<div class="fba-review" id="fbaReview"></div>
				<div class="fba-bank-box">
					<strong><?php esc_html_e( 'Pay by bank transfer after submitting', 'faithbridgeacademy' ); ?></strong>
					<span><?php echo esc_html( fba_get_option( 'bank_name' ) . ' · ' . fba_get_option( 'bank_number' ) . ' · ' . fba_get_option( 'bank_bank' ) ); ?></span>
				</div>
				<p class="fba-form-nav"><button class="fba-btn fba-btn-outline-dark" type="button" data-prev>← <?php esc_html_e( 'Back', 'faithbridgeacademy' ); ?></button>
				<button class="fba-btn fba-btn-green" type="submit"><?php esc_html_e( 'Submit application', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></button></p>
			</fieldset>
		</form>

		</div><!-- .fba-apply-main -->

		<aside class="fba-side-card">
			<h3><?php echo esc_html( fba_current_session()['label'] ); ?></h3>
			<p><?php echo esc_html( fba_current_session()['period'] . ' · ' . fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) ); ?></p>
			<?php $min_fees = fba_min_fees(); ?>
			<p class="fba-fee-line"><?php echo esc_html( sprintf( __( 'Fees show per programme as you select them — group from %1$s, one-on-one from %2$s per session.', 'faithbridgeacademy' ), fba_fee_text( $min_fees['group'] ), fba_fee_text( $min_fees['one'] ) ) ); ?></p>
			<p><?php esc_html_e( 'Bank transfer only. No receipt upload — we confirm every application personally.', 'faithbridgeacademy' ); ?></p>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
