<?php
/**
 * Homepage — FaithBridge Academy.
 *
 * @package FaithBridgeAcademy
 */

get_header();
$uri = get_template_directory_uri();
?>

<section class="fba-hero" id="fbaSlider" role="region" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Highlights', 'faithbridgeacademy' ); ?>">
	<div class="fba-slides">
		<div class="fba-slide active" role="group" aria-roledescription="slide" aria-label="1 of 3" style="background-image:url('<?php echo esc_url( $uri . '/assets/images/hero-1.jpg' ); ?>')">
			<div class="fba-wrap fba-slide-content">
				<p class="fba-hero-kicker"><?php esc_html_e( 'Intentional Faith. Structured Learning. Confident Children.', 'faithbridgeacademy' ); ?></p>
				<h1 class="fba-hero-title"><?php esc_html_e( 'Raising Children Who Know God, Love God, and Live for Him.', 'faithbridgeacademy' ); ?></h1>
				<p class="fba-hero-text"><?php esc_html_e( 'FaithBridge Academy nurtures the whole child — spirit, mind and character — through faith-based programmes and personal academic support, in partnership with parents.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-hero-actions">
					<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php echo esc_html( fba_get_option( 'hero_cta_primary' ) ); ?> <span aria-hidden="true">&rarr;</span></a>
					<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php echo esc_html( fba_get_option( 'hero_cta_secondary' ) ); ?></a>
				</p>
			</div>
		</div>
		<div class="fba-slide" role="group" aria-roledescription="slide" aria-label="2 of 3" aria-hidden="true" inert style="background-image:url('<?php echo esc_url( $uri . '/assets/images/bible-study.jpg' ); ?>')">
			<div class="fba-wrap fba-slide-content">
				<p class="fba-hero-kicker"><?php esc_html_e( 'Flagship programme', 'faithbridgeacademy' ); ?></p>
				<h2 class="fba-hero-title"><?php esc_html_e( 'Bible Study: Rooted in Christ.', 'faithbridgeacademy' ); ?></h2>
				<p class="fba-hero-text"><?php esc_html_e( 'Biblical foundation, character formation, Scripture memory and practical faith — taught live on Google Meet, with recordings for every enrolled student.', 'faithbridgeacademy' ); ?></p>
				<p class="fba-hero-actions">
					<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Discover Bible Study', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
					<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( home_url( '/fees/' ) ); ?>"><?php esc_html_e( 'View Fees', 'faithbridgeacademy' ); ?></a>
				</p>
			</div>
		</div>
		<div class="fba-slide" role="group" aria-roledescription="slide" aria-label="3 of 3" aria-hidden="true" inert style="background-image:url('<?php echo esc_url( $uri . '/assets/images/online-class.jpg' ); ?>')">
			<div class="fba-wrap fba-slide-content">
				<p class="fba-hero-kicker"><?php echo esc_html( fba_get_option( 'session_label' ) . ' · ' . fba_get_option( 'session_period' ) ); ?></p>
				<h2 class="fba-hero-title"><?php esc_html_e( 'Admissions Are Open. Start Intentionally.', 'faithbridgeacademy' ); ?></h2>
				<p class="fba-hero-text"><?php echo esc_html( sprintf( __( 'Live %1$s classes hold %2$s at %3$s. Group and one-on-one study styles available.', 'faithbridgeacademy' ), fba_get_option( 'platform' ), fba_get_option( 'class_days' ), fba_get_option( 'class_time' ) ) ); ?></p>
				<p class="fba-hero-actions">
					<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
					<a class="fba-btn fba-btn-outline-light" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Talk to Us', 'faithbridgeacademy' ); ?></a>
				</p>
			</div>
		</div>
	</div>
	<div class="fba-wrap fba-slider-ui">
		<div class="fba-slider-dots" role="tablist" aria-label="<?php esc_attr_e( 'Slides', 'faithbridgeacademy' ); ?>">
			<button class="active" role="tab" aria-selected="true" aria-label="<?php esc_attr_e( 'Slide 1', 'faithbridgeacademy' ); ?>" data-slide="0"></button>
			<button role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 2', 'faithbridgeacademy' ); ?>" data-slide="1"></button>
			<button role="tab" aria-selected="false" aria-label="<?php esc_attr_e( 'Slide 3', 'faithbridgeacademy' ); ?>" data-slide="2"></button>
		</div>
	</div>
	<button class="fba-slider-arrow fba-slider-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'faithbridgeacademy' ); ?>">&larr;</button>
	<button class="fba-slider-arrow fba-slider-next" aria-label="<?php esc_attr_e( 'Next slide', 'faithbridgeacademy' ); ?>">&rarr;</button>
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
					<span class="fba-why-icon" aria-hidden="true">&#10013;</span>
					<div>
						<strong><?php esc_html_e( 'Faith-Rooted Teaching', 'faithbridgeacademy' ); ?></strong>
						<span><?php esc_html_e( 'Every lesson is intentionally built around Christian faith, biblical truth and values.', 'faithbridgeacademy' ); ?></span>
					</div>
				</li>
				<li>
					<span class="fba-why-icon" aria-hidden="true">&#10022;</span>
					<div>
						<strong><?php esc_html_e( 'Whole-Child Development', 'faithbridgeacademy' ); ?></strong>
						<span><?php esc_html_e( 'Spiritual, intellectual, moral and personal growth — never academics alone.', 'faithbridgeacademy' ); ?></span>
					</div>
				</li>
				<li>
					<span class="fba-why-icon" aria-hidden="true">&#9673;</span>
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
			<a class="fba-link-arrow" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'View All Programmes', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</div>
		<div class="fba-program-grid">
			<a class="fba-program-card fba-program-featured reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-tag"><?php esc_html_e( 'Flagship', 'faithbridgeacademy' ); ?></span>
				<span class="fba-program-icon" aria-hidden="true">&#10013;</span>
				<strong><?php esc_html_e( 'Bible Study', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Know God, love God, live for Him.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true">Aa</span>
				<strong><?php esc_html_e( 'English', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Read, write and speak with confidence.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true">&pi;</span>
				<strong><?php esc_html_e( 'Mathematics', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Strong foundations, fearless problem-solving.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true">Fr</span>
				<strong><?php esc_html_e( 'French', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'A second language, learned joyfully.', 'faithbridgeacademy' ); ?></span>
			</a>
			<a class="fba-program-card reveal" href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>">
				<span class="fba-program-icon" aria-hidden="true">&#9881;</span>
				<strong><?php esc_html_e( 'Sciences & More', 'faithbridgeacademy' ); ?></strong>
				<span><?php esc_html_e( 'Physics, Chemistry, Biology, ICT and beyond.', 'faithbridgeacademy' ); ?></span>
			</a>
		</div>
	</div>
</section>

<section class="fba-life" aria-label="<?php esc_attr_e( 'Faith and community life', 'faithbridgeacademy' ); ?>" style="background-image:url('<?php echo esc_url( $uri . '/assets/images/life-band.jpg' ); ?>')">
	<div class="fba-life-overlay" aria-hidden="true"></div>
	<div class="fba-wrap fba-life-inner reveal">
		<p class="fba-kicker fba-kicker-light"><?php esc_html_e( 'Faith & community life', 'faithbridgeacademy' ); ?></p>
		<h2><?php esc_html_e( 'Beyond Classrooms: A Family of Faith', 'faithbridgeacademy' ); ?></h2>
		<p><?php esc_html_e( 'Monthly Bible Club gatherings, Scripture memory, worship and service — where children belong, participate and grow in community.', 'faithbridgeacademy' ); ?></p>
		<p class="fba-life-actions">
			<a class="fba-btn fba-btn-gold" href="<?php echo esc_url( home_url( '/bible-club/' ) ); ?>"><?php esc_html_e( 'Discover More', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</p>
	</div>
</section>

<section class="fba-section fba-news" aria-label="<?php esc_attr_e( 'News and updates', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap">
		<div class="fba-section-head reveal">
			<div>
				<p class="fba-kicker"><?php esc_html_e( 'News & updates', 'faithbridgeacademy' ); ?></p>
				<h2 class="fba-section-title"><?php esc_html_e( 'Stories From the Academy', 'faithbridgeacademy' ); ?></h2>
			</div>
			<a class="fba-link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'View All News', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
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
							<a class="fba-link-arrow" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
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
							<a class="fba-link-arrow" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Read More', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
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
	<div class="fba-wrap fba-panel-grid">
		<div class="reveal">
			<p class="fba-kicker fba-kicker-light"><?php esc_html_e( 'Session calendar', 'faithbridgeacademy' ); ?></p>
			<h2><?php esc_html_e( 'Four Sessions, Every Year', 'faithbridgeacademy' ); ?></h2>
			<p class="fba-panel-sub"><?php esc_html_e( 'Pick the quarter that suits your family. Applications open for the current and upcoming sessions.', 'faithbridgeacademy' ); ?></p>
			<ul class="fba-session-list">
				<?php
				$quarters = array( '1' => 'Jan–Mar', '2' => 'Apr–Jun', '3' => 'Jul–Sep', '4' => 'Oct–Dec' );
				$current  = (string) fba_get_option( 'session_quarter' );
				foreach ( $quarters as $q => $label ) :
					$active = ( $q === $current ) ? ' fba-session-current' : '';
					?>
					<li class="fba-session-item<?php echo esc_attr( $active ); ?>">
						<span class="fba-session-q"><?php echo esc_html( 'Q' . $q ); ?><small><?php echo esc_html( $label ); ?></small></span>
						<span class="fba-session-name">
							<?php echo esc_html( sprintf( __( 'Session %s', 'faithbridgeacademy' ), $q ) ); ?>
							<?php if ( $q === $current ) : ?>
								<em><?php echo esc_html( __( 'Now enrolling · ', 'faithbridgeacademy' ) . fba_get_option( 'session_period' ) ); ?></em>
							<?php endif; ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="reveal">
			<h2><?php esc_html_e( 'Quick Links', 'faithbridgeacademy' ); ?></h2>
			<ul class="fba-quicklinks">
				<li><a href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Admissions & Application', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></li>
				<li><a href="<?php echo esc_url( home_url( '/fees/' ) ); ?>"><?php esc_html_e( 'Fees & Sessions', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></li>
				<li><a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'All Programmes', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></li>
				<li><a href="<?php echo esc_url( home_url( '/resources/' ) ); ?>"><?php esc_html_e( 'Learning Resources', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></li>
				<li><a href="<?php echo esc_url( home_url( '/bible-club/' ) ); ?>"><?php esc_html_e( 'Bible Club', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></li>
			</ul>
		</div>
	</div>
</section>

<section class="fba-cta-band" aria-label="<?php esc_attr_e( 'Call to action', 'faithbridgeacademy' ); ?>">
	<div class="fba-wrap fba-cta-inner reveal">
		<div>
			<h2><?php esc_html_e( 'Give Your Child a Stronger Foundation.', 'faithbridgeacademy' ); ?></h2>
			<p><?php esc_html_e( 'Faith, values, knowledge and character are built over time. Start intentionally.', 'faithbridgeacademy' ); ?></p>
		</div>
		<a class="fba-btn fba-btn-navy" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>"><?php esc_html_e( 'Apply Now', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a>
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
			<p><a class="fba-btn fba-btn-navy" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'How It Works', 'faithbridgeacademy' ); ?> <span aria-hidden="true">&rarr;</span></a></p>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/dynamic', 'content' );

get_footer();
