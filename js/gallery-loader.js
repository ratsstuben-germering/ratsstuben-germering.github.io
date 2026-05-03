/**
 * Ratsstuben Germering - Progressive Gallery Loader
 * Renders the visible part of the gallery first and appends later batches on demand.
 */

document.addEventListener('DOMContentLoaded', function() {
    const masonry = document.getElementById('gallery-masonry');
    const sentinel = document.getElementById('gallery-sentinel');

    if (!masonry || !sentinel) return;

    const galleryImages = [
        { src: '../imgs/atmosphere_dining_room.webp', alt: 'Gastraum im warmen Abendlicht' },
        { src: '../imgs/atmosphere_window_side.webp', alt: 'Fensterplatz mit Nachmittagssonne' },
        { src: '../imgs/atmosphere_set_table.webp', alt: 'Gedeckter Tisch mit stimmungsvoller Beleuchtung' },
        { src: '../imgs/gallery/Exteriror.webp', alt: 'Ratsstuben Außenansicht' },
        { src: '../imgs/gallery/NisheTable.webp', alt: 'Gedeckter Tisch in der Nische' },
        { src: '../imgs/gallery/NiceestSnicl.webp', alt: 'Wiener Schnitzel mit Kartoffelsalat' },
        { src: '../imgs/gallery/SniclPommes.webp', alt: 'Schnitzel mit Pommes' },
        { src: '../imgs/gallery/PlateFullOfMeat.webp', alt: 'Fleischplatte mit Beilagen' },
        { src: '../imgs/gallery/Chevapcici.webp', alt: 'Portion Cevapcici' },
        { src: '../imgs/gallery/Gulash.webp', alt: 'Deftiges Gulasch' },
        { src: '../imgs/gallery/ShroomsChicken.webp', alt: 'Hähnchen mit Champignons' },
        { src: '../imgs/gallery/NiceFishPlate.webp', alt: 'Fischplatte' },
        { src: '../imgs/gallery/HawaiiToast.webp', alt: 'Hawaii Toast' },
        { src: '../imgs/gallery/ApfelStrudl.webp', alt: 'Hausgemachter Apfelstrudel' },
        { src: '../imgs/gallery/20260111_00h03m48s_grim.webp', alt: 'Ratsstuben Außenansicht' },
        { src: '../imgs/gallery/20260110_23h50m19s_grim.webp', alt: 'Speise - Schnitzel' },
        { src: '../imgs/gallery/20260110_23h46m28s_grim.webp', alt: 'Restaurant Interieur' },
        { src: '../imgs/gallery/20260110_23h54m23s_grim.webp', alt: 'Gastraum Details' },
        { src: '../imgs/gallery/20260110_23h56m41s_grim.webp', alt: 'Tischdekoration' },
        { src: '../imgs/gallery/20260110_23h55m30s_grim.webp', alt: 'Blick in den Gastraum' },
        { src: '../imgs/gallery/20260111_00h00m53s_grim.webp', alt: 'Service Bereich' },
        { src: '../imgs/gallery/20260110_23h52m42s_grim.webp', alt: 'Köstliches Essen' },
        { src: '../imgs/gallery/20260110_23h51m27s_grim.webp', alt: 'Spezialität des Hauses' },
        { src: '../imgs/gallery/20260111_00h01m08s_grim.webp', alt: 'Abendstimmung' },
        { src: '../imgs/gallery/20260110_23h57m23s_grim.webp', alt: 'Unsere Bar' },
        { src: '../imgs/gallery/20260110_23h53m16s_grim.webp', alt: 'Leckeres Dessert' },
        { src: '../imgs/gallery/20260111_00h02m11s_grim.webp', alt: 'Details' },
        { src: '../imgs/gallery/20260110_23h56m11s_grim.webp', alt: 'Frühstück / Brunch' },
        { src: '../imgs/gallery/20260111_00h01m53s_grim.webp', alt: 'Atmosphäre' },
        { src: '../imgs/gallery/20260110_23h56m26s_grim.webp', alt: 'Hauptspeise' },
        { src: '../imgs/gallery/20260111_00h02m25s_grim.webp', alt: 'Gedeckter Tisch' },
        { src: '../imgs/gallery/20260111_00h01m22s_grim.webp', alt: 'Saisonal' },
        { src: '../imgs/gallery/20260110_23h57m00s_grim.webp', alt: 'Getränke' },
        { src: '../imgs/gallery/20260111_00h01m38s_grim.webp', alt: 'Küche' },
        { src: '../imgs/gallery/20260110_23h53m57s_grim.webp', alt: 'Telleranrichtung' },
        { src: '../imgs/gallery/20260111_00h02m52s_grim.webp', alt: 'Lichtblick' },
        { src: '../imgs/gallery/20260110_23h48m27s_grim.webp', alt: 'Willkommen' },
        { src: '../imgs/gallery/20260110_23h55m11s_grim.webp', alt: 'Ambiente' }
    ];

    const initialBatchSize = window.innerWidth >= 992 ? 6 : 4;
    const subsequentBatchSize = window.innerWidth >= 992 ? 3 : 2;
    const eagerCount = window.innerWidth >= 992 ? 3 : 2;

    let renderedCount = 0;
    let isRendering = false;
    const preloadOffset = 250;

    function buildGalleryItem(image, index) {
        const item = document.createElement('div');
        item.className = 'gallery-item';

        const img = document.createElement('img');
        img.className = 'img-fluid';
        img.alt = image.alt;
        img.decoding = 'async';
        img.loading = index < eagerCount ? 'eager' : 'lazy';
        img.src = image.src;
        img.dataset.fullsrc = image.src;

        if (index < eagerCount) {
            img.fetchPriority = 'high';
        }

        item.appendChild(img);
        return item;
    }

    function renderNextBatch(batchSize) {
        if (isRendering || renderedCount >= galleryImages.length) return;
        isRendering = true;

        const targetCount = Math.min(renderedCount + batchSize, galleryImages.length);

        function appendChunk() {
            const fragment = document.createDocumentFragment();
            const chunkEnd = Math.min(renderedCount + 1, targetCount);

            for (let index = renderedCount; index < chunkEnd; index += 1) {
                fragment.appendChild(buildGalleryItem(galleryImages[index], index));
            }

            masonry.appendChild(fragment);
            renderedCount = chunkEnd;

            if (renderedCount < targetCount) {
                window.requestAnimationFrame(appendChunk);
                return;
            }

            isRendering = false;

            if (renderedCount >= galleryImages.length) {
                sentinel.hidden = true;
                return;
            }

            const sentinelTop = sentinel.getBoundingClientRect().top;
            const viewportBottom = window.innerHeight + preloadOffset;

            if (sentinelTop <= viewportBottom) {
                window.requestAnimationFrame(function() {
                    renderNextBatch(subsequentBatchSize);
                });
            }
        }

        window.requestAnimationFrame(appendChunk);
    }

    renderNextBatch(initialBatchSize);

    if (!('IntersectionObserver' in window)) {
        renderNextBatch(galleryImages.length);
        sentinel.hidden = true;
        return;
    }

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (!entry.isIntersecting) return;
            renderNextBatch(subsequentBatchSize);
        });
    }, {
        rootMargin: preloadOffset + 'px 0px'
    });

    observer.observe(sentinel);
});
