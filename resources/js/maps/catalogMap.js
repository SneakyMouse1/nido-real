import { loadMapbox, getMapboxToken, watchDarkMode } from './utils.js';

export function initCatalogMap() {
    const el = document.getElementById('catalog-map');
    if (!el) return;

    loadMapbox(() => {
        if (el.dataset.mapboxInit) return;
        el.dataset.mapboxInit = '1';

        const token = getMapboxToken();
        if (!token) return;

        mapboxgl.accessToken = token;
        const isDark = document.documentElement.classList.contains('dark');

        const map = new mapboxgl.Map({
            container: el,
            style: isDark ? 'mapbox://styles/mapbox/dark-v11' : 'mapbox://styles/mapbox/streets-v12',
            center: [-3.7, 40.4],
            zoom: 5.5,
            attributionControl: false,
        });

        map.on('load', () => map.resize());
        map.addControl(new mapboxgl.AttributionControl({ compact: true }));
        map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-right');

        watchDarkMode(map, 'mapbox://styles/mapbox/streets-v12', 'mapbox://styles/mapbox/dark-v11');
    });
}
