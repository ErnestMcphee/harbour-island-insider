<?php
/**
 * Harbour Island Insider — single.php
 * Single post template.
 *
 * @package harbour-island-insider
 */

get_header();
?>

<!-- ============================================================
     READING PROGRESS BAR
     ============================================================ -->
<div id="reading-progress-bar" role="progressbar" aria-label="<?php esc_attr_e( 'Reading progress', 'harbour-island-insider' ); ?>" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>

<?php while ( have_posts() ) : the_post(); ?>

<!-- ============================================================
     POST HERO
     ============================================================ -->
<header class="post-hero">
	<div class="container">

		<!-- Breadcrumb -->
		<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'harbour-island-insider' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'harbour-island-insider' ); ?></a>
			<span class="breadcrumb-sep" aria-hidden="true">&rsaquo;</span>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Journal', 'harbour-island-insider' ); ?></a>
			<?php
			$categories = get_the_category();
			if ( $categories ) :
				$first_cat = $categories[0];
				?>
				<span class="breadcrumb-sep" aria-hidden="true">&rsaquo;</span>
				<a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>">
					<?php echo esc_html( $first_cat->name ); ?>
				</a>
			<?php endif; ?>
		</nav>

		<!-- Category badge -->
		<?php if ( $categories ) : ?>
			<div class="post-category-badges">
				<?php foreach ( $categories as $cat ) : ?>
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="category-badge">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Post title -->
		<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

		<!-- Post meta: author, date, read time -->
		<div class="post-meta">
			<div class="post-meta-author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', get_the_author(), array( 'class' => 'author-avatar' ) ); ?>
				<div class="post-meta-author-info">
					<span class="author-name">
						<?php
						$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
						echo '<a href="' . esc_url( $author_url ) . '">' . esc_html( get_the_author() ) . '</a>';
						?>
					</span>
					<span class="post-date">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</span>
				</div>
			</div>
			<div class="post-meta-right">
				<?php
				$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
				$read_time  = max( 1, (int) ceil( $word_count / 200 ) );
				?>
				<span class="read-time">
					&#9201; <?php printf( esc_html( _n( '%d min read', '%d min read', $read_time, 'harbour-island-insider' ) ), $read_time ); ?>
				</span>
			</div>
		</div><!-- /.post-meta -->

	</div><!-- /.container -->
</header><!-- /.post-hero -->

<!-- ============================================================
     FEATURED IMAGE
     ============================================================ -->
<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-featured-image">
		<div class="container">
			<?php
			the_post_thumbnail( 'full', array(
				'class' => 'post-thumbnail-img',
				'alt'   => esc_attr( get_the_title() ),
			) );
			?>
			<?php
			$caption = get_the_post_thumbnail_caption();
			if ( $caption ) :
				echo '<p class="post-thumbnail-caption">' . esc_html( $caption ) . '</p>';
			endif;
			?>
		</div>
	</div>
<?php endif; ?>

<!-- ============================================================
     ARTICLE CONTENT + SIDEBAR
     ============================================================ -->
<section class="single-content-section">
	<div class="container">
		<div class="single-layout">

			<!-- ── Article content ── -->
			<article class="post-article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="prose">
					<?php
					the_content( sprintf(
						wp_kses(
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'harbour-island-insider' ),
							array( 'span' => array( 'class' => array() ) )
						),
						wp_kses_post( get_the_title() )
					) );
					?>

					<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'harbour-island-insider' ),
						'after'       => '</div>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					) );
					?>
				</div><!-- /.prose -->

				<!-- Post tags -->
				<?php
				$tags = get_the_tags();
				if ( $tags ) :
					echo '<div class="post-tags">';
					echo '<span class="post-tags-label">' . esc_html__( 'Topics:', 'harbour-island-insider' ) . '</span>';
					foreach ( $tags as $tag ) {
						echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-pill">' . esc_html( $tag->name ) . '</a>';
					}
					echo '</div>';
				endif;
				?>

			</article><!-- /.post-article -->

			<!-- ── Single post sidebar ── -->
			<aside class="single-sidebar" role="complementary">
				<!-- Valentines rec card (persistent in sidebar) -->
				<div class="valentines-rec-card sidebar-sticky">
					<span class="rec-badge">&#11088; <?php esc_html_e( 'Featured Partner', 'harbour-island-insider' ); ?></span>
					<h4>Valentines Resort &amp; Marina</h4>
					<p><?php esc_html_e( 'Harbour Island&rsquo;s premier marina, resort &amp; dive centre. The only full-service marina on the island.', 'harbour-island-insider' ); ?></p>
					<ul class="rec-features">
						<li><?php esc_html_e( '50+ slips &middot; Up to 160 ft', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'PADI Dive Centre', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Hotel &amp; marina villas', 'harbour-island-insider' ); ?></li>
						<li><?php esc_html_e( 'Waterfront dining', 'harbour-island-insider' ); ?></li>
					</ul>
					<a href="https://www.valentinesresort.com" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer nofollow" style="width:100%; display:flex; justify-content:center; margin-bottom:8px;">
						<?php esc_html_e( 'Visit Valentines &rarr;', 'harbour-island-insider' ); ?>
					</a>
					<div class="valentines-contact-footer">&#128225; VHF 16 &middot; &#128222; (242) 333-2142</div>
				</div>
			</aside>

		</div><!-- /.single-layout -->
	</div><!-- /.container -->
</section>

<!-- ============================================================
     AUTHOR BIO BOX
     ============================================================ -->
<section class="author-bio-section">
	<div class="container">
		<div class="author-bio-box">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', get_the_author(), array( 'class' => 'author-bio-avatar' ) ); ?>
			<div class="author-bio-content">
				<span class="author-bio-label"><?php esc_html_e( 'Written by', 'harbour-island-insider' ); ?></span>
				<h3 class="author-bio-name">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php the_author(); ?>
					</a>
				</h3>
				<?php
				$author_bio = get_the_author_meta( 'description' );
				if ( $author_bio ) :
					echo '<p class="author-bio-text">' . wp_kses_post( $author_bio ) . '</p>';
				else :
					echo '<p class="author-bio-text">' . esc_html__( 'A contributor to the Harbour Island Insider, writing about life, travel, and adventure on one of the Bahamas\' most beautiful islands.', 'harbour-island-insider' ) . '</p>';
				endif;
				?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-bio-link">
					<?php printf( esc_html__( 'More by %s &rarr;', 'harbour-island-insider' ), esc_html( get_the_author() ) ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================
     VALENTINES RECOMMENDATION CARD (after content)
     ============================================================ -->
<section class="valentines-rec-section">
	<div class="container">
		<div class="valentines-rec-card valentines-rec-card--wide">
			<div class="valentines-rec-card-inner">
				<div class="valentines-rec-icon" aria-hidden="true">&#9875;</div>
				<div class="valentines-rec-body">
					<span class="rec-badge">&#11088; <?php esc_html_e( 'Harbour Island Insider Recommends', 'harbour-island-insider' ); ?></span>
					<h3>Valentines Resort &amp; Marina</h3>
					<p><?php esc_html_e( 'Planning a trip to Harbour Island? Valentines Resort &amp; Marina is our top-rated recommendation — the island&rsquo;s only full-service marina, with a world-class PADI dive centre, boutique hotel rooms and villas, and a spectacular waterfront restaurant. Over 30 years welcoming sailors, divers, and adventurers.', 'harbour-island-insider' ); ?></p>
					<div class="valentines-rec-features">
						<span class="amenity-tag">&#9875; 50+ Marina Slips</span>
						<span class="amenity-tag">&#129395; PADI Dive Centre</span>
						<span class="amenity-tag">&#127944; Beach Access</span>
						<span class="amenity-tag">&#127374; Restaurant &amp; Bar</span>
					</div>
					<div class="valentines-rec-actions">
						<a href="https://www.valentinesresort.com" class="btn btn-primary" target="_blank" rel="noopener noreferrer nofollow">
							<?php esc_html_e( 'Visit valentinesresort.com &rarr;', 'harbour-island-insider' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/where-to-stay/' ) ); ?>" class="btn btn-outline btn-sm">
							<?php esc_html_e( 'Where to Stay Guide', 'harbour-island-insider' ); ?>
						</a>
					</div>
					<p class="valentines-rec-contact">
						&#128222; +1 (242) 333-2142 &middot; &#128225; VHF Channel 16 &middot;
						<a href="mailto:info@valentinesresort.com">info@valentinesresort.com</a>
					</p>
					<p class="valentines-rec-disclosure">
						<em><?php esc_html_e( 'Disclosure: Valentines Resort &amp; Marina is a featured commercial partner of Harbour Island Insider.', 'harbour-island-insider' ); ?></em>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ============================================================
     RELATED POSTS
     ============================================================ -->
<?php
$current_post_id = get_the_ID();
$cats            = wp_get_post_categories( $current_post_id );

if ( $cats ) :
	$related = new WP_Query( array(
		'category__in'        => $cats,
		'post__not_in'        => array( $current_post_id ),
		'posts_per_page'      => 3,
		'orderby'             => 'rand',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	) );

	if ( $related->have_posts() ) :
		?>
		<section class="related-posts-section">
			<div class="container">
				<h2 class="related-posts-heading">
					<?php esc_html_e( 'You might also like', 'harbour-island-insider' ); ?>
				</h2>
				<div class="blog-grid related-posts-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						$related_word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
						$related_read_time  = max( 1, (int) ceil( $related_word_count / 200 ) );
						$related_cats       = get_the_category();
						?>
						<article class="blog-card">
							<a href="<?php the_permalink(); ?>" class="blog-card-image-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium', array( 'class' => 'blog-card-image-img' ) ); ?>
								<?php else : ?>
									<div class="blog-card-image ocean-bg" aria-hidden="true">
										<span>&#9875;</span>
										<?php if ( $related_cats ) : ?>
											<span class="card-category"><?php echo esc_html( $related_cats[0]->name ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</a>
							<div class="blog-card-body">
								<?php if ( $related_cats ) : ?>
									<a href="<?php echo esc_url( get_category_link( $related_cats[0]->term_id ) ); ?>" class="card-category-badge">
										<?php echo esc_html( $related_cats[0]->name ); ?>
									</a>
								<?php endif; ?>
								<?php the_title( '<h3 class="card-title"><a href="' . esc_url( get_the_permalink() ) . '">', '</a></h3>' ); ?>
								<p class="card-excerpt">
									<?php echo esc_html( wp_trim_words( get_the_content(), 20, '&hellip;' ) ); ?>
								</p>
								<div class="blog-card-meta">
									<span><?php echo esc_html( get_the_author() ); ?></span>
									<span class="dot" aria-hidden="true"></span>
									<span><?php echo esc_html( get_the_date() ); ?></span>
									<span class="dot" aria-hidden="true"></span>
									<span><?php echo esc_html( $related_read_time ); ?> <?php esc_html_e( 'min', 'harbour-island-insider' ); ?></span>
								</div>
							</div>
							<div class="blog-card-footer">
								<a href="<?php the_permalink(); ?>" class="read-more">
									<?php esc_html_e( 'Read more &rarr;', 'harbour-island-insider' ); ?>
								</a>
							</div>
						</article>
					<?php endwhile; ?>
				</div><!-- /.related-posts-grid -->
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;
endif;
?>

<!-- ============================================================
     COMMENTS
     ============================================================ -->
<?php
if ( comments_open() || get_comments_number() ) :
	?>
	<section class="comments-section">
		<div class="container">
			<?php comments_template(); ?>
		</div>
	</section>
	<?php
endif;

endwhile;

get_footer();
?>

<script>
(function () {
	'use strict';

	/* Reading progress bar */
	var bar     = document.getElementById('reading-progress-bar');
	var article = document.querySelector('.post-article');

	if ( bar && article ) {
		function updateProgress() {
			var articleTop    = article.getBoundingClientRect().top + window.pageYOffset;
			var articleHeight = article.offsetHeight;
			var windowHeight  = window.innerHeight;
			var scrolled      = window.pageYOffset - articleTop + windowHeight * 0.5;
			var progress      = Math.min( 100, Math.max( 0, ( scrolled / articleHeight ) * 100 ) );
			bar.style.width   = progress + '%';
			bar.setAttribute('aria-valuenow', Math.round(progress));
		}

		window.addEventListener('scroll', updateProgress, { passive: true });
		updateProgress();
	}
}());
</script>
