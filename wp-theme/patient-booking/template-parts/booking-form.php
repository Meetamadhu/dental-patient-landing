<?php
/**
 * Booking form
 */
if (!defined('ABSPATH')) {
    exit;
}

$endpoint = pb_get('booking_endpoint');
if (!$endpoint) {
    $endpoint = rest_url('patient-booking/v1/lead');
}
?>
<form class="appt-bar__form" data-booking-form data-endpoint="<?php echo esc_url($endpoint); ?>" novalidate>
  <h2 class="appt-bar__heading" id="booking-heading"><?php esc_html_e('Book your visit', 'patient-booking'); ?></h2>
  <div class="field">
    <label for="full_name"><?php esc_html_e('Full name', 'patient-booking'); ?></label>
    <input id="full_name" name="full_name" type="text" autocomplete="name" placeholder="<?php esc_attr_e('Full Name', 'patient-booking'); ?>" required />
    <div class="field-error" role="alert"></div>
  </div>
  <div class="field">
    <label for="email"><?php esc_html_e('Email', 'patient-booking'); ?></label>
    <input id="email" name="email" type="email" autocomplete="email" placeholder="<?php esc_attr_e('E-mail Address', 'patient-booking'); ?>" required />
    <div class="field-error" role="alert"></div>
  </div>
  <div class="field">
    <label for="phone"><?php esc_html_e('Phone', 'patient-booking'); ?></label>
    <input id="phone" name="phone" type="tel" autocomplete="tel" placeholder="<?php esc_attr_e('Phone Number', 'patient-booking'); ?>" required />
    <div class="field-error" role="alert"></div>
  </div>
  <div class="field field--wide">
    <label for="treatment"><?php esc_html_e('Treatment interest', 'patient-booking'); ?></label>
    <select id="treatment" name="treatment" required>
      <option value=""><?php esc_html_e('Treatment Interest', 'patient-booking'); ?></option>
      <option value="new_patient_exam"><?php esc_html_e('New patient exam', 'patient-booking'); ?></option>
      <option value="implants"><?php esc_html_e('Dental implants', 'patient-booking'); ?></option>
      <option value="invisalign"><?php esc_html_e('Invisalign', 'patient-booking'); ?></option>
      <option value="cosmetic"><?php esc_html_e('Cosmetic dentistry', 'patient-booking'); ?></option>
      <option value="other"><?php esc_html_e('Other / not sure', 'patient-booking'); ?></option>
    </select>
    <div class="field-error" role="alert"></div>
  </div>
  <div class="field field--wide">
    <label for="preferred_time"><?php esc_html_e('Preferred time', 'patient-booking'); ?></label>
    <select id="preferred_time" name="preferred_time" required>
      <option value=""><?php esc_html_e('Preferred Time', 'patient-booking'); ?></option>
      <option value="mornings"><?php esc_html_e('Mornings', 'patient-booking'); ?></option>
      <option value="afternoons"><?php esc_html_e('Afternoons', 'patient-booking'); ?></option>
      <option value="evenings"><?php esc_html_e('Evenings', 'patient-booking'); ?></option>
      <option value="first_available"><?php esc_html_e('First available', 'patient-booking'); ?></option>
    </select>
    <div class="field-error" role="alert"></div>
  </div>
  <button class="btn btn--primary" type="submit"><?php esc_html_e('Request appointment', 'patient-booking'); ?></button>
  <p class="form-note"><?php esc_html_e('No payment required. We’ll text or call to confirm your chair.', 'patient-booking'); ?></p>
  <div class="form-status" data-form-status role="status" aria-live="polite"></div>
</form>
