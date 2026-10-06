<?php
/**
 * Blog index (DB-driven Loop).
 *
 * @package FaithBridgeAcademy
 */

get_header();
?>

<div class="fba-content">
	<div class="fba-wrap fba-prose">
		<h1><?php esc_html_e( 'News', 'faithbridgeacademy' ); ?></h1>
		<?php if ( have_posts() ) : ?>
			<div class="fba-blog-list">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'fba-post' ); ?>>
					<h2 class="fba-post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="fba-post-meta"><?php echo esc_html( get_the_date() ); ?></p>
					<div class="fba-post-excerpt">
						<?php the_excerpt(); ?>
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
			<p><?php esc_html_e( 'No posts yet — check back soon.', 'faithbridgeacademy' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
