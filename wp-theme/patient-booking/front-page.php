<?php
/**
 * Front page — MEDICO-inspired conversion landing
 */
get_header();

$phone_href = 'tel:' . preg_replace('/[^\d+]/', '', pb_get('phone'));
$endpoint   = pb_get('booking_endpoint');
if (!$endpoint) {
    $endpoint = rest_url('patient-booking/v1/lead');
}
?>

<main id="top">
  <section class="hero" aria-labelledby="hero-brand">
    <div class="hero__media">
      <img
        src="<?php echo esc_url(pb_get('hero_image')); ?>"
        alt="<?php esc_attr_e('Modern dental treatment room', 'patient-booking'); ?>"
        width="1800"
        height="1000"
        fetchpriority="high"
        decoding="async"
      />
    </div>
    <div class="hero__content">
      <div class="hero__panel">
        <p class="hero__tag"><?php esc_html_e('New patients & specialists welcome', 'patient-booking'); ?></p>
        <p class="hero__brand" id="hero-brand"><?php echo esc_html(pb_get('practice_name')); ?></p>
        <h1 class="hero__headline"><?php echo esc_html(pb_get('headline')); ?></h1>
        <p class="hero__support"><?php echo esc_html(pb_get('support')); ?></p>
      </div>
      <ul class="trust-row" aria-label="<?php esc_attr_e('Trust signals', 'patient-booking'); ?>">
        <li class="trust-badge">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.2H22l-6 4.4 2.3 7L12 16.8 5.7 20.6 8 13.6 2 9.2h7.6z"/></svg>
          <?php echo esc_html(pb_get('badge_1')); ?>
        </li>
        <li class="trust-badge"><?php echo esc_html(pb_get('badge_2')); ?></li>
        <li class="trust-badge"><?php echo esc_html(pb_get('badge_3')); ?></li>
      </ul>
    </div>
  </section>

  <section class="stats-band" aria-label="<?php esc_attr_e('Practice highlights', 'patient-booking'); ?>">
    <div class="stats-band__inner">
      <article class="stat-item reveal">
        <p class="stat-item__value">2,000+</p>
        <p class="stat-item__label"><?php esc_html_e('smiles', 'patient-booking'); ?></p>
        <p class="stat-item__note"><?php esc_html_e('Transformed by our team since 2009', 'patient-booking'); ?></p>
      </article>
      <article class="stat-item reveal">
        <p class="stat-item__value"><?php esc_html_e('Board certified', 'patient-booking'); ?></p>
        <p class="stat-item__note"><?php esc_html_e('Latest techniques & training', 'patient-booking'); ?></p>
      </article>
      <article class="stat-item reveal">
        <p class="stat-item__value">48-hour</p>
        <p class="stat-item__label"><?php esc_html_e('appointments', 'patient-booking'); ?></p>
        <p class="stat-item__note"><?php esc_html_e('Often available for new patients', 'patient-booking'); ?></p>
      </article>
    </div>
  </section>

  <section class="section services" id="services" aria-labelledby="services-title">
    <p class="eyebrow reveal"><?php esc_html_e('What we focus on', 'patient-booking'); ?></p>
    <h2 class="section-title reveal" id="services-title"><?php esc_html_e('Specialist care, explained simply', 'patient-booking'); ?></h2>
    <p class="section-lead reveal"><?php esc_html_e('Three pathways patients ask for most—scannable, no jargon overload.', 'patient-booking'); ?></p>
    <ul class="services-grid" style="margin-top:1.75rem">
      <li class="service-tile">
        <img class="service-tile__image" src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=75" alt="<?php esc_attr_e('Dental implant treatment', 'patient-booking'); ?>" width="800" height="320" loading="lazy" />
        <div class="service-tile__body">
          <div class="service-tile__title">
            <div class="service-tile__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M12 3v18M8 7h8M9 17h6"/><circle cx="12" cy="12" r="9"/></svg>
            </div>
            <h3><?php esc_html_e('Dental implants', 'patient-booking'); ?></h3>
          </div>
          <p><?php esc_html_e('Replace missing teeth with a stable, natural-looking solution planned around your bite and long-term health.', 'patient-booking'); ?></p>
          <a href="#contact"><?php esc_html_e('Learn more', 'patient-booking'); ?></a>
        </div>
      </li>
      <li class="service-tile">
        <img class="service-tile__image" src="https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=800&q=75" alt="<?php esc_attr_e('Invisalign clear aligners', 'patient-booking'); ?>" width="800" height="320" loading="lazy" />
        <div class="service-tile__body">
          <div class="service-tile__title">
            <div class="service-tile__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M4 10h16M7 10V7a5 5 0 0 1 10 0v3"/><rect x="3" y="10" width="18" height="10" rx="2"/></svg>
            </div>
            <h3><?php esc_html_e('Invisalign', 'patient-booking'); ?></h3>
          </div>
          <p><?php esc_html_e('Straighten discreetly with clear aligners and a plan you can fit around work, travel, and daily life.', 'patient-booking'); ?></p>
          <a href="#contact"><?php esc_html_e('Learn more', 'patient-booking'); ?></a>
        </div>
      </li>
      <li class="service-tile">
        <img class="service-tile__image" src="https://images.unsplash.com/photo-1609840114035-3c981b782dfe?auto=format&fit=crop&w=800&q=75" alt="<?php esc_attr_e('Cosmetic dentistry smile', 'patient-booking'); ?>" width="800" height="320" loading="lazy" />
        <div class="service-tile__body">
          <div class="service-tile__title">
            <div class="service-tile__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M12 3c4 4 7 7 7 11a7 7 0 1 1-14 0c0-4 3-7 7-11z"/></svg>
            </div>
            <h3><?php esc_html_e('Cosmetic dentistry', 'patient-booking'); ?></h3>
          </div>
          <p><?php esc_html_e('Brighten, reshape, and refine your smile with treatments that look intentional—not overdone.', 'patient-booking'); ?></p>
          <a href="#contact"><?php esc_html_e('Learn more', 'patient-booking'); ?></a>
        </div>
      </li>
    </ul>
    <a class="services-link" href="<?php echo esc_url($phone_href); ?>"><?php esc_html_e('Prefer to talk it through? Call us →', 'patient-booking'); ?></a>
  </section>

  <section class="testimonials" id="reviews" aria-labelledby="reviews-title">
    <div class="section" style="padding-block:0">
      <div class="section-head">
        <div>
          <p class="eyebrow reveal"><?php esc_html_e('Real patients', 'patient-booking'); ?></p>
          <h2 class="section-title reveal" id="reviews-title"><?php esc_html_e('Trust you can feel before you walk in', 'patient-booking'); ?></h2>
        </div>
      </div>
      <p class="section-lead reveal" style="margin-bottom:1.75rem"><?php esc_html_e('Short stories from people who booked the same way you can today.', 'patient-booking'); ?></p>
      <ul class="testimonial-grid">
        <?php for ($i = 1; $i <= 3; $i++) : ?>
          <li>
            <figure class="testimonial-card">
              <img class="testimonial-card__photo" src="<?php echo esc_url(pb_get("t{$i}_photo")); ?>" alt="" width="600" height="750" loading="lazy" />
              <div class="testimonial-card__body">
                <div class="stars" aria-label="<?php esc_attr_e('5 out of 5 stars', 'patient-booking'); ?>">★★★★★</div>
                <blockquote>“<?php echo esc_html(pb_get("t{$i}_quote")); ?>”</blockquote>
                <p class="testimonial-card__name"><?php echo esc_html(pb_get("t{$i}_name")); ?></p>
              </div>
            </figure>
          </li>
        <?php endfor; ?>
      </ul>
    </div>
  </section>

  <section class="section contact" id="contact" aria-labelledby="contact-title">
    <div class="contact__grid">
      <div class="contact__intro reveal">
        <p class="eyebrow"><?php esc_html_e('Get in touch', 'patient-booking'); ?></p>
        <h2 class="section-title" id="contact-title"><?php esc_html_e('Have a question before you book?', 'patient-booking'); ?></h2>
        <p class="section-lead"><?php esc_html_e('Send us a message and our front-desk team will follow up—usually within one business day.', 'patient-booking'); ?></p>
        <ul class="contact__details">
          <li><strong><?php esc_html_e('Phone', 'patient-booking'); ?></strong> <a href="<?php echo esc_url($phone_href); ?>"><?php echo esc_html(pb_get('phone_display')); ?></a></li>
          <li><strong><?php esc_html_e('Visit', 'patient-booking'); ?></strong> <?php echo esc_html(pb_get('address')); ?></li>
        </ul>
      </div>
      <form class="contact-form reveal" data-contact-form data-endpoint="<?php echo esc_url(rest_url('patient-booking/v1/contact')); ?>" novalidate>
        <div class="field">
          <label for="contact_name"><?php esc_html_e('Full name', 'patient-booking'); ?></label>
          <input id="contact_name" name="full_name" type="text" autocomplete="name" placeholder="Jane Smith" required />
          <div class="field-error" role="alert"></div>
        </div>
        <div class="field">
          <label for="contact_email"><?php esc_html_e('Email', 'patient-booking'); ?></label>
          <input id="contact_email" name="email" type="email" autocomplete="email" placeholder="you@email.com" required />
          <div class="field-error" role="alert"></div>
        </div>
        <div class="field">
          <label for="contact_phone"><?php esc_html_e('Phone', 'patient-booking'); ?></label>
          <input id="contact_phone" name="phone" type="tel" autocomplete="tel" placeholder="<?php esc_attr_e('Mobile number', 'patient-booking'); ?>" required />
          <div class="field-error" role="alert"></div>
        </div>
        <div class="field">
          <label for="contact_message"><?php esc_html_e('Message', 'patient-booking'); ?></label>
          <textarea id="contact_message" name="message" rows="4" placeholder="<?php esc_attr_e('How can we help?', 'patient-booking'); ?>" required></textarea>
          <div class="field-error" role="alert"></div>
        </div>
        <button class="btn btn--orange btn--block" type="submit"><?php esc_html_e('Send message', 'patient-booking'); ?></button>
        <div class="form-status" data-form-status role="status" aria-live="polite"></div>
      </form>
    </div>
  </section>

  <section class="section closing" aria-labelledby="closing-title">
    <p class="eyebrow reveal"><?php esc_html_e('Next step', 'patient-booking'); ?></p>
    <h2 class="section-title reveal" id="closing-title"><?php esc_html_e('Ready when you are', 'patient-booking'); ?></h2>
    <p class="section-lead reveal"><?php esc_html_e('Openings fill quickly. Reserve a time now, or call and we’ll place you with the right specialist.', 'patient-booking'); ?></p>
    <div class="closing__actions reveal">
      <a class="btn btn--orange" href="#contact" data-track-cta="closing"><?php esc_html_e('Book your visit', 'patient-booking'); ?></a>
      <a class="closing__phone" href="<?php echo esc_url($phone_href); ?>">
        <?php echo esc_html(sprintf(__('Prefer to speak with someone? %s', 'patient-booking'), pb_get('phone_display'))); ?>
      </a>
    </div>
  </section>
</main>

<?php
get_footer();
