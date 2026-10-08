<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<?php if ( is_front_page() ) : ?>
<link rel="preload" as="image" fetchpriority="high" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-1.jpg' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class( is_front_page() ? 'fba-has-slider' : 'fba-has-banner' ); ?>>
<?php wp_body_open(); ?>

<a class="fba-skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'faithbridgeacademy' ); ?></a>

<?php if ( '1' === fba_get_option( 'session_alert_on' ) && '' !== trim( fba_get_option( 'session_alert' ) ) ) : ?>
<div class="fba-alert" role="status">
	<div class="fba-wrap fba-alert-inner">
		<span class="fba-alert-dot" aria-hidden="true"></span>
		<p><?php echo esc_html( fba_get_option( 'session_alert' ) ); ?></p>
		<a class="fba-alert-link" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply now', 'faithbridgeacademy' ); ?> &rarr;</a>
	</div>
</div>
<?php endif; ?>

<header class="fba-header" id="fbaHeader">
	<div class="fba-wrap fba-header-inner">
		<a class="fba-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'FaithBridge Academy home', 'faithbridgeacademy' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<img class="fba-brand-logo fba-brand-logo-light" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-white.png' ); ?>" alt="<?php esc_attr_e( 'FaithBridge Academy', 'faithbridgeacademy' ); ?>">
				<img class="fba-brand-logo fba-brand-logo-dark" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="<?php esc_attr_e( 'FaithBridge Academy', 'faithbridgeacademy' ); ?>">
			<?php endif; ?>
		</a>
		<nav class="fba-nav" id="fbaNav" aria-label="<?php esc_attr_e( 'Primary', 'faithbridgeacademy' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'fba_menu_fallback',
				)
			);
			?>
		</nav>
		<div class="fba-header-actions">
			<a class="fba-btn fba-btn-gold fba-btn-sm" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
			<button class="fba-burger" id="fbaBurger" aria-label="<?php esc_attr_e( 'Open menu', 'faithbridgeacademy' ); ?>" aria-expanded="false" aria-controls="fbaDrawer">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<div class="fba-drawer-overlay" id="fbaDrawerOverlay" aria-hidden="true"></div>
<aside class="fba-drawer" id="fbaDrawer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'faithbridgeacademy' ); ?>">
	<div class="fba-drawer-head">
		<img class="fba-drawer-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-white.png' ); ?>" alt="<?php esc_attr_e( 'FaithBridge Academy', 'faithbridgeacademy' ); ?>">
		<button class="fba-drawer-close" id="fbaDrawerClose" aria-label="<?php esc_attr_e( 'Close menu', 'faithbridgeacademy' ); ?>">&times;</button>
	</div>
	<nav aria-label="<?php esc_attr_e( 'Mobile', 'faithbridgeacademy' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => 'fba_menu_fallback',
			)
		);
		?>
	</nav>
	<div class="fba-drawer-cta">
		<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
		<p><a href="<?php echo esc_url( fba_get_option( 'whatsapp' ) ); ?>"><?php echo esc_html( fba_get_option( 'phone' ) ); ?></a></p>
	</div>
</aside>

<main id="content" class="fba-main">
