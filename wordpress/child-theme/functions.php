<?php
/**
 * Harbour Island Insider — Child Theme Functions
 *
 * @package harbour-island-insider
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ============================================================
   ENQUEUE STYLES & SCRIPTS
   ============================================================ */
function hii_enqueue_assets() {

	// 1. Parent theme stylesheet
	wp_enqueue_style(
		'twentytwentyfour-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'twentytwentyfour' )->get( 'Version' )
	);

	// 2. Child theme stylesheet (depends on parent)
	wp_enqueue_style(
		'harbour-island-insider-style',
		get_stylesheet_uri(),
		array( 'twentytwentyfour-style' ),
		wp_get_theme()->get( 'Version' )
	);

	// 3. Reading progress bar script (single posts only)
	if ( is_single() ) {
		wp_enqueue_script(
			'hii-reading-progress',
			get_stylesheet_directory_uri() . '/js/reading-progress.js',
			array(),
			'1.0.0',
			true
		);
	}

	// 4. Main theme JS (hamburger, share, TOC, scroll)
	wp_enqueue_script(
		'hii-main',
		get_stylesheet_directory_uri() . '/js/main.js',
		array(),
		'1.0.0',
		true
	);

	// 5. Pass PHP data to JS
	wp_localize_script( 'hii-main', 'hiiData', array(
		'homeUrl'      => esc_url( home_url( '/' ) ),
		'isSingle'     => is_single() ? 'yes' : 'no',
		'shareTitle'   => is_single() ? get_the_title() : get_bloginfo( 'name' ),
		'shareUrl'     => is_single() ? get_permalink() : home_url( '/' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'hii_enqueue_assets' );

/* ============================================================
   THEME SUPPORT
   ============================================================ */
function hii_theme_setup() {

	// Let WordPress manage the document title tag
	add_theme_support( 'title-tag' );

	// Enable featured images
	add_theme_support( 'post-thumbnails' );

	// HTML5 output
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	// Custom header
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'default-text-color' => 'FFFFFF',
		'width'              => 1920,
		'height'             => 600,
		'flex-width'         => true,
		'flex-height'        => true,
	) );

	// Editor stylesheet
	add_editor_style( 'style.css' );

	// Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Register nav menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'harbour-island-insider' ),
		'footer'  => __( 'Footer Menu', 'harbour-island-insider' ),
		'social'  => __( 'Social Links Menu', 'harbour-island-insider' ),
	) );
}
add_action( 'after_setup_theme', 'hii_theme_setup' );

/* ============================================================
   WIDGET AREAS
   ============================================================ */
function hii_register_sidebars() {

	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'harbour-island-insider' ),
		'id'            => 'blog-sidebar',
		'description'   => __( 'Widgets that appear in the main blog sidebar.', 'harbour-island-insider' ),
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Column 2', 'harbour-island-insider' ),
		'id'            => 'footer-col-2',
		'description'   => __( 'Footer column 2 — Explore links.', 'harbour-island-insider' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Column 3', 'harbour-island-insider' ),
		'id'            => 'footer-col-3',
		'description'   => __( 'Footer column 3 — Top articles / recent posts.', 'harbour-island-insider' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'hii_register_sidebars' );

/* ============================================================
   EXCERPT CUSTOMISATION
   ============================================================ */
function hii_excerpt_length() {
	return 25;
}
add_filter( 'excerpt_length', 'hii_excerpt_length' );

function hii_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'hii_excerpt_more' );

/* ============================================================
   BODY CLASS
   ============================================================ */
function hii_body_class( $classes ) {
	$classes[] = 'harbour-island-insider';
	return $classes;
}
add_filter( 'body_class', 'hii_body_class' );

/* ============================================================
   CUSTOM TAXONOMY — JOURNAL CATEGORY
   Belt-and-braces registration if the plugin is not active
   ============================================================ */
function hii_register_journal_category_taxonomy() {
	if ( taxonomy_exists( 'journal_category' ) ) {
		return; // Already registered by the plugin
	}

	$labels = array(
		'name'              => _x( 'Journal Categories', 'taxonomy general name', 'harbour-island-insider' ),
		'singular_name'     => _x( 'Journal Category', 'taxonomy singular name', 'harbour-island-insider' ),
		'search_items'      => __( 'Search Journal Categories', 'harbour-island-insider' ),
		'all_items'         => __( 'All Journal Categories', 'harbour-island-insider' ),
		'parent_item'       => __( 'Parent Journal Category', 'harbour-island-insider' ),
		'parent_item_colon' => __( 'Parent Journal Category:', 'harbour-island-insider' ),
		'edit_item'         => __( 'Edit Journal Category', 'harbour-island-insider' ),
		'update_item'       => __( 'Update Journal Category', 'harbour-island-insider' ),
		'add_new_item'      => __( 'Add New Journal Category', 'harbour-island-insider' ),
		'new_item_name'     => __( 'New Journal Category Name', 'harbour-island-insider' ),
		'menu_name'         => __( 'Journal Categories', 'harbour-island-insider' ),
	);

	register_taxonomy( 'journal_category', array( 'post' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'journal-category' ),
		'show_in_rest'      => true,
	) );
}
add_action( 'init', 'hii_register_journal_category_taxonomy' );

/* ============================================================
   HELPER: READING TIME
   ============================================================ */
/**
 * Calculate estimated reading time for a post.
 *
 * @param  int $post_id  WP post ID.
 * @return string        e.g. "5 min read"
 */
function hii_reading_time( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 200 ) );

	/* translators: %d = number of minutes */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'harbour-island-insider' ), $minutes );
}

/* ============================================================
   HELPER: VALENTINES BOOKING CARD
   ============================================================ */
/**
 * Return the Valentines Resort sidebar/article booking card HTML.
 *
 * @param  string $context  'sidebar' or 'article'
 * @return string           HTML markup.
 */
function hii_valentines_card( $context = 'sidebar' ) {
	$booking_url = esc_url( get_option( 'hii_valentines_booking_url', '#' ) );
	$phone       = esc_html( get_option( 'hii_valentines_phone', '+1 (242) 333-2080' ) );
	$extra_class = ( 'article' === $context ) ? ' article-context' : '';

	ob_start();
	?>
	<div class="valentines-rec-card<?php echo esc_attr( $extra_class ); ?>">
		<span class="rec-badge">&#9733; Featured Partner</span>
		<h4>Valentines Resort &amp; Marina</h4>
		<p>The only full-service marina and boutique resort on Harbour Island. Voted best in the Bahamas three years running.</p>
		<ul class="rec-features">
			<li>Full-service marina (50+ slips)</li>
			<li>Boutique beachfront rooms</li>
			<li>Pool bar &amp; ocean views</li>
			<li>Dive &amp; water sports centre</li>
			<li>Pink Sand Beach access</li>
		</ul>
		<p class="rec-price">Rooms from $295/night &bull; Marina from $2.50/ft/night</p>
		<a href="<?php echo $booking_url; ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener sponsored">
			Check Availability &rarr;
		</a>
		<?php if ( $phone ) : ?>
		<p style="margin-top:12px;font-family:var(--font-ui);font-size:.75rem;color:rgba(255,255,255,.6);">
			Or call: <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" style="color:rgba(255,255,255,.85);"><?php echo $phone; ?></a>
		</p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/* ============================================================
   HELPER: FEATURED PARTNER BANNER
   ============================================================ */
/**
 * Return the featured partner banner HTML.
 *
 * @return string HTML markup.
 */
function hii_partner_banner() {
	$booking_url = esc_url( get_option( 'hii_valentines_booking_url', '#' ) );

	ob_start();
	?>
	<div class="featured-partner-banner">
		<span class="fp-icon">&#9875;</span>
		<div>
			<strong>Featured Partner:</strong> This guide features <strong>Valentines Resort &amp; Marina</strong> —
			Harbour Island's premier full-service marina and boutique resort.
			We earn a small commission if you book through our links, at no extra cost to you.
			<a href="<?php echo $booking_url; ?>" target="_blank" rel="noopener sponsored">View resort &rarr;</a>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/* ============================================================
   HELPER: DISCLOSURE NOTICE
   ============================================================ */
/**
 * Return the editorial disclosure notice HTML.
 *
 * @return string HTML markup.
 */
function hii_disclosure_notice() {
	ob_start();
	?>
	<div class="disclosure-notice">
		<span class="icon">&#9432;</span>
		<div>
			<strong>Editorial Disclosure:</strong> Harbour Island Insider is an independent travel blog.
			Some links on this page are affiliate or partner links — if you book or buy through them we may
			earn a small commission at no extra cost to you. Our editorial opinions are always our own.
			<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>">Learn more</a>.
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/* ============================================================
   WP_HEAD — GA4 + JSON-LD SCHEMA
   ============================================================ */
function hii_head_extras() {
	$ga4_id = get_option( 'hii_ga4_id', '' );

	// GA4 tracking snippet
	if ( ! empty( $ga4_id ) ) :
		$ga4_id_safe = esc_js( $ga4_id );
		?>
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga4_id ); ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo $ga4_id_safe; ?>');
</script>
	<?php endif; ?>

<!-- JSON-LD WebSite Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": <?php echo wp_json_encode( get_bloginfo( 'name' ) ); ?>,
  "url": <?php echo wp_json_encode( home_url( '/' ) ); ?>,
  "description": <?php echo wp_json_encode( get_bloginfo( 'description' ) ); ?>,
  "publisher": {
    "@type": "Organization",
    "name": <?php echo wp_json_encode( get_bloginfo( 'name' ) ); ?>,
    "url": <?php echo wp_json_encode( home_url( '/' ) ); ?>
  },
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": <?php echo wp_json_encode( home_url( '/?s={search_term_string}' ) ); ?>
    },
    "query-input": "required name=search_term_string"
  }
}
</script>
<?php
}
add_action( 'wp_head', 'hii_head_extras' );

/* ============================================================
   OPTIONS PAGE
   ============================================================ */
function hii_register_options_page() {
	add_options_page(
		__( 'Harbour Island Insider Settings', 'harbour-island-insider' ),
		__( 'HII Settings', 'harbour-island-insider' ),
		'manage_options',
		'hii-settings',
		'hii_options_page_html'
	);
}
add_action( 'admin_menu', 'hii_register_options_page' );

function hii_register_settings() {
	// Section
	add_settings_section(
		'hii_general_section',
		__( 'General Settings', 'harbour-island-insider' ),
		null,
		'hii-settings'
	);

	$fields = array(
		'hii_ga4_id'                 => __( 'GA4 Measurement ID', 'harbour-island-insider' ),
		'hii_mailchimp_api_key'      => __( 'Mailchimp API Key', 'harbour-island-insider' ),
		'hii_mailchimp_list_id'      => __( 'Mailchimp List / Audience ID', 'harbour-island-insider' ),
		'hii_valentines_booking_url' => __( 'Valentines Booking URL', 'harbour-island-insider' ),
		'hii_valentines_phone'       => __( 'Valentines Phone Number', 'harbour-island-insider' ),
	);

	foreach ( $fields as $option_name => $label ) {
		register_setting( 'hii-settings-group', $option_name, array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		add_settings_field(
			$option_name,
			$label,
			'hii_text_field_render',
			'hii-settings',
			'hii_general_section',
			array( 'option' => $option_name )
		);
	}
}
add_action( 'admin_init', 'hii_register_settings' );

function hii_text_field_render( $args ) {
	$value = get_option( $args['option'], '' );
	printf(
		'<input type="text" name="%s" value="%s" class="regular-text" />',
		esc_attr( $args['option'] ),
		esc_attr( $value )
	);
}

function hii_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Harbour Island Insider Settings', 'harbour-island-insider' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'hii-settings-group' );
			do_settings_sections( 'hii-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}
