// js/lazy-load.js
export function initLazyLoading() {
    const $lazyImages = $('img[data-src]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                $(img).attr('src', $(img).data('src')).removeAttr('data-src');
                observer.unobserve(img);
            }
        });
    });

    $lazyImages.each(function () {
        observer.observe(this);
    });
}