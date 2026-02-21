// js/events.js
import {closeModal, nextImage, openModal, prevImage} from './modal.js';

export function bindEvents() {
    $(document).on('click', '.photo', function () {
        const index = $(this).data('index');
        openModal(index);
    });

    $(document).on('click', '.modal-close', closeModal);
    $(document).on('click', '.prev-btn', prevImage);
    $(document).on('click', '.next-btn', nextImage);

    $(document).on('click', '#photo-modal', function (e) {
        if (e.target === this) closeModal();
    });

    $(document).on('keydown', function (e) {
        const $modal = $('#photo-modal');
        if ($modal.hasClass('show')) {
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        }
    });
}