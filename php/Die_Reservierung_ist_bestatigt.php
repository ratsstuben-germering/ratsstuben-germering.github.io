<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if reservation data exists in session
$hasReservation = isset($_SESSION['reservation']);
$reservation = $hasReservation ? $_SESSION['reservation'] : null;

// Clear the session after reading
if ($hasReservation) {
    unset($_SESSION['reservation']);
}
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

    <title>Reservierungsbestätigung - Ratsstuben Germering</title>

    <link href="../css/bootstrap.min.css?v=20260627d" rel="stylesheet">
    <link href="../css/common.css?v=20260627d" rel="stylesheet">

    <style>
      .success-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem 1rem;
      }

      .success-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: #28a745;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .success-icon::after {
        content: '✓';
        font-size: 3rem;
        color: var(--color-white);
        font-weight: bold;
      }

      .success-card {
        background: var(--paper-card);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-top: 2rem;
      }

      .success-card h2 {
        color: #1f8f3b;
        margin-bottom: 1rem;
        text-align: center;
      }

      .success-card .intro-text {
        text-align: center;
        color: var(--ink-soft);
        margin-bottom: 1.5rem;
      }

      .reservation-details {
        background: rgba(44, 82, 133, 0.06);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-top: 1.5rem;
      }

      .reservation-details h3 {
        font-size: 1.1rem;
        color: var(--ink);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--line);
      }

      .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--line);
      }

      .detail-row:last-child {
        border-bottom: none;
      }

      .detail-label {
        font-weight: 600;
        color: var(--ink);
      }

      .detail-value {
        color: var(--ink-soft);
        text-align: right;
      }

      .detail-value.ja {
        color: #1f8f3b;
        font-weight: 600;
      }

      .detail-value.nein {
        color: rgba(95, 86, 69, 0.6);
      }

      .error-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem 1rem;
      }

      .error-card {
        background: var(--paper-card);
        border: 1px solid var(--line);
        border-left: 4px solid #dc3545;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-top: 2rem;
      }

      .error-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        background: #dc3545;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .error-icon::after {
        content: '!';
        font-size: 2rem;
        color: var(--color-white);
        font-weight: bold;
      }

      .error-card h2 {
        color: #dc3545;
        text-align: center;
        margin-bottom: 1rem;
      }

      .error-card p {
        color: var(--ink-soft);
        text-align: center;
        line-height: 1.6;
      }

      .btn-home {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: var(--blue);
        color: var(--cream);
        text-decoration: none;
        border-radius: 7px;
        font-weight: 700;
        margin-top: 1rem;
        transition: background 0.2s;
      }

      .btn-home:hover {
        background: var(--blue-deep);
        color: var(--cream);
        text-decoration: none;
      }

      .contact-box {
        background: rgba(44, 82, 133, 0.06);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        padding: 1rem;
        margin-top: 1.5rem;
        text-align: center;
        color: var(--ink);
      }

      .contact-box a {
        color: var(--blue);
        font-weight: 700;
      }

      .extra-empty {
        color: rgba(95, 86, 69, 0.6);
        font-style: italic;
      }
    </style>
  </head>

  <body class="d-flex flex-column min-vh-100">
    <header class="site-head">
      <div class="wrap site-head-inner">
        <a class="brand" href="/index.html" aria-label="Ratsstuben Germering – Startseite">
          <img class="brand-logo" src="/imgs/logo-ratsstuben.svg?v=20260627d" alt="Ratsstuben Germering – Paulaner München" width="262" height="46">
        </a>
        <nav class="mainnav" aria-label="Hauptnavigation">
          <a href="/html/speisekarte.html">Speisekarte</a>
          <a href="/html/galerie.html">Galerie</a>
          <a class="active" href="/php/reservieren.php">Reservieren</a>
          <a class="nav-call" href="tel:+4989847989">089&nbsp;847989</a>
        </nav>
      </div>
    </header>

    <div class="site-container site-container-wide p-3 mx-auto flex-grow-1 w-100">
      <main role="main">
    <?php if ($hasReservation && $reservation): ?>
    <div class="success-container">
      <div class="success-icon"></div>
      <div class="success-card">
        <h2>Reservierung erfolgreich!</h2>
        <p class="intro-text">
          Vielen Dank für Ihre Reservierung.<br>
          Wir haben Ihre Anfrage erhalten und freuen uns auf Ihren Besuch!
        </p>

        <div class="reservation-details">
          <h3>Ihre Reservierungsdetails</h3>

          <div class="detail-row">
            <span class="detail-label">Name:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['name']); ?></span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Telefon:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['phone']); ?></span>
          </div>

          <?php if (!empty($reservation['email'])): ?>
          <div class="detail-row">
            <span class="detail-label">E-Mail:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['email']); ?></span>
          </div>
          <?php endif; ?>

          <div class="detail-row">
            <span class="detail-label">Datum:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['date']); ?></span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Uhrzeit:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['time']); ?></span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Anzahl Gäste:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['guests']); ?></span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Außenbereich:</span>
            <span class="detail-value <?php echo $reservation['outside'] ? 'ja' : 'nein'; ?>">
              <?php echo $reservation['outside'] ? 'Ja' : 'Nein'; ?>
            </span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Kinderstuhl:</span>
            <span class="detail-value <?php echo $reservation['child_seat'] ? 'ja' : 'nein'; ?>">
              <?php echo $reservation['child_seat'] ? 'Ja' : 'Nein'; ?>
            </span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Rollstuhl:</span>
            <span class="detail-value <?php echo $reservation['wheelchair'] ? 'ja' : 'nein'; ?>">
              <?php echo $reservation['wheelchair'] ? 'Ja' : 'Nein'; ?>
            </span>
          </div>

          <div class="detail-row">
            <span class="detail-label">Hund:</span>
            <span class="detail-value <?php echo $reservation['dog'] ? 'ja' : 'nein'; ?>">
              <?php echo $reservation['dog'] ? 'Ja' : 'Nein'; ?>
            </span>
          </div>

          <?php if (!empty($reservation['extra'])): ?>
          <div class="detail-row">
            <span class="detail-label">Besondere Wünsche:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['extra']); ?></span>
          </div>
          <?php endif; ?>

          <div class="detail-row">
            <span class="detail-label">Reserviert am:</span>
            <span class="detail-value"><?php echo htmlspecialchars($reservation['timestamp']); ?></span>
          </div>
        </div>

        <div class="contact-box">
          <p>Falls wir Ihre Reservierung stornieren müssen, kontaktieren wir Sie unter den angegebenen Kontaktdaten. Bitte achten Sie auf korrekte Angaben.</p>
        </div>

        <div class="text-center mt-4">
          <a href="../index.html" class="btn-home">Zurück zur Startseite</a>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="error-container">
      <div class="error-icon"></div>
      <div class="error-card">
        <h2>Fehler</h2>
        <p>
          Es ist ein Fehler aufgetreten. Dieser tritt auf, wenn Sie direkt auf diese Seite navigieren oder nach dem Absenden die Seite aktualisieren.
          <br><br>
          Dies hat jedoch keinen Einfluss auf eine bereits getätigte Reservierung.
        </p>

        <div class="contact-box">
          <p>Für telefonische Reservierungen erreichen Sie uns:</p>
          <p>Dienstag - Sonntag: 11:30 - 22:00 Uhr</p>
          <a href="tel:+4989847989">+49 89 847989</a>
        </div>

        <div class="text-center">
          <a href="../index.html" class="btn-home">Zurück zur Startseite</a>
        </div>
      </div>
    </div>
    <?php endif; ?>
      </main>
    </div>

    <footer class="site-footer w-100">
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
              <a href="../html/datenschutz.html" class="footer-link">Datenschutz</a><br>
              <a href="../html/impressum.html" class="footer-link">Impressum</a>
            </nav>
          </div>
        </div>
      </div>
    </footer>
    <script src="../js/cookie-banner.js?v=20260503" defer></script>
  </body>
</html>
