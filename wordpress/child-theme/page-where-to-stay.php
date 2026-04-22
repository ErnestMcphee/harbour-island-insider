<?php
/**
 * Harbour Island Insider — page-where-to-stay.php
 * Template Name: Where to Stay
 *
 * @package harbour-island-insider
 */

get_header();
?>

<!-- ============================================================
     ACCOMMODATION HERO
     ============================================================ -->
<section class="accommodation-hero" aria-labelledby="wts-hero-heading">
	<div class="accommodation-hero-bg" aria-hidden="true"></div>
	<div class="container">
		<div class="accommodation-hero-content">
			<span class="eyebrow"><?php esc_html_e( 'Harbour Island, Bahamas', 'harbour-island-insider' ); ?></span>
			<h1 id="wts-hero-heading"><?php esc_html_e( 'Where to Stay on Harbour Island', 'harbour-island-insider' ); ?></h1>
			<p><?php esc_html_e( 'Honest, independent recommendations for every budget and travel style — from the island\'s premier marina resort to boutique inns and intimate guesthouses.', 'harbour-island-insider' ); ?></p>
		</div>
	</div>
</section>

<!-- ============================================================
     EDITORIAL DISCLOSURE NOTICE
     ============================================================ -->
<div class="disclosure-notice">
	<div class="container">
		<div class="disclosure-notice-inner">
			<span class="disclosure-icon" aria-hidden="true">&#8505;</span>
			<div>
				<strong><?php esc_html_e( 'Editorial Disclosure', 'harbour-island-insider' ); ?></strong>
				<?php esc_html_e( 'Harbour Island Insider has a commercial partnership with Valentines Resort &amp; Marina, who appears on this page as a Featured Partner. This means we may receive compensation when you book through our links. All other recommendations on this page are editorially independent and based solely on merit. Our full editorial policy is available ', 'harbour-island-insider' ); ?>
				<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>"><?php esc_html_e( 'here', 'harbour-island-insider' ); ?></a>.
				<?php esc_html_e( 'We comply with FTC guidelines for material connections and affiliate relationships.', 'harbour-island-insider' ); ?>
			</div>
		</div>
	</div>
</div>

<!-- ============================================================
     PAGE CONTENT (editable in WP admin)
     ============================================================ -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php if ( get_the_content() ) : ?>
		<section class="page-content-section">
			<div class="container">
				<div class="prose">
					<?php the_content(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; endif; ?>

<!-- ============================================================
     FEATURED PARTNER: VALENTINES RESORT & MARINA
     ============================================================ -->
<section class="wts-featured-section">
	<div class="container">

		<div class="section-header">
			<span class="eyebrow"><?php esc_html_e( 'Our Top Recommendation', 'harbour-island-insider' ); ?></span>
			<h2><?php esc_html_e( 'Featured Partner', 'harbour-island-insider' ); ?></h2>
		</div>

		<div class="featured-partner-banner">
			<span class="fp-icon" aria-hidden="true">&#11088;</span>
			<div>
				<strong><?php esc_html_e( 'Featured Partner &mdash; Valentines Resort &amp; Marina', 'harbour-island-insider' ); ?></strong>
				<?php esc_html_e( 'Harbour Island Insider has partnered with Valentines Resort &amp; Marina, our top-rated recommendation for accommodation, marina berths, and dive experiences on Harbour Island.', 'harbour-island-insider' ); ?>
				<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>"><?php esc_html_e( 'Learn about our editorial policy &rarr;', 'harbour-island-insider' ); ?></a>
			</div>
		</div>

		<!-- Main Valentines card -->
		<div class="featured-property-card" id="valentines-resort">

			<!-- Property image / hero area -->
			<div class="featured-property-image" style="background: linear-gradient(135deg, #023E8A, #0096C7);" aria-label="<?php esc_attr_e( 'Valentines Resort and Marina Harbour Island', 'harbour-island-insider' ); ?>">
				<span class="property-image-icon" aria-hidden="true">&#9875;</span>
				<div class="property-image-overlay">
					<span class="partner-badge">&#11088; <?php esc_html_e( 'Top Pick &middot; Our #1 Recommendation', 'harbour-island-insider' ); ?></span>
					<div class="property-image-name">Valentines Resort &amp; Marina</div>
					<div class="property-image-location">Harbour Island, Bahamas</div>
				</div>
			</div>

			<div class="featured-property-body">

				<!-- Rating row -->
				<div class="property-rating-row">
					<div class="rating-stars" aria-label="<?php esc_attr_e( '5 stars', 'harbour-island-insider' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<span class="property-review-count"><?php esc_html_e( 'Exceptional &middot; 200+ reviews', 'harbour-island-insider' ); ?></span>
					<div class="property-amenity-tags">
						<span class="amenity-tag">&#9875; <?php esc_html_e( 'Full Marina', 'harbour-island-insider' ); ?></span>
						<span class="amenity-tag">&#129395; <?php esc_html_e( 'PADI Dive Centre', 'harbour-island-insider' ); ?></span>
						<span class="amenity-tag">&#127944; <?php esc_html_e( 'Beach Access', 'harbour-island-insider' ); ?></span>
						<span class="amenity-tag">&#127374; <?php esc_html_e( 'Restaurant', 'harbour-island-insider' ); ?></span>
					</div>
				</div>

				<p class="property-description">
					<?php esc_html_e( 'The anchor of Harbour Island\'s marina community since 1992. Valentines offers 50+ slips for vessels up to 160 ft, boutique hotel rooms and villas, a world-class PADI dive centre, and the best waterfront restaurant on the island &mdash; all in one spectacular location on the protected harbour.', 'harbour-island-insider' ); ?>
				</p>

				<!-- Property specs grid -->
				<div class="property-specs-grid">
					<div class="property-spec">
						<span class="spec-label"><?php esc_html_e( 'Marina Slips', 'harbour-island-insider' ); ?></span>
						<span class="spec-value"><?php esc_html_e( '50+ Berths', 'harbour-island-insider' ); ?></span>
						<span class="spec-sub"><?php esc_html_e( 'Vessels up to 160 ft', 'harbour-island-insider' ); ?></span>
					</div>
					<div class="property-spec">
						<span class="spec-label"><?php esc_html_e( 'Dive Centre', 'harbour-island-insider' ); ?></span>
						<span class="spec-value"><?php esc_html_e( 'PADI Certified', 'harbour-island-insider' ); ?></span>
						<span class="spec-sub"><?php esc_html_e( 'Daily dives &middot; All levels', 'harbour-island-insider' ); ?></span>
					</div>
					<div class="property-spec">
						<span class="spec-label"><?php esc_html_e( 'Accommodations', 'harbour-island-insider' ); ?></span>
						<span class="spec-value"><?php esc_html_e( 'Rooms &amp; Villas', 'harbour-island-insider' ); ?></span>
						<span class="spec-sub"><?php esc_html_e( 'Marina &amp; harbour views', 'harbour-island-insider' ); ?></span>
					</div>
					<div class="property-spec">
						<span class="spec-label"><?php esc_html_e( 'Established', 'harbour-island-insider' ); ?></span>
						<span class="spec-value"><?php esc_html_e( 'Since 1992', 'harbour-island-insider' ); ?></span>
						<span class="spec-sub"><?php esc_html_e( '30+ years of hospitality', 'harbour-island-insider' ); ?></span>
					</div>
					<div class="property-spec">
						<span class="spec-label"><?php esc_html_e( 'Power', 'harbour-island-insider' ); ?></span>
						<span class="spec-value"><?php esc_html_e( '30/50/100A', 'harbour-island-insider' ); ?></span>
						<span class="spec-sub"><?php esc_html_e( 'Shore power &amp; fuel dock', 'harbour-island-insider' ); ?></span>
					</div>
					<div class="property-spec">
						<span class="spec-label"><?php esc_html_e( 'VHF', 'harbour-island-insider' ); ?></span>
						<span class="spec-value"><?php esc_html_e( 'Channel 16', 'harbour-island-insider' ); ?></span>
						<span class="spec-sub"><?php esc_html_e( 'Monitored 24/7', 'harbour-island-insider' ); ?></span>
					</div>
				</div>

				<!-- Amenities list -->
				<div class="property-amenities">
					<h4><?php esc_html_e( 'Amenities &amp; Services', 'harbour-island-insider' ); ?></h4>
					<ul class="amenities-checklist">
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Full-service marina — 50+ slips, fuel dock, pump-out station', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'PADI dive centre with daily boat dives to all local sites', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Boutique hotel rooms and marina-view villas', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Waterfront restaurant &mdash; fresh-caught fish, Bahamian cuisine, craft cocktails', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Swimming pool and beach access (5-min complimentary shuttle)', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Laundry facilities, showers &amp; ship&rsquo;s store', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Golf cart rentals, fishing charters &amp; snorkel equipment', 'harbour-island-insider' ); ?></li>
						<li><span class="check" aria-hidden="true">&#10003;</span><?php esc_html_e( 'Customs &amp; immigration clearance assistance', 'harbour-island-insider' ); ?></li>
					</ul>
				</div>

				<!-- Contact & booking -->
				<div class="property-contact">
					<div class="contact-info">
						<div class="contact-item"><span aria-hidden="true">&#128205;</span> Valentines Marina Drive, Dunmore Town, Harbour Island, Bahamas</div>
						<div class="contact-item"><span aria-hidden="true">&#128222;</span> <a href="tel:+12423332142">+1 (242) 333-2142</a></div>
						<div class="contact-item"><span aria-hidden="true">&#128225;</span> VHF Channel 16</div>
						<div class="contact-item"><span aria-hidden="true">&#9993;</span> <a href="mailto:info@valentinesresort.com">info@valentinesresort.com</a></div>
					</div>
					<div class="property-cta">
						<a href="https://www.valentinesresort.com" class="btn btn-primary" target="_blank" rel="noopener noreferrer nofollow">
							<?php esc_html_e( 'Visit valentinesresort.com &rarr;', 'harbour-island-insider' ); ?>
						</a>
					</div>
				</div>

			</div><!-- /.featured-property-body -->
		</div><!-- /.featured-property-card -->

	</div><!-- /.container -->
</section>

<!-- ============================================================
     OTHER ACCOMMODATION RECOMMENDATIONS
     ============================================================ -->
<section class="wts-other-section">
	<div class="container">

		<div class="section-header">
			<span class="eyebrow"><?php esc_html_e( 'Also Worth Considering', 'harbour-island-insider' ); ?></span>
			<h2><?php esc_html_e( 'More Places to Stay', 'harbour-island-insider' ); ?></h2>
			<p><?php esc_html_e( 'Independently selected. These properties were not involved in any commercial arrangement with this site.', 'harbour-island-insider' ); ?></p>
		</div>

		<div class="rec-boxes-grid">

			<!-- Pink Sands Resort -->
			<div class="rec-box">
				<div class="rec-box-header" style="background: linear-gradient(135deg, #C0506A, #F2C4CE);">
					<span class="rec-box-icon" aria-hidden="true">&#127944;</span>
					<span class="rec-box-category"><?php esc_html_e( 'Boutique Resort', 'harbour-island-insider' ); ?></span>
				</div>
				<div class="rec-box-body">
					<h3><?php esc_html_e( 'Pink Sands Resort', 'harbour-island-insider' ); ?></h3>
					<div class="rec-box-rating" aria-label="<?php esc_attr_e( '5 stars', 'harbour-island-insider' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<p><?php esc_html_e( 'Legendary oceanfront cottages set directly on the Pink Sand Beach. Arguably the most romantic property on Harbour Island, with cottage-style accommodation, a stunning pool, and fine dining. A true bucket-list experience.', 'harbour-island-insider' ); ?></p>
					<ul class="rec-box-features">
						<li><?php esc_html_e( 'Direct Pink Sand Beach access', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Cottage-style rooms &amp; suites', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Pool, spa &amp; fine dining', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Adults-preferred atmosphere', 'harbour-island-insider' ); ?></li>
					</ul>
					<div class="rec-box-contact">
						<span>&#128222; +1 (242) 333-2030</span>
					</div>
					<a href="https://www.pinksandsresort.com" class="btn btn-outline btn-sm" target="_blank" rel="noopener noreferrer nofollow">
						<?php esc_html_e( 'Learn More &rarr;', 'harbour-island-insider' ); ?>
					</a>
				</div>
			</div><!-- /.rec-box -->

			<!-- The Landing -->
			<div class="rec-box">
				<div class="rec-box-header" style="background: linear-gradient(135deg, #2D6A4F, #52B788);">
					<span class="rec-box-icon" aria-hidden="true">&#127968;</span>
					<span class="rec-box-category"><?php esc_html_e( 'Boutique Hotel', 'harbour-island-insider' ); ?></span>
				</div>
				<div class="rec-box-body">
					<h3><?php esc_html_e( 'The Landing', 'harbour-island-insider' ); ?></h3>
					<div class="rec-box-rating" aria-label="<?php esc_attr_e( '4 stars', 'harbour-island-insider' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
					<p><?php esc_html_e( 'A beautifully restored colonial-era building in the heart of Dunmore Town, just steps from the ferry dock. Intimate, elegant, and authentically Bahamian &mdash; with a beloved restaurant that locals and guests both rave about.', 'harbour-island-insider' ); ?></p>
					<ul class="rec-box-features">
						<li><?php esc_html_e( 'Historic Dunmore Town location', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Acclaimed waterfront restaurant', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( '8 charming boutique rooms', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Deeply local, personal service', 'harbour-island-insider' ); ?></li>
					</ul>
					<div class="rec-box-contact">
						<span>&#128222; +1 (242) 333-2707</span>
					</div>
					<a href="https://www.harbour-island.com" class="btn btn-outline btn-sm" target="_blank" rel="noopener noreferrer nofollow">
						<?php esc_html_e( 'Learn More &rarr;', 'harbour-island-insider' ); ?>
					</a>
				</div>
			</div><!-- /.rec-box -->

			<!-- Rock House Hotel -->
			<div class="rec-box">
				<div class="rec-box-header" style="background: linear-gradient(135deg, #E07B54, #F4A261);">
					<span class="rec-box-icon" aria-hidden="true">&#127754;</span>
					<span class="rec-box-category"><?php esc_html_e( 'Design Hotel', 'harbour-island-insider' ); ?></span>
				</div>
				<div class="rec-box-body">
					<h3><?php esc_html_e( 'Rock House Hotel', 'harbour-island-insider' ); ?></h3>
					<div class="rec-box-rating" aria-label="<?php esc_attr_e( '5 stars', 'harbour-island-insider' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<p><?php esc_html_e( 'Perched on the western bluff overlooking the harbour, Rock House is one of the Caribbean&rsquo;s great design hotels. Spectacular sunset views, an infinity pool, and an intimate atmosphere that attracts a discerning international crowd.', 'harbour-island-insider' ); ?></p>
					<ul class="rec-box-features">
						<li><?php esc_html_e( 'Harbour-view hilltop location', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Award-winning design &amp; interiors', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Infinity pool &amp; sundeck', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Restaurant with panoramic views', 'harbour-island-insider' ); ?></li>
					</ul>
					<div class="rec-box-contact">
						<span>&#128222; +1 (242) 333-2053</span>
					</div>
					<a href="https://www.rockhousebahamas.com" class="btn btn-outline btn-sm" target="_blank" rel="noopener noreferrer nofollow">
						<?php esc_html_e( 'Learn More &rarr;', 'harbour-island-insider' ); ?>
					</a>
				</div>
			</div><!-- /.rec-box -->

		</div><!-- /.rec-boxes-grid -->

		<!-- Bottom disclosure -->
		<div class="wts-bottom-disclosure">
			<p>
				<strong><?php esc_html_e( 'Editorial note:', 'harbour-island-insider' ); ?></strong>
				<?php esc_html_e( 'The properties listed above (other than Valentines Resort &amp; Marina) are independently recommended based on editorial merit. We have no commercial relationship with Pink Sands Resort, The Landing, or Rock House Hotel. Our Featured Partner disclosure is listed at the top of this page.', 'harbour-island-insider' ); ?>
			</p>
		</div>

	</div><!-- /.container -->
</section>

<?php
get_footer();
