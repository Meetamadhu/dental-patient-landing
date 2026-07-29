<?php
/**
 * Shared social media icon links
 */
if (!defined('ABSPATH')) {
    exit;
}

$networks = array(
    'facebook'  => array(
        'url'   => pb_get('social_facebook'),
        'label' => 'Facebook',
        'svg'   => '<path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H8v3h3v7h3v-7h3l1-3h-4V9c0-.6.4-1 1-1z"/>',
    ),
    'instagram' => array(
        'url'   => pb_get('social_instagram'),
        'label' => 'Instagram',
        'svg'   => '<path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm5 4.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5zm5.2-.9a1.1 1.1 0 1 0 1.1 1.1 1.1 1.1 0 0 0-1.1-1.1zM12 9.5A2.5 2.5 0 1 1 9.5 12 2.5 2.5 0 0 1 12 9.5z"/>',
    ),
    'linkedin'  => array(
        'url'   => pb_get('social_linkedin'),
        'label' => 'LinkedIn',
        'svg'   => '<path d="M6.5 9H3v12h3.5V9zM4.8 3A2 2 0 1 0 4.8 7a2 2 0 0 0 0-4zM21 13.4c0-3-1.6-4.4-3.8-4.4a3.3 3.3 0 0 0-3 1.7V9H10.8v12H14.3v-6.4c0-1.7.3-3.3 2.4-3.3s2.1 1.9 2.1 3.4V21H22v-7.6z"/>',
    ),
    'google'    => array(
        'url'   => pb_get('social_google'),
        'label' => 'Google Business Profile',
        'svg'   => '<path d="M21.6 12.23c0-.68-.06-1.33-.17-1.96H12v3.71h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.89-1.74 2.98-4.3 2.98-7.27z"/><path d="M12 22c2.7 0 4.97-.9 6.63-2.43l-3.24-2.5c-.9.6-2.05.96-3.39.96-2.61 0-4.82-1.76-5.61-4.13H3.06v2.58A10 10 0 0 0 12 22z"/><path d="M6.39 13.9A6 6 0 0 1 6.08 12c0-.66.11-1.3.3-1.9V7.52H3.06A10 10 0 0 0 2 12c0 1.61.39 3.14 1.06 4.48l3.33-2.58z"/><path d="M12 5.98c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.96 2.97 14.7 2 12 2A10 10 0 0 0 3.06 7.52l3.33 2.58C7.18 7.74 9.39 5.98 12 5.98z"/>',
    ),
    'youtube'   => array(
        'url'   => pb_get('social_youtube'),
        'label' => 'YouTube',
        'svg'   => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.8zM9.8 15.5v-7l6.2 3.5-6.2 3.5z"/>',
    ),
);

$as_list = !empty($args['as_list']);
$class   = !empty($args['class']) ? $args['class'] : 'footer-social';

if ($as_list) {
    echo '<ul class="' . esc_attr($class) . '" aria-label="' . esc_attr__('Social media', 'patient-booking') . '">';
} else {
    echo '<div class="' . esc_attr($class) . '" aria-label="' . esc_attr__('Social links', 'patient-booking') . '">';
}

foreach ($networks as $key => $network) {
    if (empty($network['url'])) {
        continue;
    }
    if ($as_list) {
        echo '<li>';
    }
    printf(
        '<a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s" data-social="%3$s"><svg viewBox="0 0 24 24" aria-hidden="true">%4$s</svg></a>',
        esc_url($network['url']),
        esc_attr($network['label']),
        esc_attr($key),
        $network['svg']
    );
    if ($as_list) {
        echo '</li>';
    }
}

echo $as_list ? '</ul>' : '</div>';
