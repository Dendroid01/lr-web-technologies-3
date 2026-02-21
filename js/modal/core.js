import {getModalContent} from './content.js';

const $modal = $('<div class="blur-modal"></div>');

function initModal() {
    createModalElement();
    bindEvents();
}

function createModalElement() {
    const modalContent = `
        <div class="blur-modal-content">
            <span class="blur-modal-close">&times;</span>
            <div class="blur-modal-body"></div>
        </div>
    `;
    $modal.html(modalContent).hide().appendTo('body');
}

function bindEvents() {
    $modal.on('click', '.blur-modal-close', hideModal);
    $modal.on('click', (e) => {
        if (e.target === $modal[0]) hideModal();
    });
    $(document).on('keydown', (e) => {
        if (e.key === 'Escape' && $modal.is(':visible')) hideModal();
    });
}

function showModal(type) {
    const content = getModalContent(type);
    $modal.find('.blur-modal-body').html(content);

    $('body').addClass('modal-open');
    $modal.fadeIn(300);

    $modal.find('.blur-modal-content').css({'transform': 'scale(0.9)', 'opacity': 0})
        .animate({'transform': 'scale(1)', 'opacity': 1}, 300);
}

function hideModal() {
    $('body').removeClass('modal-open');
    $modal.fadeOut(300);
}

export {initModal, showModal, hideModal};