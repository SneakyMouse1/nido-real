import './bootstrap';
import Alpine from 'alpinejs';

import themeStore from './stores/theme';
import mobileMenuStore from './stores/mobileMenu';
import catalogStore from './stores/catalog';
import toastStore from './stores/toast';
import { initAjaxCatalog } from './utils/ajaxCatalog';

// Alpine.data components
import favoriteButton from './components/favoriteButton';
import favoriteCard from './components/favoriteCard';
import propertyGallery from './components/propertyGallery';

window.Alpine = Alpine;

Alpine.store('theme', themeStore);
Alpine.store('mobileMenu', mobileMenuStore);
Alpine.store('catalog', catalogStore);
Alpine.store('toast', toastStore);

Alpine.data('favoriteButton', favoriteButton);
Alpine.data('favoriteCard', favoriteCard);
Alpine.data('propertyGallery', propertyGallery);

Alpine.start();
initAjaxCatalog();

import { initMaps } from './maps/index.js';

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMaps);
} else {
    initMaps();
}

// ── Swup ──────────────────────────────────────────────────────────────────
import Swup from 'swup';
import SwupHeadPlugin from '@swup/head-plugin';

const swup = new Swup({
    containers: ['#swup-header', '#swup', '#swup-footer'],
    cache: false,
    plugins: [new SwupHeadPlugin({ persistAssets: true })],
    ignoreVisit: (url) => url.includes('/secret-admin') || url.includes('/cabinet'),
});

window.swup = swup;

swup.hooks.on('content:replace', () => {
    window.Alpine?.store('mobileMenu')?.close();

    if (window.Alpine) {
        Alpine.stopObservingMutations();
        Alpine.destroyTree(document.body);
        Alpine.initTree(document.body);
        Alpine.startObservingMutations();
    }
});

swup.hooks.on('page:view', () => {
    initAjaxCatalog();
    document.dispatchEvent(new CustomEvent('swup:page:view'));

    ['property-map', 'catalog-map'].forEach(id => {
        const el = document.getElementById(id);
        if (el) delete el.dataset.mapboxInit;
    });

    initMaps();
});