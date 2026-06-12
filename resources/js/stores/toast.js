/**
 * Alpine.js store: toast
 *
 * Usage from any Alpine component or JS:
 *   Alpine.store('toast').show('Message text', 'success' | 'error' | 'info')
 *   window.dispatchEvent(new CustomEvent('toast', { detail: { message: '...', type: 'info' } }))
 */
export default {
    visible: false,
    message: '',
    type: 'info',      // 'success' | 'error' | 'info'
    _timer: null,

    show(message, type = 'info', duration = 3500) {
        clearTimeout(this._timer);
        this.message = message;
        this.type    = type;
        this.visible = true;
        this._timer  = setTimeout(() => { this.visible = false; }, duration);
    },

    hide() {
        clearTimeout(this._timer);
        this.visible = false;
    },
};
