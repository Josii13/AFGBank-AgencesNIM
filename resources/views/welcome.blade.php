<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trouvez votre Point NIM AFG Bank Atlantic Group le plus proche de chez vous à Madagascar.">
    <title>Points NIM – AFG Bank</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <style>
        /* ---- Map ---- */
        #map {
            height: 280px;
            width: 100%;
            border-radius: 0 0 1rem 1rem;
        }
        @media (min-width: 768px) {
            #map { height: 530px; border-radius: 0 0 1rem 1rem; }
        }

        /* ---- Leaflet popup ---- */
        .leaflet-popup-content-wrapper {
            border-radius: 14px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.18);
            padding: 0;
            overflow: hidden;
        }
        .leaflet-popup-content { margin: 0; line-height: 1.4; }
        .nim-popup-header {
            background: #00A651;
            color: white;
            padding: 10px 14px 8px;
        }
        .nim-popup-header h3 { font-weight: 700; font-size: 14px; margin: 0 0 2px; }
        .nim-popup-header p  { font-size: 11px; opacity: 0.85; margin: 0; }
        .nim-popup-body { padding: 10px 14px 12px; }
        .nim-popup-address {
            font-size: 12px; color: #555;
            margin-bottom: 8px; line-height: 1.45;
        }
        .nim-popup-hours-title {
            font-size: 10px; text-transform: uppercase;
            letter-spacing: 0.06em; color: #999;
            font-weight: 600; margin-bottom: 5px;
        }
        .nim-popup-hours-row {
            display: flex; justify-content: space-between;
            gap: 16px; font-size: 12px;
            padding: 3px 0; border-bottom: 1px solid #f3f4f6;
        }
        .nim-popup-hours-row:last-child { border-bottom: none; }
        .nim-popup-open   { color: #00A651; font-weight: 600; }
        .nim-popup-closed { color: #E30613; font-weight: 600; }

        /* ---- Bouton fermer popup ---- */
        .leaflet-popup-close-button {
            width: 26px !important;
            height: 26px !important;
            top: 8px !important;
            right: 8px !important;
            background: white !important;
            border-radius: 50% !important;
            font-size: 16px !important;
            line-height: 26px !important;
            text-align: center !important;
            color: #374151 !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2) !important;
            padding: 0 !important;
        }
        .leaflet-popup-close-button:hover {
            background: #f3f4f6 !important;
            color: #111827 !important;
        }

        /* ---- Active card ---- */
        .card-active {
            border-color: #00A651 !important;
            background-color: #f0fdf4 !important;
            box-shadow: 0 0 0 2px rgba(0,166,81,0.15) !important;
        }

        /* ---- Scrollable list desktop ---- */
        @media (min-width: 768px) {
            #nim-list-wrapper {
                max-height: 530px;
                overflow-y: auto;
                padding-right: 2px;
            }
            #nim-list-wrapper::-webkit-scrollbar { width: 4px; }
            #nim-list-wrapper::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
            #nim-list-wrapper::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        }

        /* ---- Scrollable list mobile (sous la carte) ---- */
        @media (max-width: 767px) {
            #nim-list-wrapper {
                max-height: 340px;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        .nim-card { transition: border-color .2s, background-color .2s, box-shadow .2s; }

        /* ---- Header logos responsive ---- */
        .header-logos {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            overflow: hidden;
        }
        .header-logos img {
            flex-shrink: 0;
            object-fit: contain;
        }
        @media (max-width: 380px) {
            .header-logos img:first-child { height: 48px; }
            .header-logos img:last-child  { height: 40px; }
        }
        @media (min-width: 381px) and (max-width: 767px) {
            .header-logos img:first-child { height: 56px; }
            .header-logos img:last-child  { height: 48px; }
        }
        @media (min-width: 768px) {
            .header-logos img:first-child { height: 80px; }
            .header-logos img:last-child  { height: 68px; }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans min-h-screen">

    {{-- HEADER --}}
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-2">
            <div class="header-logos">
                <img src="{{ asset('images/logo_afg.jpg') }}"  alt="AFG Bank">
                <img src="{{ asset('images/LOGO_NIM.jpeg') }}" alt="Points NIM">
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <section class="bg-gradient-to-r from-green-800 to-green-600 text-white py-6 px-4">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-xl md:text-3xl font-bold leading-tight mb-2">
                Trouvez votre Point NIM
            </h1>
            <p class="text-green-100 text-sm md:text-base max-w-lg mb-2">
                Retrouvez les différents points NIM disponibles à travers Madagascar.
                Cliquez sur un marqueur ou une carte pour voir les détails et les horaires.
            </p>
            <p class="text-white text-base md:text-xl font-semibold">
                Contactez-nous : +261 32 12 032 32 ou afgmada_relationclient@afgbank.mg
            </p>
        </div>
    </section>

    {{-- MAIN --}}
    <main class="max-w-6xl mx-auto px-4 py-4 md:py-6">

        {{-- Layout : colonne sur mobile, côte-à-côte sur desktop --}}
        <div class="flex flex-col md:flex-row gap-4 md:gap-6">

            {{-- MAP (en premier sur mobile ET desktop) --}}
            <div class="md:flex-1 min-w-0">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="px-4 pt-3 pb-2 flex items-center gap-2 border-b border-gray-100">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <h2 class="text-sm font-semibold text-gray-700">Carte interactive</h2>
                        <span class="ml-auto text-xs text-gray-400">{{ count($nimPoints) }} points</span>
                    </div>
                    <div id="map"></div>
                </div>
            </div>

            {{-- LISTE (sous la carte sur mobile, à droite sur desktop) --}}
            <div class="md:w-80 shrink-0">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3 px-1">
                    Nos {{ count($nimPoints) }} Points NIM
                </p>
                {{-- Wrapper scrollable indépendant --}}
                <div id="nim-list-wrapper">
                    <div class="flex flex-col gap-3" id="nim-list"></div>
                </div>
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="mt-10 bg-white border-t border-gray-100 py-6 px-4">
        <div class="max-w-6xl mx-auto flex flex-col items-center gap-2">
            <p class="text-xs text-gray-400 text-center">
                © {{ date('Y') }} AFG Bank – Atlantic Group. Tous droits réservés. Madagascar.
            </p>
        </div>
    </footer>

    {{-- LEAFLET JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <script>
    const nimPoints = {!! json_encode($nimPoints) !!};

    const map = L.map('map').setView([-20.0, 47.0], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map);

    function makeIcon(active) {
        const bg = active ? '#E30613' : '#00A651';
        return L.divIcon({
            className: '',
            html: `<div style="
                width:36px;height:36px;
                background:${bg};
                border:3px solid white;
                border-radius:50%;
                box-shadow:0 3px 12px rgba(0,0,0,0.28);
                display:flex;align-items:center;justify-content:center;
            "><div style="width:11px;height:11px;background:white;border-radius:50%;"></div></div>`,
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -22],
        });
    }

    function buildPopup(p) {
        const rows = p.hours.map(h => {
            const cls = h.time === 'Fermé' ? 'nim-popup-closed' : 'nim-popup-open';
            return `<div class="nim-popup-hours-row">
                <span>${h.day}</span><span class="${cls}">${h.time}</span>
            </div>`;
        }).join('');

        return `<div style="min-width:220px;font-family:system-ui,sans-serif;">
            <div class="nim-popup-header">
                <h3>${p.name}</h3><p>${p.city}</p>
            </div>
            <div class="nim-popup-body">
                <p class="nim-popup-address">📍 ${p.address}</p>
                <p class="nim-popup-hours-title">Horaires d'ouverture</p>
                ${rows}
            </div>
        </div>`;
    }

    const markers = [];
    let activeIndex = null;

    nimPoints.forEach((p, i) => {
        const marker = L.marker([p.lat, p.lng], { icon: makeIcon(false) })
            .addTo(map)
            .bindPopup(buildPopup(p), { maxWidth: 280 });

        marker.on('click', () => setActive(i));
        marker.on('popupclose', () => { if (activeIndex === i) resetActive(); });

        markers.push(marker);
    });

    const listEl = document.getElementById('nim-list');

    nimPoints.forEach((p, i) => {
        const card = document.createElement('div');
        card.id = `card-${i}`;
        card.className = 'nim-card bg-white rounded-xl shadow-sm border border-transparent p-4 cursor-pointer hover:border-green-400 hover:shadow-md';
        card.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="mt-0.5 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                    <span style="color:#00A651;font-weight:700;font-size:12px;">${i + 1}</span>
                </div>
                <div class="min-w-0">
                    <p style="font-weight:600;font-size:14px;color:#1f2937;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${p.name}</p>
                    <p style="font-size:11px;color:#9ca3af;margin-top:2px;">${p.city}</p>
                    <p style="font-size:11px;color:#6b7280;margin-top:4px;line-height:1.4;">${p.address}</p>
                    <p style="font-size:11px;color:#00A651;font-weight:500;margin-top:6px;">
                        Lun – Ven : ${p.hours[0].time}
                    </p>
                </div>
            </div>
        `;
        card.addEventListener('click', () => {
            map.setView([p.lat, p.lng], 15, { animate: true });
            markers[i].openPopup();
            setActive(i);

            /* Sur mobile : scroll vers la carte DANS le wrapper scrollable */
            if (window.innerWidth < 768) {
                /* Scroll le wrapper vers la carte cliquée */
                const wrapper = document.getElementById('nim-list-wrapper');
                const cardEl  = document.getElementById(`card-${i}`);
                if (wrapper && cardEl) {
                    const cardTop    = cardEl.offsetTop;
                    const wrapperTop = wrapper.offsetTop;
                    wrapper.scrollTo({ top: cardTop - wrapperTop, behavior: 'smooth' });
                }
                /* Scroll la page vers la carte si nécessaire */
                setTimeout(() => {
                    document.getElementById('nim-list-wrapper')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 300);
            }
        });
        listEl.appendChild(card);
    });

    function setActive(i) {
        if (activeIndex !== null) {
            markers[activeIndex].setIcon(makeIcon(false));
            document.getElementById(`card-${activeIndex}`)?.classList.remove('card-active');
        }
        activeIndex = i;
        markers[i].setIcon(makeIcon(true));
        const cardEl = document.getElementById(`card-${i}`);
        cardEl?.classList.add('card-active');

        /* Desktop : scroll dans le wrapper */
        if (window.innerWidth >= 768) {
            const wrapper = document.getElementById('nim-list-wrapper');
            if (wrapper && cardEl) {
                wrapper.scrollTo({ top: cardEl.offsetTop - wrapper.offsetTop - 8, behavior: 'smooth' });
            }
        }
    }

    setActive(0);
    markers[0].openPopup();

    function resetActive() {
        if (activeIndex !== null) {
            markers[activeIndex].setIcon(makeIcon(false));
            document.getElementById(`card-${activeIndex}`)?.classList.remove('card-active');
            activeIndex = null;
        }
    }
    </script>

</body>
</html>