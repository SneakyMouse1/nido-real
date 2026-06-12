/**
 * Alpine.js component: favoriteButton
 *
 * Usage in Blade:
 *   x-data="favoriteButton({ url: '...', isFav: true/false })"
 *
 * Handles AJAX toggle of a favorite property without page reload.
 * On success updates the `fav` state and emits a custom 'favorite-changed' event.
 */
export default function favoriteButton({ url, isFav }) {
    return {
        fav: isFav,
        loading: false,
        hovered: false,

        toggle() {
            if (this.loading) return;

            this.loading = true;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(r => r.json())
                .then(data => {
                    this.fav = data.is_favorite;
                    // Notify other components on the page
                    window.dispatchEvent(
                        new CustomEvent('favorite-changed', {
                            detail: { url, isFavorite: data.is_favorite },
                        })
                    );
                })
                .catch(() => {
                    // Silently fail — state stays as-is
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    };
}
