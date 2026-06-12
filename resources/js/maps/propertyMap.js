import { loadMapbox, getMapboxToken, watchDarkMode } from './utils.js';

export function initPropertyMap() {
    const el = document.getElementById('property-map');
    if (!el) return;

    loadMapbox(() => {
        if (el.dataset.mapboxInit) return;
        el.dataset.mapboxInit = '1';

        const lat = parseFloat(el.dataset.lat);
        const lng = parseFloat(el.dataset.lng);
        const label = el.dataset.label || '';
        const token = getMapboxToken();

        if (isNaN(lat) || isNaN(lng) || !token) return;

        mapboxgl.accessToken = token;
        const isDark = document.documentElement.classList.contains('dark');

        const map = new mapboxgl.Map({
            container: el,
            style: isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/streets-v12',
            center: [lng, lat],
            zoom: 15,
            attributionControl: false,
        });

        map.addControl(new mapboxgl.AttributionControl({ compact: true }));
        map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-right');

        const markerEl = document.createElement('div');
        markerEl.innerHTML = `
            <div style="display:flex;flex-direction:column;align-items:center;filter:drop-shadow(0 4px 8px rgba(0,0,0,0.25))">
                <div style="background:#C75B39;border-radius:50% 50% 50% 0;transform:rotate(-45deg);width:44px;height:44px;display:flex;align-items:center;justify-content:center;">
                    <svg style="transform:rotate(45deg);color:white;" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
                        <path d="M9 21V12h6v9"/>
                    </svg>
                </div>
            </div>`;

        new mapboxgl.Marker({ element: markerEl, anchor: 'bottom' })
            .setLngLat([lng, lat])
            .setPopup(
                new mapboxgl.Popup({ offset: 48, closeButton: false })
                    .setHTML(`<p style="font-size:13px;font-weight:600;margin:0;padding:4px 2px;">${label}</p>`)
            )
            .addTo(map);

        watchDarkMode(map, 'mapbox://styles/mapbox/streets-v12', 'mapbox://styles/mapbox/dark-v11');
    });
}
