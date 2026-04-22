<?php
/**
 * Harbour Island Insider — index.php
 * Main blog listing template.
 *
 * @package harbour-island-insider
 */

get_header();
?>

<!-- ============================================================
     BLOG HERO
     ============================================================ -->
<section class="blog-hero" aria-labelledby="blog-hero-heading">
	<div class="container">
		<span class="eyebrow"><?php esc_html_e( 'Independent Island Journalism', 'harbour-island-insider' ); ?></span>
		<h1 id="blog-hero-heading"><?php esc_html_e( 'The Harbour Island Journal', 'harbour-island-insider' ); ?></h1>
		<p><?php esc_html_e( 'Independent guides, honest tips, and insider knowledge for your Bahamas adventure', 'harbour-island-insider' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>

<!-- ============================================================
     CATEGORY FILTER PILLS
     ============================================================ -->
<div class="blog-categories-bar">
	<div class="container">
		<?php
		$current_cat = get_query_var( 'cat' ) ? get_query_var( 'cat' ) : 0;
		$current_slug = '';
		if ( $current_cat ) {
			$cat_obj = get_category( $current_cat );
			if ( $cat_obj && ! is_wp_error( $cat_obj ) ) {
				$current_slug = $cat_obj->slug;
			}
		}

		$filter_cats = array(
			''              => 'All Articles',
			'island-life'   => '&#127944; Island Life',
			'marina-sailing' => '&#9875; Marina &amp; Sailing',
			'diving'        => '&#129395; Diving',
			'beaches'       => '&#127958; Beaches',
			'food-drink'    => '&#127374; Food &amp; Drink',
			'travel-tips'   => '&#9992; Travel Tips',
		);

		foreach ( $filter_cats as $slug => $label ) {
			$is_active = ( $slug === $current_slug || ( $slug === '' && $current_slug === '' && ! is_category() ) );
			$class     = 'cat-tab' . ( $is_active ? ' active' : '' );
			if ( $slug === '' ) {
				$url = home_url( '/' );
			} else {
				$cat = get_category_by_slug( $slug );
				$url = $cat ? get_category_link( $cat->term_id ) : home_url( '/?cat=' . $slug );
			}
			echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '">' . wp_kses_post( $label ) . '</a>';
		}
		?>
	</div>
</div>

<!-- Editorial disclosure -->
<div class="editorial-disclosure-bar">
	<div class="container">
		<span>&#8505;&#65039;</span>
		<span>
			<strong><?php esc_html_e( 'Editorial Disclosure:', 'harbour-island-insider' ); ?></strong>
			<?php esc_html_e( 'Valentines Resort &amp; Marina is a featured commercial partner. Our editorial content remains independent.', 'harbour-island-insider' ); ?>
			<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>"><?php esc_html_e( 'Full policy &rarr;', 'harbour-island-insider' ); ?></a>
		</span>
	</div>
</div>

<!-- ============================================================
     MAIN CONTENT AREA
     ============================================================ -->
<section class="blog-listing-section">
	<div class="container">
		<div class="blog-listing-grid">

			<!-- ── Main column (8/12) ── -->
			<main id="main" class="blog-main-column" role="main">

				<!-- Featured partner banner -->
				<div class="featured-partner-banner">
					<span class="fp-icon">&#11088;</span>
					<div>
						<strong><?php esc_html_e( 'Featured Partner:', 'harbour-island-insider' ); ?></strong>
						<?php esc_html_e( 'Looking for where to stay?', 'harbour-island-insider' ); ?>
						<a href="<?php echo esc_url( home_url( '/where-to-stay/' ) ); ?>"><?php esc_html_e( 'Valentines Resort &amp; Marina', 'harbour-island-insider' ); ?></a>
						<?php esc_html_e( '— our #1 recommendation for marina berths, accommodation &amp; diving on Harbour Island.', 'harbour-island-insider' ); ?>
						<a href="<?php echo esc_url( home_url( '/where-to-stay/' ) ); ?>"><?php esc_html_e( 'Check availability &rarr;', 'harbour-island-insider' ); ?></a>
					</div>
				</div>

				<?php if ( have_posts() ) : ?>

					<div class="blog-grid" id="articlesGrid">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/card-post' );
						endwhile;
						?>
					</div><!-- /.blog-grid -->

					<!-- Pagination -->
					<div class="blog-pagination">
						<?php
						the_posts_pagination( array(
							'mid_size'           => 2,
							'prev_text'          => '&larr; ' . esc_html__( 'Previous', 'harbour-island-insider' ),
							'next_text'          => esc_html__( 'Next', 'harbour-island-insider' ) . ' &rarr;',
							'before_page_number' => '',
						) );
						?>
					</div>

				<?php else : ?>

					<div class="no-results">
						<div class="no-results-icon">&#128269;</div>
						<h2><?php esc_html_e( 'No articles found', 'harbour-island-insider' ); ?></h2>
						<p><?php esc_html_e( 'Try a different keyword or browse all categories.', 'harbour-island-insider' ); ?></p>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
							<?php esc_html_e( 'Back to Journal &rarr;', 'harbour-island-insider' ); ?>
						</a>
					</div>

				<?php endif; ?>

			</main><!-- /#main -->

			<!-- ── Sidebar (4/12) ── -->
			<aside class="blog-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog sidebar', 'harbour-island-insider' ); ?>">

				<!-- Search widget -->
				<div class="sidebar-widget sidebar-search">
					<h4><?php esc_html_e( 'Search the Journal', 'harbour-island-insider' ); ?></h4>
					<?php get_search_form(); ?>
				</div>

				<!-- Recent Posts widget -->
				<div class="sidebar-widget">
					<h4><?php esc_html_e( 'Most Read', 'harbour-island-insider' ); ?></h4>
					<?php
					$recent_posts = new WP_Query( array(
						'posts_per_page'      => 5,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => true,
						'orderby'             => 'comment_count',
						'order'               => 'DESC',
					) );

					if ( $recent_posts->have_posts() ) :
						echo '<ul class="sidebar-posts">';
						while ( $recent_posts->have_posts() ) :
							$recent_posts->the_post();
							?>
							<li>
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="sidebar-post-thumb" aria-hidden="true" tabindex="-1">
										<?php the_post_thumbnail( 'thumbnail' ); ?>
									</a>
								<?php else : ?>
									<div class="sidebar-post-image ocean-bg" aria-hidden="true">&#9875;</div>
								<?php endif; ?>
								<div>
									<a href="<?php the_permalink(); ?>" class="sidebar-post-title"><?php the_title(); ?></a>
									<div class="sidebar-post-date"><?php echo esc_html( get_the_date() ); ?></div>
								</div>
							</li>
							<?php
						endwhile;
						echo '</ul>';
						wp_reset_postdata();
					endif;
					?>
				</div><!-- /.sidebar-widget -->

				<!-- Categories widget -->
				<div class="sidebar-widget">
					<h4><?php esc_html_e( 'Browse by Topic', 'harbour-island-insider' ); ?></h4>
					<div class="tag-cloud">
						<?php
						$cats = get_categories( array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'hide_empty' => true,
						) );
						foreach ( $cats as $cat ) :
							?>
							<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="tag-pill">
								<?php echo esc_html( $cat->name ); ?>
								<span class="tag-count">(<?php echo absint( $cat->count ); ?>)</span>
							</a>
							<?php
						endforeach;
						?>
					</div>
				</div><!-- /.sidebar-widget -->

				<!-- Featured Partner: Valentines promo box -->
				<div class="valentines-rec-card">
					<span class="rec-badge">&#11088; <?php esc_html_e( 'Featured Partner', 'harbour-island-insider' ); ?></span>
					<h4>Valentines Resort &amp; Marina</h4>
					<p><?php esc_html_e( 'Our #1 recommendation for marina berths, accommodation, and diving on Harbour Island. The only full-service marina on the island.', 'harbour-island-insider' ); ?></p>
					<ul class="rec-features">
						<li><?php esc_html_e( '50+ slips &middot; Vessels up to 160 ft', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'PADI dive centre on property', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Hotel rooms &amp; marina villas', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Waterfront restaurant &amp; bar', 'harbour-island-insider' ); ?></li>
					</ul>
					<a href="https://www.valentinesresort.com" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer nofollow" style="width:100%; justify-content:center; margin-bottom:8px; display:flex;">
						<?php esc_html_e( 'Check Availability &rarr;', 'harbour-island-insider' ); ?>
					</a>
					<div class="valentines-contact-footer">&#128225; VHF 16 &middot; &#128222; (242) 333-2142</div>
				</div><!-- /.valentines-rec-card -->

				<!-- Newsletter CTA -->
				<div class="sidebar-widget sidebar-newsletter">
					<h4><?php esc_html_e( 'The Island Dispatch', 'harbour-island-insider' ); ?></h4>
					<p><?php esc_html_e( 'Monthly conditions, dive reports, and exclusive Valentines rates — free.', 'harbour-island-insider' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/#newsletter' ) ); ?>" class="btn btn-secondary btn-sm" style="width:100%; justify-content:center; display:flex;">
						<?php esc_html_e( 'Subscribe Free &rarr;', 'harbour-island-insider' ); ?>
					</a>
				</div>

			</aside><!-- /.blog-sidebar -->

		</div><!-- /.blog-listing-grid -->
	</div><!-- /.container -->
</section>

<?php
get_footer();
