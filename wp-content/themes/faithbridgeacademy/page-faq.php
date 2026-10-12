<?php
/**
 * FAQs page (slug: faq). Accordion, vanilla JS.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Frequently Asked Questions', 'faithbridgeacademy' ),
		'sub'   => __( 'Straight answers about sessions, fees, classes and the Bible Club.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/slide-5.jpg',
	)
);

$faqs = array(
	array( __( 'When do classes hold?', 'faithbridgeacademy' ), fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) . ' (' . fba_get_option( 'timezone' ) . '). ' . fba_get_option( 'format_note' ) . '.' ),
	array( __( 'How much are the fees?', 'faithbridgeacademy' ), sprintf( __( 'Group classes: %s per session. One-on-one: %s per session. See the Fees page for naira equivalents.', 'faithbridgeacademy' ), fba_fee_label( (float) fba_get_option( 'fee_group' ) ), fba_fee_label( (float) fba_get_option( 'fee_one_to_one' ) ) ) ),
	array( __( 'How do I pay?', 'faithbridgeacademy' ), sprintf( __( 'By bank transfer to %s · %s · %s. We confirm every application personally — no receipt upload needed.', 'faithbridgeacademy' ), fba_get_option( 'bank_name' ), fba_get_option( 'bank_number' ), fba_get_option( 'bank_bank' ) ) ),
	array( __( 'How many children can join a group class?', 'faithbridgeacademy' ), sprintf( __( 'At most %s learners per group class. One-on-one places are uncapped.', 'faithbridgeacademy' ), fba_get_option( 'group_capacity' ) ) ),
	array( __( 'Are class recordings available?', 'faithbridgeacademy' ), fba_get_option( 'recordings_note' ) ),
	array( __( 'What is the Bible Club?', 'faithbridgeacademy' ), sprintf( __( 'A separate annual membership (₦%s) for monthly gatherings — worship, Scripture memory and service, January to December.', 'faithbridgeacademy' ), number_format( (float) fba_get_option( 'club_fee' ) ) ) ),
	array( __( 'Which programmes do you offer?', 'faithbridgeacademy' ), __( 'Bible Study, English, French, Igbo, Hausa, Yoruba, Mathematics, Physics, Chemistry, Biology, Government, Literature, Economics, ICT, Agriculture and Basic Science & Technology.', 'faithbridgeacademy' ) ),
);
?>

<div class="fba-content">
	<div class="fba-wrap fba-prose">
		<div class="fba-faq reveal">
			<?php foreach ( $faqs as $i => $f ) : ?>
				<div class="fba-faq-item<?php echo 0 === $i ? ' open' : ''; ?>">
					<button class="fba-faq-q" type="button" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
						<?php echo esc_html( $f[0] ); ?>
						<span aria-hidden="true">+</span>
					</button>
					<div class="fba-faq-a"<?php echo 0 === $i ? '' : ' hidden'; ?>>
						<p><?php echo esc_html( $f[1] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<p style="margin-top:2rem"><a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></p>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
