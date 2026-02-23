// js/gallery/gallery-init.js
import { initModal } from './modal.js';
import { bindEvents } from './events.js';
import { initLazyLoading } from './lazy-load.js';

$(document).ready(function () {
    if (!$('#gallery').length) return console.warn('Gallery element not found');

    if (window.galleryData) {
        console.log('Gallery data loaded from PHP:', window.galleryData.length, 'photos');
    }

    initModal();
    bindEvents();
    initLazyLoading();
});
