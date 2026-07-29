<footer class="site-footer">
  <div class="site-footer__inner">
    <div class="footer-brand">
      <a class="footer-brand__mark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(pb_get('practice_name')); ?>">
        <img class="footer-brand__logo" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo.png'); ?>" alt="<?php echo esc_attr(pb_get('practice_name')); ?>" width="200" height="52" />
      </a>
      <p><?php esc_html_e('Specialist dentistry for new patients and complex treatment pathways—implants, Invisalign, and cosmetic care.', 'patient-booking'); ?></p>
      <?php get_template_part('template-parts/social-links', null, array('class' => 'footer-social')); ?>
    </div>

    <div>
      <span class="site-footer__col-title"><?php esc_html_e('Contact', 'patient-booking'); ?></span>
      <ul class="footer-contact">
        <li>
          <span class="footer-contact__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
          </span>
          <span><?php echo esc_html(pb_get('address')); ?></span>
        </li>
        <li>
          <span class="footer-contact__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.81.36 1.6.68 2.34a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.74-1.74a2 2 0 0 1 2.11-.45c.74.32 1.53.55 2.34.68A2 2 0 0 1 22 16.92z"/></svg>
          </span>
          <a href="<?php echo esc_url('tel:' . preg_replace('/[^\d+]/', '', pb_get('phone'))); ?>"><?php echo esc_html(pb_get('phone_display')); ?></a>
        </li>
      </ul>
    </div>

    <div>
      <span class="site-footer__col-title"><?php esc_html_e('Quick links', 'patient-booking'); ?></span>
      <ul class="footer-links">
        <li><a href="#contact"><?php esc_html_e('Book appointment', 'patient-booking'); ?></a></li>
        <li><a href="#services"><?php esc_html_e('Treatments', 'patient-booking'); ?></a></li>
        <li><a href="#reviews"><?php esc_html_e('Patient stories', 'patient-booking'); ?></a></li>
        <li><a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>"><?php esc_html_e('Privacy policy', 'patient-booking'); ?></a></li>
      </ul>
    </div>
  </div>

  <div class="site-footer__bottom">
    <div class="site-footer__bottom-inner">
      <span>&copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html(pb_get('practice_name')); ?>. <?php esc_html_e('All rights reserved.', 'patient-booking'); ?></span>
      <a href="#top"><?php esc_html_e('Back to top ↑', 'patient-booking'); ?></a>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
