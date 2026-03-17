(function() {
  var reopenDate = new Date('2026-03-31T00:00:00');
  var now = new Date();

  if (now < reopenDate) {
    document.body.classList.add('has-holiday-banner');

    var banner = document.createElement('div');
    banner.className = 'holiday-banner';
    banner.innerHTML = '\
      <div class="holiday-banner-content">\
        <span class="holiday-banner-text">\
          Wir haben Urlaub! Wieder offen ab <span class="holiday-banner-highlight">31.03.2026</span>\
        </span>\
        <span class="holiday-banner-note">Reservierungen für spätere Termine nehmen wir gerne entgegen.</span>\
      </div>\
    ';
    document.body.insertBefore(banner, document.body.firstChild);
  }
})();
