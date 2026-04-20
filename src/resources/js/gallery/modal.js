//import {galleryData} from './gallery-data.js';

let currentIndex = 0;
const $modal = $('#photo-modal');

export function initModal() {
    if (!$modal.length) {
        const $newModal = $('<div id="photo-modal" class="modal"></div>');
        const modalContent = `
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <div class="modal-nav">
                    <button class="nav-btn prev-btn">&larr;</button>
                    <button class="nav-btn next-btn">&rarr;</button>
                </div>
                <div class="modal-image-container">
                    <img class="modal-image" src="" alt="">
                </div>
                <div class="modal-info">
                    <h3 class="modal-title"></h3>
                    <p class="modal-description"></p>
                    <div class="modal-counter"></div>
                </div>
            </div>
        `;
        $newModal.html(modalContent);
        $('body').append($newModal);
    }
}

export function openModal(index) {
    currentIndex = index;
    updateModal();
    $('#photo-modal').addClass('show');
    $('body').css('overflow', 'hidden');
}

export function closeModal() {
    $('#photo-modal').removeClass('show');
    $('body').css('overflow', '');
}

export function prevImage() {
    currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
    updateModal();
}

export function nextImage() {
    currentIndex = (currentIndex + 1) % galleryData.length;
    updateModal();
}

function updateModal() {
    const currentItem = galleryData[currentIndex];
    const $modalImage = $('.modal-image');
    const $modalTitle = $('.modal-title');
    const $modalDescription = $('.modal-description');
    const $modalCounter = $('.modal-counter');
    const $prevBtn = $('.prev-btn');
    const $nextBtn = $('.next-btn');

    $modalImage.addClass('loading');

    const tempImage = new Image();
    tempImage.onload = function () {
        $modalImage.removeClass('loading').attr('src', currentItem.src);
        if (tempImage.width < 400 || tempImage.height < 400) {
            $modalImage.addClass('original-size');
        } else {
            $modalImage.removeClass('original-size');
        }
    };
    tempImage.onerror = function () {
        $modalImage.removeClass('loading')
            .attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9IiNmMGY0ZjgiPjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZTVlNWU1Ii8+PHRleHQgeD0iMjAwIiB5PSIxNTAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNiIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+SW1hZ2Ugbm90IGZvdW5kPC90ZXh0Pjwvc3ZnPg==')
            .attr('alt', 'Изображение не найдено');
    };
    tempImage.src = currentItem.src;

    $modalTitle.text(currentItem.title);
    $modalDescription.text(currentItem.hoverText);
    $modalCounter.text(`${currentIndex + 1} / ${galleryData.length}`);

    $prevBtn.prop('disabled', galleryData.length <= 1);
    $nextBtn.prop('disabled', galleryData.length <= 1);

    preloadAdjacentImages();
}

function preloadAdjacentImages() {
    [currentIndex - 1, currentIndex + 1].forEach(i => {
        const idx = (i + galleryData.length) % galleryData.length;
        const img = new Image();
        img.src = galleryData[idx].src;
    });
}
