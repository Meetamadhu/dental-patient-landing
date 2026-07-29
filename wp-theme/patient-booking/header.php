<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#contact"><?php esc_html_e('Skip to contact form', 'patient-booking'); ?></a>

<header class="site-header">
  <div class="site-header__inner">
    <a class="brand-mark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(pb_get('practice_name')); ?>">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <img class="brand-mark__logo" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo.png'); ?>" alt="<?php echo esc_attr(pb_get('practice_name')); ?>" width="180" height="44" />
      <?php endif; ?>
    </a>
    <nav aria-label="<?php esc_attr_e('Primary', 'patient-booking'); ?>">
      <ul class="header-nav">
        <li><a class="is-active" href="#top"><?php esc_html_e('Home', 'patient-booking'); ?></a></li>
        <li><a href="#services"><?php esc_html_e('Treatments', 'patient-booking'); ?></a></li>
        <li><a href="#reviews"><?php esc_html_e('Patients', 'patient-booking'); ?></a></li>
        <li><a href="#contact"><?php esc_html_e('Contact', 'patient-booking'); ?></a></li>
      </ul>
    </nav>
    <div class="header-actions">
      <?php get_template_part('template-parts/social-links', null, array('class' => 'header-social', 'as_list' => true)); ?>
      <a class="phone-link" href="<?php echo esc_url('tel:' . preg_replace('/[^\d+]/', '', pb_get('phone'))); ?>" aria-label="<?php echo esc_attr(sprintf(__('Call %s', 'patient-booking'), pb_get('practice_name'))); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.81.36 1.6.68 2.34a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.74-1.74a2 2 0 0 1 2.11-.45c.74.32 1.53.55 2.34.68A2 2 0 0 1 22 16.92z"/></svg>
        <span class="phone-link__text"><?php esc_html_e('Call now', 'patient-booking'); ?></span>
      </a>
      <a class="btn btn--orange btn--header" href="#contact" data-track-cta="header"><?php esc_html_e('Book your visit', 'patient-booking'); ?></a>
    </div>
  </div>
</header>
