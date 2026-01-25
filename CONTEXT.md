# Ratsstuben Germering - Website Codebase Context

## Project Overview

Restaurant website for "Ratsstuben Germering" - a traditional German restaurant in Germering, Germany. The site provides menu viewing, a dynamic photo gallery, secure table reservations, and legal information.

**Deployment:** Hybrid - GitHub Pages (static hosting) + External PHP Server (reservations at ratsstuben-germering.de)

## Technology Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| HTML5 | - | Semantic markup, SEO-friendly structure |
| CSS3 | - | Custom properties, Flexbox, Masonry Grids, Dark Theme |
| Bootstrap | 4.0 | Responsive grid and component base |
| PHP | 7.4+ | Reservation processing with security |
| WebP | - | High-performance image optimization |
| JavaScript | Vanilla | Interactive components (Lightbox, Cookie banner) |

## File Structure

```
ratsstuben-germering.github.io/
├── index.html              # Landing page (Hero background, location link)
├── README.md               # Project documentation
├── CONTEXT.md              # This file - Technical context
├── css/
│   ├── bootstrap.min.css   # Bootstrap framework
│   ├── common.css          # Global variables, dark theme, utility classes
│   ├── index.css           # Homepage-specific styles
│   ├── speisekarte.css     # Hero header, PDF viewer styling
│   ├── galerie.css         # Masonry collage, Lightbox styles, parallax CTA
│   ├── reservieren.css     # Premium form card, icons, interactive pills
│   └── legal.css           # Legal document layout, dark theme overrides
├── html/                   # Static pages (ALL DARK THEME)
│   ├── galerie.html        # Photo gallery (36 images, lazy loaded)
│   ├── speisekarte.html    # Menu with PDF viewer & CTA
│   ├── impressum.html      # Legal notice
│   └── datenschutz.html    # Privacy policy
├── php/                    # Server-side processing (ALL DARK THEME)
│   ├── security.php        # Security utilities (CSRF, Rate Limiting, sanitization)
│   ├── reservieren.php     # Secure reservation form with CSRF
│   ├── Tischreservierung.php  # Form handler (security improvements)
│   ├── Die_Reservierung_ist_bestatigt.php  # Success page (dark theme)
│   └── temp/               # Protected rate limiting storage
├── js/
│   ├── cookie-banner.js    # Cookie consent (deferred loading)
│   └── lightbox.js         # Lightweight gallery lightbox
├── media/
│   └── Speisekarte_RatsstubenGermering.pdf  # Menu source
├── imgs/
│   ├── T_hero.webp         # Main hero image (used site-wide)
│   ├── *_hero.webp         # Page-specific banner images
│   └── gallery/            # 38 optimized WebP gallery images
├── favicons/               # Complete favicon set
└── .deployment_scripts/
    ├── deployWebApp.sh     # Production deployment script
    └── nginx-cache.conf    # Caching & compression config
```

## UI Design System

### Visual Identity
- **Dark Theme:** Site-wide dark theme with fixed background image
- **Card-Based Layout:** Elevated dark cards (#2d2d2d) with `1.25rem` rounded corners
- **Hero Sections:** Page-specific atmospheric banners with 0.45 dark overlay
- **Typography:** Lightweight headings (`font-weight: 300`)
- **Spacing:** Consistent `1.5rem` gaps throughout

### Background Image
- **Image:** `T_hero.webp` used site-wide with parallax effect
- **Overlay:** `rgba(0, 0, 0, 0.5)` gradient
- **Attachment:** Fixed (parallax scrolling effect)
- **Position:** Center

### Brand/Logo
- **Structure:** `<h3 class="masthead-brand"><a>Ratsstuben <span class="brand-subtitle">aus Germering</span></a></h3>`
- **Subtitle:** 0.7em font size, inline display, white-space nowrap (stays on one line)
- **Phone:** International format `+49 89 847989`

### Responsive Design
- Mobile-first approach
- 3-column gallery grid → 1-column on mobile
- Centered navigation on mobile (< 768px)
- Float-right navigation on desktop (≥ 768px)

## Dark Theme Implementation (2026-01)

### All Pages Now Use Dark Theme
- **Body class:** `bg-dark` (all pages)
- **Header:** `dark-header` (all pages)
- **Footer:** `dark-footer` (all pages)

### Dark Theme CSS (`css/common.css`)
```css
.bg-dark {
  background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../imgs/T_hero.webp');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  background-attachment: fixed;
  background-color: #1d1d1d;
}

/* Card backgrounds */
.bg-dark .card,
.bg-dark .reservation-card,
.bg-dark .legal-card,
.bg-dark .pdf-viewer-wrapper {
  background-color: #2d2d2d !important;
  border-color: rgba(255, 255, 255, 0.1) !important;
}

/* Text colors */
.bg-dark h1, .bg-dark h2, .bg-dark h3, .bg-dark h4, .bg-dark h5, .bg-dark h6 {
  color: var(--color-white) !important;
}

.bg-dark p, .bg-dark li, .bg-dark span, .bg-dark div {
  color: rgba(255, 255, 255, 0.85);
}
```

### Legal Pages Dark Theme (`css/legal.css`)
```css
/* Alert boxes */
.bg-dark .alert-light {
  background-color: #3d3d3d !important;
  border-color: rgba(255, 255, 255, 0.15) !important;
  color: rgba(255, 255, 255, 0.85) !important;
}

/* Legal content */
.bg-dark .legal-content h2 {
  color: var(--color-white) !important;
  border-bottom-color: rgba(255, 255, 255, 0.15) !important;
}

.bg-dark .legal-content p,
.bg-dark .legal-content li {
  color: rgba(255, 255, 255, 0.85) !important;
}
```

## Hero Section Overlays

All hero images now use consistent `0.45` dark overlay for text readability:

| Page | Overlay | Image |
|------|---------|-------|
| index.html | 0.4 (in body bg) | T_hero.webp |
| galerie.html | 0.45 | Galerie_hero.webp |
| speisekarte.html | 0.45 | Speisekarte_hero.webp |
| datenschutz.html | 0.45 | Legal_hero.webp |
| impressum.html | 0.45 | Legal_hero.webp |
| reservieren (PHP) | 0.15 | TitelSite_hero.webp |

## CTA Sections (Call to Action)

### Both CTAs Now Have Identical Styling
```css
.reservation-cta {
  background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../imgs/T_hero.webp');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;  /* Parallax effect */
  border: none;
  width: 100%;
  border-radius: 1.25rem !important;
}
```

**Locations:**
- galerie.html: "Hunger bekommen?" CTA
- speisekarte.html: "Lust bekommen?" CTA

## Security Implementation

### Security Module (`php/security.php`)

```php
// Rate Limiting
checkRateLimit($limit, $period) // IP-based DoS protection (30/10min)

// CSRF Protection
generateCsrfToken()    // Generate 32-byte token
validateCsrfToken()    // Validate with 2-hour expiry

// Input Sanitization
sanitizeString($input, $maxLength)  // Clean text input
sanitizeEmail($input)               // Validate email
sanitizeInt($input)                 // Clean integers
validateDate($date)                 // YYYY-MM-DD format
validateTime($time)                 // HH:MM format

// Security Headers
setSecurityHeaders()    // CSP, X-Frame-Options, etc.

// Utilities
getSafeErrorMessage()   // User-friendly errors
logError()              // Secure error logging
validateHoneypot()      // Advanced bot detection
```

### Security Features

| Feature | Implementation |
|---------|---------------|
| Rate Limiting | IP-based (30 req / 10 min), local temp storage |
| CSRF Protection | Token-based, 2-hour expiration |
| Input Sanitization | `htmlspecialchars()`, `filter_var()` |
| Honeypot | Multiple fields + timing validation (< 2s = bot) |
| Security Headers | CSP, X-Frame-Options, X-XSS-Protection, etc. |
| Error Handling | Safe messages, secure logging, HTTP status codes |
| Validation | Date/time format, required fields, range checks |

### Security Headers Applied

```php
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Content-Security-Policy: default-src 'self'; ...
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=(), camera=()
```

## Performance Optimization

### Image Optimization
- **Format:** WebP (optimized via `cwebp` and `magick`)
- **Processing:** New gallery images surgically cropped to content and flattened against card background (`#2d2d2d`) for consistent rounded corners.
- **Lazy Loading:** All 38 gallery images use `loading="lazy"`
- **Metadata:** Stripped EXIF data

### JavaScript Loading
- **Deferred Loading:** All script tags use `defer` attribute
- **Non-blocking:** Scripts load after HTML parsing

### Caching Strategy (`.deployment_scripts/nginx-cache.conf`)

| Asset Type | Cache Duration | Headers |
|------------|---------------|---------|
| Images/Fonts | 1 year | `public, immutable` |
| CSS/JS | 1 month | `public, must-revalidate` |
| PDFs | 1 week | `public` |
| HTML/PHP | 1 hour | `public, must-revalidate` |

### Performance Estimate
- **Lighthouse Performance:** 75-85/100
- **Load time (3G):** 3-5 seconds
- **Load time (WiFi):** 1-2 seconds

## Mobile Responsiveness

### Navigation
- **Mobile (< 768px):** Centered with `justify-content: center`
- **Desktop (≥ 768px):** Float right
- **Brand subtitle:** `white-space: nowrap` to prevent wrapping

### Button Adjustments
- **"Jetzt verbindlich reservieren":** Text wraps naturally on mobile
- **"Jetzt Tisch reservieren":** Reduced padding on mobile (`px-5` → `1.5rem`)

## Key Features

### 1. Secure Reservation System

**Flow:**
1. User visits `/php/reservieren.php`
2. Server generates CSRF token
3. Form submits to `Tischreservierung.php`
4. Server validates CSRF, sanitizes inputs, checks honeypot
5. On success: Telegram notification → redirect to confirmation
6. On error: Safe message with phone/email contact

### 2. Masonry Gallery with Lightbox (`html/galerie.html`)
- 3-column desktop grid, 1-column mobile
- WebP images with lazy loading
- **Lightbox Feature:** Interactive full-screen view for all images (`js/lightbox.js`)
- **Surgical Cropping:** New images fill the frame for a professional "full-frame" look

### 3. Responsive Menu (`html/speisekarte.html`)
- Embedded PDF viewer
- Download fallback for mobile
- Parallax CTA section

### 4. Legal Pages
- Dark theme with proper contrast
- Alert boxes with dark backgrounds
- Readable text on dark cards

## Development

### Local Development

**Docker (Recommended):**
```bash
docker run -d --name ratsstuben-php -p 8080:80 \
  -v "$(pwd):/var/www/html" php:apache
```

### Environment Variables
- `TELEGRAM_BOT_TOKEN` - Bot API token
- `CHAT_ID` - Target chat for notifications

## Restaurant Info

| Field | Value |
|-------|-------|
| **Name** | Ratsstuben Germering |
| **Address** | Rathausplatz 1, 82110 Germering |
| **History** | 35+ Years of Tradition |
| **Hours** | Tue - Sun: 11:30 - 22:00 (Mon: Closed) |
| **Phone** | +49 89 847989 |
| **Email** | ratsstuben.germering@gmail.com |

## Recent Updates (2026-01-25)

### Security Hardening ✅
- Implemented IP-based **Rate Limiting** (30 requests per 10 minutes).
- Created secure `php/temp/` storage for rate limit data with 2% garbage collection.
- Verified 403 Forbidden access to sensitive security data.

### Codebase Maintenance ✅
- Removed deprecated `html/reservieren.html` and updated all navigation links.
- Removed and archived 2 low-quality gallery images (`Exterior2.webp`, `picture_of_menu_and_plate.webp`).

## Known Issues & TODO

### Potential Improvements
- [ ] Add reCAPTCHA v3 for additional spam protection
- [ ] Purge unused Bootstrap CSS (~100KB savings)
- [ ] Combine CSS files for production
- [ ] Add service worker for offline support
- [ ] Disable parallax on mobile for performance

### Migration Notes
- Static `html/reservieren.html` is deprecated; use `/php/reservieren.php`
- All navigation links now point to secure PHP version