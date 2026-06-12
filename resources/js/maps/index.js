import { loadMapbox } from './utils.js';
import { initPropertyMap } from './propertyMap.js';
import { initCatalogMap } from './catalogMap.js';

export function initMaps() {
    loadMapbox(() => {
        initPropertyMap();
        initCatalogMap();
    });
}
