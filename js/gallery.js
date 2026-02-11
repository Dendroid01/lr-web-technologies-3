$(document).ready(function() {
    if (!$('#gallery').length) {
        console.warn('Gallery element not found on this page');
        return;
    }

    const galleryData = [
        { 
            src: "images/1.jpg", 
            title: "Роберт Де Ниро", 
            hoverText: "Легенда американского кино, 70-е годы"
        },
        { 
            src: "images/2.jpg", 
            title: "Мэрил Стрип", 
            hoverText: "Оскароносная актриса, известна по драмам"
        },
        { 
            src: "images/3.jpg", 
            title: "Леонардо ДиКаприо", 
            hoverText: "Лауреат премий, известен фильмами Леонардо"
        },
        { 
            src: "images/4.jpg", 
            title: "Том Хэнкс", 
            hoverText: "Том Хэнкс: любимец публики и актёр мирового уровня"
        },
        { 
            src: "images/5.jpg", 
            title: "Натали Портман", 
            hoverText: "Натали Портман: актриса и активистка"
        },
        { 
            src: "images/6.jpg", 
            title: "Аль Пачино", 
            hoverText: "Аль Пачино — мастер перевоплощений"
        },
        { 
            src: "images/7.jpg", 
            title: "Хоакин Феникс", 
            hoverText: "Хоакин Феникс: драматические роли"
        },
        { 
            src: "images/8.jpg", 
            title: "Скарлетт Йохансон", 
            hoverText: "Скарлетт Йохансон: звезда Marvel"
        },
        { 
            src: "images/9.jpg", 
            title: "Морган Фримен", 
            hoverText: "Морган Фримен: неподражаемый голос и харизма"
        },
        { 
            src: "images/10.jpg", 
            title: "Брэд Питт", 
            hoverText: "Брэд Питт: культовый актёр Голливуда"
        },
        { 
            src: "images/11.jpg", 
            title: "Франсуа Клюзе", 
            hoverText: "Франсуа Клюзе: французский киноактер"
        },
        { 
            src: "images/12.jpg", 
            title: "Омар Си", 
            hoverText: "Омар Си: французский актёр-комик"
        },
        { 
            src: "images/13.jpg", 
            title: "Одри Флёро", 
            hoverText: "Одри Флёро: французская актриса"
        },
        { 
            src: "images/14.jpg", 
            title: "Меган Фокс", 
            hoverText: "Меган Фокс: известная по боевикам"
        },
        { 
            src: "images/15.jpg", 
            title: "Марго Робби", 
            hoverText: "Марго Робби: актриса и продюсер"
        }
    ];

    let currentIndex = 0;
    const $modal = $('#photo-modal');

    function initGallery() {
        renderGallery();
        initModal();
        bindEvents();
    }

    function renderGallery() {
        const $gallery = $('#gallery').empty();
        
        $.each(galleryData, function(index, item) {
            const $photoDiv = $('<div class="photo"></div>')
                .attr('data-index', index);
            
            const $img = $('<img>')
                .attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjM0MCIgdmlld0JveD0iMCAwIDMwMCAzNDAiIGZpbGw9IiNmMGY0ZjgiPjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMzQwIiBmaWxsPSIjZTVlNWU1Ii8+PHRleHQgeD0iMTUwIiB5PSIxNzAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4=')
                .attr('data-src', item.src)
                .attr('alt', item.title)
                .attr('loading', 'lazy');
            
            const $caption = $('<p class="caption"></p>')
                .text(item.title);
            
            const $hoverText = $('<span class="hover-text"></span>')
                .text(item.hoverText);
            
            $photoDiv.append($img, $caption, $hoverText);
            $gallery.append($photoDiv);
        });
        
        initLazyLoading();
    }

    function initModal() {
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

    function bindEvents() {
        $(document).on('click', '.photo', function() {
            const index = $(this).data('index');
            openModal(index);
        });
        
        $(document).on('click', '.modal-close', function() {
            closeModal();
        });
        
        $(document).on('click', '.prev-btn', function() {
            prevImage();
        });
        
        $(document).on('click', '.next-btn', function() {
            nextImage();
        });
        
        $(document).on('click', '#photo-modal', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        $(document).on('keydown', function(e) {
            if ($modal.hasClass('show')) {
                switch(e.key) {
                    case 'Escape':
                        closeModal();
                        break;
                    case 'ArrowLeft':
                        prevImage();
                        break;
                    case 'ArrowRight':
                        nextImage();
                        break;
                }
            }
        });
    }

    function openModal(index) {
        currentIndex = index;
        updateModal();
        $modal.addClass('show');
        $('body').css('overflow', 'hidden');
    }

    function closeModal() {
        $modal.removeClass('show');
        $('body').css('overflow', '');
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
        updateModal();
    }

    function nextImage() {
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
        tempImage.onload = function() {
            $modalImage.removeClass('loading');
            $modalImage.attr('src', currentItem.src);

            if (tempImage.width < 400 || tempImage.height < 400) {
                $modalImage.addClass('original-size');
            } else {
                $modalImage.removeClass('original-size');
            }
        };

        tempImage.onerror = function() {
            $modalImage.removeClass('loading');
            $modalImage.attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9IiNmMGY0ZjgiPjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZTVlNWU1Ii8+PHRleHQgeD0iMjAwIiB5PSIxNTAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNiIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+SW1hZ2Ugbm90IGZvdW5kPC90ZXh0Pjwvc3ZnPg==');
            $modalImage.attr('alt', 'Изображение не найдено');
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
        const preloadImage = (index) => {
            if (index >= 0 && index < galleryData.length) {
                const img = new Image();
                img.src = galleryData[index].src;
            }
        };
        
        preloadImage((currentIndex - 1 + galleryData.length) % galleryData.length);
        preloadImage((currentIndex + 1) % galleryData.length);
    }

    function initLazyLoading() {
        const $lazyImages = $('img[data-src]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    $(img).attr('src', $(img).data('src')).removeAttr('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        $lazyImages.each(function() {
            imageObserver.observe(this);
        });
    }

    initGallery();
});