<?php
/**
 * Homepage — FaithBridge Academy.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();

$kses = array(
	'br'   => array(),
	'span' => array( 'class' => array() ),
);

$slides = array(
	array(
		'align' => 'center',
		'img'   => $uri . '/assets/images/hero-1.jpg',
		'eye'   => '',
		'title' => __( 'Intentional Faith.<br><span class="hl">Confident Children.</span>', 'faithbridgeacademy' ),
		'text'  => __( 'Nurturing the whole child — spirit, mind and character — in partnership with parents.', 'faithbridgeacademy' ),
		'cta1'  => array( __( 'Explore Programmes', 'faithbridgeacademy' ), home_url( '/programmes/' ) ),
		'cta2'  => array( __( 'Apply Now', 'faithbridgeacademy' ), home_url( '/apply/' ) ),
	),
	array(
		'align' => 'left',
		'img'   => $uri . '/assets/images/bible-study.jpg',
		'eye'   => '',
		'title' => __( 'Bible Study:<br><span class="hl">Rooted in Christ.</span>', 'faithbridgeacademy' ),
		'text'  => __( 'Scripture, character and practical faith — live on Google Meet, with recordings.', 'faithbridgeacademy' ),
		'cta1'  => array( __( 'Discover Bible Study', 'faithbridgeacademy' ), home_url( '/programmes/' ) ),
		'cta2'  => array( __( 'View Fees', 'faithbridgeacademy' ), home_url( '/fees/' ) ),
	),
	array(
		'align' => 'right',
		'img'   => $uri . '/assets/images/online-class.jpg',
		'eye'   => '',
		'title' => __( 'A Stronger<br><span class="hl">Foundation.</span>', 'faithbridgeacademy' ),
		'text'  => __( 'Live classes Tuesdays and Saturdays, 5 PM Nigeria Time. Group and one-on-one.', 'faithbridgeacademy' ),
		'cta1'  => array( __( 'Apply Now', 'faithbridgeacademy' ), home_url( '/apply/' ) ),
		'cta2'  => array( __( 'Talk to Us', 'faithbridgeacademy' ), home_url( '/contact/' ) ),
	),
	array(
		'align' => 'left',
		'img'   => $uri . '/assets/images/why-2.jpg',
		'eye'   => '',
		'title' => __( 'Seventeen Paths.<br><span class="hl">One Method.</span>', 'faithbridgeacademy' ),
		'text'  => __( 'Languages, sciences and more — one intentional method, every quarter.', 'faithbridgeacademy' ),
		'cta1'  => array( __( 'View Programmes', 'faithbridgeacademy' ), home_url( '/programmes/' ) ),
		'cta2'  => array( __( 'View Fees', 'faithbridgeacademy' ), home_url( '/fees/' ) ),
	),
	array(
		'align' => 'right',
		'img'   => $uri . '/assets/images/hero-3.jpg',
		'eye'   => '',
		'title' => __( 'Every Child<br><span class="hl">Known & Celebrated.</span>', 'faithbridgeacademy' ),
		'text'  => __( 'Small groups, caring facilitators, parents carried along every step.', 'faithbridgeacademy' ),
		'cta1'  => array( __( 'How It Works', 'faithbridgeacademy' ), home_url( '/about/' ) ),
		'cta2'  => array( __( 'Apply Now', 'faithbridgeacademy' ), home_url( '/apply/' ) ),
	),
	array(
		'align' => 'left',
		'img'   => $uri . '/assets/images/life-band.jpg',
		'eye'   => '',
		'title' => __( 'A Family<br><span class="hl">of Faith.</span>', 'faithbridgeacademy' ),
		'text'  => __( 'Monthly Bible Club — where children belong, participate and grow.', 'faithbridgeacademy' ),
		'cta1'  => array( __( 'Join the Bible Club', 'faithbridgeacademy' ), home_url( '/bible-club/' ) ),
		'cta2'  => array( __( 'Apply Now', 'faithbridgeacademy' ), home_url( '/apply/' ) ),
	),
);
?>

<section class="fba-hero" id="fbaSlider" role="region" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Highlights', 'faithbridgeacademy' ); ?>">
	<div class="fba-slides">
		<?php foreach ( $slides as $i => $s ) : ?>
		<div class="fba-slide fba-align-<?php echo esc_attr( $s['align'] ); ?><?php echo 0 === $i ? ' active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( sprintf( __( '%1$d of %2$d', 'faithbridgeacademy' ), $i + 1, count( $slides ) ) ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>"<?php echo 0 === $i ? '' : ' inert'; ?> style="background-image:url('<?php echo esc_url( $s['img'] ); ?>')">
			<div class="fba-wrap fba-slide-content">
				<?php if ( 0 === $i ) : ?>
				<h1 class="fba-hero-title"><?php echo wp_kses( $s['title'], $kses ); ?></h1>
				<?php else : ?>
				<h2 class="fba-hero-title"><?php echo wp_kses( $s['title'], $kses ); ?></h2>
				<?php endif; ?>
				<p class="fba-hero-text"><?php echo esc_html( $s['text'] ); ?></p>
				<p class="fba-hero-actions">
					<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( $s['cta1'][1] ); ?>"><?php echo esc_html( $s['cta1'][0] ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
					<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( $s['cta2'][1] ); ?>"><?php echo esc_html( $s['cta2'][0] ); ?></a>
				</p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="fba-wrap fba-slider-ui">
		<div class="fba-slider-dots" id="fbaSliderDots" role="tablist" aria-label="<?php esc_attr_e( 'Slides', 'faithbridgeacademy' ); ?>"></div>
	</div>
</section>

<section class="fba-stats" aria-label="<?php esc_attr_e( 'FaithBridge at a glance', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap fba-stats-grid">
		<div class="fba-stat reveal">
			<span class="fba-stat-num" data-count="17">0</span>
			<span class="fba-stat-label"><?php esc_html_e( 'Programmes Offered', 'faithbridgeacademy' ); ?></span>
		</div>
		<div class="fba-stat reveal">
			<span class="fba-stat-num" data-count="4" data-suffix="">0</span>
			<span class="fba-stat-label"><?php esc_html_e( 'Sessions Every Year', 'faithbridgeacademy' ); ?></span>
		</div>
		<div class="fba-stat reveal">
			<span class="fba-stat-num" data-count="15">0</span>
			<span class="fba-stat-label"><?php esc_html_e( 'Max Per Group Class', 'faithbridgeacademy' ); ?></span>
		</div>
		<div class="fba-stat reveal">
			<span class="fba-stat-num" data-count="100" data-suffix="%">0</span>
			<span class="fba-stat-label"><?php esc_html_e( 'Live Online on Google Meet', 'faithbridgeacademy' ); ?></span>
		</div>
	</div>
</section>

<section class="fba-section fba-why" aria-label="<?php esc_attr_e( 'Why FaithBridge', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap fba-why-grid">
		<div class="reveal">
			<p class="fba-kicker"><?php esc_html_e( 'Why FaithBridge Academy?', 'faithbridgeacademy' ); ?></p>
			<h2 class="fba-section-title"><?php esc_html_e( 'Education That Empowers You For Life', 'faithbridgeacademy' ); ?></h2>
			<p class="fba-lead"><?php esc_html_e( 'We bring together faith, learning and character so children develop as whole individuals — spirit, mind and character.', 'faithbridgeacademy' ); ?></p>
			<ul class="fba-why-list">
				<li>
					<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-cross"></i></span>
					<div>
						<strong><?php esc_html_e( 'Faith-Rooted Teaching', 'faithbridgeacademy' ); ?></strong>
						<span><?php esc_html_e( 'Every lesson is intentionally built around Christian faith, biblical truth and values.', 'faithbridgeacademy' ); ?></span>
					</div>
				</li>
				<li>
					<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-heart"></i></span>
					<div>
						<strong><?php esc_html_e( 'Whole-Child Development', 'faithbridgeacademy' ); ?></strong>
						<span><?php esc_html_e( 'Spiritual, intellectual, moral and personal growth — never academics alone.', 'faithbridgeacademy' ); ?></span>
					</div>
				</li>
				<li>
					<span class="fba-why-icon" aria-hidden="true"><i class="ph ph-chalkboard-teacher"></i></span>
					<div>
						<strong><?php esc_html_e( 'Intentional, Child-Centred Classes', 'faithbridgeacademy' ); ?></strong>
						<span><?php esc_html_e( 'Structured curriculum, small groups of 15 or fewer, and one-on-one options — online and personal.', 'faithbridgeacademy' ); ?></span>
					</div>
				</li>
			</ul>
		</div>
		<div class="fba-why-collage reveal">
			<img class="fba-why-main" src="<?php echo esc_url( $uri . '/assets/images/why-1.jpg' ); ?>" alt="<?php esc_attr_e( 'A student learning with confidence', 'faithbridgeacademy' ); ?>" loading="lazy">
			<img class="fba-why-small fba-why-small-a" src="<?php echo esc_url( $uri . '/assets/images/why-2.jpg' ); ?>" alt="<?php esc_attr_e( 'Children learning together', 'faithbridgeacademy' ); ?>" loading="lazy">
			<img class="fba-why-small fba-why-small-b" src="<?php echo esc_url( $uri . '/assets/images/hero-3.jpg' ); ?>" alt="<?php esc_attr_e( 'Study and Scripture', 'faithbridgeacademy' ); ?>" loading="lazy">
		</div>
	</div>
</section>

<section class="fba-section fba-programs" aria-label="<?php esc_attr_e( 'Popular programmes', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap">
		<div class="fba-section-head reveal">
			<div>
				<p class="fba-kicker"><?php esc_html_e( 'Popular programmes', 'faithbridgeacademy' ); ?></p>
				<h2 class="fba-section-title"><?php esc_html_e( 'One Academy, Many Paths to Grow', 'faithbridgeacademy' ); ?></h2>
			</div>
			<a class="fba-link-arrow" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'View All Programmes', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
		</div>
		<div class="fba-program-grid">
			<a class="fba-program-card fba-program-featured reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-tag"><?php esc_html_e( 'Flagship', 'faithbridgeacademy' ); ?></span>
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-book-open"></i></span>
				<strong><?php esc_html_e( 'Bible Study', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Know God deeply, love Him sincerely, and live out your faith with confidence every day.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-quotes"></i></span>
				<strong><?php esc_html_e( 'English', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Read widely, write clearly and speak with poise in every room you enter.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-star"></i></span>
				<strong><?php esc_html_e( 'Mathematics', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Strong foundations and fearless problem-solving, from basics to brilliance.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-globe-stand"></i></span>
				<strong><?php esc_html_e( 'French', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'A second language learned joyfully — speak, sing and shine en français.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true"><i class="ph ph-graduation-cap"></i></span>
				<strong><?php esc_html_e( 'Sciences & More', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Physics, Chemistry, Biology, ICT, Government — thirteen paths and counting.', 'faithbridgeacademy' ); ?></span>
			</a>
		</div>
	</div>
</section>

<section class="fba-life" aria-label="<?php esc_attr_e( 'Faith and community life', 'faithbridgeacademy' ); ?>" style="background-image:url('<?php echo esc_url( $uri . '/assets/images/life-band.jpg' ); ?>')">
	<div class="fba-life-overlay" aria-hidden="true"></div>
	<div class="fba-wrap">
		<div class="fba-life-inner reveal">
			<p class="fba-kicker fba-kicker-light"><?php esc_html_e( 'Faith & community life', 'faithbridgeacademy' ); ?></p>
			<h2><?php esc_html_e( 'Beyond Classrooms: A Family of Faith', 'faithbridgeacademy' ); ?></h2>
			<p><?php esc_html_e( 'Monthly Bible Club gatherings, Scripture memory, worship and service — where children belong, participate and grow in community.', 'faithbridgeacademy' ); ?></p>
			<p class="fba-life-actions">
				<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/bible-club/' ) ); ?>"><?php esc_html_e( 'Discover More', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
			</p>
		</div>
	</div>
</section>

<section class="fba-section fba-news" aria-label="<?php esc_attr_e( 'News and updates', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap">
		<div class="fba-section-head reveal">
			<div>
				<p class="fba-kicker"><?php esc_html_e( 'News & updates', 'faithbridgeacademy' ); ?></p>
				<h2 class="fba-section-title"><?php esc_html_e( 'Stories From the Academy', 'faithbridgeacademy' ); ?></h2>
			</div>
			<a class="fba-link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'View All News', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
		</div>
		<div class="fba-news-grid">
			<?php
			$news = new WP_Query(
				array(
					'posts_per_page' => 3,
					'post_status'    => 'publish',
				)
			);
			if ( $news->have_posts() ) :
				while ( $news->have_posts() ) :
					$news->the_post();
					?>
					<article class="fba-news-card reveal">
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
							<a class="fba-link-arrow" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				$fallbacks = array(
					array( 'news-1.jpg', 'Admissions Open for Session 4 (Oct–Dec 2026)' ),
					array( 'news-2.jpg', 'Why Scripture Memory Shapes Character' ),
					array( 'news-3.jpg', 'How Our Live Online Classes Work' ),
				);
				foreach ( $fallbacks as $f ) :
					?>
					<article class="fba-news-card reveal">
						<span class="fba-news-thumb" aria-hidden="true"><img src="<?php echo esc_url( $uri . '/assets/images/' . $f[0] ); ?>" alt="" loading="lazy"></span>
						<div class="fba-news-body">
							<p class="fba-news-date"><?php esc_html_e( 'FaithBridge Academy', 'faithbridgeacademy' ); ?></p>
							<h3><?php echo esc_html( $f[1] ); ?></h3>
							<a class="fba-link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Read More', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
						</div>
					</article>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
</section>

<section class="fba-panel" aria-label="<?php esc_attr_e( 'Sessions and quick links', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap">
		<div class="fba-section-head reveal">
			<div>
				<p class="fba-kicker fba-kicker-light"><?php esc_html_e( 'Session calendar', 'faithbridgeacademy' ); ?></p>
				<h2 class="fba-section-title fba-title-light"><?php esc_html_e( 'Four Sessions, Every Year', 'faithbridgeacademy' ); ?></h2>
				<p class="fba-panel-sub"><?php esc_html_e( 'Pick the quarter that suits your family. Applications open for the current and upcoming sessions.', 'faithbridgeacademy' ); ?></p>
			</div>
		</div>
		<div class="fba-quarter-grid">
			<?php
			$quarters = array(
				'1' => array( 'Jan–Mar', __( 'Fresh beginnings', 'faithbridgeacademy' ) ),
				'2' => array( 'Apr–Jun', __( 'Growth season', 'faithbridgeacademy' ) ),
				'3' => array( 'Jul–Sep', __( 'Deepening roots', 'faithbridgeacademy' ) ),
				'4' => array( 'Oct–Dec', __( 'Fruitful finish', 'faithbridgeacademy' ) ),
			);
			$current  = (string) fba_get_option( 'session_quarter' );
			foreach ( $quarters as $q => $meta ) :
				$is_current = ( $q === $current );
				?>
				<article class="fba-quarter-card<?php echo $is_current ? ' fba-quarter-current' : ''; ?> reveal">
					<?php if ( $is_current ) : ?>
						<span class="fba-quarter-badge"><i class="ph ph-sparkle" aria-hidden="true"></i> <?php esc_html_e( 'Now enrolling', 'faithbridgeacademy' ); ?></span>
					<?php endif; ?>
					<span class="fba-quarter-num" aria-hidden="true"><?php echo esc_html( 'Q' . $q ); ?></span>
					<h3><?php echo esc_html( sprintf( __( 'Session %s', 'faithbridgeacademy' ), $q ) ); ?></h3>
					<p class="fba-quarter-months"><?php echo esc_html( $meta[0] ); ?></p>
					<p class="fba-quarter-theme"><?php echo esc_html( $meta[1] ); ?></p>
					<?php if ( $is_current ) : ?>
						<p class="fba-quarter-period"><?php echo esc_html( fba_get_option( 'session_period' ) ); ?></p>
					<?php endif; ?>
					<a class="fba-link-arrow fba-link-gold" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
				</article>
			<?php endforeach; ?>
		</div>
		<ul class="fba-quicklinks reveal">
			<li><a href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><i class="ph ph-graduation-cap" aria-hidden="true"></i> <?php esc_html_e( 'Admissions & Application', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></li>
			<li><a href="<?php echo esc_url( home_url( '/fees/' ) ); ?>"><i class="ph ph-star" aria-hidden="true"></i> <?php esc_html_e( 'Fees & Sessions', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></li>
			<li><a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><i class="ph ph-book-open" aria-hidden="true"></i> <?php esc_html_e( 'All Programmes', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></li>
			<li><a href="<?php echo esc_url( home_url( '/resources/' ) ); ?>"><i class="ph ph-globe-stand" aria-hidden="true"></i> <?php esc_html_e( 'Learning Resources', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></li>
			<li><a href="<?php echo esc_url( home_url( '/bible-club/' ) ); ?>"><i class="ph ph-hands-praying" aria-hidden="true"></i> <?php esc_html_e( 'Bible Club', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></li>
			<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><i class="ph ph-envelope-simple" aria-hidden="true"></i> <?php esc_html_e( 'Contact Us', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></li>
		</ul>
	</div>
</section>

<section class="fba-section fba-cta-zone" aria-label="<?php esc_attr_e( 'Call to action', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap">
		<div class="fba-cta-panel reveal">
			<span class="fba-cta-ring" aria-hidden="true"></span>
			<div class="fba-cta-copy">
				<p class="fba-kicker fba-kicker-light"><?php esc_html_e( 'Begin the journey', 'faithbridgeacademy' ); ?></p>
				<h2><?php esc_html_e( 'Give Your Child a Stronger Foundation.', 'faithbridgeacademy' ); ?></h2>
				<p><?php esc_html_e( 'Faith, values, knowledge and character are built over time. Start intentionally — applications take minutes.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-cta-actions">
					<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
					<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Explore Programmes', 'faithbridgeacademy' ); ?></a>
				</p>
			</div>
			<aside class="fba-cta-session">
				<p class="fba-cta-session-label"><i class="ph ph-calendar-check" aria-hidden="true"></i> <?php esc_html_e( 'Now enrolling', 'faithbridgeacademy' ); ?></p>
				<p class="fba-cta-session-title"><?php echo esc_html( fba_get_option( 'session_label' ) ); ?></p>
				<p class="fba-cta-session-period"><?php echo esc_html( fba_get_option( 'session_period' ) ); ?></p>
				<p class="fba-cta-session-days"><?php echo esc_html( fba_get_option( 'class_days' ) . ' · ' . fba_get_option( 'class_time' ) ); ?></p>
			</aside>
		</div>
	</div>
</section>

<section class="fba-section fba-homefeel" aria-label="<?php esc_attr_e( 'Learning that feels like home', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap fba-homefeel-grid">
		<img class="reveal" src="<?php echo esc_url( $uri . '/assets/images/home-feel.jpg' ); ?>" alt="<?php esc_attr_e( 'A child learning at home', 'faithbridgeacademy' ); ?>" loading="lazy">
		<div class="reveal">
			<p class="fba-kicker"><?php esc_html_e( 'The FaithBridge experience', 'faithbridgeacademy' ); ?></p>
			<h2 class="fba-section-title"><?php esc_html_e( 'Learning That Feels Like Home', 'faithbridgeacademy' ); ?></h2>
			<p class="fba-lead"><?php esc_html_e( 'Calm, structured, personal — an online academy where your child is known, guided and celebrated.', 'faithbridgeacademy' ); ?></p>
			<ul class="fba-checklist">
				<li><?php esc_html_e( 'Small group classes — 15 learners or fewer', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'One-on-one options for focused support', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'Caring facilitators who know your child', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'Parents carried along every step', 'faithbridgeacademy' ); ?></li>
				<li><?php esc_html_e( 'Safe, faith-filled online environment', 'faithbridgeacademy' ); ?></li>
			</ul>
			<p><a class="fba-btn fba-btn-navy" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'How It Works', 'faithbridgeacademy' ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a></p>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
