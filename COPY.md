# Final Copy — Patient Booking Landing Page

Replace `[Practice Name]`, phone, address, and review attribution with your live details after kickoff.

---

## Brand / practice name (hero-level)
**[Practice Name]**

---

## Header
- Phone link label: **Call now**
- Primary CTA: **Book your visit**

---

## Hero
**Headline:**  
Your smile, scheduled around your life.

**Supporting sentence:**  
New-patient and specialist appointments in a few clicks—implants, Invisalign, and cosmetic care with a team that routes you to the right chair.

**Primary CTA:**  
Book your visit

**Micro-copy under CTA:**  
Takes under 60 seconds · Same-week openings often available

---

## Trust badges (above the fold)
1. **4.9★ Google-rated** *(swap for your live rating)*
2. **Same-week openings**
3. **Specialist-routed care**

---

## Booking form
**Section eyebrow:** Reserve your chair  
**Headline:** Book a new-patient or specialist visit  
**Supporting:** Tell us what you need and when works. We’ll confirm your appointment and match you to the right dentist.

| Field | Label | Placeholder / options |
|---|---|---|
| Name | Full name | Jane Smith |
| Phone | Mobile number | For confirmation texts |
| Email | Email | For your booking receipt |
| Treatment | What are you interested in? | New patient exam · Dental implants · Invisalign · Cosmetic dentistry · Other / not sure |
| Time | Preferred time | Mornings · Afternoons · Evenings · First available |

**Submit CTA:** Request appointment  
**Form micro-copy:** No payment required to request a time. We’ll text or call to confirm.  
**Success message:** You’re on our list. A team member will confirm your chair shortly.  
**Error message:** Please check the highlighted fields and try again.

**Abandon capture note (front desk):**  
If a visitor enters name + phone then leaves, the form saves a partial lead so you can follow up within the hour.

---

## Services
**Eyebrow:** What we focus on  
**Headline:** Specialist care, explained simply  
**Supporting:** Three pathways patients ask for most—scannable, no jargon overload.

### Dental implants
**Title:** Dental implants  
**Blurb:** Replace missing teeth with a stable, natural-looking solution planned around your bite and long-term health.

### Invisalign
**Title:** Invisalign  
**Blurb:** Straighten discreetly with clear aligners and a plan you can fit around work, travel, and daily life.

### Cosmetic dentistry
**Title:** Cosmetic dentistry  
**Blurb:** Brighten, reshape, and refine your smile with treatments that look intentional—not overdone.

**Services CTA (text link):** Prefer to talk it through? Call us →

---

## Testimonials
**Eyebrow:** Real patients  
**Headline:** Trust you can feel before you walk in  
**Supporting:** Short stories from people who booked the same way you can today.

### Testimonial 1
**Stars:** 5  
**Quote:** “I booked an implant consult online on my lunch break. They called the same afternoon and had me in that week.”  
**Attribution:** — Maya R., dental implants

### Testimonial 2
**Stars:** 5  
**Quote:** “The Invisalign process felt clear from day one. No pressure—just a plan that fit my calendar.”  
**Attribution:** — Daniel K., Invisalign

### Testimonial 3
**Stars:** 5  
**Quote:** “I wanted a subtle cosmetic refresh. The team listened, showed options, and I left feeling like myself—only brighter.”  
**Attribution:** — Priya S., cosmetic dentistry

*(Replace quotes/photos with your supplied reviews after kickoff.)*

---

## Closing CTA
**Headline:** Ready when you are  
**Supporting:** Openings fill quickly. Reserve a time now, or call and we’ll place you with the right specialist.  
**CTA:** Book your visit  
**Secondary:** Prefer to speak with someone? **[Phone number]**

---

## Footer
- Address line  
- Hours (e.g. Mon–Fri 8–6 · Sat by appointment)  
- Privacy policy link  
- © [Year] [Practice Name]

---

## Analytics event labels (for GTM/GA4)
| Event | Trigger |
|---|---|
| `generate_lead` / `form_submit` | Successful booking form submit |
| `phone_click` | Any `tel:` link click |
| `cta_click` | Primary “Book your visit” clicks |
| `scroll_depth` | 25%, 50%, 75%, 90% |
| `form_start` | First interaction with any form field |
| `partial_lead` | Name + phone captured on abandon |

---

## Tone checklist
- One promise per section  
- Essentials-only form language  
- No medical overclaim; confidence without hype  
- CTA verbs stay consistent: **Book your visit** / **Request appointment**
