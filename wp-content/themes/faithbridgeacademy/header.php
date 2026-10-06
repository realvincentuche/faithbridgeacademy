<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="fba-skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'faithbridgeacademy' ); ?></a>

<header class="fba-header">
	<div class="fba-wrap fba-header-inner">
		<a class="fba-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Faith Bridge Academy home', 'faithbridgeacademy' ); ?>"><?php esc_html_e( 'Faith Bridge Academy', 'faithbridgeacademy' ); ?></a>
		<nav class="fba-nav" aria-label="<?php esc_attr_e( 'Primary', 'faithbridgeacademy' ); ?>">
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
	</div>
</header>

<main id="content" class="fba-main">
