<?php
/**
 * Reservation Form Page with CSRF Protection
 * This PHP version should be hosted on the PHP server
 */

require_once __DIR__ . '/security.php';

// Set security headers
setSecurityHeaders();

// Generate CSRF token for this form
$csrfToken = generateCsrfToken();
$timestamp = time();
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicons/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">

    <title>Tisch reservieren - Ratsstuben Germering</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Common styles -->
    <link href="../css/common.css" rel="stylesheet">

    <!-- Page-specific styles -->
    <link href="../css/reservieren.css" rel="stylesheet">

    <style>
      /* Force reset to debug spacing issue */
      body { padding-bottom: 0 !important; }
      footer { margin-bottom: 0 !important; }

      /* Enhanced honeypot styles */
      .website-url-field {
        position: absolute;
        left: -9999px;
        width: 1px;
        height: 1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
      }
    </style>

  </head>

  <body class="bg-dark d-flex flex-column min-vh-100">
    <header class="masthead dark-header w-100">
      <div class="site-container site-container-wide mx-auto px-3">
        <div class="inner">
          <h3 class="masthead-brand"><a href="/index.html">Ratsstuben <span class="brand-subtitle">aus Germering</span></a></h3>
          <nav class="nav nav-masthead">
            <a class="nav-link" href="/index.html">Titelseite</a>
            <a class="nav-link" href="/html/galerie.html">Galerie</a>
            <a class="nav-link" href="/html/speisekarte.html">Speisekarte</a>
            <a class="nav-link active" href="/php/reservieren.php">Reservieren</a>
          </nav>
        </div>
      </div>
    </header>

    <div class="site-container site-container-wide mx-auto w-100">
      <main role="main">
        <div class="container px-3 pt-4">
          <div class="row justify-content-center">
            <div class="col-lg-10">
              <!-- Hero Header Card -->
              <div class="reservation-hero text-center text-white d-flex align-items-center justify-content-center shadow-lg mb-0 rounded-lg">
                <div class="px-3 py-5">
                  <h1 class="display-4 font-weight-light mb-3">Tisch reservieren</h1>
                  <p class="lead shadow-text mb-0">Wir freuen uns darauf, Sie bald bei uns begrüßen zu dürfen.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-10">
              <div class="reservation-card shadow-lg bg-white p-4 p-md-5">
                <div class="text-center mb-5">
                  <p class="text-muted">Bitte füllen Sie das Formular aus, um Ihre Anfrage zu senden.<br>
                  Bei kurzfristigen Stornierungen werden wir Sie telefonisch kontaktieren.</p>
                </div>

                <form method="POST" action="Tischreservierung.php" id="reservationForm">
                  <!-- CSRF Token -->
                  <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                  <!-- Timestamp for bot detection -->
                  <input type="hidden" name="form_timestamp" value="<?php echo $timestamp; ?>">

                  <!-- Honeypot fields (hidden from users) -->
                  <input type="text" name="address" class="honeyfield" tabindex="-1" autocomplete="off">
                  <input type="text" name="website_url" class="website-url-field" tabindex="-1" autocomplete="off">

                  <!-- Section 1: Wann & Wer -->
                  <div class="form-section mb-5">
                    <h2 class="h5 border-bottom pb-3 mb-4 text-dark font-weight-bold d-flex align-items-center">
                      <span class="section-icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16"><path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg></span>
                      1. Reservierungsdetails
                    </h2>
                    <div class="row">
                      <div class="col-md-4 mb-3">
                        <label for="date" class="small font-weight-bold text-uppercase text-muted mb-2 d-block">Datum</label>
                        <input type="date" name="date" class="form-control form-control-lg custom-input" id="date" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="time" class="small font-weight-bold text-uppercase text-muted mb-2 d-block">Uhrzeit</label>
                        <input type="time" name="time" class="form-control form-control-lg custom-input" id="time" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="n_guests" class="small font-weight-bold text-uppercase text-muted mb-2 d-block">Gästeanzahl</label>
                        <input type="number" name="n_guests" class="form-control form-control-lg custom-input" id="n_guests" placeholder="Anzahl" required min="1">
                      </div>
                    </div>
                  </div>

                  <!-- Section 2: Kontakt -->
                  <div class="form-section mb-5">
                    <h2 class="h5 border-bottom pb-3 mb-4 text-dark font-weight-bold d-flex align-items-center">
                      <span class="section-icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16"><path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.496 3.5 3.5 0 0 0-1.098-.312V12a.5.5 0 0 0-1 0v.022c-.289.028-.562.08-.813.155A4.22 4.22 0 0 0 8 12c-.5 0-.934.092-1.313.243a4.174 4.174 0 0 0-.813-.155V12a.5.5 0 0 0-1 0v.987a3.5 3.5 0 0 0-1.098.312c-.29.139-.55.305-.776.496V2.5z"/></svg></span>
                      2. Ihre Kontaktdaten
                    </h2>
                    <div class="mb-3">
                      <label for="name" class="small font-weight-bold text-uppercase text-muted mb-2 d-block">Vollständiger Name</label>
                      <input type="text" name="name" class="form-control form-control-lg custom-input" id="name" placeholder="Vor- und Nachname" required>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="telefon" class="small font-weight-bold text-uppercase text-muted mb-2 d-block">Telefon</label>
                        <input type="tel" name="telefon" class="form-control form-control-lg custom-input" id="telefon" placeholder="+49 **** **** ***" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="email" class="small font-weight-bold text-uppercase text-muted mb-2 d-block">Email <span class="font-weight-light">(Optional)</span></label>
                        <input type="email" name="email" class="form-control form-control-lg custom-input" id="email" placeholder="beispiel@mail.de">
                      </div>
                    </div>
                  </div>

                  <!-- Section 3: Wünsche -->
                  <div class="form-section mb-5">
                    <h2 class="h5 border-bottom pb-3 mb-4 text-dark font-weight-bold d-flex align-items-center">
                      <span class="section-icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/><path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg></span>
                      3. Besondere Wünsche
                    </h2>
                    <div class="mb-4">
                      <div class="row">
                        <div class="col-sm-6 mb-3">
                          <div class="custom-control custom-checkbox selection-pill p-3">
                            <input type="checkbox" name="outside-area" class="custom-control-input" id="outside-area">
                            <label class="custom-control-label font-weight-bold w-100" for="outside-area">Außenbereich</label>
                          </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <div class="custom-control custom-checkbox selection-pill p-3">
                            <input type="checkbox" name="Kinderstuhl" class="custom-control-input" id="Kinderstuhl">
                            <label class="custom-control-label font-weight-bold w-100" for="Kinderstuhl">Kinderstuhl</label>
                          </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <div class="custom-control custom-checkbox selection-pill p-3">
                            <input type="checkbox" name="Roolstuhl" class="custom-control-input" id="Roolstuhl">
                            <label class="custom-control-label font-weight-bold w-100" for="Roolstuhl">Rollstuhlplatz</label>
                          </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <div class="custom-control custom-checkbox selection-pill p-3">
                            <input type="checkbox" name="Hund" class="custom-control-input" id="Hund">
                            <label class="custom-control-label font-weight-bold w-100" for="Hund">Hund mitbringen</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="extra" class="small font-weight-bold text-uppercase text-muted">Weitere Informationen</label>
                      <textarea name="extra" class="form-control" id="extra" rows="3" placeholder="Haben Sie Allergien oder besondere Anlässe?"></textarea>
                    </div>
                  </div>

                  <div class="pt-3">
                    <button class="btn btn-dark btn-lg btn-block py-3 shadow" type="submit">Jetzt verbindlich reservieren</button>
                    <p class="text-center small text-muted mt-3">* Mit dem Absenden akzeptieren Sie, dass wir Sie zwecks Reservierung kontaktieren dürfen.</p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <footer class="site-footer dark-footer w-100">
      <div class="site-container site-container-wide mx-auto px-3">
        <div class="footer-grid">
          <div class="footer-section">
            <h4 class="footer-section-title">Kontakt</h4>
            <address>
              <p class="footer-copyright">&copy; Ratsstuben Germering</p>
              <p><a href="tel:089847989" class="footer-phone">tel: 089 847989</a></p>
            </address>
          </div>
          <div class="footer-section">
            <h4 class="footer-section-title">Öffnungszeiten</h4>
            <p class="footer-work-hours">
              Dienstag - Sonntag: 11:30 - 22:00 Uhr<br>
              Montags geschlossen
            </p>
          </div>
          <div class="footer-section">
            <h4 class="footer-section-title">Rechtliches</h4>
            <nav aria-label="Footer navigation">
              <a href="/html/datenschutz.html" class="footer-link">Datenschutz</a><br>
              <a href="/html/impressum.html" class="footer-link">Impressum</a>
            </nav>
          </div>
        </div>
      </div>
    </footer>

    <script src="../js/cookie-banner.js" defer></script>

  </body>
</html>
