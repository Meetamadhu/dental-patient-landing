<?php
/**
 * Patient Booking Landing — theme setup
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PB_THEME_VERSION', '1.0.0');

function pb_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
}
add_action('after_setup_theme', 'pb_setup');

function pb_scripts() {
    wp_enqueue_style(
        'pb-fonts',
        'https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700;800&family=Outfit:wght@600;700&display=swap',
        array(),
        null
    );
    wp_enqueue_style(
        'pb-main',
        get_template_directory_uri() . '/assets/css/styles.css',
        array('pb-fonts'),
        PB_THEME_VERSION
    );
    wp_enqueue_script(
        'pb-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        PB_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'pb_scripts');

/**
 * Defaults — override in Customizer
 */
function pb_defaults() {
    return array(
        'practice_name'   => 'Harbour Smile Studio',
        'practice_tag'    => 'Specialist dentistry',
        'phone'           => '+15550123456',
        'phone_display'   => '(555) 012-3456',
        'address'         => '123 Harbour Way, Suite 200 · Mon–Fri 8–6 · Sat by appointment',
        'headline'        => 'Your smile, scheduled around your life',
        'support'         => 'Implants · Invisalign · Cosmetic care — routed to the right chair',
        'badge_1'         => '4.9★ Google-rated',
        'badge_2'         => 'Same-week openings',
        'badge_3'         => 'Specialist-routed care',
        'hero_image'      => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1600&q=70',
        'booking_endpoint'=> '',
        'gtm_id'          => '',
        'ga4_id'          => '',
        'color_ink'       => '#2d3436',
        'color_teal'      => '#24c4cf',
        'color_teal_deep' => '#12a8b3',
        'color_mist'      => '#f4f6f8',
        'color_orange'    => '#f39c12',
        'social_facebook' => 'https://www.facebook.com/harboursmilestudio',
        'social_instagram'=> 'https://www.instagram.com/harboursmilestudio',
        'social_linkedin' => 'https://www.linkedin.com/company/harboursmilestudio',
        'social_google'   => 'https://g.page/harboursmilestudio',
        'social_youtube'  => 'https://www.youtube.com/@harboursmilestudio',
        't1_quote'        => 'I booked an implant consult online on my lunch break. They called the same afternoon and had me in that week.',
        't1_name'         => 'Maya R., dental implants',
        't1_photo'        => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=160&q=70',
        't2_quote'        => 'The Invisalign process felt clear from day one. No pressure—just a plan that fit my calendar.',
        't2_name'         => 'Daniel K., Invisalign',
        't2_photo'        => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=160&q=70',
        't3_quote'        => 'I wanted a subtle cosmetic refresh. The team listened, showed options, and I left feeling like myself—only brighter.',
        't3_name'         => 'Priya S., cosmetic dentistry',
        't3_photo'        => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=160&q=70',
    );
}

function pb_get($key) {
    $defaults = pb_defaults();
    $default  = isset($defaults[$key]) ? $defaults[$key] : '';
    return get_theme_mod('pb_' . $key, $default);
}

function pb_customize_register($wp_customize) {
    $wp_customize->add_section('pb_practice', array(
        'title'    => __('Practice details', 'patient-booking'),
        'priority' => 30,
    ));
    $wp_customize->add_section('pb_copy', array(
        'title'    => __('Landing copy', 'patient-booking'),
        'priority' => 31,
    ));
    $wp_customize->add_section('pb_brand', array(
        'title'    => __('Brand colours', 'patient-booking'),
        'priority' => 32,
    ));
    $wp_customize->add_section('pb_social', array(
        'title'    => __('Social media links', 'patient-booking'),
        'priority' => 33,
    ));
    $wp_customize->add_section('pb_reviews', array(
        'title'    => __('Testimonials', 'patient-booking'),
        'priority' => 34,
    ));
    $wp_customize->add_section('pb_tracking', array(
        'title'    => __('Analytics & booking', 'patient-booking'),
        'priority' => 35,
    ));

    $text_fields = array(
        'pb_practice' => array(
            'practice_name' => array('Practice name', 'text'),
            'practice_tag'  => array('Tagline under name', 'text'),
            'phone'         => array('Phone (tel: link, e.g. +15550123456)', 'text'),
            'phone_display' => array('Phone display text', 'text'),
            'address'       => array('Address / hours', 'textarea'),
        ),
        'pb_copy' => array(
            'headline'   => array('Hero headline', 'text'),
            'support'    => array('Hero supporting sentence', 'textarea'),
            'badge_1'    => array('Trust badge 1', 'text'),
            'badge_2'    => array('Trust badge 2', 'text'),
            'badge_3'    => array('Trust badge 3', 'text'),
            'hero_image' => array('Hero image URL', 'text'),
        ),
        'pb_tracking' => array(
            'booking_endpoint' => array('Booking webhook / endpoint URL (blank = built-in WP lead capture)', 'text'),
            'gtm_id'           => array('GTM container ID (GTM-XXXX)', 'text'),
            'ga4_id'           => array('GA4 measurement ID (G-XXXX)', 'text'),
        ),
        'pb_social' => array(
            'social_facebook'  => array('Facebook URL', 'url'),
            'social_instagram' => array('Instagram URL', 'url'),
            'social_linkedin'  => array('LinkedIn URL', 'url'),
            'social_google'    => array('Google Business URL', 'url'),
            'social_youtube'   => array('YouTube URL', 'url'),
        ),
    );

    foreach ($text_fields as $section => $fields) {
        foreach ($fields as $key => $meta) {
            list($label, $type) = $meta;
            $sanitize = 'sanitize_text_field';
            if ($type === 'textarea') {
                $sanitize = 'sanitize_textarea_field';
            } elseif ($type === 'url') {
                $sanitize = 'esc_url_raw';
            }
            $wp_customize->add_setting('pb_' . $key, array(
                'default'           => pb_defaults()[$key],
                'sanitize_callback' => $sanitize,
                'transport'         => 'refresh',
            ));
            $wp_customize->add_control('pb_' . $key, array(
                'label'   => __($label, 'patient-booking'),
                'section' => $section,
                'type'    => ($type === 'url') ? 'url' : $type,
            ));
        }
    }

    $colors = array(
        'color_ink'       => 'Ink / text',
        'color_teal'      => 'Teal accent',
        'color_teal_deep' => 'Teal deep',
        'color_mist'      => 'Gray background',
        'color_orange'    => 'Orange CTA accent',
    );
    foreach ($colors as $key => $label) {
        $wp_customize->add_setting('pb_' . $key, array(
            'default'           => pb_defaults()[$key],
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pb_' . $key, array(
            'label'   => __($label, 'patient-booking'),
            'section' => 'pb_brand',
        )));
    }

    for ($i = 1; $i <= 3; $i++) {
        foreach (array('quote', 'name', 'photo') as $part) {
            $key = "t{$i}_{$part}";
            $wp_customize->add_setting('pb_' . $key, array(
                'default'           => pb_defaults()[$key],
                'sanitize_callback' => $part === 'quote' ? 'sanitize_textarea_field' : 'sanitize_text_field',
            ));
            $wp_customize->add_control('pb_' . $key, array(
                'label'   => sprintf(__('Testimonial %d %s', 'patient-booking'), $i, $part),
                'section' => 'pb_reviews',
                'type'    => $part === 'quote' ? 'textarea' : 'text',
            ));
        }
    }
}
add_action('customize_register', 'pb_customize_register');

function pb_custom_css() {
    $ink    = pb_get('color_ink');
    $teal   = pb_get('color_teal');
    $deep   = pb_get('color_teal_deep');
    $mist   = pb_get('color_mist');
    $orange = pb_get('color_orange');
    echo '<style id="pb-brand-vars">:root{';
    echo '--brand-ink:' . esc_attr($ink) . ';';
    echo '--brand-teal:' . esc_attr($teal) . ';';
    echo '--brand-teal-deep:' . esc_attr($deep) . ';';
    echo '--brand-gray:' . esc_attr($mist) . ';';
    echo '--brand-orange:' . esc_attr($orange) . ';';
    echo '}</style>';
}
add_action('wp_head', 'pb_custom_css', 20);

function pb_gtm_head() {
    $gtm = trim(pb_get('gtm_id'));
    $ga4 = trim(pb_get('ga4_id'));

    if ($ga4) {
        echo "<!-- GA4 -->\n";
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr($ga4) . '"></script>' . "\n";
        echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','" . esc_js($ga4) . "');</script>\n";
    }

    if ($gtm) {
        echo "<!-- Google Tag Manager -->\n";
        echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . esc_js($gtm) . "');</script>\n";
    } else {
        echo "<script>window.dataLayer=window.dataLayer||[];</script>\n";
    }
}
add_action('wp_head', 'pb_gtm_head', 1);

function pb_gtm_body() {
    $gtm = trim(pb_get('gtm_id'));
    if (!$gtm) {
        return;
    }
    echo '<!-- Google Tag Manager (noscript) -->';
    echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr($gtm) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
}
add_action('wp_body_open', 'pb_gtm_body');

/**
 * Optional REST endpoint for booking posts (stores as CPT-less option log + fires action for CRM plugins)
 */
function pb_register_booking_route() {
    register_rest_route('patient-booking/v1', '/lead', array(
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => 'pb_handle_lead',
    ));
    register_rest_route('patient-booking/v1', '/contact', array(
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => 'pb_handle_contact',
    ));
}
add_action('rest_api_init', 'pb_register_booking_route');

function pb_handle_contact(WP_REST_Request $request) {
    $params = $request->get_json_params();
    if (!is_array($params)) {
        $params = $request->get_params();
    }

    $name    = sanitize_text_field($params['full_name'] ?? '');
    $phone   = sanitize_text_field($params['phone'] ?? '');
    $email   = sanitize_email($params['email'] ?? '');
    $message = sanitize_textarea_field($params['message'] ?? '');

    if (strlen($name) < 2 || empty($phone) || !is_email($email) || strlen($message) < 5) {
        return new WP_REST_Response(array('ok' => false, 'message' => 'Invalid fields'), 400);
    }

    $lead = array(
        'full_name' => $name,
        'phone'     => $phone,
        'email'     => $email,
        'message'   => $message,
        'created'   => current_time('mysql'),
        'source'    => 'contact_form',
    );

    $existing = get_option('pb_contact_leads', array());
    if (!is_array($existing)) {
        $existing = array();
    }
    array_unshift($existing, $lead);
    $existing = array_slice($existing, 0, 200);
    update_option('pb_contact_leads', $existing, false);

    $admin = get_option('admin_email');
    $subject = sprintf('[%s] Contact form — %s', pb_get('practice_name'), $name);
    $body = "Name: {$lead['full_name']}\nPhone: {$lead['phone']}\nEmail: {$lead['email']}\nMessage:\n{$lead['message']}\n";
    wp_mail($admin, $subject, $body);

    do_action('pb_contact_lead', $lead);

    return new WP_REST_Response(array('ok' => true), 200);
}

function pb_handle_lead(WP_REST_Request $request) {
    $params = $request->get_json_params();
    if (!is_array($params)) {
        $params = $request->get_params();
    }

    $name  = sanitize_text_field($params['full_name'] ?? '');
    $phone = sanitize_text_field($params['phone'] ?? '');
    $email = sanitize_email($params['email'] ?? '');

    if (strlen($name) < 2 || empty($phone) || !is_email($email)) {
        return new WP_REST_Response(array('ok' => false, 'message' => 'Invalid fields'), 400);
    }

    $lead = array(
        'full_name'      => $name,
        'phone'          => $phone,
        'email'          => $email,
        'treatment'      => sanitize_text_field($params['treatment'] ?? ''),
        'preferred_time' => sanitize_text_field($params['preferred_time'] ?? ''),
        'created'        => current_time('mysql'),
        'source'         => 'landing_booking',
    );

    $existing = get_option('pb_leads', array());
    if (!is_array($existing)) {
        $existing = array();
    }
    array_unshift($existing, $lead);
    $existing = array_slice($existing, 0, 200);
    update_option('pb_leads', $existing, false);

    $admin = get_option('admin_email');
    $subject = sprintf('[%s] New booking request — %s', pb_get('practice_name'), $name);
    $body = "Name: {$lead['full_name']}\nPhone: {$lead['phone']}\nEmail: {$lead['email']}\nTreatment: {$lead['treatment']}\nPreferred time: {$lead['preferred_time']}\n";
    wp_mail($admin, $subject, $body);

    /**
     * Hook for scheduling software / CRM bridges
     * do_action('pb_booking_lead', $lead);
     */
    do_action('pb_booking_lead', $lead);

    return new WP_REST_Response(array('ok' => true), 200);
}

/**
 * Simple admin screen to review captured leads
 */
function pb_admin_menu() {
    add_menu_page(
        __('Booking leads', 'patient-booking'),
        __('Booking leads', 'patient-booking'),
        'manage_options',
        'pb-leads',
        'pb_render_leads_page',
        'dashicons-calendar-alt',
        26
    );
}
add_action('admin_menu', 'pb_admin_menu');

function pb_render_leads_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    $leads = get_option('pb_leads', array());
    if (!is_array($leads)) {
        $leads = array();
    }
    echo '<div class="wrap"><h1>' . esc_html__('Booking leads', 'patient-booking') . '</h1>';
    echo '<p>' . esc_html__('Partial abandon capture is stored in the visitor’s browser and pushed as a partial_lead analytics event. Completed requests appear below and are emailed to the site admin.', 'patient-booking') . '</p>';
    if (empty($leads)) {
        echo '<p>' . esc_html__('No leads yet.', 'patient-booking') . '</p></div>';
        return;
    }
    echo '<table class="widefat striped"><thead><tr>';
    foreach (array('Created', 'Name', 'Phone', 'Email', 'Treatment', 'Preferred time') as $h) {
        echo '<th>' . esc_html($h) . '</th>';
    }
    echo '</tr></thead><tbody>';
    foreach ($leads as $lead) {
        echo '<tr>';
        echo '<td>' . esc_html($lead['created'] ?? '') . '</td>';
        echo '<td>' . esc_html($lead['full_name'] ?? '') . '</td>';
        echo '<td>' . esc_html($lead['phone'] ?? '') . '</td>';
        echo '<td>' . esc_html($lead['email'] ?? '') . '</td>';
        echo '<td>' . esc_html($lead['treatment'] ?? '') . '</td>';
        echo '<td>' . esc_html($lead['preferred_time'] ?? '') . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}
