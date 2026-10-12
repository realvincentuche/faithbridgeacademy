<?php
/**
 * Resources page (slug: resources). Learning resources + recommended books.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Learning Resources', 'faithbridgeacademy' ),
		'sub'   => __( 'Memory verses, class notes and recommended books.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/slide-1.jpg',
	)
);

$verses = array_filter( array_map( 'trim', explode( "\n", (string) fba_get_option( 'memory_verses' ) ) ) );
$loop   = new WP_Query(
	array(
		'post_type'      => 'programme',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'meta_query'     => array(
			array( 'key' => '_fba_books', 'compare' => 'EXISTS' ),
		),
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap fba-single-grid">
		<div class="fba-prose reveal">
			<h2><?php esc_html_e( 'Memory verses this session', 'faithbridgeacademy' ); ?></h2>
			<?php if ( $verses ) : ?>
				<ul class="fba-book-list">
					<?php foreach ( $verses as $v ) : ?>
						<li><?php echo esc_html( $v ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p><?php esc_html_e( 'Memory verses for this session will appear here.', 'faithbridgeacademy' ); ?></p>
			<?php endif; ?>

			<h2><?php esc_html_e( 'Recommended books by programme', 'faithbridgeacademy' ); ?></h2>
			<?php if ( $loop->have_posts() ) : ?>
				<?php
				$shown = false;
				while ( $loop->have_posts() ) :
					$loop->the_post();
					$books = array_filter( array_map( 'trim', explode( "\n", (string) get_post_meta( get_the_ID(), '_fba_books', true ) ) ) );
					if ( ! $books ) {
						continue;
					}
					$shown = true;
					?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<ul class="fba-book-list">
						<?php foreach ( $books as $b ) : ?>
							<li><?php echo esc_html( $b ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php
				endwhile;
				wp_reset_postdata();
				if ( ! $shown ) :
					?>
					<p><?php esc_html_e( 'Book lists are being compiled — check back soon, or ask us on WhatsApp.', 'faithbridgeacademy' ); ?></p>
					<?php
				endif;
				?>
			<?php else : ?>
				<p><?php esc_html_e( 'Book lists are being compiled — check back soon.', 'faithbridgeacademy' ); ?></p>
			<?php endif; ?>
		</div>
		<aside class="fba-side-card reveal">
			<h3><?php esc_html_e( 'Need a book?', 'faithbridgeacademy' ); ?></h3>
			<p><?php esc_html_e( 'Soft copies download instantly. Hard copies deliver to Lagos, nationwide, or outside Nigeria (soft-only).', 'faithbridgeacademy' ); ?></p>
			<a class="fba-btn fba-btn-green" href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php esc_html_e( 'Ask on WhatsApp', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
		</aside>
	</div>
</div>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
