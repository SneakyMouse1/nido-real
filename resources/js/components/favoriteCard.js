/**
 * Alpine.js component: favoriteCard
 *
 * Usage in Blade (favorites list):
 *   x-data="favoriteCard({ url: '...' })"
 *
 * Handles AJAX removal of a property from the favorites list.
 * Sets `removing = true` immediately (triggers x-show / x-transition in the template).
 * Rolls back on network error.
 */
export default function favoriteCard({ url }) {
    return {
        removing: false,

        remove() {
            if (this.removing) return;

            this.removing = true;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to remove favorite');
                    }
                    return response.json();
                })
                .then(data => {
                    window.dispatchEvent(
                        new CustomEvent('favorite-changed', {
                            detail: { url, isFavorite: false },
                        })
                    );
                })
                .catch(() => {
                    // Roll back on error so the card reappears
                    this.removing = false;
                });
        },
    };
}
