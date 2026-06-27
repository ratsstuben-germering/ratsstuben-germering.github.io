/**
 * Ratsstuben Germering – Speisekarte renderer
 * Renders Speisekarte_v2.json as a printed menu sheet:
 * left-aligned dish rows with leader dots, the "Empfehlungen" band,
 * and a grouped, type-labelled drinks section.
 */

document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('dynamic-menu-container');
  const noteEl = document.getElementById('menu-note');
  if (!container) return;

  fetch('../media/Speisekarte_v2.json?v=20260627e')
    .then(function (r) { if (!r.ok) throw new Error('Network response was not ok'); return r.json(); })
    .then(function (data) { render(data, container, noteEl); })
    .catch(function (err) {
      console.error('Error loading menu:', err);
      container.innerHTML = '<p class="menu-loading">Die Speisekarte konnte gerade nicht geladen werden. '
        + '<a href="../media/Speisekarte_RatsstubenGermering.pdf?v=20260605" download>Bitte hier als PDF öffnen.</a></p>';
    });
});

function formatPrice(p) {
  if (typeof p !== 'number') return p;
  return p.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
}

function esc(s) {
  const d = document.createElement('div');
  d.textContent = (s === undefined || s === null) ? '' : s;
  return d.innerHTML;
}

function render(data, container, noteEl) {
  const sizeTok  = it => it.size ? `<span class="size">${esc(it.size)}</span>` : '';
  const badgeTok = it => it.badge ? `<span class="badge b-${esc(it.badge_type || 'classic')}">${esc(it.badge)}</span>` : '';
  const numTok   = it => `<span class="num">${(it.id !== undefined && it.id !== '') ? esc(String(it.id)) : ''}</span>`;

  let html = '';
  (data.categories || []).forEach(function (cat, i) {
    // grouped, type-labelled drinks section
    if (cat.layout === 'drinks' && Array.isArray(cat.groups)) {
      html += `<section class="sec">
        <div class="sec-head"><h2>${esc(cat.name)}</h2><span class="rule"></span></div>
        <div class="drinks">`;
      cat.groups.forEach(function (g) {
        html += `<div class="drink-group">
          <h3 class="drink-sub">${esc(g.label)}${g.note ? ` <span class="drink-note">${esc(g.note)}</span>` : ''}</h3>
          <ul class="drinks-list">`;
        (g.items || []).forEach(function (it) {
          html += `<li class="drink-row"><span class="d-nm">${esc(it.name)}</span><span class="dots"></span>${sizeTok(it)}<span class="pr">${formatPrice(it.price)}</span></li>`;
        });
        html += `</ul></div>`;
      });
      html += `</div></section>`;
      return;
    }

    // food section (first one = recommendations band)
    const feat = i === 0;
    html += `<section class="sec ${feat ? 'feat' : ''}">
      <div class="sec-head">${feat ? '<span class="star" aria-hidden="true">★</span>' : ''}<h2>${esc(cat.name)}</h2><span class="rule"></span></div>
      <ul class="dishes">`;
    (cat.items || []).forEach(function (it) {
      html += `<li class="dish">${numTok(it)}<div class="body">
          <div class="line"><span class="nm">${esc(it.name)}${badgeTok(it)}</span><span class="dots"></span>${sizeTok(it)}<span class="pr">${formatPrice(it.price)}</span></div>
          ${it.description ? `<p class="desc">${esc(it.description)}</p>` : ''}
        </div></li>`;
    });
    html += `</ul></section>`;
  });

  container.innerHTML = html;
  if (noteEl) noteEl.textContent = data.footer || '';
}
