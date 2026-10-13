<?php
/**
 * Single programme: fees, seats, books, apply CTA, LMS link when present.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

while ( have_posts() ) :
	the_post();
	$pid     = get_the_ID();
	$fees    = fba_programme_fees( $pid );
	$seats   = fba_seats_left( $pid );
	$open    = fba_programme_is_open( $pid );
	$status  = fba_programme_status( $pid );
	$session = fba_current_session();
	$books   = array_filter( array_map( 'trim', explode( "\n", (string) get_post_meta( $pid, '_fba_books', true ) ) ) );
	$course  = fba_programme_course_url( $pid );

	$cover = get_post_meta( $pid, '_fba_cover_id', true ) ? wp_get_attachment_image_url( (int) get_post_meta( $pid, '_fba_cover_id', true ), 'full' ) : false;
	if ( ! $cover && has_post_thumbnail() ) {
		$cover = get_the_post_thumbnail_url( $pid, 'full' );
	}
	get_template_part(
		'template-parts/page',
		'banner',
		array(
			'title' => get_the_title(),
			'sub'   => $session['label'] . ' · ' . $session['period'],
			'img'   => $cover ? $cover : $uri . '/assets/images/slide-5.jpg',
			'tint'  => 'green',
		)
	);
	?>
	<div class="fba-content">
		<div class="fba-wrap fba-single-grid">
			<article class="fba-prose">
				<p class="fba-lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php if ( $open ) : ?>
					<p class="fba-cat-seats"><?php echo esc_html( sprintf( __( '%1$d of %2$d group seats left for %3$s', 'faithbridgeacademy' ), $seats, (int) fba_get_option( 'group_capacity' ), $session['label'] ) ); ?></p>
				<?php elseif ( 'coming' === $status ) : ?>
					<p class="fba-cat-status"><?php esc_html_e( 'Enrolment opens soon for this programme.', 'faithbridgeacademy' ); ?></p>
				<?php else : ?>
					<p class="fba-cat-status closed"><?php esc_html_e( 'The group class is full for this session. One-on-one places may still be available — talk to us.', 'faithbridgeacademy' ); ?></p>
				<?php endif; ?>

				<h2><?php esc_html_e( 'Fees for this session', 'faithbridgeacademy' ); ?></h2>
				<table class="fba-fee-table">
					<tr>
						<th><?php esc_html_e( 'Learning style', 'faithbridgeacademy' ); ?></th>
						<th><?php esc_html_e( 'Fee per session', 'faithbridgeacademy' ); ?></th>
					</tr>
					<tr>
						<td><?php echo esc_html( sprintf( __( 'Group class (%d learners or fewer)', 'faithbridgeacademy' ), (int) fba_get_option( 'group_capacity' ) ) ); ?></td>
						<td><?php echo fba_fee_label( $fees['group'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'One-on-one', 'faithbridgeacademy' ); ?></td>
						<td><?php echo fba_fee_label( $fees['one'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
					</tr>
				</table>
				<p><small><?php echo esc_html( fba_get_option( 'fee_note' ) ); ?></small></p>

				<?php
				$body = trim( get_the_content() );
				$lead = trim( get_the_excerpt() );
				if ( '' !== $body && $body !== $lead && wp_strip_all_tags( $body ) !== wp_strip_all_tags( $lead ) ) {
					the_content();
				}
				?>

				<?php if ( $books ) : ?>
					<h2><?php esc_html_e( 'Recommended books', 'faithbridgeacademy' ); ?></h2>
					<ul class="fba-book-list">
						<?php foreach ( $books as $b ) : ?>
							<li><?php echo esc_html( $b ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $course ) : ?>
					<p><a class="fba-btn fba-btn-navy" href="<?php echo esc_url( $course ); ?>"><?php esc_html_e( 'Open online course', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></p>
				<?php endif; ?>
			</article>

			<aside class="fba-side-card">
				<h3><?php esc_html_e( 'Apply for this programme', 'faithbridgeacademy' ); ?></h3>
				<p class="fba-fee-line"><?php esc_html_e( 'Group', 'faithbridgeacademy' ); ?>: <?php echo fba_fee_label( $fees['group'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<p class="fba-fee-line"><?php esc_html_e( 'One-on-one', 'faithbridgeacademy' ); ?>: <?php echo fba_fee_label( $fees['one'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<p><?php echo esc_html( $session['label'] . ' · ' . $session['period'] . ' · ' . fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) ); ?></p>
				<?php if ( $open ) : ?>
					<a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url( $pid ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
				<?php else : ?>
					<a class="fba-btn fba-btn-green" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Join the waitlist', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
				<?php endif; ?>
				<div class="fba-bank-box">
					<strong><?php esc_html_e( 'Pay by bank transfer', 'faithbridgeacademy' ); ?></strong>
					<span><?php echo esc_html( fba_get_option( 'bank_name' ) . ' · ' . fba_get_option( 'bank_number' ) . ' · ' . fba_get_option( 'bank_bank' ) ); ?></span>
				</div>
			</aside>
		</div>
	</div>
	<?php
endwhile;

// No dynamic-content include: the programme body already printed above inside
// the loop. Including it here would re-loop a consumed query (silent no-op).

get_footer();
