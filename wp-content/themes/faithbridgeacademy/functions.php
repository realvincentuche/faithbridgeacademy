<?php
/**
 * Faith Bridge Academy theme setup.
 *
 * @package FaithBridgeAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FBA_VERSION', '0.2.0' );

/**
 * Theme setup: menus, title tag, thumbnails, HTML5, feed links, custom logo.
 */
function fba_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'faithbridgeacademy' ),
			'footer'  => __( 'Footer Menu', 'faithbridgeacademy' ),
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 56,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
}
add_action( 'after_setup_theme', 'fba_setup' );

/**
 * Enqueue theme styles and scripts.
 */
function fba_assets() {
	wp_enqueue_style(
		'fba-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Figtree:wght@400;500;600;700;800&display=swap',
		array(),
		FBA_VERSION
	);

	wp_enqueue_style(
		'fba-phosphor',
		get_template_directory_uri() . '/assets/css/phosphor-icon-regular.css',
		array(),
		FBA_VERSION
	);

	wp_enqueue_style(
		'fba-style',
		get_stylesheet_uri(),
		array(),
		FBA_VERSION
	);

	wp_enqueue_style(
		'fba-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'fba-style', 'fba-fonts', 'fba-phosphor' ),
		FBA_VERSION
	);

	wp_enqueue_script(
		'fba-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		FBA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'fba_assets' );

/* -------------------------------------------------------------------------
 * Options helper + defaults (single source of truth for volatile data)
 * ------------------------------------------------------------------------- */

/**
 * Default option values. Options page values (DB) override these.
 * Templates must NEVER hard-code dates, fees, phones, emails or links.
 *
 * @return array
 */
function fba_option_defaults() {
	return array(
		// Session.
		'session_label'    => 'Session 4',
		'session_period'   => 'October – December 2026',
		'session_year'     => '2026',
		'session_quarter'  => '4',
		'class_days'       => 'Tuesdays and Saturdays',
		'class_time'       => '5:00 PM',
		'timezone'         => 'Africa/Lagos (Nigeria Time)',
		'platform'         => 'Google Meet',
		'format_note'      => 'Live online via Google Meet',
		'recordings_note'  => 'Class recordings are available to enrolled students for revision and continuity.',
		'onsite_note'      => 'On-site learning available by arrangement.',
		'session_alert'    => '',
		'session_alert_on' => '0',
		// Money.
		'exchange_rate'    => '1500',
		'fee_group'        => '200',
		'fee_one_to_one'   => '300',
		'fee_note'         => 'Programme fees are charged per session (per quarter). Naira equivalents are calculated from the dollar price at the current exchange rate, rounded up to the nearest ₦1,000.',
		'bank_name'        => 'Faithbridgeacademy Limited',
		'bank_number'      => '1309301999',
		'bank_bank'        => 'Providus Bank',
		'enrol_url'        => '',
		// Club (annual membership service).
		'club_fee'         => '20000',
		'club_rhythm'      => 'once every month',
		'club_year_rule'   => 'calendar',
		'club_welcome'     => 'Welcome to the FaithBridge Bible Club family. Watch out for our monthly meeting details on WhatsApp.',
		// Caps & rules.
		'group_capacity'   => '15',
		'one_to_one_cap'   => 'unlimited',
		'followup_days'    => '7',
		'max_wards'        => '0', // 0 = unlimited.
		// Contact.
		'email'            => 'faithbridgeacad@gmail.com',
		'phone'            => '+234 808 583 4096',
		'whatsapp'         => 'https://wa.me/2348085834096',
		'online_note'      => 'Available to families globally where the programme permits.',
		'social_instagram' => 'https://instagram.com/faithbridgeacademy',
		'social_facebook'  => 'https://facebook.com/faithbridgeacademy',
		'social_tiktok'    => 'https://tiktok.com/@faithbridgeacademy',
		'social_youtube'   => 'https://youtube.com/@faithbridgeacademy',
		'social_linkedin'  => 'https://linkedin.com/company/faithbridge-academy',
		'social_x'         => 'https://x.com/Faithbridgeacad',
		// Content bits.
		'hero_cta_primary'   => 'Explore Our Programmes',
		'hero_cta_secondary' => 'Apply Now',
		'footer_tagline'     => 'Raising Children Who Know God, Love God, and Live for Him.',
		'memory_verses'      => "Psalm 27\nPsalm 121\nPsalm 119:105",
	);
}

/**
 * Get a FaithBridge option with code default fallback.
 *
 * @param string $key Option key.
 * @return string
 */
function fba_get_option( $key ) {
	$defaults = fba_option_defaults();
	$stored   = get_option( 'fba_options', array() );
	if ( is_array( $stored ) && isset( $stored[ $key ] ) && '' !== $stored[ $key ] ) {
		return $stored[ $key ];
	}
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}

/**
 * Quarter number => month range label.
 *
 * @param string|int $q Quarter 1-4.
 * @return string
 */
function fba_quarter_label( $q ) {
	$map = array(
		'1' => 'Jan–Mar',
		'2' => 'Apr–Jun',
		'3' => 'Jul–Sep',
		'4' => 'Oct–Dec',
	);
	$q   = (string) $q;
	return isset( $map[ $q ] ) ? $map[ $q ] : '';
}

/**
 * Dollar => naira, ceiled to the nearest 1,000.
 *
 * @param float $usd Dollar amount.
 * @return int
 */
function fba_usd_to_ngn( $usd ) {
	$rate = (float) fba_get_option( 'exchange_rate' );
	if ( $rate <= 0 ) {
		$rate = 1500;
	}
	return (int) ( ceil( (float) $usd * $rate / 1000 ) * 1000 );
}

/**
 * Format a dollar fee as "$200 / ₦300,000".
 *
 * @param float $usd Dollar amount.
 * @return string
 */
function fba_fee_label( $usd ) {
	$usd = (float) $usd;
	return '$' . number_format( $usd ) . ' / ₦' . number_format( fba_usd_to_ngn( $usd ) );
}

/* -------------------------------------------------------------------------
 * Settings page: Settings > FaithBridge
 * ------------------------------------------------------------------------- */

/**
 * Register settings page + setting.
 */
function fba_settings_init() {
	register_setting(
		'fba_options_group',
		'fba_options',
		array(
			'sanitize_callback' => 'fba_sanitize_options',
			'default'           => array(),
		)
	);

	add_options_page(
		__( 'FaithBridge Settings', 'faithbridgeacademy' ),
		__( 'FaithBridge', 'faithbridgeacademy' ),
		'manage_options',
		'faithbridge',
		'fba_settings_page'
	);
}
add_action( 'admin_init', 'fba_settings_init' );
add_action( 'admin_menu', 'fba_settings_init' );

/**
 * Sanitize options by key type.
 *
 * @param array $input Raw input.
 * @return array
 */
function fba_sanitize_options( $input ) {
	$out      = array();
	$urls     = array( 'enrol_url', 'whatsapp', 'social_instagram', 'social_facebook', 'social_tiktok', 'social_youtube', 'social_linkedin', 'social_x' );
	$ints     = array( 'exchange_rate', 'fee_group', 'fee_one_to_one', 'club_fee', 'group_capacity', 'followup_days', 'max_wards', 'session_year', 'session_quarter' );
	$checkbox = array( 'session_alert_on' );
	foreach ( (array) $input as $key => $value ) {
		if ( 'email' === $key ) {
			$out[ $key ] = sanitize_email( $value );
		} elseif ( in_array( $key, $urls, true ) ) {
			$out[ $key ] = esc_url_raw( $value );
		} elseif ( in_array( $key, $ints, true ) ) {
			$out[ $key ] = preg_replace( '/[^0-9]/', '', (string) $value );
		} elseif ( in_array( $key, $checkbox, true ) ) {
			$out[ $key ] = $value ? '1' : '0';
		} else {
			$out[ $key ] = sanitize_textarea_field( $value );
		}
	}
	return $out;
}

/**
 * Render the settings page (tabbed).
 */
function fba_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$tab  = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'session'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- tab navigation only.
	$tabs = array(
		'session'   => __( 'Session', 'faithbridgeacademy' ),
		'fees'      => __( 'Fees & Bank', 'faithbridgeacademy' ),
		'club'      => __( 'Bible Club', 'faithbridgeacademy' ),
		'catalogue' => __( 'Catalogue', 'faithbridgeacademy' ),
		'contact'   => __( 'Contact & Socials', 'faithbridgeacademy' ),
	);

	$fields = array(
		'session'   => array( 'session_label', 'session_period', 'session_year', 'session_quarter', 'class_days', 'class_time', 'timezone', 'platform', 'format_note', 'recordings_note', 'onsite_note', 'session_alert_on', 'session_alert' ),
		'fees'      => array( 'exchange_rate', 'fee_group', 'fee_one_to_one', 'fee_note', 'bank_name', 'bank_number', 'bank_bank', 'enrol_url' ),
		'club'      => array( 'club_fee', 'club_rhythm', 'club_year_rule', 'club_welcome' ),
		'catalogue' => array( 'group_capacity', 'one_to_one_cap', 'followup_days', 'max_wards', 'memory_verses', 'hero_cta_primary', 'hero_cta_secondary', 'footer_tagline' ),
		'contact'   => array( 'email', 'phone', 'whatsapp', 'online_note', 'social_instagram', 'social_facebook', 'social_tiktok', 'social_youtube', 'social_linkedin', 'social_x' ),
	);

	$labels = array(
		'session_label' => __( 'Session label', 'faithbridgeacademy' ),
		'session_period' => __( 'Session period', 'faithbridgeacademy' ),
		'session_year' => __( 'Session year', 'faithbridgeacademy' ),
		'session_quarter' => __( 'Session quarter (1-4)', 'faithbridgeacademy' ),
		'class_days' => __( 'Class days', 'faithbridgeacademy' ),
		'class_time' => __( 'Class time', 'faithbridgeacademy' ),
		'timezone' => __( 'Timezone', 'faithbridgeacademy' ),
		'platform' => __( 'Online platform', 'faithbridgeacademy' ),
		'format_note' => __( 'Format note', 'faithbridgeacademy' ),
		'recordings_note' => __( 'Recordings note', 'faithbridgeacademy' ),
		'onsite_note' => __( 'On-site note', 'faithbridgeacademy' ),
		'session_alert_on' => __( 'Show session alert banner', 'faithbridgeacademy' ),
		'session_alert' => __( 'Session alert text', 'faithbridgeacademy' ),
		'exchange_rate' => __( 'Naira per $1', 'faithbridgeacademy' ),
		'fee_group' => __( 'Default group fee ($)', 'faithbridgeacademy' ),
		'fee_one_to_one' => __( 'Default one-on-one fee ($)', 'faithbridgeacademy' ),
		'fee_note' => __( 'Fee note', 'faithbridgeacademy' ),
		'bank_name' => __( 'Account name', 'faithbridgeacademy' ),
		'bank_number' => __( 'Account number', 'faithbridgeacademy' ),
		'bank_bank' => __( 'Bank', 'faithbridgeacademy' ),
		'enrol_url' => __( 'External enrol URL (optional)', 'faithbridgeacademy' ),
		'club_fee' => __( 'Club annual fee (₦)', 'faithbridgeacademy' ),
		'club_rhythm' => __( 'Meeting rhythm', 'faithbridgeacademy' ),
		'club_year_rule' => __( 'Membership year rule', 'faithbridgeacademy' ),
		'club_welcome' => __( 'Club welcome text', 'faithbridgeacademy' ),
		'group_capacity' => __( 'Group class capacity', 'faithbridgeacademy' ),
		'one_to_one_cap' => __( 'One-on-one cap', 'faithbridgeacademy' ),
		'followup_days' => __( 'Payment follow-up after (days)', 'faithbridgeacademy' ),
		'max_wards' => __( 'Max wards per application (0 = unlimited)', 'faithbridgeacademy' ),
		'memory_verses' => __( 'Memory verses (one per line)', 'faithbridgeacademy' ),
		'hero_cta_primary' => __( 'Hero CTA primary', 'faithbridgeacademy' ),
		'hero_cta_secondary' => __( 'Hero CTA secondary', 'faithbridgeacademy' ),
		'footer_tagline' => __( 'Footer tagline', 'faithbridgeacademy' ),
		'email' => __( 'Email', 'faithbridgeacademy' ),
		'phone' => __( 'Phone / WhatsApp', 'faithbridgeacademy' ),
		'whatsapp' => __( 'WhatsApp link', 'faithbridgeacademy' ),
		'online_note' => __( 'Online learning note', 'faithbridgeacademy' ),
		'social_instagram' => __( 'Instagram', 'faithbridgeacademy' ),
		'social_facebook' => __( 'Facebook', 'faithbridgeacademy' ),
		'social_tiktok' => __( 'TikTok', 'faithbridgeacademy' ),
		'social_youtube' => __( 'YouTube', 'faithbridgeacademy' ),
		'social_linkedin' => __( 'LinkedIn', 'faithbridgeacademy' ),
		'social_x' => __( 'X / Twitter', 'faithbridgeacademy' ),
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'FaithBridge Settings', 'faithbridgeacademy' ); ?></h1>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $slug => $label ) : ?>
				<a class="nav-tab<?php echo $tab === $slug ? ' nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( 'options-general.php?page=faithbridge&tab=' . $slug ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'fba_options_group' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( $fields[ $tab ] as $key ) : ?>
					<tr>
						<th scope="row"><label for="fba-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( isset( $labels[ $key ] ) ? $labels[ $key ] : $key ); ?></label></th>
						<td>
							<?php if ( 'session_alert_on' === $key ) : ?>
								<input type="checkbox" id="fba-<?php echo esc_attr( $key ); ?>" name="fba_options[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( fba_get_option( $key ), '1' ); ?>>
							<?php elseif ( in_array( $key, array( 'session_alert', 'fee_note', 'club_welcome', 'memory_verses', 'recordings_note' ), true ) ) : ?>
								<textarea id="fba-<?php echo esc_attr( $key ); ?>" name="fba_options[<?php echo esc_attr( $key ); ?>]" rows="3" class="large-text"><?php echo esc_textarea( fba_get_option( $key ) ); ?></textarea>
							<?php else : ?>
								<input type="text" id="fba-<?php echo esc_attr( $key ); ?>" name="fba_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( fba_get_option( $key ) ); ?>" class="regular-text">
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/* -------------------------------------------------------------------------
 * Menus
 * ------------------------------------------------------------------------- */

/**
 * Fallback primary menu (keeps local == live identical before menus exist).
 */
function fba_menu_fallback() {
	$items = array(
		home_url( '/' )             => __( 'Home', 'faithbridgeacademy' ),
		home_url( '/programmes/' ) => __( 'Programmes', 'faithbridgeacademy' ),
		home_url( '/bible-club/' ) => __( 'Bible Club', 'faithbridgeacademy' ),
		home_url( '/about/' )      => __( 'About', 'faithbridgeacademy' ),
		home_url( '/blog/' )       => __( 'Blog', 'faithbridgeacademy' ),
		home_url( '/contact/' )    => __( 'Contact', 'faithbridgeacademy' ),
	);
	echo '<ul class="menu">';
	foreach ( $items as $url => $label ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Fallback footer menu (keeps bottom bar populated before a menu exists).
 */
function fba_footer_fallback() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/apply/' ) ) . '">' . esc_html__( 'Apply Now', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/fees/' ) ) . '">' . esc_html__( 'Fees', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/faq/' ) ) . '">' . esc_html__( 'FAQ', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'faithbridgeacademy' ) . '</a></li>';
	echo '</ul>';
}

/* -------------------------------------------------------------------------
 * Testimonials + newsletter subscribers (private CPTs)
 * ------------------------------------------------------------------------- */

/**
 * Register testimonial + subscriber CPTs.
 */
function fba_register_cpts() {
	register_post_type(
		'testimonial',
		array(
			'labels'       => array(
				'name'          => __( 'Testimonials', 'faithbridgeacademy' ),
				'singular_name' => __( 'Testimonial', 'faithbridgeacademy' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'menu_icon'    => 'dashicons-format-quote',
		)
	);

	register_post_type(
		'subscriber',
		array(
			'labels'       => array(
				'name'          => __( 'Subscribers', 'faithbridgeacademy' ),
				'singular_name' => __( 'Subscriber', 'faithbridgeacademy' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'supports'     => array( 'title' ),
			'menu_icon'    => 'dashicons-email',
			'capabilities' => array(
				'create_posts' => 'manage_options',
			),
			'map_meta_cap' => true,
		)
	);
}
add_action( 'init', 'fba_register_cpts' );

/**
 * Newsletter subscribe handler (stores private subscriber record).
 */
function fba_subscribe_handler() {
	if ( ! isset( $_POST['fba_subscribe_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_subscribe_nonce'] ) ), 'fba_subscribe' ) ) {
		wp_safe_redirect( add_query_arg( 'subscribed', 'error', home_url( '/' ) ) );
		exit;
	}
	$email = isset( $_POST['fba_email'] ) ? sanitize_email( wp_unslash( $_POST['fba_email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'subscribed', 'error', home_url( '/' ) ) );
		exit;
	}
	$existing = get_page_by_title( $email, OBJECT, 'subscriber' );
	if ( ! $existing ) {
		wp_insert_post(
			array(
				'post_title'  => $email,
				'post_status' => 'private',
				'post_type'   => 'subscriber',
			)
		);
	}
	wp_safe_redirect( add_query_arg( 'subscribed', 'done', home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_fba_subscribe', 'fba_subscribe_handler' );
add_action( 'admin_post_fba_subscribe', 'fba_subscribe_handler' );

/* -------------------------------------------------------------------------
 * Page seeder
 * ------------------------------------------------------------------------- */

/**
 * Seed skeleton pages on theme activation so local == live on first activate.
 * Never overwrites existing pages.
 */
function fba_seed_on_activate() {
	$pages = array(
		'home'       => __( 'Home', 'faithbridgeacademy' ),
		'about'      => __( 'About Us', 'faithbridgeacademy' ),
		'programmes' => __( 'Programmes', 'faithbridgeacademy' ),
		'bible-club' => __( 'Bible Club', 'faithbridgeacademy' ),
		'fees'       => __( 'Fees', 'faithbridgeacademy' ),
		'faq'        => __( 'FAQs', 'faithbridgeacademy' ),
		'apply'      => __( 'Apply Now', 'faithbridgeacademy' ),
		'contact'    => __( 'Contact Us', 'faithbridgeacademy' ),
		'blog'       => __( 'Blog', 'faithbridgeacademy' ),
		'resources'  => __( 'Resources', 'faithbridgeacademy' ),
	);

	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}
		$new_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $new_id && ! is_wp_error( $new_id ) ) {
			$ids[ $slug ] = $new_id;
		}
	}

	if ( isset( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}
	if ( isset( $ids['blog'] ) ) {
		update_option( 'page_for_posts', $ids['blog'] );
	}

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'fba_seed_on_activate' );

/**
 * One-click page setup for servers where the theme was deployed via FTP
 * (activation hook never fired, so pages/menus may be missing).
 */
function fba_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$missing = array();
	foreach ( array( 'home', 'about', 'programmes', 'bible-club', 'fees', 'faq', 'apply', 'contact', 'blog', 'resources' ) as $slug ) {
		if ( ! get_page_by_path( $slug ) ) {
			$missing[] = $slug;
		}
	}
	if ( ! $missing ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=fba_setup_pages' ), 'fba_setup_pages' );
	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'FaithBridge Academy theme: missing pages (', 'faithbridgeacademy' ) . esc_html( implode( ', ', $missing ) ) . esc_html__( '). ', 'faithbridgeacademy' );
	echo '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Create pages now', 'faithbridgeacademy' ) . '</a>';
	echo '</p></div>';
}
add_action( 'admin_notices', 'fba_setup_notice' );

/**
 * Admin-post handler: run the seeder on demand, then flush permalinks.
 */
function fba_setup_pages_handler() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'fba_setup_pages' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'faithbridgeacademy' ) );
	}
	fba_seed_on_activate();
	wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
	exit;
}
add_action( 'admin_post_fba_setup_pages', 'fba_setup_pages_handler' );
