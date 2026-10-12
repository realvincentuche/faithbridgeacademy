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
$pre   = isset( $_GET['programme'] ) ? (int) $_GET['programme'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- preselect only.

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Apply Now', 'faithbridgeacademy' ),
		'sub'   => fba_get_option( 'session_label' ) . ' · ' . fba_get_option( 'session_period' ),
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
?>

<div class="fba-content">
	<div class="fba-wrap fba-apply-grid">

		<?php if ( 'done' === $state ) : ?>
			<div class="fba-notice fba-notice-ok reveal" role="status">
				<h2><?php esc_html_e( 'Application received.', 'faithbridgeacademy' ); ?></h2>
				<p><?php echo esc_html( sprintf( __( 'Your reference is %s. Transfer your fees to %s · %s · %s, then wait for our confirmation on WhatsApp.', 'faithbridgeacademy' ), $ref, fba_get_option( 'bank_name' ), fba_get_option( 'bank_number' ), fba_get_option( 'bank_bank' ) ) ); ?></p>
			</div>
		<?php elseif ( 'duplicate' === $state ) : ?>
			<div class="fba-notice reveal" role="status">
				<h2><?php esc_html_e( 'Already applied.', 'faithbridgeacademy' ); ?></h2>
				<p><?php echo esc_html( sprintf( __( 'This ward already has an application for this session (%s). Contact us if anything needs to change.', 'faithbridgeacademy' ), $ref ) ); ?></p>
			</div>
		<?php elseif ( $state ) : ?>
			<div class="fba-notice reveal" role="alert">
				<p><?php esc_html_e( 'Something is missing or invalid — please check the highlighted fields and try again.', 'faithbridgeacademy' ); ?></p>
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
				<p><label for="fbaName"><?php esc_html_e( 'Full name', 'faithbridgeacademy' ); ?></label>
				<input id="fbaName" name="fba_name" type="text" autocomplete="name" required></p>
				<p><label for="fbaPhone"><?php esc_html_e( 'Phone / WhatsApp', 'faithbridgeacademy' ); ?></label>
				<input id="fbaPhone" name="fba_phone" type="tel" autocomplete="tel" required></p>
				<p><label for="fbaEmail"><?php esc_html_e( 'Email (optional)', 'faithbridgeacademy' ); ?></label>
				<input id="fbaEmail" name="fba_email" type="email" autocomplete="email"></p>
				<p class="fba-sponsor-only" hidden><label for="fbaRelation"><?php esc_html_e( 'Relationship to ward', 'faithbridgeacademy' ); ?></label>
				<input id="fbaRelation" name="fba_relation" type="text" placeholder="<?php esc_attr_e( 'e.g. Mother, Uncle, Guardian', 'faithbridgeacademy' ); ?>"></p>
				<p class="fba-form-nav"><button class="fba-btn fba-btn-navy" type="button" data-next><?php esc_html_e( 'Continue', 'faithbridgeacademy' ); ?> →</button></p>
			</fieldset>

			<fieldset class="fba-step" data-step="2">
				<legend><?php esc_html_e( 'Ward details', 'faithbridgeacademy' ); ?></legend>
				<p><label for="fbaWardName"><?php esc_html_e( "Ward's full name", 'faithbridgeacademy' ); ?></label>
				<input id="fbaWardName" name="fba_ward_name" type="text" required></p>
				<p><label for="fbaWardDob"><?php esc_html_e( 'Date of birth', 'faithbridgeacademy' ); ?></label>
				<input id="fbaWardDob" name="fba_ward_dob" type="date" required></p>
				<p><label for="fbaWardClass"><?php esc_html_e( 'Current class / grade', 'faithbridgeacademy' ); ?></label>
				<select id="fbaWardClass" name="fba_ward_class">
					<?php foreach ( fba_class_optgroups() as $label => $items ) : ?>
						<optgroup label="<?php echo esc_attr( $label ); ?>">
							<?php foreach ( $items as $item ) : ?>
								<option value="<?php echo esc_attr( $item ); ?>"><?php echo esc_html( $item ); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select></p>
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

		<aside class="fba-side-card">
			<h3><?php echo esc_html( fba_get_option( 'session_label' ) ); ?></h3>
			<p><?php echo esc_html( fba_get_option( 'session_period' ) . ' · ' . fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) ); ?></p>
			<p class="fba-fee-line"><?php esc_html_e( 'Group', 'faithbridgeacademy' ); ?>: <?php echo fba_fee_label( (float) fba_get_option( 'fee_group' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> · <?php esc_html_e( 'One-on-one', 'faithbridgeacademy' ); ?>: <?php echo fba_fee_label( (float) fba_get_option( 'fee_one_to_one' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<p><?php esc_html_e( 'Bank transfer only. No receipt upload — we confirm every application personally.', 'faithbridgeacademy' ); ?></p>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
