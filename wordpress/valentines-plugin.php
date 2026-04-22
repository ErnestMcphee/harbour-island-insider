<?php
/**
 * Plugin Name: Valentines Resort & Marina
 * Plugin URI:  https://valentinesresort.com
 * Description: Custom post types, shortcodes, SEO meta, Mailchimp integration,
 *              and booking enquiry handling for Valentines Resort & Marina.
 * Version:     1.0.0
 * Author:      Valentines Resort & Marina
 * Text Domain: valentines-resort
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Never load directly

// ============================================================
// 1. CUSTOM POST TYPES
// ============================================================

add_action( 'init', 'valentines_register_post_types' );

function valentines_register_post_types() {

    // --- Marina Slips ---
    register_post_type( 'marina_slip', [
        'labels'      => [
            'name'          => 'Marina Slips',
            'singular_name' => 'Marina Slip',
            'add_new_item'  => 'Add New Slip',
            'edit_item'     => 'Edit Slip',
        ],
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-admin-site-alt3',
        'supports'    => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'rewrite'     => [ 'slug' => 'marina-slips' ],
        'show_in_rest'=> true,
    ] );

    // --- Accommodations (Rooms / Villas) ---
    register_post_type( 'accommodation', [
        'labels'      => [
            'name'          => 'Accommodations',
            'singular_name' => 'Accommodation',
            'add_new_item'  => 'Add New Room / Villa',
            'edit_item'     => 'Edit Accommodation',
        ],
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-building',
        'supports'    => [ 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ],
        'rewrite'     => [ 'slug' => 'accommodations' ],
        'show_in_rest'=> true,
    ] );

    // --- Experiences / Activities ---
    register_post_type( 'experience', [
        'labels'      => [
            'name'          => 'Experiences',
            'singular_name' => 'Experience',
            'add_new_item'  => 'Add New Experience',
            'edit_item'     => 'Edit Experience',
        ],
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-star-filled',
        'supports'    => [ 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ],
        'rewrite'     => [ 'slug' => 'experiences' ],
        'show_in_rest'=> true,
    ] );

    // --- Testimonials ---
    register_post_type( 'testimonial', [
        'labels'      => [
            'name'          => 'Testimonials',
            'singular_name' => 'Testimonial',
            'add_new_item'  => 'Add New Testimonial',
        ],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-format-quote',
        'supports'    => [ 'title', 'editor', 'custom-fields' ],
        'show_in_rest'=> true,
    ] );

    // --- Team Members ---
    register_post_type( 'team_member', [
        'labels'      => [
            'name'          => 'Team Members',
            'singular_name' => 'Team Member',
        ],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-id',
        'supports'    => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'show_in_rest'=> true,
    ] );
}

// ============================================================
// 2. CUSTOM TAXONOMIES
// ============================================================

add_action( 'init', 'valentines_register_taxonomies' );

function valentines_register_taxonomies() {

    // Blog categories (beyond default)
    register_taxonomy( 'journal_category', 'post', [
        'labels'       => [
            'name'          => 'Journal Categories',
            'singular_name' => 'Journal Category',
        ],
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'journal' ],
        'show_in_rest' => true,
    ] );

    // Room / Villa types
    register_taxonomy( 'room_type', 'accommodation', [
        'labels'       => [ 'name' => 'Room Types', 'singular_name' => 'Room Type' ],
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'room-type' ],
        'show_in_rest' => true,
    ] );

    // Experience categories
    register_taxonomy( 'experience_type', 'experience', [
        'labels'       => [ 'name' => 'Experience Types', 'singular_name' => 'Experience Type' ],
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'experience-type' ],
        'show_in_rest' => true,
    ] );
}

// ============================================================
// 3. CUSTOM META BOXES
// ============================================================

add_action( 'add_meta_boxes', 'valentines_add_meta_boxes' );

function valentines_add_meta_boxes() {

    // Accommodation details
    add_meta_box(
        'accommodation_details',
        'Accommodation Details',
        'valentines_accommodation_meta_cb',
        'accommodation',
        'normal',
        'high'
    );

    // Marina slip details
    add_meta_box(
        'slip_details',
        'Marina Slip Details',
        'valentines_slip_meta_cb',
        'marina_slip',
        'normal',
        'high'
    );

    // Testimonial details
    add_meta_box(
        'testimonial_details',
        'Testimonial Details',
        'valentines_testimonial_meta_cb',
        'testimonial',
        'normal',
        'high'
    );
}

function valentines_accommodation_meta_cb( $post ) {
    wp_nonce_field( 'valentines_meta_nonce', 'valentines_nonce' );
    $fields = [
        'nightly_rate'  => [ 'label' => 'Nightly Rate (USD)', 'type' => 'number' ],
        'max_guests'    => [ 'label' => 'Max Guests',          'type' => 'number' ],
        'bedrooms'      => [ 'label' => 'Bedrooms',            'type' => 'number' ],
        'bathrooms'     => [ 'label' => 'Bathrooms',           'type' => 'number' ],
        'square_feet'   => [ 'label' => 'Square Feet',         'type' => 'number' ],
        'view_type'     => [ 'label' => 'View Type',           'type' => 'text'   ],
        'amenities'     => [ 'label' => 'Amenities (comma-sep)','type' => 'text'  ],
        'booking_link'  => [ 'label' => 'External Booking URL','type' => 'url'    ],
    ];
    echo '<table class="form-table">';
    foreach ( $fields as $key => $f ) {
        $val = esc_attr( get_post_meta( $post->ID, "_valentines_{$key}", true ) );
        echo "<tr><th><label for='valentines_{$key}'>{$f['label']}</label></th>";
        echo "<td><input type='{$f['type']}' id='valentines_{$key}' name='valentines_{$key}' value='{$val}' class='regular-text' /></td></tr>";
    }
    echo '</table>';
}

function valentines_slip_meta_cb( $post ) {
    wp_nonce_field( 'valentines_meta_nonce', 'valentines_nonce' );
    $fields = [
        'max_loa'     => [ 'label' => 'Max LOA (ft)',    'type' => 'number' ],
        'max_beam'    => [ 'label' => 'Max Beam (ft)',   'type' => 'number' ],
        'max_draft'   => [ 'label' => 'Max Draft (ft)',  'type' => 'number' ],
        'power'       => [ 'label' => 'Power (30A/50A/100A)', 'type' => 'text' ],
        'daily_rate'  => [ 'label' => 'Daily Rate (USD/ft)', 'type' => 'number' ],
        'slip_number' => [ 'label' => 'Slip Number/ID',  'type' => 'text'   ],
    ];
    echo '<table class="form-table">';
    foreach ( $fields as $key => $f ) {
        $val = esc_attr( get_post_meta( $post->ID, "_valentines_{$key}", true ) );
        echo "<tr><th><label for='valentines_{$key}'>{$f['label']}</label></th>";
        echo "<td><input type='{$f['type']}' id='valentines_{$key}' name='valentines_{$key}' value='{$val}' class='regular-text' /></td></tr>";
    }
    echo '</table>';
}

function valentines_testimonial_meta_cb( $post ) {
    wp_nonce_field( 'valentines_meta_nonce', 'valentines_nonce' );
    $fields = [
        'guest_name'     => 'Guest Name',
        'guest_location' => 'Guest Location / Boat Name',
        'stay_type'      => 'Stay Type (Marina / Hotel / Villa)',
        'rating'         => 'Rating (1–5)',
        'review_source'  => 'Source (Google / TripAdvisor / Direct)',
    ];
    echo '<table class="form-table">';
    foreach ( $fields as $key => $label ) {
        $val = esc_attr( get_post_meta( $post->ID, "_valentines_{$key}", true ) );
        echo "<tr><th><label for='valentines_{$key}'>{$label}</label></th>";
        echo "<td><input type='text' id='valentines_{$key}' name='valentines_{$key}' value='{$val}' class='regular-text' /></td></tr>";
    }
    echo '</table>';
}

// Save meta boxes
add_action( 'save_post', 'valentines_save_meta' );

function valentines_save_meta( $post_id ) {
    if (
        ! isset( $_POST['valentines_nonce'] ) ||
        ! wp_verify_nonce( $_POST['valentines_nonce'], 'valentines_meta_nonce' ) ||
        ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
        ! current_user_can( 'edit_post', $post_id )
    ) return;

    $fields = [
        'nightly_rate','max_guests','bedrooms','bathrooms','square_feet',
        'view_type','amenities','booking_link',
        'max_loa','max_beam','max_draft','power','daily_rate','slip_number',
        'guest_name','guest_location','stay_type','rating','review_source',
    ];

    foreach ( $fields as $key ) {
        if ( isset( $_POST["valentines_{$key}"] ) ) {
            update_post_meta(
                $post_id,
                "_valentines_{$key}",
                sanitize_text_field( $_POST["valentines_{$key}"] )
            );
        }
    }
}

// ============================================================
// 4. SHORTCODES
// ============================================================

// [valentines_booking_form] — inline booking enquiry form
add_shortcode( 'valentines_booking_form', 'valentines_booking_form_shortcode' );

function valentines_booking_form_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'title'       => 'Reserve Your Stay',
        'show_marina' => 'yes',
        'button_text' => 'Check Availability',
    ], $atts );

    ob_start(); ?>
    <div class="valentines-booking-form" style="background:#f5f5f5; padding:32px; border-radius:12px; max-width:680px; margin:0 auto;">
        <h3 style="margin-top:0;"><?php echo esc_html( $atts['title'] ); ?></h3>
        <form method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
            <?php wp_nonce_field( 'valentines_booking_enquiry', 'booking_nonce' ); ?>
            <input type="hidden" name="action" value="valentines_booking_enquiry" />
            <p>
                <label>Check-In <br><input type="date" name="checkin" required /></label>
                &nbsp;&nbsp;
                <label>Check-Out <br><input type="date" name="checkout" required /></label>
            </p>
            <p>
                <label>Guests <br>
                    <select name="guests">
                        <?php for ( $i = 1; $i <= 10; $i++ ) echo "<option value='{$i}'>{$i}</option>"; ?>
                    </select>
                </label>
                &nbsp;&nbsp;
                <label>Accommodation Type <br>
                    <select name="room_type">
                        <option value="hotel_room">Hotel Room</option>
                        <option value="marina_view_suite">Marina View Suite</option>
                        <option value="marina_villa">Marina Villa</option>
                        <?php if ( 'yes' === $atts['show_marina'] ) : ?>
                        <option value="marina_slip">Marina Slip Only</option>
                        <?php endif; ?>
                    </select>
                </label>
            </p>
            <p>
                <label>Your Name <br><input type="text" name="guest_name" required style="width:100%;" /></label>
            </p>
            <p>
                <label>Email Address <br><input type="email" name="guest_email" required style="width:100%;" /></label>
            </p>
            <p>
                <label>Phone (optional) <br><input type="tel" name="guest_phone" style="width:100%;" /></label>
            </p>
            <p>
                <label>Special Requests <br><textarea name="special_requests" rows="3" style="width:100%;"></textarea></label>
            </p>
            <p>
                <button type="submit" style="background:#E07B54;color:#fff;border:none;padding:12px 28px;border-radius:50px;font-size:1rem;cursor:pointer;">
                    <?php echo esc_html( $atts['button_text'] ); ?> →
                </button>
            </p>
            <p style="font-size:.8rem; color:#666;">No payment required. We'll respond within 2 hours.</p>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

// Handle booking enquiry form submission
add_action( 'admin_post_valentines_booking_enquiry', 'valentines_handle_booking' );
add_action( 'admin_post_nopriv_valentines_booking_enquiry', 'valentines_handle_booking' );

function valentines_handle_booking() {
    if (
        ! isset( $_POST['booking_nonce'] ) ||
        ! wp_verify_nonce( $_POST['booking_nonce'], 'valentines_booking_enquiry' )
    ) wp_die( 'Security check failed.' );

    $name    = sanitize_text_field( $_POST['guest_name'] ?? '' );
    $email   = sanitize_email( $_POST['guest_email'] ?? '' );
    $phone   = sanitize_text_field( $_POST['guest_phone'] ?? '' );
    $checkin = sanitize_text_field( $_POST['checkin'] ?? '' );
    $checkout= sanitize_text_field( $_POST['checkout'] ?? '' );
    $guests  = intval( $_POST['guests'] ?? 1 );
    $type    = sanitize_text_field( $_POST['room_type'] ?? '' );
    $notes   = sanitize_textarea_field( $_POST['special_requests'] ?? '' );

    // Store as a custom post for the enquiry log
    wp_insert_post( [
        'post_type'   => 'booking_enquiry',
        'post_title'  => sanitize_text_field( "{$name} — {$checkin} to {$checkout}" ),
        'post_status' => 'private',
        'meta_input'  => [
            '_valentines_guest_email'    => $email,
            '_valentines_guest_phone'    => $phone,
            '_valentines_checkin'        => $checkin,
            '_valentines_checkout'       => $checkout,
            '_valentines_guests'         => $guests,
            '_valentines_room_type'      => $type,
            '_valentines_special_notes'  => $notes,
        ],
    ] );

    // Email the resort
    $to      = get_option( 'valentines_enquiry_email', get_option('admin_email') );
    $subject = "New Booking Enquiry: {$name} ({$checkin} → {$checkout})";
    $body    = "New enquiry received.\n\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\n"
             . "Check-In: {$checkin}\nCheck-Out: {$checkout}\nGuests: {$guests}\n"
             . "Type: {$type}\n\nNotes:\n{$notes}";

    wp_mail( $to, $subject, $body, [ 'From: Valentines Resort <noreply@valentinesresort.com>' ] );

    // Email confirmation to guest
    wp_mail(
        $email,
        "Your Valentines Resort Enquiry — We'll Be in Touch Soon!",
        valentines_confirmation_email( $name, $checkin, $checkout ),
        [
            'From: Valentines Resort & Marina <reservations@valentinesresort.com>',
            'Content-Type: text/html; charset=UTF-8',
        ]
    );

    // Redirect to thank-you page (create a page with slug 'booking-confirmed', or fall back to home)
    $redirect = get_permalink( get_page_by_path('booking-confirmed') ) ?: home_url('/?booking=confirmed');
    wp_safe_redirect( add_query_arg( 'booking', 'confirmed', $redirect ) );
    exit;
}

function valentines_confirmation_email( $name, $checkin, $checkout ) {
    return "
    <html><body style='font-family:Georgia,serif; color:#1A1A2E; max-width:600px; margin:0 auto;'>
        <div style='background:#023E8A; padding:32px; text-align:center;'>
            <h1 style='color:#fff; margin:0; font-size:1.4rem;'>Valentines Resort & Marina</h1>
            <p style='color:rgba(255,255,255,.7); margin:4px 0 0; font-size:.85rem; letter-spacing:.08em; text-transform:uppercase; font-family:sans-serif;'>Harbour Island · Bahamas</p>
        </div>
        <div style='padding:40px;'>
            <h2>Hi {$name}, we've received your enquiry!</h2>
            <p>Thank you for reaching out. Our reservations team will confirm availability for your requested dates within 2 hours.</p>
            <div style='background:#F5E6C8; border-radius:8px; padding:20px; margin:24px 0;'>
                <strong>Your requested dates:</strong><br>
                Check-In: <strong>{$checkin}</strong><br>
                Check-Out: <strong>{$checkout}</strong>
            </div>
            <p>In the meantime, explore our <a href='https://valentinesresort.com/journal' style='color:#0077B6;'>Island Journal</a> for tips on getting here, what to pack, and the best things to do on Harbour Island.</p>
            <p>Questions? Call us anytime at <a href='tel:+12423332142' style='color:#0077B6;'>+1 (242) 333-2142</a> or hail us on VHF Channel 16.</p>
            <p>We can't wait to welcome you! 🌊</p>
            <p>— The Valentines Team</p>
        </div>
        <div style='background:#1A1A2E; padding:20px; text-align:center;'>
            <p style='color:rgba(255,255,255,.5); font-size:.75rem; font-family:sans-serif; margin:0;'>
                © 2026 Valentines Resort & Marina · Harbour Island, Bahamas<br>
                <a href='https://valentinesresort.com' style='color:rgba(255,255,255,.4);'>valentinesresort.com</a>
            </p>
        </div>
    </body></html>";
}

// [valentines_testimonials] — outputs recent testimonials
add_shortcode( 'valentines_testimonials', 'valentines_testimonials_shortcode' );

function valentines_testimonials_shortcode( $atts ) {
    $atts = shortcode_atts( [ 'count' => 4 ], $atts );
    $posts = get_posts( [
        'post_type'      => 'testimonial',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby'        => 'rand',
    ] );
    if ( ! $posts ) return '';

    $out = '<div class="valentines-testimonials" style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;">';
    foreach ( $posts as $p ) {
        $name    = esc_html( get_post_meta( $p->ID, '_valentines_guest_name', true ) );
        $loc     = esc_html( get_post_meta( $p->ID, '_valentines_guest_location', true ) );
        $rating  = intval( get_post_meta( $p->ID, '_valentines_rating', true ) ?: 5 );
        $stars   = str_repeat( '★', $rating );
        $content = wpautop( wp_kses_post( $p->post_content ) );
        $out .= "
        <div style='background:#fff;border-radius:12px;padding:28px;border:1px solid #E5E7EB;'>
            <div style='color:#F59E0B;font-size:1rem;margin-bottom:12px;'>{$stars}</div>
            <div style='font-style:italic;margin-bottom:16px;'>{$content}</div>
            <strong>{$name}</strong><br>
            <span style='font-size:.8rem;color:#6B7280;'>{$loc}</span>
        </div>";
    }
    $out .= '</div>';
    return $out;
}

// [valentines_newsletter_form] — Mailchimp-connected newsletter signup
add_shortcode( 'valentines_newsletter_form', 'valentines_newsletter_form_shortcode' );

function valentines_newsletter_form_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'title'       => 'Join the Island Journal',
        'description' => 'Monthly cruising tips, dive reports, and exclusive rates for Harbour Island.',
        'button'      => 'Subscribe Free',
    ], $atts );

    ob_start(); ?>
    <div class="valentines-newsletter" style="background:#E07B54;padding:40px;border-radius:16px;color:#fff;max-width:560px;margin:0 auto;">
        <h3 style="color:#fff;margin-top:0;"><?php echo esc_html($atts['title']); ?></h3>
        <p style="color:rgba(255,255,255,.85);margin-bottom:20px;"><?php echo esc_html($atts['description']); ?></p>
        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('valentines_newsletter', 'newsletter_nonce'); ?>
            <input type="hidden" name="action" value="valentines_newsletter_subscribe" />
            <p><input type="text" name="first_name" placeholder="First Name" required style="width:100%;padding:10px 14px;border-radius:6px;border:none;font-size:.95rem;margin-bottom:10px;" /></p>
            <p><input type="email" name="email" placeholder="Email Address" required style="width:100%;padding:10px 14px;border-radius:6px;border:none;font-size:.95rem;margin-bottom:10px;" /></p>
            <p><button type="submit" style="background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.7);padding:11px 24px;border-radius:50px;font-size:.9rem;cursor:pointer;width:100%;">
                <?php echo esc_html($atts['button']); ?> →
            </button></p>
            <p style="font-size:.72rem;color:rgba(255,255,255,.55);text-align:center;">No spam. Unsubscribe anytime.</p>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

// Handle newsletter subscription
add_action( 'admin_post_valentines_newsletter_subscribe', 'valentines_handle_newsletter' );
add_action( 'admin_post_nopriv_valentines_newsletter_subscribe', 'valentines_handle_newsletter' );

function valentines_handle_newsletter() {
    if ( ! isset($_POST['newsletter_nonce']) || ! wp_verify_nonce($_POST['newsletter_nonce'], 'valentines_newsletter') ) {
        wp_die('Security check failed.');
    }

    $email      = sanitize_email( $_POST['email'] ?? '' );
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $api_key    = get_option( 'valentines_mailchimp_api_key', '' );
    $list_id    = get_option( 'valentines_mailchimp_list_id', '' );

    if ( $api_key && $list_id ) {
        $dc       = substr( $api_key, strpos($api_key, '-') + 1 );
        $endpoint = "https://{$dc}.api.mailchimp.com/3.0/lists/{$list_id}/members";
        wp_remote_post( $endpoint, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("anystring:{$api_key}"),
                'Content-Type'  => 'application/json',
            ],
            'body' => wp_json_encode( [
                'email_address' => $email,
                'status'        => 'subscribed',
                'merge_fields'  => [ 'FNAME' => $first_name ],
                'tags'          => [ 'website-signup', 'island-journal' ],
            ] ),
        ] );
    }

    // Welcome email to subscriber
    wp_mail(
        $email,
        "Welcome to the Island Journal! 🌴",
        valentines_welcome_email( $first_name ),
        [ 'From: Valentines Resort <journal@valentinesresort.com>', 'Content-Type: text/html; charset=UTF-8' ]
    );

    wp_safe_redirect( add_query_arg( 'subscribed', '1', wp_get_referer() ?: home_url() ) );
    exit;
}

function valentines_welcome_email( $name ) {
    return "
    <html><body style='font-family:Georgia,serif;color:#1A1A2E;max-width:600px;margin:0 auto;'>
        <div style='background:#E07B54;padding:32px;text-align:center;'>
            <h1 style='color:#fff;margin:0;font-size:1.4rem;'>Welcome to the Island Journal 🌴</h1>
        </div>
        <div style='padding:40px;'>
            <h2>Hi {$name}, welcome aboard!</h2>
            <p>You're now part of a community of 4,200+ ocean lovers who receive monthly dispatches from Harbour Island. Here's what to expect:</p>
            <ul style='line-height:2;'>
                <li>🌊 Monthly cruising conditions & waypoint updates</li>
                <li>🤿 Dive reports and what's been spotted this month</li>
                <li>🍽️ Local food tips and restaurant news</li>
                <li>🎉 Events, regattas, and what's happening on island</li>
                <li>🏷️ Exclusive subscriber-only rates at the resort</li>
            </ul>
            <p>Your first dispatch is on its way. In the meantime, explore our island guide:</p>
            <div style='text-align:center;margin:28px 0;'>
                <a href='https://valentinesresort.com/journal' style='background:#0077B6;color:#fff;padding:12px 28px;border-radius:50px;text-decoration:none;font-family:sans-serif;font-size:.9rem;'>
                    Read the Island Journal →
                </a>
            </div>
            <p>See you on the water! ⚓</p>
            <p>— The Valentines Team</p>
        </div>
        <div style='background:#1A1A2E;padding:20px;text-align:center;'>
            <p style='color:rgba(255,255,255,.4);font-size:.72rem;font-family:sans-serif;margin:0;'>
                Valentines Resort & Marina · Harbour Island, Bahamas<br>
                <a href='#' style='color:rgba(255,255,255,.3);'>Unsubscribe</a>
            </p>
        </div>
    </body></html>";
}

// ============================================================
// 5. SETTINGS PAGE
// ============================================================

add_action( 'admin_menu', 'valentines_settings_menu' );

function valentines_settings_menu() {
    add_options_page(
        'Valentines Resort Settings',
        'Valentines Resort',
        'manage_options',
        'valentines-resort-settings',
        'valentines_settings_page'
    );
}

function valentines_settings_page() {
    if ( isset($_POST['valentines_settings_nonce']) && wp_verify_nonce($_POST['valentines_settings_nonce'], 'valentines_save_settings') ) {
        update_option( 'valentines_enquiry_email',     sanitize_email($_POST['enquiry_email'] ?? '') );
        update_option( 'valentines_mailchimp_api_key', sanitize_text_field($_POST['mailchimp_api_key'] ?? '') );
        update_option( 'valentines_mailchimp_list_id', sanitize_text_field($_POST['mailchimp_list_id'] ?? '') );
        echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
    }

    $email   = get_option('valentines_enquiry_email', get_option('admin_email'));
    $mc_key  = get_option('valentines_mailchimp_api_key', '');
    $mc_list = get_option('valentines_mailchimp_list_id', '');
    ?>
    <div class="wrap">
        <h1>Valentines Resort & Marina — Settings</h1>
        <form method="POST">
            <?php wp_nonce_field('valentines_save_settings','valentines_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="enquiry_email">Enquiry Notification Email</label></th>
                    <td><input type="email" id="enquiry_email" name="enquiry_email" value="<?php echo esc_attr($email); ?>" class="regular-text" />
                        <p class="description">Booking enquiries will be sent to this address.</p></td>
                </tr>
                <tr>
                    <th><label for="mailchimp_api_key">Mailchimp API Key</label></th>
                    <td><input type="text" id="mailchimp_api_key" name="mailchimp_api_key" value="<?php echo esc_attr($mc_key); ?>" class="regular-text" />
                        <p class="description">Found in Mailchimp → Account → Extras → API Keys.</p></td>
                </tr>
                <tr>
                    <th><label for="mailchimp_list_id">Mailchimp Audience / List ID</label></th>
                    <td><input type="text" id="mailchimp_list_id" name="mailchimp_list_id" value="<?php echo esc_attr($mc_list); ?>" class="regular-text" />
                        <p class="description">Found in Mailchimp → Audience → Settings → Audience name and defaults.</p></td>
                </tr>
            </table>
            <?php submit_button('Save Settings'); ?>
        </form>

        <hr />
        <h2>Available Shortcodes</h2>
        <table class="widefat" style="max-width:700px;">
            <thead><tr><th>Shortcode</th><th>Description</th></tr></thead>
            <tbody>
                <tr><td><code>[valentines_booking_form]</code></td><td>Full booking enquiry form with email notification</td></tr>
                <tr><td><code>[valentines_booking_form title="Book a Slip" show_marina="yes"]</code></td><td>Customised booking form for marina guests</td></tr>
                <tr><td><code>[valentines_testimonials count="4"]</code></td><td>Display random testimonials from the testimonials post type</td></tr>
                <tr><td><code>[valentines_newsletter_form]</code></td><td>Mailchimp newsletter signup form</td></tr>
            </tbody>
        </table>
    </div>
    <?php
}

// ============================================================
// 6. SEO META FIELDS (adds Open Graph + description to posts)
// ============================================================

add_action( 'add_meta_boxes', 'valentines_seo_meta_box' );

function valentines_seo_meta_box() {
    add_meta_box(
        'valentines_seo',
        'SEO & Social Sharing',
        'valentines_seo_meta_cb',
        [ 'post', 'page', 'accommodation', 'experience', 'marina_slip' ],
        'normal',
        'high'
    );
}

function valentines_seo_meta_cb( $post ) {
    wp_nonce_field( 'valentines_seo_nonce', 'valentines_seo_nonce_field' );
    $desc    = esc_textarea( get_post_meta( $post->ID, '_valentines_meta_description', true ) );
    $og_img  = esc_url( get_post_meta( $post->ID, '_valentines_og_image', true ) );
    $focus   = esc_attr( get_post_meta( $post->ID, '_valentines_focus_keyword', true ) );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="meta_description">Meta Description</label></th>
            <td>
                <textarea id="meta_description" name="valentines_meta_description" rows="3" style="width:100%;"><?php echo $desc; ?></textarea>
                <p class="description">Keep under 160 characters. Currently: <span id="meta_desc_count"><?php echo mb_strlen($desc); ?></span> characters.</p>
            </td>
        </tr>
        <tr>
            <th><label for="focus_keyword">Focus Keyword</label></th>
            <td><input type="text" id="focus_keyword" name="valentines_focus_keyword" value="<?php echo $focus; ?>" class="regular-text" placeholder="e.g. Harbour Island marina" /></td>
        </tr>
        <tr>
            <th><label for="og_image">Open Graph Image URL</label></th>
            <td><input type="url" id="og_image" name="valentines_og_image" value="<?php echo $og_img; ?>" class="regular-text" placeholder="https://…" /></td>
        </tr>
    </table>
    <script>
        document.getElementById('meta_description').addEventListener('input', function(){
            document.getElementById('meta_desc_count').textContent = this.value.length;
        });
    </script>
    <?php
}

add_action( 'save_post', 'valentines_save_seo_meta' );

function valentines_save_seo_meta( $post_id ) {
    if (
        ! isset($_POST['valentines_seo_nonce_field']) ||
        ! wp_verify_nonce($_POST['valentines_seo_nonce_field'], 'valentines_seo_nonce') ||
        ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) ||
        ! current_user_can('edit_post', $post_id)
    ) return;

    $fields = [
        'valentines_meta_description' => '_valentines_meta_description',
        'valentines_focus_keyword'    => '_valentines_focus_keyword',
        'valentines_og_image'         => '_valentines_og_image',
    ];
    foreach ( $fields as $post_key => $meta_key ) {
        if ( isset($_POST[$post_key]) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field($_POST[$post_key]) );
        }
    }
}

// Output meta tags in <head>
add_action( 'wp_head', 'valentines_output_meta_tags' );

function valentines_output_meta_tags() {
    if ( ! is_singular() ) return;
    global $post;
    $desc   = get_post_meta( $post->ID, '_valentines_meta_description', true );
    $og_img = get_post_meta( $post->ID, '_valentines_og_image', true );
    if ( $desc ) {
        echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($desc) . '" />' . "\n";
    }
    echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '" />' . "\n";
    echo '<meta property="og:type" content="article" />' . "\n";
    if ( $og_img ) {
        echo '<meta property="og:image" content="' . esc_url($og_img) . '" />' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
}

// ============================================================
// 7. AUTO-POPULATE DEFAULT BLOG CATEGORIES ON ACTIVATION
// ============================================================

register_activation_hook( __FILE__, 'valentines_on_activate' );

function valentines_on_activate() {
    valentines_register_post_types();
    valentines_register_taxonomies();
    flush_rewrite_rules();

    $journal_categories = [
        'Marina Life'   => 'Stories, tips, and news from our marina and the cruising community.',
        'Diving'        => 'Dive site guides, marine life reports, and PADI course news.',
        'Island Guide'  => 'Everything to do, see, and experience on Harbour Island.',
        'Food & Drink'  => 'Bahamian cuisine, restaurant guides, and drink recipes.',
        'Travel Tips'   => 'How to get here, when to come, and how to plan your trip.',
        'Marine Life'   => 'Underwater wildlife, conservation, and ocean science.',
    ];

    foreach ( $journal_categories as $name => $description ) {
        if ( ! term_exists( $name, 'journal_category' ) ) {
            wp_insert_term( $name, 'journal_category', [ 'description' => $description ] );
        }
    }

    $room_types = [ 'Hotel Room', 'Marina View Suite', 'Marina Villa', 'Penthouse Suite' ];
    foreach ( $room_types as $rt ) {
        if ( ! term_exists( $rt, 'room_type' ) ) {
            wp_insert_term( $rt, 'room_type' );
        }
    }

    $experience_types = [ 'Diving', 'Snorkelling', 'Fishing', 'Water Sports', 'Dining', 'Island Tours' ];
    foreach ( $experience_types as $et ) {
        if ( ! term_exists( $et, 'experience_type' ) ) {
            wp_insert_term( $et, 'experience_type' );
        }
    }

    // Register booking_enquiry CPT for storing enquiries
    register_post_type( 'booking_enquiry', [
        'labels'      => [ 'name' => 'Booking Enquiries', 'singular_name' => 'Booking Enquiry' ],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-calendar-alt',
        'supports'    => [ 'title', 'custom-fields' ],
        'capability_type' => 'post',
    ] );
}

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
