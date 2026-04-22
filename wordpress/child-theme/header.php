<?php
/**
 * Harbour Island Insider — header.php
 *
 * @package harbour-island-insider
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ============================================================
     ISLAND TICKER
     ============================================================ -->
<div class="island-ticker" role="marquee" aria-label="Harbour Island live conditions">
	<div class="ticker-track" id="tickerTrack">
		<span class="ticker-item"><span class="dot">&#9679;</span> Water temp: 79&deg;F / 26&deg;C</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Dive visibility: 80&ndash;100 ft</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Trade winds: E&ndash;SE 12&ndash;18 kts</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Valentines Marina slips available this week</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Pink Sand Beach conditions: excellent</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Hammerhead shark season underway at Current Cut</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Current Cut tide window: check before diving</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Golf cart rentals available at the dock</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Water temp: 79&deg;F / 26&deg;C</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Dive visibility: 80&ndash;100 ft</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Trade winds: E&ndash;SE 12&ndash;18 kts</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Valentines Marina slips available this week</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Pink Sand Beach conditions: excellent</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Hammerhead shark season underway at Current Cut</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Current Cut tide window: check before diving</span>
		<span class="ticker-item"><span class="dot">&#9679;</span> Golf cart rentals available at the dock</span>
	</div>
</div>

<!-- ============================================================
     NAVBAR
     ============================================================ -->
<nav class="navbar-blog" id="navbar" role="navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'harbour-island-insider' ); ?>">
	<div class="container">
		<div class="navbar-inner">

			<!-- Logo / Blog name -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="blog-logo" rel="home">
				<span class="logo-main"><?php bloginfo( 'name' ); ?></span>
				<span class="logo-sub">Independent &middot; Harbour Island, Bahamas</span>
			</a>

			<!-- Primary navigation menu -->
			<?php
			wp_nav_menu( array(
				'theme_location'  => 'primary',
				'menu_id'         => 'navLinks',
				'container'       => false,
				'items_wrap'      => '<ul id="%1$s" class="blog-nav-links %2$s">%3$s</ul>',
				'fallback_cb'     => function() {
					echo '<ul id="navLinks" class="blog-nav-links">';
					echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/where-to-stay/' ) ) . '">Where to Stay</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/journal/' ) ) . '">Island Journal</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/?cat=food-drink' ) ) . '">Food &amp; Drink</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/?cat=marina-sailing' ) ) . '">Marina Life</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/?cat=diving' ) ) . '">Diving</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">About</a></li>';
					echo '</ul>';
				},
			) );
			?>

			<!-- Actions: CTA button + hamburger -->
			<div class="blog-nav-actions">
				<button class="search-icon-btn" aria-label="<?php esc_attr_e( 'Search', 'harbour-island-insider' ); ?>" id="navSearchToggle">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				</button>
				<a href="https://www.valentinesresort.com" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer nofollow">
					<?php esc_html_e( 'Visit Valentines &rarr;', 'harbour-island-insider' ); ?>
				</a>
				<button class="nav-hamburger" id="navHamburger" aria-label="<?php esc_attr_e( 'Toggle mobile menu', 'harbour-island-insider' ); ?>" aria-expanded="false" aria-controls="navLinks">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>

		</div><!-- /.navbar-inner -->
	</div><!-- /.container -->
</nav><!-- /.navbar-blog -->

<!-- Inline search overlay (hidden by default) -->
<div class="nav-search-overlay" id="navSearchOverlay" role="search" aria-hidden="true">
	<div class="container">
		<?php get_search_form(); ?>
		<button class="search-overlay-close" id="navSearchClose" aria-label="<?php esc_attr_e( 'Close search', 'harbour-island-insider' ); ?>">&times;</button>
	</div>
</div>

<script>
(function () {
	'use strict';

	/* ---------- Ticker ---------- */
	var track = document.getElementById('tickerTrack');
	if (track) {
		var speed = 0.5; // px per frame
		var pos   = 0;
		function animateTicker() {
			pos -= speed;
			var halfWidth = track.scrollWidth / 2;
			if (Math.abs(pos) >= halfWidth) {
				pos = 0;
			}
			track.style.transform = 'translateX(' + pos + 'px)';
			requestAnimationFrame(animateTicker);
		}
		requestAnimationFrame(animateTicker);

		/* Pause on hover */
		track.addEventListener('mouseenter', function () { speed = 0; });
		track.addEventListener('mouseleave', function () { speed = 0.5; });
	}

	/* ---------- Mobile hamburger ---------- */
	var hamburger = document.getElementById('navHamburger');
	var navLinks  = document.getElementById('navLinks');
	if (hamburger && navLinks) {
		hamburger.addEventListener('click', function () {
			var isOpen = navLinks.classList.toggle('nav-open');
			hamburger.classList.toggle('is-active', isOpen);
			hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});
	}

	/* ---------- Navbar scroll behaviour ---------- */
	var navbar = document.getElementById('navbar');
	if (navbar) {
		var lastScroll = 0;
		window.addEventListener('scroll', function () {
			var currentScroll = window.pageYOffset;
			if (currentScroll > 80) {
				navbar.classList.add('navbar-scrolled');
			} else {
				navbar.classList.remove('navbar-scrolled');
			}
			lastScroll = currentScroll;
		}, { passive: true });
	}

	/* ---------- Search overlay ---------- */
	var searchToggle  = document.getElementById('navSearchToggle');
	var searchOverlay = document.getElementById('navSearchOverlay');
	var searchClose   = document.getElementById('navSearchClose');
	if (searchToggle && searchOverlay) {
		searchToggle.addEventListener('click', function () {
			searchOverlay.classList.toggle('overlay-open');
			searchOverlay.setAttribute('aria-hidden', searchOverlay.classList.contains('overlay-open') ? 'false' : 'true');
			var input = searchOverlay.querySelector('input[type="search"]');
			if (input) { input.focus(); }
		});
	}
	if (searchClose && searchOverlay) {
		searchClose.addEventListener('click', function () {
			searchOverlay.classList.remove('overlay-open');
			searchOverlay.setAttribute('aria-hidden', 'true');
		});
	}

	/* Close mobile menu when a nav link is clicked */
	if (navLinks) {
		navLinks.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				navLinks.classList.remove('nav-open');
				if (hamburger) {
					hamburger.classList.remove('is-active');
					hamburger.setAttribute('aria-expanded', 'false');
				}
			});
		});
	}
}());
</script>
