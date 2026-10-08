<?php
/**
 * Blog index (DB-driven Loop).
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

get_template_part(
	'template-parts/page',
	'banner',
	array(
		'title' => __( 'Blog', 'faithbridgeacademy' ),
		'sub'   => __( 'Faith, parenting, and learning — stories and wisdom for the journey.', 'faithbridgeacademy' ),
		'img'   => $uri . '/assets/images/news-2.jpg',
	)
);
?>

<div class="fba-content">
	<div class="fba-wrap">
		<?php if ( have_posts() ) : ?>
			<div class="fba-news-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'fba-news-card' ); ?>>
					<a class="fba-news-thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium' ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( $uri . '/assets/images/news-1.jpg' ); ?>" alt="" loading="lazy">
						<?php endif; ?>
					</a>
					<div class="fba-news-body">
						<p class="fba-news-date"><?php echo esc_html( get_the_date() ); ?></p>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="fba-post-excerpt"><?php the_excerpt(); ?></div>
					</div>
				</article>
				<?php
			endwhile;
			?>
			</div>
			<div class="fba-pagination">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<div class="fba-prose">
				<p><?php esc_html_e( 'No posts yet — check back soon.', 'faithbridgeacademy' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
