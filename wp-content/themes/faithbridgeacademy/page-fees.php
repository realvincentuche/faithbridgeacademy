<?php
/**
 * Fees page: session table for every programme + bank details.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri     = get_template_directory_uri();
$session = fba_current_session();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Fees & Sessions', 'faithbridgeacademy' ),
		'sub'   => $session['label'] . ' · ' . $session['period'],
		'img'   => $uri . '/assets/images/slide-3.jpg',
	)
);

$loop = new WP_Query(
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
		<p class="fba-lead"><?php echo esc_html( fba_get_option( 'fee_note' ) ); ?></p>
		<table class="fba-fee-table">
			<tr>
				<th><?php esc_html_e( 'Programme', 'faithbridgeacademy' ); ?></th>
				<th><?php esc_html_e( 'Group', 'faithbridgeacademy' ); ?></th>
				<th><?php esc_html_e( 'One-on-one', 'faithbridgeacademy' ); ?></th>
				<th><?php esc_html_e( 'Seats left', 'faithbridgeacademy' ); ?></th>
			</tr>
			<?php if ( $loop->have_posts() ) : ?>
				<?php
				while ( $loop->have_posts() ) :
					$loop->the_post();
					$pid   = get_the_ID();
					$fees  = fba_programme_fees( $pid );
					$open  = fba_programme_is_open( $pid );
					$seats = fba_seats_left( $pid );
					?>
					<tr>
						<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
						<td><?php echo esc_html( fba_fee_label( $fees['group'] ) ); ?></td>
						<td><?php echo esc_html( fba_fee_label( $fees['one'] ) ); ?></td>
						<td><?php echo $open ? esc_html( (string) $seats ) : esc_html__( 'Full', 'faithbridgeacademy' ); ?></td>
					</tr>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			<?php endif; ?>
		</table>

		<div class="fba-bank-box">
			<strong><?php esc_html_e( 'Pay by bank transfer', 'faithbridgeacademy' ); ?></strong>
			<span><?php echo esc_html( fba_get_option( 'bank_name' ) . ' · ' . fba_get_option( 'bank_number' ) . ' · ' . fba_get_option( 'bank_bank' ) ); ?></span>
		</div>
		<p><a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></p>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
