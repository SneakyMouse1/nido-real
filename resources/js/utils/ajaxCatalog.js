export function initAjaxCatalog() {
    document.addEventListener('click', e => {
        const link = e.target.closest('.js-ajax-link, nav[aria-label="Paginación"] a');
        if (!link) return;

        e.preventDefault();
        const url = link.href;
        const container = document.getElementById('catalog-container');

        if (container) {
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
            container.classList.add('opacity-50', 'pointer-events-none');
            
            // Hide sort dropdown if open (Alpine handles click.away but we intercept preventDefault, so let's dispatch click to close it natively or let it close on reload)
            
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('catalog-container');
                    
                    if (newContent) {
                        container.innerHTML = newContent.innerHTML;
                        window.history.pushState(null, '', url);
                        
                        // Re-initialize any Alpine components inside the new content if needed?
                        // Alpine automatically initializes new elements because of the MutationObserver!
                    }
                    
                    container.classList.remove('opacity-50', 'pointer-events-none');
                })
                .catch(() => {
                    // Fallback on error
                    window.location.href = url;
                });
        }
    });
}
