<?php
/**
 * Footer template.
 *
 * @package FaithBridgeAcademy
 */
?>

</main>

<footer class="fba-footer">
	<div class="fba-wrap fba-footer-inner">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Faith Bridge Academy. All rights reserved.', 'faithbridgeacademy' ); ?></p>
		<nav aria-label="<?php esc_attr_e( 'Footer', 'faithbridgeacademy' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => 'fba_footer_fallback',
				)
			);
			?>
		</nav>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
