# Ratsstuben Germering - Restaurant Website

Traditional German restaurant website with online reservation system, photo gallery, and menu display.

**Live Site:** https://ratsstuben-germering.de
**GitHub Pages:** https://ratsstuben-germering.github.io

## Quick Start

### Local Development with Docker

```bash
# Serve with PHP (recommended for full testing)
docker run -d --name ratsstuben-php -p 8080:80 -v "$(pwd):/var/www/html" php:apache

# Access at http://localhost:8080
```

### Static Files Only

```bash
# Python 3
python3 -m http.server 8080

# Node.js
npx serve

# PHP built-in server
php -S localhost:8080
```

## Project Overview

| Aspect | Details |
|--------|---------|
| **Type** | Static site with PHP backend for reservations |
| **Hosting** | GitHub Pages (static) + External PHP Server (reservations) |
| **Security** | CSRF protection, input sanitization, security headers, honeypot |
| **Performance** | Lazy loading, deferred JS, caching headers, WebP images |

## File Structure

```
ratsstuben-germering.github.io/
├── index.html              # Landing page
├── css/                    # Stylesheets
│   ├── bootstrap.min.css   # Bootstrap 4.0 framework
│   ├── common.css          # Shared styles, CSS variables, footer
│   ├── index.css           # Homepage styles
│   ├── galerie.css         # Gallery masonry layout
│   ├── reservieren.css     # Reservation form
│   ├── speisekarte.css     # Menu page
│   └── legal.css           # Privacy/Terms pages
├── html/                   # Static pages
│   ├── galerie.html        # Photo gallery
│   ├── speisekarte.html    # Menu with PDF viewer
│   ├── datenschutz.html    # Privacy policy
│   └── impressum.html      # Legal notice
├── php/                    # Server-side processing
│   ├── security.php        # Security utilities (CSRF, Rate Limiting, sanitization)
│   ├── reservieren.php     # Secure reservation form with CSRF
│   ├── Tischreservierung.php  # Form handler with validation
│   ├── Die_Reservierung_ist_bestatigt.php  # Success page
│   └── temp/               # Local storage for rate limiting data (auto-cleaned)
├── js/
│   └── cookie-banner.js    # Cookie consent (deferred loading)
├── imgs/
│   └── gallery/            # 27 WebP gallery images (lazy loaded)
├── media/
│   └── Speisekarte_RatsstubenGermering.pdf
├── favicons/               # Complete favicon set
└── .deployment_scripts/
    ├── deployWebApp.sh     # Production deployment
    └── nginx-cache.conf    # Caching & compression config
```

## Features

### Security
- ✅ IP-based rate limiting (30 requests / 10 min)
- ✅ CSRF token protection (2-hour expiration)
- ✅ Input sanitization (string, email, integer)
- ✅ Security headers (CSP, X-Frame-Options, X-XSS-Protection)
- ✅ Advanced honeypot with timing validation
- ✅ Secure error logging (no sensitive data exposure)
- ✅ Server-side validation (date, time, required fields)

### Performance
- ✅ Image lazy loading (27 gallery images)
- ✅ Deferred JavaScript loading
- ✅ Nginx caching configuration
- ✅ WebP image format (3MB total vs ~20MB original)
- ✅ Gzip compression ready

### User Experience
- Responsive design (mobile-first)
- Card-based layout with modern styling
- Interactive form elements
- PDF menu viewer with download fallback
- German language interface

## Deployment

### Production Server
The site uses a hybrid deployment:
- **Static files:** GitHub Pages (gh-pages branch)
- **PHP backend:** External server at `ratsstuben-germering.de`

### Nginx Configuration
Include `.deployment_scripts/nginx-cache.conf` in your Nginx config for caching headers.

### Environment Variables
Set on PHP server:
- `TELEGRAM_BOT_TOKEN` - Telegram bot API token
- `CHAT_ID` - Telegram chat ID for notifications

## Restaurant Info

- **Name:** Ratsstuben Germering
- **Address:** Rathausplatz 1, 82110 Germering
- **Hours:** Tue - Sun: 11:30 - 22:00 (Mon: Closed)
- **Phone:** +49 89 847989
- **Email:** ratsstuben.germering@gmail.com

## Technology Stack

| Technology | Purpose |
|------------|---------|
| HTML5 | Semantic markup |
| CSS3 | Variables, Flexbox, Grid |
| Bootstrap 4.0 | Responsive framework |
| PHP 7.4+ | Reservation processing |
| Vanilla JS | Cookie consent |
| WebP | Image optimization |

## License

© Ratsstuben Germering
