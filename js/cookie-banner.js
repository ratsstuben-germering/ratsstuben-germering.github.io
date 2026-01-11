document.addEventListener("DOMContentLoaded", function() {
    // HTML for the banner
    var bannerHTML = '<div id="cookie-banner" style="position: fixed; bottom: 0; width: 100%; background: #222; color: #fff; padding: 1rem; text-align: center; z-index: 9999; display: none;">' +
        'Diese Seite verwendet technisch notwendige Cookies (für Reservierungen). Wir sammeln keine Daten für Marketingzwecke.' +
        '<button id="cookie-ok" style="margin-left: 1rem; padding: 0.5rem 1rem; cursor: pointer; color: black;">Ich erkenne an</button>' +
        '</div>';

    // Inject banner into body
    document.body.insertAdjacentHTML('beforeend', bannerHTML);

    function setCookie(name, value, days) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) +
            '; expires=' + expires +
            '; path=/; SameSite=Lax';
    }

    function getCookie(name) {
        return document.cookie.split('; ').some(row => row.startsWith(name + '='));
    }

    // Check cookie and show banner
    var banner = document.getElementById('cookie-banner');
    if (!getCookie('cookieInfoShown')) {
        banner.style.display = 'block';
    }

    // Handle click
    document.getElementById('cookie-ok').addEventListener('click', function () {
        setCookie('cookieInfoShown', 'true', 365);
        banner.style.display = 'none';
    });
});
