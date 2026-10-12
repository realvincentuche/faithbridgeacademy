<?php
/**
 * Faith Bridge Academy theme setup.
 *
 * @package FaithBridgeAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FBA_VERSION', '0.3.0' );

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
		'https://fonts.googleapis.com/css2?family=Raleway:wght@600;700;800&family=Figtree:wght@400;500;600;700;800&display=swap',
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
		'email'            => 'info@faithbridgeacademy.com',
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
 * Register the fba_options setting.
 */
function fba_settings_register() {
	register_setting(
		'fba_options_group',
		'fba_options',
		array(
			'sanitize_callback' => 'fba_sanitize_options',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'fba_settings_register' );

/**
 * Add the Settings > FaithBridge page.
 */
function fba_settings_menu() {
	add_options_page(
		__( 'FaithBridge Settings', 'faithbridgeacademy' ),
		__( 'FaithBridge', 'faithbridgeacademy' ),
		'manage_options',
		'faithbridge',
		'fba_settings_page'
	);
}
add_action( 'admin_menu', 'fba_settings_menu' );

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
 * Mirrors the recommended wp-admin menu structure, dropdowns included.
 */
function fba_menu_fallback() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li class="menu-item-has-children"><a href="' . esc_url( home_url( '/programmes/' ) ) . '" aria-haspopup="true" aria-expanded="false">' . esc_html__( 'Programmes', 'faithbridgeacademy' ) . '</a>';
	echo '<ul class="sub-menu">';
	echo '<li><a href="' . esc_url( home_url( '/programmes/' ) ) . '">' . esc_html__( 'All Programmes', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/programmes/' ) ) . '">' . esc_html__( 'Bible Study', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/programmes/' ) ) . '">' . esc_html__( 'Languages', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/programmes/' ) ) . '">' . esc_html__( 'Sciences & Others', 'faithbridgeacademy' ) . '</a></li>';
	echo '</ul></li>';
	echo '<li class="menu-item-has-children"><a href="' . esc_url( home_url( '/apply/' ) ) . '" aria-haspopup="true" aria-expanded="false">' . esc_html__( 'Admissions', 'faithbridgeacademy' ) . '</a>';
	echo '<ul class="sub-menu">';
	echo '<li><a href="' . esc_url( home_url( '/apply/' ) ) . '">' . esc_html__( 'How to Apply', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/fees/' ) ) . '">' . esc_html__( 'Fees & Sessions', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/faq/' ) ) . '">' . esc_html__( 'FAQs', 'faithbridgeacademy' ) . '</a></li>';
	echo '</ul></li>';
	echo '<li><a href="' . esc_url( home_url( '/bible-club/' ) ) . '">' . esc_html__( 'Bible Club', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">' . esc_html__( 'About', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/blog/' ) ) . '">' . esc_html__( 'Blog', 'faithbridgeacademy' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'faithbridgeacademy' ) . '</a></li>';
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
	if ( post_type_exists( 'programme' ) ) {
		$c = wp_count_posts( 'programme' );
		$prog_count = $c ? (int) $c->publish : 0;
		if ( $prog_count < 16 ) {
			$missing[] = 'programmes-catalogue(' . $prog_count . '/16)';
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
	fba_seed_programmes();
	flush_rewrite_rules();
	wp_safe_redirect( admin_url( 'edit.php?post_type=programme' ) );
	exit;
}
add_action( 'admin_post_fba_setup_pages', 'fba_setup_pages_handler' );

/* -------------------------------------------------------------------------
 * Programme catalogue (Phase 2): CPT + groups + fees/seats logic
 * ------------------------------------------------------------------------- */

/**
 * The 16 client-locked programmes, in catalogue order.
 *
 * @return array
 */
function fba_programme_seed_data() {
	return array(
		array( 'slug' => 'bible-study', 'title' => 'Bible Study', 'group' => 'bible', 'desc' => 'Know God deeply through Scripture — memory verses, character lessons and practical faith, taught live with recordings for revision.' ),
		array( 'slug' => 'english', 'title' => 'English', 'group' => 'languages', 'desc' => 'Read widely, write clearly and speak with poise — from phonics to essay writing, built on great books and godly speech.' ),
		array( 'slug' => 'french', 'title' => 'French', 'group' => 'languages', 'desc' => 'A second language learned joyfully — speak, sing and shine en français, from first greetings to confident conversation.' ),
		array( 'slug' => 'igbo', 'title' => 'Igbo', 'group' => 'languages', 'desc' => 'Asụsụ Igbo learned with pride — speak, read and write the language of home, guided by fluent facilitators.' ),
		array( 'slug' => 'hausa', 'title' => 'Hausa', 'group' => 'languages', 'desc' => 'Hausa learned step by step — conversation, reading and writing, rooted in respect for culture and community.' ),
		array( 'slug' => 'yoruba', 'title' => 'Yoruba', 'group' => 'languages', 'desc' => 'Èdè Yorùbá with confidence — proverbs, stories and sound structure, from first words to fluent expression.' ),
		array( 'slug' => 'mathematics', 'title' => 'Mathematics', 'group' => 'others', 'desc' => 'Strong foundations and fearless problem-solving — from number basics to exam brilliance, no fear, just method.' ),
		array( 'slug' => 'physics', 'title' => 'Physics', 'group' => 'others', 'desc' => "Understand how God's ordered world works — motion, energy and matter explained clearly with worked examples." ),
		array( 'slug' => 'chemistry', 'title' => 'Chemistry', 'group' => 'others', 'desc' => 'Matter, reactions and the order in creation — theory plus diagrams that make abstract ideas stick.' ),
		array( 'slug' => 'biology', 'title' => 'Biology', 'group' => 'others', 'desc' => 'Life in all its wonder — cells, systems and the environment, studied with awe and exam precision.' ),
		array( 'slug' => 'government', 'title' => 'Government', 'group' => 'others', 'desc' => 'Power, citizenship and the Nigerian state — understand governance and your place in it.' ),
		array( 'slug' => 'literature', 'title' => 'Literature', 'group' => 'others', 'desc' => 'Stories that shape the soul — prose, poetry and drama, read deeply and answered with insight.' ),
		array( 'slug' => 'economics', 'title' => 'Economics', 'group' => 'others', 'desc' => 'Choice, markets and stewardship — grasp the principles that explain everyday life and exams alike.' ),
		array( 'slug' => 'ict', 'title' => 'ICT', 'group' => 'others', 'desc' => 'Confident with computers — from computing basics to practical digital skills for school and life online.' ),
		array( 'slug' => 'agriculture', 'title' => 'Agriculture', 'group' => 'others', 'desc' => 'The soil, the seed and the harvest — crop and animal husbandry taught plainly for school and real life.' ),
		array( 'slug' => 'basic-science-technology', 'title' => 'Basic Science & Technology', 'group' => 'others', 'desc' => 'Curiosity first — explore living things, materials and simple machines the hands-on way.' ),
	);
}

/**
 * Register the programme CPT + group taxonomy. Never flushes here.
 */
function fba_register_programme_cpt() {
	register_taxonomy(
		'programme_group',
		'programme',
		array(
			'labels'            => array(
				'name'          => __( 'Programme Groups', 'faithbridgeacademy' ),
				'singular_name' => __( 'Programme Group', 'faithbridgeacademy' ),
			),
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'programme-group', 'with_front' => false ),
		)
	);

	register_post_type(
		'programme',
		array(
			'labels'        => array(
				'name'          => __( 'Programmes', 'faithbridgeacademy' ),
				'singular_name' => __( 'Programme', 'faithbridgeacademy' ),
				'add_new_item'  => __( 'Add New Programme', 'faithbridgeacademy' ),
				'edit_item'     => __( 'Edit Programme', 'faithbridgeacademy' ),
			),
			'public'        => true,
			'has_archive'   => 'programme',
			'rewrite'       => array( 'slug' => 'programme', 'with_front' => false ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'     => 'dashicons-book',
			'menu_position' => 21,
			'show_in_rest'  => false,
		)
	);
}
add_action( 'init', 'fba_register_programme_cpt' );

/**
 * Seed groups + the 16 locked programmes. Never overwrites existing slugs.
 *
 * @return array created/skipped counts.
 */
function fba_seed_programmes() {
	$done = array( 'groups' => 0, 'created' => 0, 'skipped' => 0 );

	foreach ( array( 'bible' => 'Bible', 'languages' => 'Languages', 'others' => 'Others' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'programme_group' ) ) {
			$res = wp_insert_term( $name, 'programme_group', array( 'slug' => $slug ) );
			if ( ! is_wp_error( $res ) ) {
				$done['groups']++;
			}
		}
	}

	$order = 1;
	foreach ( fba_programme_seed_data() as $p ) {
		$existing = get_page_by_path( $p['slug'], OBJECT, 'programme' );
		if ( $existing ) {
			$done['skipped']++;
			$order++;
			continue;
		}
		$new_id = wp_insert_post(
			wp_slash(
				array(
					'post_title'   => $p['title'],
					'post_name'    => $p['slug'],
					'post_content' => $p['desc'],
					'post_excerpt' => $p['desc'],
					'post_status'  => 'publish',
					'post_type'    => 'programme',
					'menu_order'   => $order,
				)
			)
		);
		if ( $new_id && ! is_wp_error( $new_id ) ) {
			wp_set_object_terms( $new_id, $p['group'], 'programme_group' );
			update_post_meta( $new_id, '_fba_status', 'open' );
			$done['created']++;
		}
		$order++;
	}

	return $done;
}

/**
 * Current session snapshot from settings.
 *
 * @return array
 */
function fba_current_session() {
	return array(
		'label'   => fba_get_option( 'session_label' ),
		'period'  => fba_get_option( 'session_period' ),
		'year'    => fba_get_option( 'session_year' ),
		'quarter' => fba_get_option( 'session_quarter' ),
	);
}

/**
 * Effective fees for a programme ($), meta override falls back to settings.
 *
 * @param int $post_id Programme ID.
 * @return array {group, one}
 */
function fba_programme_fees( $post_id ) {
	$group = get_post_meta( $post_id, '_fba_fee_group', true );
	$one   = get_post_meta( $post_id, '_fba_fee_one_to_one', true );
	return array(
		'group' => '' !== $group ? (float) $group : (float) fba_get_option( 'fee_group' ),
		'one'   => '' !== $one ? (float) $one : (float) fba_get_option( 'fee_one_to_one' ),
	);
}

/**
 * Enrolment status: open|closed|coming.
 *
 * @param int $post_id Programme ID.
 * @return string
 */
function fba_programme_status( $post_id ) {
	$s = get_post_meta( $post_id, '_fba_status', true );
	return in_array( $s, array( 'open', 'closed', 'coming' ), true ) ? $s : 'open';
}

/**
 * Group enrolments banked for the current session (Phase 3 applications drive this).
 *
 * @param int $post_id Programme ID.
 * @return int
 */
function fba_enrolled_group( $post_id ) {
	return max( 0, (int) get_post_meta( $post_id, '_fba_enrolled_group', true ) );
}

/**
 * Seats left in the group class for the current session.
 *
 * @param int $post_id Programme ID.
 * @return int
 */
function fba_seats_left( $post_id ) {
	$cap = (int) fba_get_option( 'group_capacity' );
	if ( $cap <= 0 ) {
		return 999;
	}
	return max( 0, $cap - fba_enrolled_group( $post_id ) );
}

/**
 * Whether a programme currently accepts group applications.
 *
 * @param int $post_id Programme ID.
 * @return bool
 */
function fba_programme_is_open( $post_id ) {
	return 'open' === fba_programme_status( $post_id ) && fba_seats_left( $post_id ) > 0;
}

/**
 * Published programme count (honest stats).
 *
 * @return int
 */
function fba_programme_count() {
	$c = wp_count_posts( 'programme' );
	return $c ? (int) $c->publish : 0;
}

/**
 * Apply-page URL, optionally pre-selecting a programme (Phase 3 reads ?programme=).
 *
 * @param int $post_id Programme ID (0 = plain apply URL).
 * @return string
 */
function fba_apply_url( $post_id = 0 ) {
	$page = get_page_by_path( 'apply' );
	$url  = $page ? get_permalink( $page ) : home_url( '/apply/' );
	if ( $post_id ) {
		$url = add_query_arg( 'programme', (int) $post_id, $url );
	}
	return $url;
}

/**
 * Linked LMS course URL. LMS-agnostic: renders only when the course exists.
 * Masteriyo pilot: Bible Study course ID stored on the programme.
 *
 * @param int $post_id Programme ID.
 * @return string
 */
function fba_programme_course_url( $post_id ) {
	$course_id = (int) get_post_meta( $post_id, '_fba_course_id', true );
	if ( ! $course_id ) {
		return '';
	}
	if ( post_type_exists( 'mto-course' ) && 'mto-course' === get_post_type( $course_id ) ) {
		return get_permalink( $course_id );
	}
	if ( 'publish' === get_post_status( $course_id ) ) {
		return get_permalink( $course_id );
	}
	return '';
}

/**
 * Whether the Masteriyo LMS plugin is active (pilot gate).
 *
 * @return bool
 */
function fba_masteriyo_active() {
	return post_type_exists( 'mto-course' ) || class_exists( 'Masteriyo\Masteriyo' ) || defined( 'MASTERIYO_VERSION' );
}

/**
 * Enrol a user into a Masteriyo course. No-op unless Masteriyo is active.
 * Called from approved applications when a WP user + course link exist.
 *
 * @param int $user_id WP user ID.
 * @param int $course_id Masteriyo course ID.
 * @return bool
 */
function fba_masteriyo_enrol( $user_id, $course_id ) {
	if ( ! fba_masteriyo_active() || ! $user_id || ! $course_id ) {
		return false;
	}
	if ( function_exists( 'masteriyo_enroll_user_to_course' ) ) {
		return (bool) masteriyo_enroll_user_to_course( $course_id, $user_id );
	}
	if ( class_exists( 'Masteriyo\Addons\Enrollment\EnrollmentHelper' ) && method_exists( 'Masteriyo\Addons\Enrollment\EnrollmentHelper', 'enroll' ) ) {
		return (bool) call_user_func( array( 'Masteriyo\Addons\Enrollment\EnrollmentHelper', 'enroll' ), $course_id, $user_id );
	}
	return false;
}

/**
 * Thin-stroke icon (inline SVG) per programme group.
 *
 * @param string $slug Group slug: bible|languages|others|all.
 * @return string
 */
function fba_group_icon( $slug = 'others' ) {
	$paths = array(
		'all'       => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
		'bible'     => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
		'languages' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
		'others'    => '<path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/><line x1="22" y1="10" x2="22" y2="16"/>',
	);
	$inner = isset( $paths[ $slug ] ) ? $paths[ $slug ] : $paths['others'];
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
}

/**
 * Thin-stroke icon (inline SVG) for a programme's group.
 *
 * @param int $post_id Programme ID.
 * @return string
 */
function fba_programme_group_icon( $post_id ) {
	$terms = get_the_terms( $post_id, 'programme_group' );
	$slug  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : 'others';
	return fba_group_icon( $slug );
}

/**
 * Programme details meta box.
 */
function fba_programme_metabox() {
	add_meta_box( 'fba-programme-details', __( 'Programme Details', 'faithbridgeacademy' ), 'fba_programme_metabox_html', 'programme', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'fba_programme_metabox' );

/**
 * Meta box HTML.
 *
 * @param WP_Post $post Current post.
 */
function fba_programme_metabox_html( $post ) {
	wp_nonce_field( 'fba_programme_meta', 'fba_programme_nonce' );
	$fee_group = get_post_meta( $post->ID, '_fba_fee_group', true );
	$fee_one   = get_post_meta( $post->ID, '_fba_fee_one_to_one', true );
	$status    = fba_programme_status( $post->ID );
	$enrolled  = fba_enrolled_group( $post->ID );
	$course    = get_post_meta( $post->ID, '_fba_course_id', true );
	$books     = get_post_meta( $post->ID, '_fba_books', true );
	?>
	<p><label for="fba-fee-group"><?php esc_html_e( 'Group fee ($) — blank uses settings default', 'faithbridgeacademy' ); ?></label><br>
	<input type="number" min="0" step="1" id="fba-fee-group" name="fba_fee_group" value="<?php echo esc_attr( $fee_group ); ?>" class="small-text"></p>
	<p><label for="fba-fee-one"><?php esc_html_e( 'One-on-one fee ($) — blank uses settings default', 'faithbridgeacademy' ); ?></label><br>
	<input type="number" min="0" step="1" id="fba-fee-one" name="fba_fee_one" value="<?php echo esc_attr( $fee_one ); ?>" class="small-text"></p>
	<p><label for="fba-status"><?php esc_html_e( 'Enrolment status', 'faithbridgeacademy' ); ?></label><br>
	<select id="fba-status" name="fba_status">
		<?php foreach ( array( 'open' => __( 'Open', 'faithbridgeacademy' ), 'coming' => __( 'Coming soon', 'faithbridgeacademy' ), 'closed' => __( 'Closed', 'faithbridgeacademy' ) ) as $val => $label ) : ?>
			<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $status, $val ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select></p>
	<p><label for="fba-enrolled"><?php esc_html_e( 'Group enrolments banked (current session)', 'faithbridgeacademy' ); ?></label><br>
	<input type="number" min="0" step="1" id="fba-enrolled" name="fba_enrolled_group" value="<?php echo esc_attr( $enrolled ); ?>" class="small-text"></p>
	<p><label for="fba-course"><?php esc_html_e( 'Linked LMS course ID (optional)', 'faithbridgeacademy' ); ?></label><br>
	<input type="number" min="0" step="1" id="fba-course" name="fba_course_id" value="<?php echo esc_attr( $course ); ?>" class="small-text"></p>
	<p><label for="fba-books"><?php esc_html_e( 'Recommended books (one per line)', 'faithbridgeacademy' ); ?></label><br>
	<textarea id="fba-books" name="fba_books" rows="3" class="large-text"><?php echo esc_textarea( $books ); ?></textarea></p>
	<?php
	$cover_id  = (int) get_post_meta( $post->ID, '_fba_cover_id', true );
	$cover_url = $cover_id ? wp_get_attachment_image_url( $cover_id, 'medium' ) : '';
	?>
	<p><label><?php esc_html_e( 'Cover image (used as the detail page banner)', 'faithbridgeacademy' ); ?></label><br>
	<span id="fba-cover-preview"><?php echo $cover_url ? '<img src="' . esc_url( $cover_url ) . '" style="max-width:220px;height:auto;display:block;margin-bottom:0.5rem">' : ''; ?></span>
	<input type="hidden" id="fba-cover-id" name="fba_cover_id" value="<?php echo esc_attr( (string) $cover_id ); ?>">
	<button type="button" class="button" id="fba-cover-pick"><?php esc_html_e( 'Choose cover image', 'faithbridgeacademy' ); ?></button>
	<button type="button" class="button-link" id="fba-cover-clear"<?php echo $cover_id ? '' : ' hidden'; ?>><?php esc_html_e( 'Remove', 'faithbridgeacademy' ); ?></button></p>
	<?php
}

/**
 * Save programme meta.
 *
 * @param int $post_id Post ID.
 */
function fba_save_programme_meta( $post_id ) {
	if ( ! isset( $_POST['fba_programme_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_programme_nonce'] ) ), 'fba_programme_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['fba_fee_group'] ) ) {
		update_post_meta( $post_id, '_fba_fee_group', preg_replace( '/[^0-9.]/', '', (string) wp_unslash( $_POST['fba_fee_group'] ) ) );
	}
	if ( isset( $_POST['fba_fee_one'] ) ) {
		update_post_meta( $post_id, '_fba_fee_one_to_one', preg_replace( '/[^0-9.]/', '', (string) wp_unslash( $_POST['fba_fee_one'] ) ) );
	}
	if ( isset( $_POST['fba_status'] ) ) {
		$s = sanitize_key( wp_unslash( $_POST['fba_status'] ) );
		update_post_meta( $post_id, '_fba_status', in_array( $s, array( 'open', 'closed', 'coming' ), true ) ? $s : 'open' );
	}
	if ( isset( $_POST['fba_enrolled_group'] ) ) {
		update_post_meta( $post_id, '_fba_enrolled_group', max( 0, (int) wp_unslash( $_POST['fba_enrolled_group'] ) ) );
	}
	if ( isset( $_POST['fba_course_id'] ) ) {
		update_post_meta( $post_id, '_fba_course_id', max( 0, (int) wp_unslash( $_POST['fba_course_id'] ) ) );
	}
	if ( isset( $_POST['fba_books'] ) ) {
		update_post_meta( $post_id, '_fba_books', sanitize_textarea_field( wp_unslash( $_POST['fba_books'] ) ) );
	}
	if ( isset( $_POST['fba_cover_id'] ) ) {
		update_post_meta( $post_id, '_fba_cover_id', max( 0, (int) wp_unslash( $_POST['fba_cover_id'] ) ) );
	}
}
add_action( 'save_post_programme', 'fba_save_programme_meta' );

/**
 * Media picker for the programme cover image.
 *
 * @param string $hook Current admin page hook.
 */
function fba_cover_media_assets( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'programme' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_add_inline_script(
		'media-editor',
		"jQuery(function($){var f=wp.media({title:'Choose cover image',multiple:false,library:{type:'image'}});$('#fba-cover-pick').on('click',function(e){e.preventDefault();f.open();});f.on('select',function(){var a=f.state().get('selection').first().toJSON();$('#fba-cover-id').val(a.id);$('#fba-cover-preview').html('<img src=\"'+a.sizes.medium.url+'\" style=\"max-width:220px;height:auto;display:block;margin-bottom:0.5rem\">');$('#fba-cover-clear').removeAttr('hidden');});$('#fba-cover-clear').on('click',function(e){e.preventDefault();$('#fba-cover-id').val('');$('#fba-cover-preview').empty();$(this).attr('hidden','');});});"
	);
}
add_action( 'admin_enqueue_scripts', 'fba_cover_media_assets' );

/**
 * Admin columns: fees + seats at a glance.
 *
 * @param array $cols Columns.
 * @return array
 */
function fba_programme_columns( $cols ) {
	$cols['fba_fees']  = __( 'Fees', 'faithbridgeacademy' );
	$cols['fba_seats'] = __( 'Seats left', 'faithbridgeacademy' );
	return $cols;
}
add_filter( 'manage_programme_posts_columns', 'fba_programme_columns' );

/**
 * Admin column values.
 *
 * @param string $col Column key.
 * @param int    $post_id Post ID.
 */
function fba_programme_column_values( $col, $post_id ) {
	if ( 'fba_fees' === $col ) {
		$fees = fba_programme_fees( $post_id );
		echo esc_html( '$' . number_format( $fees['group'] ) . ' / $' . number_format( $fees['one'] ) );
	} elseif ( 'fba_seats' === $col ) {
		echo esc_html( (string) fba_seats_left( $post_id ) );
	}
}
add_action( 'manage_programme_posts_custom_column', 'fba_programme_column_values', 10, 2 );

/* -------------------------------------------------------------------------
 * Phase 3: applications + club memberships
 * ------------------------------------------------------------------------- */

/**
 * Register application + club_member CPTs (private, admin UI only).
 */
function fba_register_phase3_cpts() {
	register_post_type(
		'application',
		array(
			'labels'        => array(
				'name'          => __( 'Applications', 'faithbridgeacademy' ),
				'singular_name' => __( 'Application', 'faithbridgeacademy' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'supports'      => array( 'title' ),
			'menu_icon'     => 'dashicons-clipboard',
			'menu_position' => 22,
			'capabilities'  => array( 'create_posts' => 'manage_options' ),
			'map_meta_cap'  => true,
		)
	);

	register_post_type(
		'faq',
		array(
			'labels'        => array(
				'name'          => __( 'FAQs', 'faithbridgeacademy' ),
				'singular_name' => __( 'FAQ', 'faithbridgeacademy' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'supports'      => array( 'title', 'editor', 'page-attributes' ),
			'menu_icon'     => 'dashicons-editor-help',
			'menu_position' => 25,
			'capabilities'  => array( 'create_posts' => 'manage_options' ),
			'map_meta_cap'  => true,
		)
	);

	register_post_type(
		'enquiry',
		array(
			'labels'        => array(
				'name'          => __( 'Enquiries', 'faithbridgeacademy' ),
				'singular_name' => __( 'Enquiry', 'faithbridgeacademy' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'supports'      => array( 'title', 'editor' ),
			'menu_icon'     => 'dashicons-email-alt',
			'menu_position' => 24,
			'capabilities'  => array( 'create_posts' => 'manage_options' ),
			'map_meta_cap'  => true,
		)
	);

	register_post_type(
		'club_member',
		array(
			'labels'        => array(
				'name'          => __( 'Club Members', 'faithbridgeacademy' ),
				'singular_name' => __( 'Club Member', 'faithbridgeacademy' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'supports'      => array( 'title' ),
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 23,
			'capabilities'  => array( 'create_posts' => 'manage_options' ),
			'map_meta_cap'  => true,
		)
	);
}
add_action( 'init', 'fba_register_phase3_cpts' );

/**
 * Current class/grade optgroups (classification only, never priced).
 *
 * @return array label => items
 */
function fba_class_optgroups() {
	return array(
		__( 'Early Years', 'faithbridgeacademy' )          => array( __( 'Nursery / Preschool', 'faithbridgeacademy' ), __( 'Kindergarten', 'faithbridgeacademy' ) ),
		__( 'Primary School', 'faithbridgeacademy' )      => array( __( 'Primary Grade 1', 'faithbridgeacademy' ), __( 'Primary Grade 2', 'faithbridgeacademy' ), __( 'Primary Grade 3', 'faithbridgeacademy' ), __( 'Primary Grade 4', 'faithbridgeacademy' ), __( 'Primary Grade 5', 'faithbridgeacademy' ), __( 'Primary Grade 6', 'faithbridgeacademy' ) ),
		__( 'Junior High', 'faithbridgeacademy' )         => array( __( 'Junior Grade 7', 'faithbridgeacademy' ), __( 'Junior Grade 8', 'faithbridgeacademy' ), __( 'Junior Grade 9', 'faithbridgeacademy' ) ),
		__( 'Senior High', 'faithbridgeacademy' )         => array( __( 'Senior Grade 10', 'faithbridgeacademy' ), __( 'Senior Grade 11', 'faithbridgeacademy' ), __( 'Senior Grade 12', 'faithbridgeacademy' ) ),
		__( 'Continuing Education', 'faithbridgeacademy' ) => array( __( 'Adult Literacy', 'faithbridgeacademy' ), __( 'Professional Upskilling', 'faithbridgeacademy' ) ),
		__( 'Other', 'faithbridgeacademy' )               => array( __( 'Other', 'faithbridgeacademy' ) ),
	);
}

/**
 * Open sessions list (current + upcoming quarter).
 *
 * @return array
 */
function fba_open_sessions() {
	$q    = (int) fba_get_option( 'session_quarter' );
	$year = (int) fba_get_option( 'session_year' );
	if ( $q < 1 || $q > 4 ) {
		$q = 4;
	}
	if ( $year < 2020 ) {
		$year = (int) gmdate( 'Y' );
	}
	$out   = array();
	$out[] = array( 'year' => $year, 'quarter' => $q );
	$nq    = $q % 4 + 1;
	$ny    = $nq === 1 ? $year + 1 : $year;
	$out[] = array( 'year' => $ny, 'quarter' => $nq );
	return $out;
}

/**
 * Session option label: "Session 4 · Oct–Dec 2026".
 *
 * @param int $year Year.
 * @param int $quarter Quarter.
 * @return string
 */
function fba_session_option_label( $year, $quarter ) {
	return sprintf( __( 'Session %1$d · %2$s %3$d', 'faithbridgeacademy' ), $quarter, fba_quarter_label( $quarter ), $year );
}

/**
 * Build an application reference: FBA-YYYY-QN-XXXX.
 *
 * @param int $year Year.
 * @param int $quarter Quarter.
 * @return string
 */
function fba_application_ref( $year, $quarter ) {
	return sprintf( 'FBA-%d-Q%d-%s', $year, $quarter, strtoupper( wp_generate_password( 4, false, false ) ) );
}

/**
 * Dedupe check: same phone + ward name + DOB + session already applied?
 *
 * @param string $phone Phone digits.
 * @param string $ward Ward name.
 * @param string $dob DOB (Y-m-d).
 * @param int    $year Year.
 * @param int    $quarter Quarter.
 * @return int|false Existing application ID or false.
 */
function fba_duplicate_application( $phone, $ward, $dob, $year, $quarter ) {
	$q = new WP_Query(
		array(
			'post_type'      => 'application',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_query'     => array(
				array( 'key' => '_fba_phone', 'value' => $phone ),
				array( 'key' => '_fba_ward_name', 'value' => $ward ),
				array( 'key' => '_fba_ward_dob', 'value' => $dob ),
				array( 'key' => '_fba_year', 'value' => (string) $year ),
				array( 'key' => '_fba_quarter', 'value' => (string) $quarter ),
			),
		)
	);
	if ( $q->have_posts() ) {
		return $q->posts[0]->ID;
	}
	return false;
}

/**
 * Totals for a set of programme IDs at one style, with rate snapshot.
 *
 * @param array  $programme_ids Programme IDs.
 * @param string $style group|one.
 * @return array {usd, ngn, rate, per}
 */
function fba_application_totals( $programme_ids, $style ) {
	$rate = (float) fba_get_option( 'exchange_rate' );
	if ( $rate <= 0 ) {
		$rate = 1500;
	}
	$usd = 0;
	$per = array();
	foreach ( (array) $programme_ids as $pid ) {
		$fees  = fba_programme_fees( (int) $pid );
		$fee   = 'one' === $style ? $fees['one'] : $fees['group'];
		$usd  += $fee;
		$per[] = array(
			'id'    => (int) $pid,
			'title' => get_the_title( (int) $pid ),
			'usd'   => $fee,
			'ngn'   => (int) ( ceil( $fee * $rate / 1000 ) * 1000 ),
		);
	}
	return array(
		'usd'  => $usd,
		'ngn'  => (int) ( ceil( $usd * $rate / 1000 ) * 1000 ),
		'rate' => $rate,
		'per'  => $per,
	);
}

/**
 * Bank extra group seats when an application is approved.
 *
 * @param int $app_id Application ID.
 */
function fba_bank_application_seats( $app_id ) {
	if ( 'approved' !== get_post_meta( $app_id, '_fba_app_status', true ) ) {
		return;
	}
	if ( get_post_meta( $app_id, '_fba_seats_banked', true ) ) {
		return;
	}
	$style = get_post_meta( $app_id, '_fba_style', true );
	if ( 'group' !== $style ) {
		update_post_meta( $app_id, '_fba_seats_banked', '1' );
		return;
	}
	$pids = get_post_meta( $app_id, '_fba_programmes', true );
	foreach ( (array) $pids as $pid ) {
		$pid      = (int) $pid;
		$enrolled = max( 0, (int) get_post_meta( $pid, '_fba_enrolled_group', true ) );
		update_post_meta( $pid, '_fba_enrolled_group', $enrolled + 1 );
	}
	update_post_meta( $app_id, '_fba_seats_banked', '1' );
}

/**
 * Application form handler (public, nonce-protected).
 */
function fba_application_handler() {
	if ( ! isset( $_POST['fba_apply_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_apply_nonce'] ) ), 'fba_apply' ) ) {
		wp_safe_redirect( add_query_arg( 'fba', 'error', fba_apply_url() ) );
		exit;
	}

	$kind      = isset( $_POST['fba_kind'] ) && 'sponsor' === $_POST['fba_kind'] ? 'sponsor' : 'self';
	$name      = isset( $_POST['fba_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_name'] ) ) : '';
	$phone_raw = isset( $_POST['fba_phone'] ) ? (string) wp_unslash( $_POST['fba_phone'] ) : '';
	$phone     = preg_replace( '/[^0-9+]/', '', $phone_raw );
	$email     = isset( $_POST['fba_email'] ) ? sanitize_email( wp_unslash( $_POST['fba_email'] ) ) : '';
	$relation  = isset( $_POST['fba_relation'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_relation'] ) ) : '';

	$ward_name  = isset( $_POST['fba_ward_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_ward_name'] ) ) : '';
	$ward_dob   = isset( $_POST['fba_ward_dob'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_ward_dob'] ) ) : '';
	$ward_class = isset( $_POST['fba_ward_class'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_ward_class'] ) ) : '';
	$style      = isset( $_POST['fba_style'] ) && 'one' === $_POST['fba_style'] ? 'one' : 'group';
	$session    = isset( $_POST['fba_session'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_session'] ) ) : '';
	$pids_raw   = isset( $_POST['fba_programmes'] ) ? (array) wp_unslash( $_POST['fba_programmes'] ) : array();

	if ( '' === $name || '' === $phone || '' === $ward_name || '' === $ward_dob || '' === $session || ! $pids_raw ) {
		wp_safe_redirect( add_query_arg( 'fba', 'missing', fba_apply_url() ) );
		exit;
	}
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $ward_dob ) ) {
		wp_safe_redirect( add_query_arg( 'fba', 'dob', fba_apply_url() ) );
		exit;
	}
	list( $year, $quarter ) = array_map( 'intval', explode( 'Q', $session ) + array( 0, 0 ) );
	if ( $year < 2020 || $quarter < 1 || $quarter > 4 ) {
		wp_safe_redirect( add_query_arg( 'fba', 'session', fba_apply_url() ) );
		exit;
	}
	$pids = array();
	foreach ( $pids_raw as $raw ) {
		$pid = (int) $raw;
		if ( $pid && 'programme' === get_post_type( $pid ) && 'publish' === get_post_status( $pid ) ) {
			$pids[] = $pid;
		}
	}
	if ( ! $pids ) {
		wp_safe_redirect( add_query_arg( 'fba', 'programmes', fba_apply_url() ) );
		exit;
	}

	$dup = fba_duplicate_application( $phone, $ward_name, $ward_dob, $year, $quarter );
	if ( $dup ) {
		$ref = get_post_meta( $dup, '_fba_ref', true );
		wp_safe_redirect( add_query_arg( array( 'fba' => 'duplicate', 'ref' => $ref ), fba_apply_url() ) );
		exit;
	}

	$totals = fba_application_totals( $pids, $style );
	$ref    = fba_application_ref( $year, $quarter );

	$app_id = wp_insert_post(
		array(
			'post_title'  => $ref . ' — ' . $ward_name,
			'post_status' => 'private',
			'post_type'   => 'application',
		)
	);
	if ( ! $app_id || is_wp_error( $app_id ) ) {
		wp_safe_redirect( add_query_arg( 'fba', 'error', fba_apply_url() ) );
		exit;
	}

	update_post_meta( $app_id, '_fba_ref', $ref );
	update_post_meta( $app_id, '_fba_app_status', 'pending' );
	update_post_meta( $app_id, '_fba_kind', $kind );
	update_post_meta( $app_id, '_fba_name', $name );
	update_post_meta( $app_id, '_fba_phone', $phone );
	update_post_meta( $app_id, '_fba_email', $email );
	update_post_meta( $app_id, '_fba_relation', $relation );
	update_post_meta( $app_id, '_fba_ward_name', $ward_name );
	update_post_meta( $app_id, '_fba_ward_dob', $ward_dob );
	update_post_meta( $app_id, '_fba_ward_class', $ward_class );
	update_post_meta( $app_id, '_fba_style', $style );
	update_post_meta( $app_id, '_fba_year', (string) $year );
	update_post_meta( $app_id, '_fba_quarter', (string) $quarter );
	update_post_meta( $app_id, '_fba_programmes', $pids );
	update_post_meta( $app_id, '_fba_total_usd', $totals['usd'] );
	update_post_meta( $app_id, '_fba_total_ngn', $totals['ngn'] );
	update_post_meta( $app_id, '_fba_rate', $totals['rate'] );

	wp_safe_redirect( add_query_arg( array( 'fba' => 'done', 'ref' => $ref ), fba_apply_url() ) );
	exit;
}
add_action( 'admin_post_nopriv_fba_apply', 'fba_application_handler' );
add_action( 'admin_post_fba_apply', 'fba_application_handler' );

/**
 * Application detail meta box (status + snapshot + follow-up).
 */
function fba_application_metabox() {
	add_meta_box( 'fba-application-details', __( 'Application Details', 'faithbridgeacademy' ), 'fba_application_metabox_html', 'application', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'fba_application_metabox' );

/**
 * Application meta box HTML.
 *
 * @param WP_Post $post Current post.
 */
function fba_application_metabox_html( $post ) {
	wp_nonce_field( 'fba_application_meta', 'fba_application_nonce' );
	$get = function ( $k ) use ( $post ) {
		return get_post_meta( $post->ID, $k, true );
	};
	$status   = $get( '_fba_app_status' ) ? $get( '_fba_app_status' ) : 'pending';
	$pids     = (array) $get( '_fba_programmes' );
	$titles   = array();
	foreach ( $pids as $pid ) {
		$titles[] = get_the_title( (int) $pid );
	}
	$followup = (int) fba_get_option( 'followup_days' );
	?>
	<p><strong><?php esc_html_e( 'Reference', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( $get( '_fba_ref' ) ); ?></p>
	<p><strong><?php esc_html_e( 'Applicant', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( $get( '_fba_name' ) . ' (' . $get( '_fba_kind' ) . ')' ); ?> · <?php echo esc_html( $get( '_fba_phone' ) ); ?> · <?php echo esc_html( $get( '_fba_email' ) ); ?>
	<?php if ( $get( '_fba_relation' ) ) : ?> · <?php echo esc_html( $get( '_fba_relation' ) ); ?><?php endif; ?></p>
	<p><strong><?php esc_html_e( 'Ward', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( $get( '_fba_ward_name' ) . ' · ' . $get( '_fba_ward_dob' ) . ' · ' . $get( '_fba_ward_class' ) ); ?></p>
	<p><strong><?php esc_html_e( 'Programmes', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( implode( ', ', $titles ) ); ?> (<?php echo esc_html( $get( '_fba_style' ) ); ?>, <?php echo esc_html( $get( '_fba_year' ) . '-Q' . $get( '_fba_quarter' ) ); ?>)</p>
	<p><strong><?php esc_html_e( 'Totals (snapshot)', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( '$' . number_format( (float) $get( '_fba_total_usd' ) ) . ' / ₦' . number_format( (float) $get( '_fba_total_ngn' ) ) . ' @ ' . $get( '_fba_rate' ) ); ?></p>
	<p><label for="fba-app-status"><?php esc_html_e( 'Status', 'faithbridgeacademy' ); ?></label><br>
	<select id="fba-app-status" name="fba_app_status">
		<?php foreach ( array( 'pending' => __( 'Pending', 'faithbridgeacademy' ), 'approved' => __( 'Approved', 'faithbridgeacademy' ), 'rejected' => __( 'Rejected', 'faithbridgeacademy' ) ) as $val => $label ) : ?>
			<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $status, $val ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select></p>
	<p><em><?php echo esc_html( sprintf( __( 'Follow up if still pending after %d days.', 'faithbridgeacademy' ), $followup ) ); ?></em></p>
	<?php
}

/**
 * Save application status; bank seats on approval.
 *
 * @param int $post_id Post ID.
 */
function fba_save_application_meta( $post_id ) {
	if ( ! isset( $_POST['fba_application_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_application_nonce'] ) ), 'fba_application_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['fba_app_status'] ) ) {
		$s = sanitize_key( wp_unslash( $_POST['fba_app_status'] ) );
		update_post_meta( $post_id, '_fba_app_status', in_array( $s, array( 'pending', 'approved', 'rejected' ), true ) ? $s : 'pending' );
		fba_bank_application_seats( $post_id );
		if ( 'approved' === $s ) {
			$user_id = (int) get_post_meta( $post_id, '_fba_user_id', true );
			foreach ( (array) get_post_meta( $post_id, '_fba_programmes', true ) as $cpid ) {
				fba_masteriyo_enrol( $user_id, (int) get_post_meta( (int) $cpid, '_fba_course_id', true ) );
			}
		}
	}
}
add_action( 'save_post_application', 'fba_save_application_meta' );

/**
 * Application admin columns.
 *
 * @param array $cols Columns.
 * @return array
 */
function fba_application_columns( $cols ) {
	$cols['fba_status'] = __( 'Status', 'faithbridgeacademy' );
	$cols['fba_total']  = __( 'Total', 'faithbridgeacademy' );
	return $cols;
}
add_filter( 'manage_application_posts_columns', 'fba_application_columns' );

/**
 * Application column values.
 *
 * @param string $col Column key.
 * @param int    $post_id Post ID.
 */
function fba_application_column_values( $col, $post_id ) {
	if ( 'fba_status' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_fba_app_status', true ) );
	} elseif ( 'fba_total' === $col ) {
		echo esc_html( '$' . number_format( (float) get_post_meta( $post_id, '_fba_total_usd', true ) ) . ' / ₦' . number_format( (float) get_post_meta( $post_id, '_fba_total_ngn', true ) ) );
	}
}
add_action( 'manage_application_posts_custom_column', 'fba_application_column_values', 10, 2 );

/**
 * Club annual fee in naira + dollar equivalent.
 *
 * @return array {ngn, usd}
 */
function fba_club_fee() {
	$ngn  = (float) fba_get_option( 'club_fee' );
	$rate = (float) fba_get_option( 'exchange_rate' );
	if ( $rate <= 0 ) {
		$rate = 1500;
	}
	return array( 'ngn' => $ngn, 'usd' => $ngn / $rate );
}

/**
 * Club join handler (public, nonce-protected). Payment confirmed offline,
 * membership active Jan–Dec of the current year.
 */
function fba_club_handler() {
	if ( ! isset( $_POST['fba_club_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_club_nonce'] ) ), 'fba_club' ) ) {
		wp_safe_redirect( add_query_arg( 'club', 'error', home_url( '/bible-club/' ) ) );
		exit;
	}
	$name  = isset( $_POST['fba_club_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_club_name'] ) ) : '';
	$phone = isset( $_POST['fba_club_phone'] ) ? preg_replace( '/[^0-9+]/', '', (string) wp_unslash( $_POST['fba_club_phone'] ) ) : '';
	$email = isset( $_POST['fba_club_email'] ) ? sanitize_email( wp_unslash( $_POST['fba_club_email'] ) ) : '';
	if ( '' === $name || '' === $phone ) {
		wp_safe_redirect( add_query_arg( 'club', 'missing', home_url( '/bible-club/' ) ) );
		exit;
	}
	$year = (int) gmdate( 'Y' );
	$fee  = fba_club_fee();

	$mid = wp_insert_post(
		array(
			'post_title'  => $name . ' — ' . $year,
			'post_status' => 'private',
			'post_type'   => 'club_member',
		)
	);
	if ( ! $mid || is_wp_error( $mid ) ) {
		wp_safe_redirect( add_query_arg( 'club', 'error', home_url( '/bible-club/' ) ) );
		exit;
	}
	update_post_meta( $mid, '_fba_club_status', 'active' );
	update_post_meta( $mid, '_fba_club_name', $name );
	update_post_meta( $mid, '_fba_club_phone', $phone );
	update_post_meta( $mid, '_fba_club_email', $email );
	update_post_meta( $mid, '_fba_club_year', (string) $year );
	update_post_meta( $mid, '_fba_club_fee_ngn', $fee['ngn'] );
	update_post_meta( $mid, '_fba_club_fee_usd', round( $fee['usd'], 2 ) );

	wp_safe_redirect( add_query_arg( 'club', 'done', home_url( '/bible-club/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_fba_club', 'fba_club_handler' );
add_action( 'admin_post_fba_club', 'fba_club_handler' );

/**
 * Club member detail meta box.
 */
function fba_club_metabox() {
	add_meta_box( 'fba-club-details', __( 'Membership Details', 'faithbridgeacademy' ), 'fba_club_metabox_html', 'club_member', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'fba_club_metabox' );

/**
 * Club meta box HTML.
 *
 * @param WP_Post $post Current post.
 */
function fba_club_metabox_html( $post ) {
	wp_nonce_field( 'fba_club_meta', 'fba_club_nonce' );
	$status = get_post_meta( $post->ID, '_fba_club_status', true );
	?>
	<p><strong><?php esc_html_e( 'Member', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( get_post_meta( $post->ID, '_fba_club_name', true ) . ' · ' . get_post_meta( $post->ID, '_fba_club_phone', true ) . ' · ' . get_post_meta( $post->ID, '_fba_club_email', true ) ); ?></p>
	<p><strong><?php esc_html_e( 'Year / fee snapshot', 'faithbridgeacademy' ); ?>:</strong> <?php echo esc_html( get_post_meta( $post->ID, '_fba_club_year', true ) . ' · ₦' . number_format( (float) get_post_meta( $post->ID, '_fba_club_fee_ngn', true ) ) ); ?></p>
	<p><label for="fba-club-status"><?php esc_html_e( 'Status', 'faithbridgeacademy' ); ?></label><br>
	<select id="fba-club-status" name="fba_club_status">
		<?php foreach ( array( 'active' => __( 'Active', 'faithbridgeacademy' ), 'expired' => __( 'Expired', 'faithbridgeacademy' ) ) as $val => $label ) : ?>
			<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $status, $val ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select></p>
	<p><em><?php esc_html_e( 'Membership runs Jan–Dec each year. Mark expired members for renewal follow-up in January.', 'faithbridgeacademy' ); ?></em></p>
	<?php
}

/**
 * Save club status.
 *
 * @param int $post_id Post ID.
 */
function fba_save_club_meta( $post_id ) {
	if ( ! isset( $_POST['fba_club_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_club_nonce'] ) ), 'fba_club_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['fba_club_status'] ) ) {
		$s = sanitize_key( wp_unslash( $_POST['fba_club_status'] ) );
		update_post_meta( $post_id, '_fba_club_status', 'expired' === $s ? 'expired' : 'active' );
	}
}
add_action( 'save_post_club_member', 'fba_save_club_meta' );

/**
 * Enquiry handler (public, nonce-protected). Stores private record for admin.
 */
function fba_enquiry_handler() {
	if ( ! isset( $_POST['fba_enquiry_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['fba_enquiry_nonce'] ) ), 'fba_enquiry' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', home_url( '/contact/' ) ) );
		exit;
	}
	$name    = isset( $_POST['fba_enquiry_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fba_enquiry_name'] ) ) : '';
	$phone   = isset( $_POST['fba_enquiry_phone'] ) ? preg_replace( '/[^0-9+]/', '', (string) wp_unslash( $_POST['fba_enquiry_phone'] ) ) : '';
	$email   = isset( $_POST['fba_enquiry_email'] ) ? sanitize_email( wp_unslash( $_POST['fba_enquiry_email'] ) ) : '';
	$message = isset( $_POST['fba_enquiry_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['fba_enquiry_message'] ) ) : '';
	if ( '' === $name || '' === $message || ( '' === $phone && '' === $email ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'missing', home_url( '/contact/' ) ) );
		exit;
	}
	$eid = wp_insert_post(
		array(
			'post_title'   => $name . ' — ' . gmdate( 'Y-m-d H:i' ),
			'post_content' => $message,
			'post_status'  => 'private',
			'post_type'    => 'enquiry',
		)
	);
	if ( $eid && ! is_wp_error( $eid ) ) {
		update_post_meta( $eid, '_fba_enquiry_name', $name );
		update_post_meta( $eid, '_fba_enquiry_phone', $phone );
		update_post_meta( $eid, '_fba_enquiry_email', $email );
	}
	wp_safe_redirect( add_query_arg( 'sent', 'done', home_url( '/contact/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_fba_enquiry', 'fba_enquiry_handler' );
add_action( 'admin_post_fba_enquiry', 'fba_enquiry_handler' );

/**
 * Club member admin columns.
 *
 * @param array $cols Columns.
 * @return array
 */
function fba_club_columns( $cols ) {
	$cols['fba_status'] = __( 'Status', 'faithbridgeacademy' );
	$cols['fba_year']   = __( 'Year', 'faithbridgeacademy' );
	return $cols;
}
add_filter( 'manage_club_member_posts_columns', 'fba_club_columns' );

/**
 * Club column values.
 *
 * @param string $col Column key.
 * @param int    $post_id Post ID.
 */
function fba_club_column_values( $col, $post_id ) {
	if ( 'fba_status' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_fba_club_status', true ) );
	} elseif ( 'fba_year' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_fba_club_year', true ) );
	}
}
add_action( 'manage_club_member_posts_custom_column', 'fba_club_column_values', 10, 2 );
