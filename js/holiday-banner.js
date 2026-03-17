(function() {
  var reopenDate = new Date('2026-03-31T00:00:00');
  var now = new Date();

  if (now < reopenDate) {
    var overlay = document.createElement('div');
    overlay.className = 'holiday-modal-overlay';
    overlay.id = 'holiday-modal';

    overlay.innerHTML = '\
      <div class="holiday-modal">\
        <div class="holiday-modal-icon">&#9728;</div>\
        <h3 class="holiday-modal-title">Urlaubszeit!</h3>\
        <p class="holiday-modal-text">\
          Wir haben Urlaub!<br>\
          Wieder offen ab <span class="holiday-modal-highlight">31.03.2026</span>\
        </p>\
        <p class="holiday-modal-note">Reservierungen für spätere Termine nehmen wir gerne entgegen.</p>\
        <button class="holiday-modal-btn" onclick="document.getElementById(\'holiday-modal\').style.display=\'none\'">Verstanden</button>\
      </div>\
    ';

    document.body.appendChild(overlay);
  }
})();
