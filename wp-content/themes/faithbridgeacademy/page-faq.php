<?php
/**
 * FAQs page (slug: faq). Category pills + grouped accordion, vanilla JS.
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

$cats = get_terms(
	array(
		'taxonomy'   => 'faq_category',
		'hide_empty' => false,
		'orderby'    => 'term_id',
	)
);
$cat_slugs = ( $cats && ! is_wp_error( $cats ) ) ? wp_list_pluck( $cats, 'slug' ) : array();
$active    = isset( $_GET['cat'] ) ? sanitize_key( wp_unslash( $_GET['cat'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- filter only.
if ( ! in_array( $active, $cat_slugs, true ) ) {
	$active = $cat_slugs ? $cat_slugs[0] : '';
}

$faqs = array();
if ( $active ) {
	$faq_loop = new WP_Query(
		array(
			'post_type'      => 'faq',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'faq_category',
					'field'    => 'slug',
					'terms'    => $active,
				),
			),
		)
	);
	if ( $faq_loop->have_posts() ) {
		while ( $faq_loop->have_posts() ) {
			$faq_loop->the_post();
			$faqs[] = array( get_the_title(), get_the_content() );
		}
		wp_reset_postdata();
	}
}
if ( ! $faqs && ! $cat_slugs ) {
	foreach ( fba_faq_seed_data() as $f ) {
		$faqs[] = array( $f['q'], fba_faq_seed_answer( $f['a'] ) );
	}
}
?>

<div class="fba-content">
	<div class="fba-wrap fba-prose">
		<?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
			<ul class="fba-cat-filter reveal">
				<?php foreach ( $cats as $c ) : ?>
					<li><a class="<?php echo $active === $c->slug ? 'active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'cat', $c->slug, get_permalink( get_page_by_path( 'faq' ) ) ) ); ?>"><?php echo esc_html( $c->name ); ?> <span class="count"><?php echo esc_html( (string) $c->count ); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="fba-faq reveal">
			<?php if ( $faqs ) : ?>
				<?php foreach ( $faqs as $i => $f ) : ?>
					<div class="fba-faq-item<?php echo 0 === $i ? ' open' : ''; ?>">
						<button class="fba-faq-q" type="button" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
							<?php echo esc_html( $f[0] ); ?>
							<span aria-hidden="true"><?php echo 0 === $i ? '–' : '+'; ?></span>
						</button>
						<div class="fba-faq-a"<?php echo 0 === $i ? '' : ' hidden'; ?>>
							<p><?php echo wp_kses_post( $f[1] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No questions in this category yet.', 'faithbridgeacademy' ); ?></p>
			<?php endif; ?>
		</div>
		<p style="margin-top:2rem"><a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_apply_url() ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></p>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
