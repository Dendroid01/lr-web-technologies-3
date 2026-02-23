let currentIndex = 0;
const $modal = $('#photo-modal');

// Используем данные из window.galleryData (переданные из PHP)
const galleryData = window.galleryData || [];

export function initModal() {
    if (!$modal.length) {
        console.error('Modal element not found');
    }
}

export function openModal(index) {
    if (!galleryData.length) return;

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
    if (!galleryData.length) return;
    currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
    updateModal();
}

export function nextImage() {
    if (!galleryData.length) return;
    currentIndex = (currentIndex + 1) % galleryData.length;
    updateModal();
}

function updateModal() {
    if (!galleryData.length) return;

    const currentItem = galleryData[currentIndex];
    const $modalImage = $('.modal-image');
    const $modalTitle = $('.modal-title');
    const $modalDescription = $('.modal-description');
    const $modalCounter = $('.modal-counter');
    const $prevBtn = $('.prev-btn');
    const $nextBtn = $('.next-btn');

    $modalImage.addClass('loading');

    // Формируем правильный путь к изображению
    const imageSrc = currentItem.src.startsWith('http')
        ? currentItem.src
        : (window.assetUrl || '') + currentItem.src;

    const tempImage = new Image();
    tempImage.onload = function () {
        $modalImage.removeClass('loading').attr('src', imageSrc);
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
    tempImage.src = imageSrc;

    $modalTitle.text(currentItem.title);
    $modalDescription.text(currentItem.hover_text || currentItem.hoverText);
    $modalCounter.text(`${currentIndex + 1} / ${galleryData.length}`);

    $prevBtn.prop('disabled', galleryData.length <= 1);
    $nextBtn.prop('disabled', galleryData.length <= 1);

    preloadAdjacentImages();
}

function preloadAdjacentImages() {
    [currentIndex - 1, currentIndex + 1].forEach(i => {
        const idx = (i + galleryData.length) % galleryData.length;
        const img = new Image();
        const imageSrc = galleryData[idx].src.startsWith('http')
            ? galleryData[idx].src
            : (window.assetUrl || '') + galleryData[idx].src;
        img.src = imageSrc;
    });
}
