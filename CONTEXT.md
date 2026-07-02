# Ratsstuben Germering - Website Codebase Context

## Project Overview

Restaurant website for "Ratsstuben Germering" - a traditional Croatian/Bavarian Wirtshaus with beer garden at the Rathausplatz in Germering, Germany. The site provides menu viewing, a photo gallery, secure table reservations, and legal information.

**Deployment:** Hybrid - GitHub Pages (static hosting) + External PHP Server (reservations at ratsstuben-germering.de)

## Technology Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| HTML5 | - | Semantic markup, SEO-friendly structure |
| CSS3 | - | Custom properties, Grid/Flexbox, light "Wirtshaus" theme |
| Bootstrap | 4.0 | Only on content/PHP pages (NOT loaded on index.html) |
| PHP | 7.4+ | Reservation processing with security |
| WebP | - | High-performance image optimization |
| JavaScript | Vanilla | Menu renderer, lightbox, banners (no frameworks) |
| Fonts | self-hosted | Fraunces (display) + Source Sans 3 (body), GDPR-safe, no CDN |

## File Structure

```
ratsstuben-germering.github.io/
├── index.html              # Landing page (hero, menu teaser, reviews, rooms, story, visit)
├── README.md               # Project documentation
├── CONTEXT.md              # This file - Technical context
├── css/
│   ├── bootstrap.min.css   # Bootstrap framework (subpages only)
│   ├── common.css          # Palette tokens, fonts, buttons, header/footer (site-wide)
│   ├── index.css           # Homepage sections
│   ├── speisekarte.css     # Printed-menu sheet styling + guest quote
│   ├── galerie.css         # Gallery grid + lightbox
│   ├── reservieren.css     # Form card, pills, trust line
│   └── legal.css           # Legal document layout
├── html/                   # Static pages
│   ├── galerie.html        # Photo gallery (lazy loaded)
│   ├── speisekarte.html    # Menu (JSON-driven) with PDF fallback
│   ├── impressum.html      # Legal notice
│   └── datenschutz.html    # Privacy policy
├── php/                    # Server-side processing
│   ├── security.php        # Security utilities (CSRF, rate limiting, sanitization)
│   ├── reservieren.php     # Reservation form (CSRF, client-side validation)
│   ├── Tischreservierung.php  # Form handler (full server-side validation)
│   ├── Die_Reservierung_ist_bestatigt.php  # Success page
│   └── temp/               # Protected rate limiting storage
├── js/
│   ├── speisekarte.js      # Menu renderer (reads Speisekarte_v2.json)
│   ├── gallery-loader.js   # Gallery loader
│   ├── lightbox.js         # Lightweight gallery lightbox
│   ├── holiday-banner.js   # Holiday notice modal
│   └── cookie-banner.js    # Cookie consent (deferred)
├── media/
│   ├── Speisekarte_RatsstubenGermering.pdf  # PDF menu source
│   ├── Speisekarte_v2.json # Menu data (categories, badges, footer note)
│   └── google_reviews.json # 20 verbatim positive Google reviews (raw material,
│                           #   scraped 2026-07-02 via restaurantguru mirror;
│                           #   VERIFY against live Google Business Profile before publishing)
├── fonts/                  # Self-hosted woff2 (Fraunces, Source Sans 3)
├── imgs/                   # WebP photos (hero, atmosphere, gallery/)
├── favicons/               # Complete favicon set
└── .deployment_scripts/
    ├── deployWebApp.sh     # Production deployment script
    └── nginx-cache.conf    # Caching & compression config
```

## UI Design System (light "Wirtshaus" theme, 2026-06 redesign)

The former site-wide dark theme was replaced in June 2026 by a bright
Bavarian-Wirtshaus look. All tokens live in `css/common.css`:

```css
--paper:      #f6efe1;  /* warm linen background            */
--paper-card: #fffaf0;  /* lighter card surface             */
--ink:        #2b2419;  /* warm near-black text             */
--ink-soft:   #5f5645;  /* muted body text                  */
--blue:       #284a72;  /* navy from the painted sign (lead)*/
--blue-deep:  #1d3a5c;  /* hover/darker                     */
--amber:      #c07d1d;  /* beer & schnitzel accent          */
--amber-deep: #a1640d;
--line:       #e2d4ba;  /* warm hairline border             */
--cream:      #fdf6e6;  /* text on blue                     */
```

- **Typography:** Fraunces 900 for display/headings, Source Sans 3 for body,
  both self-hosted (GDPR - no Google Fonts CDN).
- **Header:** light band with traced navy sign logo, 4px amber rule.
- **Footer:** blue band mirroring the sign, 4px amber rule.
- **Physical metaphor:** hero photo, homepage menu-teaser card and story photo
  are slightly rotated - printed things laid on the tablecloth.
- Legacy CSS var aliases in common.css keep old class names working.

## Homepage Sections (index.html, top to bottom)

1. **Hero** - headline, lead, 3 actions (Speisekarte / Reservieren / Anruf), facts, rotated photo
2. **Menu teaser** - "Empfehlungen des Hauses" card with 3 dishes + prices, link to full menu
3. **Reviews band** - blue full-bleed strip: 4,5/5 stars, "über 350 Bewertungen bei Google",
   3 verbatim guest quotes (source: media/google_reviews.json)
4. **Rooms** - Biergarten + Stube photos, link to gallery
5. **Story** - "Seit über 35 Jahren am Rathausplatz" + set-table photo
6. **Visit** - address, hours, reserve/route/call buttons, S-Bahn (~10 min walk) and
   payment note (Bar- und Kartenzahlung)

Structured data: schema.org Restaurant JSON-LD incl. `paymentAccepted`.
Deliberately NO `aggregateRating` markup (Google penalizes self-served
third-party ratings) and NO embedded Google Map (GDPR - cookie banner
promises no marketing data; route button links out instead).

## Key Features

### 1. Secure Reservation System

**Flow:**
1. User visits `/php/reservieren.php` (trust line: 4,5 Sterne bei Google)
2. Server generates CSRF token
3. Form submits to `Tischreservierung.php`
4. Server validates CSRF, sanitizes inputs, checks honeypot + plausibility
5. On success: Telegram notification → redirect to confirmation
6. On error: safe message with phone/email contact

**Validation (client + server, added 2026-07):**
- Date: today … +1 year (`min`/`max` on input, re-checked server-side)
- Monday = Ruhetag → rejected (inline JS `setCustomValidity` + server check)
- Time: 11:30-21:30 (assumed last seating 30 min before close - confirm with owner)
- Wording: button says "Reservierungsanfrage senden" (request, confirmed by phone),
  NOT "verbindlich" - the site promises a phone confirmation

### 2. JSON-Driven Menu (`html/speisekarte.html`)
- `js/speisekarte.js` renders `media/Speisekarte_v2.json` as a printed menu sheet
- First category = "Empfehlungen des Hauses" band, with a verbatim guest quote below the dishes
- Badges: Klassiker (blue) / Kroatisch (amber) / Spezialität (orange)
- Footer note from JSON: prices incl. VAT + "Bar- und Kartenzahlung möglich"
- PDF download fallback

### 3. Gallery with Lightbox (`html/galerie.html`)
- WebP images, lazy loading, lightweight lightbox (`js/lightbox.js`)

### 4. Reviews raw material (`media/google_reviews.json`)
- 20 positive (≥4★) German-language Google reviews, verbatim, with author/date
- Collected 2026-07-02 from the restaurantguru.com mirror (Google itself blocks scraping)
- Aggregate figures: Google panel 4,5★ / ~357 reviews (restaurantguru's own aggregate 3,9)
- Used for: homepage quotes, speisekarte quote, reservation trust line
- Before publishing more of them: verify wording on the live Google Business Profile

## Security Implementation

### Security Module (`php/security.php`)

```php
checkRateLimit($limit, $period) // IP-based DoS protection (30/10min)
generateCsrfToken()             // 32-byte token
validateCsrfToken()             // 2-hour expiry
sanitizeString/Email/Int()      // Input sanitization
validateDate($date)             // YYYY-MM-DD format
validateTime($time)             // HH:MM format
setSecurityHeaders()            // CSP, X-Frame-Options, etc.
validateHoneypot()              // Honeypot fields + timing (< 2s = bot)
```

Additional plausibility checks live in `Tischreservierung.php` (past date,
+1 year cap, Monday, opening hours).

## Performance

- WebP everywhere, lazy loading, stripped EXIF
- `defer` on all scripts; fonts preloaded on index
- Cache-busting via `?v=YYYYMMDDx` query strings - bump on every asset change
- nginx caching config in `.deployment_scripts/nginx-cache.conf`

## Restaurant Info

| Field | Value |
|-------|-------|
| **Name** | Ratsstuben Germering |
| **Address** | Rathausplatz 1, 82110 Germering |
| **History** | 35+ years of tradition |
| **Cuisine** | Croatian, Bavarian, international |
| **Hours** | Tue - Sun: 11:30 - 22:00 (Mon: closed) |
| **Phone** | +49 89 847989 |
| **Email** | ratsstuben.germering@gmail.com |
| **Payment** | Cash and card (card accepted since 2026 - also update Google Business Profile attribute) |
| **Nearby** | S8 Germering-Unterpfaffenhofen, ~700 m / 10 min walk |

## Development

### Local Development

```bash
# simplest (matches production PHP behavior well enough for pages/forms)
php -S 127.0.0.1:8080 -t .

# or Docker
docker run -d --name ratsstuben-php -p 8080:80 \
  -v "$(pwd):/var/www/html" php:apache
```

Mail/Telegram won't fire locally; forms render and validate.

### Environment Variables
- `TELEGRAM_BOT_TOKEN` - Bot API token
- `CHAT_ID` - Target chat for notifications

## Recent Updates (2026-07-02/03)

- **Homepage conversion pass:** menu teaser, Google reviews band (3 quotes),
  story section, visit/CTA section
- **Reservation UX+validation:** honest "Anfrage" wording, date/time/Monday
  validation client- and server-side
- **Card payments:** now accepted - noted on homepage, menu footer, schema.org
- **google_reviews.json:** 20 verbatim positive reviews collected as raw material

## Known Issues & TODO

- [ ] Verify 4,5★ / "über 350 Bewertungen" against live Google Business Profile
- [ ] Confirm last-seating time (currently assumed 21:30)
- [ ] Owner: update Google Business Profile payment attribute (card accepted)
- [ ] Professional food photo shoot (highest-ROI improvement; hero photo is a phone shot)
- [ ] Cookie banner button wording "Ich erkenne an" → "Verstanden"
- [ ] Purge unused Bootstrap CSS on subpages (~100KB savings)
- [ ] Add Instagram/Facebook links if/when profiles exist

### Migration Notes
- Static `html/reservieren.html` is deprecated; use `/php/reservieren.php`
- All navigation links point to the PHP version
