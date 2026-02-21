import { galleryData } from './gallery-data.js';
import { renderGallery } from './gallery-render.js';
import { initModal } from './modal.js';
import { bindEvents } from './events.js';
import { initLazyLoading } from './lazy-load.js';

$(document).ready(function() {
    if (!$('#gallery').length) return console.warn('Gallery element not found');

    renderGallery(galleryData);
    initModal();
    bindEvents();
    initLazyLoading();
});