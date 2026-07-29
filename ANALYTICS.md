# Analytics & event tracking

Events fire to `dataLayer` (GTM) and `gtag()` (GA4) when configured.

## Setup in WordPress

**Appearance → Customize → Analytics & booking**

| Field | Example |
|---|---|
| GTM container ID | `GTM-ABC1234` |
| GA4 measurement ID | `G-XXXXXXXX` |

You can use GTM only, GA4 only, or both.

---

## Events shipped day one

| Event name | When it fires | Key parameters |
|---|---|---|
| `form_start` | First focus inside the booking form | `form_id: booking` |
| `generate_lead` | Successful form submit | `form_id`, `treatment`, `preferred_time` |
| `form_submit` | Same as above (alias for existing GTM tags) | `form_id`, `treatment` |
| `phone_click` | Any `tel:` link click | `link_url`, `link_text` |
| `cta_click` | “Book your visit” clicks | `cta_id` (`header` / `hero` / `closing`), `cta_text` |
| `scroll_depth` | User reaches 25 / 50 / 75 / 90% | `percent_scrolled` |
| `partial_lead` | Name + phone saved on abandon/blur | `has_name`, `has_phone`, `treatment` |

---

## Recommended GTM tags

### 1. GA4 Event — form submit
- Trigger: Custom Event = `generate_lead` (or `form_submit`)
- Event name: `generate_lead`
- Params: `treatment` → `{{DLV - treatment}}`

### 2. GA4 Event — phone click
- Trigger: Custom Event = `phone_click`
- Event name: `phone_click`

### 3. GA4 Event — scroll depth
- Trigger: Custom Event = `scroll_depth`
- Event name: `scroll_depth`
- Param: `percent_scrolled`

> You can disable GTM’s built-in Scroll Depth trigger to avoid double-counting, since this theme already pushes `scroll_depth`.

### 4. Optional — form start & partial lead
- Use for funnel analysis and abandoned-booking alerts (e.g. GTM → webhook / email).

---

## GA4 DebugView checklist

1. Install [Google Analytics Debugger](https://chrome.google.com/webstore) or use GA4 DebugView.
2. Load the landing page.
3. Scroll past halfway → expect `scroll_depth`.
4. Click the header phone link → `phone_click`.
5. Focus a form field → `form_start`.
6. Submit a valid booking → `generate_lead` + `form_submit`.

---

## Preview HTML (non-WP)

`preview/index.html` initialises `dataLayer`. Paste your GTM snippet in `<head>` before go-live testing, or rely on the WordPress theme Customizer fields for production.
