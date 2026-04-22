<?php
/**
 * Harbour Island Insider — template-parts/card-post.php
 * Reusable blog post card partial.
 *
 * Called via: get_template_part( 'template-parts/card-post' )
 *
 * @package harbour-island-insider
 */

// Map category slugs to gradient classes and emoji icons.
$card_categories  = get_the_category();
$primary_category = $card_categories ? $card_categories[0] : null;

$cat_slug  = $primary_category ? $primary_category->slug : '';
$cat_name  = $primary_category ? $primary_category->name : '';
$cat_link  = $primary_category ? get_category_link( $primary_category->term_id ) : '';

$gradient_map = array(
	'marina-sailing' => 'ocean-bg',
	'marina'         => 'ocean-bg',
	'diving'         => 'dive-bg',
	'beaches'        => 'pink-bg',
	'beach'          => 'pink-bg',
	'food-drink'     => 'sunset-bg',
	'food'           => 'sunset-bg',
	'island-life'    => 'island-bg',
	'travel-tips'    => 'island-bg',
	'travel'         => 'island-bg',
);

$emoji_map = array(
	'marina-sailing' => '&#9875;',
	'marina'         => '&#9875;',
	'diving'         => '&#129395;',
	'beaches'        => '&#127944;',
	'beach'          => '&#127944;',
	'food-drink'     => '&#127374;',
	'food'           => '&#127374;',
	'island-life'    => '&#127796;',
	'travel-tips'    => '&#9992;',
	'travel'         => '&#9992;',
);

$gradient_class = isset( $gradient_map[ $cat_slug ] ) ? $gradient_map[ $cat_slug ] : 'ocean-bg';
$card_emoji     = isset( $emoji_map[ $cat_slug ] ) ? $emoji_map[ $cat_slug ] : '&#9875;';

// Estimated read time.
$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
$read_time  = max( 1, (int) ceil( $word_count / 200 ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ); ?> aria-labelledby="card-title-<?php the_ID(); ?>">

	<!-- ── Card image area ── -->
	<a href="<?php the_permalink(); ?>" class="blog-card-image-link" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>

			<?php the_post_thumbnail( 'medium', array( 'class' => 'blog-card-thumbnail', 'alt' => '' ) ); ?>

		<?php else : ?>

			<div class="blog-card-image <?php echo esc_attr( $gradient_class ); ?>" role="img" aria-label="<?php echo esc_attr( $cat_name ); ?> article">
				<span class="card-emoji" aria-hidden="true"><?php echo wp_kses_post( $card_emoji ); ?></span>
				<?php if ( $cat_name ) : ?>
					<span class="card-category"><?php echo esc_html( $cat_name ); ?></span>
				<?php endif; ?>
			</div>

		<?php endif; ?>
	</a>

	<!-- ── Card body ── -->
	<div class="blog-card-body">

		<!-- Category badge -->
		<?php if ( $cat_name && $cat_link ) : ?>
			<a href="<?php echo esc_url( $cat_link ); ?>" class="card-category-badge">
				<?php echo esc_html( $cat_name ); ?>
			</a>
		<?php elseif ( $cat_name ) : ?>
			<span class="card-category-badge"><?php echo esc_html( $cat_name ); ?></span>
		<?php endif; ?>

		<!-- Post title -->
		<?php
		the_title(
			'<h3 id="card-title-' . get_the_ID() . '" class="card-title"><a href="' . esc_url( get_the_permalink() ) . '">',
			'</a></h3>'
		);
		?>

		<!-- Excerpt -->
		<p class="card-excerpt">
			<?php
			if ( has_excerpt() ) {
				echo wp_kses_post( wp_trim_words( get_the_excerpt(), 22, '&hellip;' ) );
			} else {
				echo esc_html( wp_trim_words( get_the_content(), 20, '&hellip;' ) );
			}
			?>
		</p>

		<!-- Meta row: author + date + read time -->
		<div class="blog-card-meta">
			<span class="card-author">
				<?php
				$author_id  = get_the_author_meta( 'ID' );
				$author_url = get_author_posts_url( $author_id );
				echo '<a href="' . esc_url( $author_url ) . '">' . esc_html( get_the_author() ) . '</a>';
				?>
			</span>
			<span class="dot" aria-hidden="true"></span>
			<span class="card-date">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</span>
			<span class="dot" aria-hidden="true"></span>
			<span class="read-time">
				<?php
				printf(
					/* translators: %d = estimated reading time in minutes */
					esc_html( _n( '%d min', '%d min', $read_time, 'harbour-island-insider' ) ),
					(int) $read_time
				);
				?>
			</span>
		</div>

	</div><!-- /.blog-card-body -->

	<!-- ── Card footer ── -->
	<div class="blog-card-footer">
		<a href="<?php the_permalink(); ?>" class="read-more" aria-label="<?php echo esc_attr( sprintf( __( 'Read more: %s', 'harbour-island-insider' ), get_the_title() ) ); ?>">
			<?php esc_html_e( 'Read more &rarr;', 'harbour-island-insider' ); ?>
		</a>
		<span class="read-time" aria-hidden="true">&#9201; <?php echo (int) $read_time; ?> min</span>
	</div>

</article><!-- /.blog-card -->
