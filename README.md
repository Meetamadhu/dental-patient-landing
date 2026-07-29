# Patient Booking Landing — Handover

Purpose-built WordPress landing page that turns visitors into booked patients. Mobile-first, single primary CTA, essentials-only form, testimonials, service scan, trust badges, and GA4/GTM event tracking.

**Placeholder practice name:** Harbour Smile Studio — replace with your brand after kickoff.

---

## Deliverables map

| # | Deliverable | Location |
|---|---|---|
| 1 | Wireframe for approval | `wireframe/index.html` |
| 2 | Final copy | `COPY.md` |
| 3 | High-fidelity responsive design | `preview/index.html` |
| 4 | WordPress theme (ready to publish) | `wp-theme/patient-booking/` |
| 5 | Analytics / GTM events | `ANALYTICS.md` + Customizer fields |

---

## Quick start — preview (no WordPress)

1. Open `preview/index.html` in a browser.
2. Review layout, copy, and form validation.
3. Approve wireframe structure in `wireframe/index.html` if you haven’t already.

---

## Install on WordPress

1. Zip the folder `wp-theme/patient-booking/` (the folder itself must contain `style.css`).
2. **Appearance → Themes → Add New → Upload Theme** → activate **Patient Booking Landing**.
3. **Settings → Reading** → set your homepage to a static page (or leave default; `front-page.php` renders the landing).
4. **Appearance → Customize** and edit:
   - **Practice details** — name, phone, address
   - **Landing copy** — headline, support, trust badges, hero image URL
   - **Brand colours** — paste your brand hex values
   - **Testimonials** — paste real patient quotes + photo URLs
   - **Analytics & booking** — GTM ID, GA4 ID, optional scheduling webhook
5. **Appearance → Customize → Site Identity** — upload logo (optional).
6. Create a Privacy Policy page and assign it under **Settings → Privacy**.

### Edit without a developer

Almost everything is in **Appearance → Customize**. For deeper HTML/CSS tweaks, edit:

- `front-page.php` — section structure
- `assets/css/styles.css` — design tokens at the top (`:root`)
- `template-parts/booking-form.php` — form fields / labels

---

## Booking / scheduling software

**Default (works day one):** form posts to WordPress REST  
`POST /wp-json/patient-booking/v1/lead`

- Saves lead under **Booking leads** in WP admin  
- Emails the site admin  
- Fires `pb_booking_lead` action for CRM plugins

**Connect your scheduler:** In Customizer → **Booking webhook / endpoint URL**, paste your scheduling software webhook (JSON body with `full_name`, `phone`, `email`, `treatment`, `preferred_time`). Leave blank to keep the built-in endpoint.

**Abandon follow-up:** When a visitor enters name + phone then leaves, values are saved locally and a `partial_lead` analytics event fires so you can build a GTM → CRM/email alert. Front desk can also call back from incomplete phone clicks + form starts in GA.

---

## Performance notes (already baked in)

- Mobile-first CSS, deferred JS, system-safe font loading via Google Fonts `display=swap`
- Hero image uses `fetchpriority="high"`; testimonial images `loading="lazy"`
- No heavy libraries
- `prefers-reduced-motion` respected

After brand assets arrive, compress the hero to WebP (~120–180KB) and host on your CDN/media library for best LCP.

---

## What I need from you at kickoff

1. Brand colours (hex) + logo (SVG/PNG)
2. Live Google rating + badge wording
3. Real patient reviews + approved photos
4. Scheduling software name + webhook/API docs (NexHealth, DentalSoft, Calendly, etc.)
5. GTM container ID and/or GA4 measurement ID
6. Practice phone, address, hours, legal practice name

---

## Approval checkpoint

Please confirm:

1. Wireframe section order (`wireframe/index.html`)
2. Placeholder name “Harbour Smile Studio” is fine until brand files arrive
3. Form fields: name, phone, email, treatment, preferred time — nothing else

Then drop brand assets and we’ll (or you’ll) swap tokens in Customizer and publish.
