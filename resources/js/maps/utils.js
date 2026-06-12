// resources/js/maps/utils.js

export function loadMapbox(cb) {
    if (typeof mapboxgl !== 'undefined') { cb(); return; }

    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css';
    document.head.appendChild(link);

    const script = document.createElement('script');
    script.src = 'https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js';
    script.onload = cb;
    document.head.appendChild(script);
}

export function getMapboxToken() {
    return document.querySelector('meta[name="mapbox-token"]')?.content;
}

export function watchDarkMode(map, lightStyle, darkStyle) {
    const observer = new MutationObserver(() => {
        const dark = document.documentElement.classList.contains('dark');
        map.setStyle(dark ? darkStyle : lightStyle);
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
}
