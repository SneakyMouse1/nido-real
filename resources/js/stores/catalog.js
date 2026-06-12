export default {
    view: localStorage.getItem('catalog_view') || 'grid',
    setView(v) {
        this.view = v;
        localStorage.setItem('catalog_view', v);
    }
};
