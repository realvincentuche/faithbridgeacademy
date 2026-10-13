<?php
/**
 * Programme catalogue grid with group filters.
 *
 * Args: group (slug, '' = all).
 *
 * @package FaithBridgeAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active = isset( $args['group'] ) ? sanitize_key( $args['group'] ) : '';
$groups = get_terms(
	array(
		'taxonomy'   => 'programme_group',
		'hide_empty' => true,
		'orderby'    => 'term_id',
	)
);
$total  = fba_programme_count();

$query_args = array(
	'post_type'      => 'programme',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
);
if ( $active ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'programme_group',
			'field'    => 'slug',
			'terms'    => $active,
		),
	);
}
$loop = new WP_Query( $query_args );
?>

<ul class="fba-cat-filter reveal">
	<li><a class="<?php echo '' === $active ? 'active' : ''; ?>" href="<?php echo esc_url( get_permalink( get_page_by_path( 'programmes' ) ) ); ?>"><span class="fba-filter-icon" aria-hidden="true"><?php echo fba_group_icon( 'all' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><?php esc_html_e( 'All', 'faithbridgeacademy' ); ?> <span class="count"><?php echo esc_html( (string) $total ); ?></span></a></li>
	<?php if ( $groups && ! is_wp_error( $groups ) ) : ?>
		<?php foreach ( $groups as $g ) : ?>
			<li><a class="<?php echo $active === $g->slug ? 'active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'group', $g->slug, get_permalink( get_page_by_path( 'programmes' ) ) ) ); ?>"><span class="fba-filter-icon" aria-hidden="true"><?php echo fba_group_icon( $g->slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><?php echo esc_html( $g->name ); ?> <span class="count"><?php echo esc_html( (string) $g->count ); ?></span></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<div class="fba-cat-grid">
	<?php if ( $loop->have_posts() ) : ?>
		<?php
		while ( $loop->have_posts() ) :
			$loop->the_post();
			$pid    = get_the_ID();
			$status = fba_programme_status( $pid );
			$slug   = get_post_field( 'post_name', $pid );
			?>
			<a class="fba-cat-card reveal" href="<?php the_permalink(); ?>">
				<?php if ( 'bible-study' === $slug ) : ?>
					<span class="fba-cat-flag"><?php esc_html_e( 'Flagship', 'faithbridgeacademy' ); ?></span>
				<?php endif; ?>
				<span class="fba-cat-photo" aria-hidden="true"><img src="<?php echo esc_url( fba_programme_image( $pid ) ); ?>" alt="" loading="lazy"></span>
				<strong><?php the_title(); ?></strong>
				<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php if ( 'coming' === $status ) : ?>
					<span class="fba-cat-status"><?php esc_html_e( 'Coming soon', 'faithbridgeacademy' ); ?></span>
				<?php elseif ( ! fba_programme_is_open( $pid ) ) : ?>
					<span class="fba-cat-status closed"><?php esc_html_e( 'Group class full', 'faithbridgeacademy' ); ?></span>
				<?php endif; ?>
			</a>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
	<?php else : ?>
		<p><?php esc_html_e( 'No programmes found in this group yet.', 'faithbridgeacademy' ); ?></p>
	<?php endif; ?>
</div>
