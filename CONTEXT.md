# Ratsstuben Germering - Website Codebase Context

## Project Overview

Restaurant website for "Ratsstuben Germering" - a traditional German restaurant in Germering, Germany. The site provides menu viewing, a dynamic photo gallery, table reservations, and legal information.

**Deployment:** GitHub Pages (static hosting with PHP support via external server for reservations)

## Technology Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| HTML5 | - | Semantic markup |
| CSS3 | - | Modern UI with CSS Variables, Flexbox, and Masonry Grids |
| Bootstrap | 4.0 | Responsive grid and component base |
| PHP | 7.4+ | Reservation processing and session-based success pages |
| WebP | - | High-performance image optimization |
| JavaScript | Vanilla | Cookie consent and interactive elements |

## File Structure

```
ratsstuben-germering.github.io/
├── index.html              # Landing page (Clean, hero background, location link)
├── favicon.ico             # Legacy multi-size favicon
├── css/
│   ├── bootstrap.min.css   # Bootstrap framework
│   ├── common.css          # Global variables, centered logo, responsive footer
│   ├── index.css           # Homepage-specific mobile-optimized styles
│   ├── speisekarte.css     # Hero header and PDF viewer styling
│   ├── galerie.css         # Masonry collage and hover effects
│   ├── reservieren.css     # Premium form card, icons, and interactive pills
│   └── legal.css           # Specialized layout for legal documents
├── html/
│   ├── galerie.html        # Masonry photo gallery with 27 optimized images
│   ├── speisekarte.html    # Menu display with responsive PDF & Reservation CTA
│   ├── reservieren.html    # High-end reservation form card
│   ├── impressum.html      # Modernized legal notice
│   └── datenschutz.html    # Modernized privacy policy
├── js/
│   └── cookie-banner.js    # Centralized cookie consent logic
├── php/
│   ├── Tischreservierung.php      # Form handler
│   ├── Die_Reservierung_ist_bestatigt.php  # Visual confirmation page
│   └── test_success.php            # Development preview tool
├── media/
│   └── Speisekarte_RatsstubenGermering.pdf  # Menu source file
├── imgs/
│   ├── T_hero.webp          # Optimized main background
│   ├── Speisekarte_hero.webp # Dedicated menu page banner
│   ├── Galerie_hero.webp    # Dedicated gallery page banner
│   ├── TitelSite_hero.webp  # Dedicated reservation page banner
│   ├── Legal_hero.webp      # Neutral banner for legal pages
│   └── gallery/             # Collection of 27 optimized gallery assets
└── favicons/               # Full branding set (Apple, 16x16, 32x32)
```

## UI Design System

### Visual Identity
*   **Card-Based Layout:** Core content is housed in elevated white cards with `1.25rem` rounded corners and "Premium Soft" shadows.
*   **Hero Sections:** Every page features a specific atmospheric banner image with consistent rounding and subtle overlays.
*   **Typography:** Elegant, lightweight headings (`font-weight: 300`) with precise letter-spacing.
*   **Consistency:** Perfectly synchronized spacing (`1.5rem` gaps) and rounded corners across all components.

### Performance Optimization
*   **WebP Standard:** All images converted to WebP, reducing total payload from ~20MB to under 3MB.
*   **SEO:** Proper `H1` hierarchy, semantic HTML, and descriptive alt tags for all gallery items.
*   **Mobile-First:** Drastically simplified mobile layouts to eliminate clutter and prioritize conversion (Reservations/Menu).

## Key Features

### 1. Masonry Galerie (`html/galerie.html`)
- Dynamic 3-column grid (desktop) that collapses to 1 column (mobile).
- Fast-loading WebP assets with stripping of all metadata.
- Interactive hover effects for engagement.

### 2. Reservation Card (`html/reservieren.html`)
- Visual form grouping with custom SVG iconography.
- Interactive "Selection Pills" for guest preferences.
- Anti-spam honeypot protection.

### 3. Responsive Speisekarte (`html/speisekarte.html`)
- Integrated PDF viewer with responsive height.
- Direct-download primary CTA for mobile users.
- Cross-selling "Hunger bekommen?" footer.

## Restaurant Info

- **Name:** Ratsstuben Germering
- **Address:** Rathausplatz 1, 82110 Germering
- **History:** 35+ Years of Tradition
- **Hours:** Tue - Sun: 11:30 - 22:00 (Mon: Closed)
- **Contact:** 089 847989 | ante.gojin@gmail.com
