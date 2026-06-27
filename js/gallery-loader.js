/**
 * Ratsstuben Germering – Galerie
 * Renders the photographs as chapters of the printed booklet:
 * honest section heads, real captions, native lazy-loading.
 * Width/height are set on every <img> so the masonry reserves space
 * before the picture loads (no layout shift).
 */

document.addEventListener('DOMContentLoaded', function () {
  const root = document.getElementById('gallery-masonry');
  if (!root) return;

  const G = '../imgs/gallery/';
  const A = '../imgs/';

  const sections = [
    {
      title: 'Unser Haus',
      images: [
        { src: A + 'atmosphere_set_table.webp',   w: 1600, h: 1200, cap: 'Eingedeckt für den Abend' },
        { src: A + 'atmosphere_window_side.webp',  w: 1600, h: 1200, cap: 'Plätze am Fenster' },
        { src: G + '20260110_23h56m26s_grim.webp', w: 733,  h: 895,  cap: 'Blick in die Stube' },
        { src: G + 'NisheTable.webp',              w: 1200, h: 900,  cap: 'Tisch in der Nische' },
        { src: G + 'maps_stube.webp',              w: 900,  h: 1200, cap: 'Gemütlich eingerichtet' },
        { src: G + 'maps_kerze.webp',              w: 900,  h: 1200, cap: 'Kerzenschein am Tisch' }
      ]
    },
    {
      title: 'Aus der Küche',
      images: [
        { src: G + 'NiceestSnicl.webp',            w: 1200, h: 900, cap: 'Wiener Schnitzel mit Pommes' },
        { src: G + 'Chevapcici.webp',              w: 1200, h: 900, cap: 'Cevapcici mit Djuvecreis' },
        { src: G + 'PlateFullOfMeat.webp',         w: 1200, h: 900, cap: 'Fleischteller vom Rost' },
        { src: G + 'Gulash.webp',                  w: 1200, h: 900, cap: 'Gulasch mit Reis' },
        { src: G + 'ShroomsChicken.webp',          w: 1200, h: 900, cap: 'Hähnchen in Champignonrahm' },
        { src: G + 'NiceFishPlate.webp',           w: 1200, h: 900, cap: 'Gegrillte Fischplatte' },
        { src: G + '20260110_23h50m19s_grim.webp', w: 735,  h: 726, cap: 'Schnitzel mit Spargel & Sauce Hollandaise' },
        { src: G + '20260110_23h54m23s_grim.webp', w: 1200, h: 622, cap: 'Forelle mit Petersilienkartoffeln' },
        { src: G + '20260110_23h55m11s_grim.webp', w: 1200, h: 611, cap: 'Gemischte Grillplatte' },
        { src: G + '20260111_00h02m11s_grim.webp', w: 547,  h: 837, cap: 'Vukovar-Platte für zwei' },
        { src: G + '20260111_00h01m53s_grim.webp', w: 665,  h: 881, cap: 'Medaillons mit Spätzle' },
        { src: G + '20260111_00h01m38s_grim.webp', w: 461,  h: 834, cap: 'Hausgemachte Spätzle' },
        { src: G + '20260111_00h01m08s_grim.webp', w: 733,  h: 854, cap: 'Herzhaftes Pilzragout' },
        { src: G + '20260110_23h53m57s_grim.webp', w: 922,  h: 655, cap: 'Frischer gemischter Salat' },
        { src: G + 'HawaiiToast.webp',             w: 1200, h: 900, cap: "Medaillons 'Hawaii'" },
        { src: G + 'ApfelStrudl.webp',             w: 1200, h: 900, cap: 'Hausgemachter Apfelstrudel' }
      ]
    },
    {
      title: 'Im Biergarten',
      images: [
        { src: G + 'maps_exterior.webp',           w: 1400, h: 964, cap: 'Die Ratsstuben am Rathausplatz' },
        { src: G + 'maps_biergarten.webp',         w: 1400, h: 627, cap: 'Schattenplätze im Biergarten' },
        { src: G + 'Exteriror.webp',               w: 1200, h: 900, cap: 'Lauschige Plätze im Garten' },
        { src: G + '20260111_00h00m53s_grim.webp', w: 1200, h: 545, cap: 'Unser Biergarten' },
        { src: G + '20260110_23h52m42s_grim.webp', w: 736,  h: 892, cap: 'Ein Paulaner im Grünen' },
        { src: G + '20260111_00h02m25s_grim.webp', w: 724,  h: 880, cap: 'Paulaner Weißbier, frisch gezapft' }
      ]
    },
    {
      title: 'Momente',
      images: [
        { src: G + '20260110_23h46m28s_grim.webp', w: 885,  h: 859,  cap: 'Zu Gast bei uns' },
        { src: G + 'maps_gaeste.webp',             w: 1400, h: 788,  cap: 'Gesellige Runde am Tisch' },
        { src: G + '20260110_23h56m11s_grim.webp', w: 731,  h: 880,  cap: 'Frisch am Tisch serviert' },
        { src: G + '20260110_23h57m00s_grim.webp', w: 731,  h: 812,  cap: 'Anstoßen mit Paulaner' },
        { src: G + 'maps_paulaner_karte.webp',     w: 900,  h: 1200, cap: 'Bei uns gehört Paulaner dazu' },
        { src: G + '20260111_00h02m52s_grim.webp', w: 499,  h: 888,  cap: 'Süßes zum Schluss' }
      ]
    }
  ];

  const frag = document.createDocumentFragment();

  sections.forEach(function (sec) {
    const section = document.createElement('section');
    section.className = 'g-sec';

    const head = document.createElement('div');
    head.className = 'sec-head';
    const h2 = document.createElement('h2');
    h2.textContent = sec.title;
    const rule = document.createElement('span');
    rule.className = 'rule';
    rule.setAttribute('aria-hidden', 'true');
    head.appendChild(h2);
    head.appendChild(rule);
    section.appendChild(head);

    const cols = document.createElement('div');
    cols.className = 'photo-cols';

    sec.images.forEach(function (im) {
      const fig = document.createElement('figure');
      fig.className = 'gallery-item';

      const img = document.createElement('img');
      img.src = im.src;
      img.alt = im.cap;
      img.width = im.w;
      img.height = im.h;
      img.loading = 'lazy';
      img.decoding = 'async';
      img.dataset.fullsrc = im.src;

      const cap = document.createElement('figcaption');
      cap.textContent = im.cap;

      fig.appendChild(img);
      fig.appendChild(cap);
      cols.appendChild(fig);
    });

    section.appendChild(cols);
    frag.appendChild(section);
  });

  root.appendChild(frag);
});
