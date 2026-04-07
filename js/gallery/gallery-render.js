export function renderGallery(galleryData) {
    const $gallery = $('#gallery').empty();

    galleryData.forEach((item, index) => {
        const $photoDiv = $('<div class="photo"></div>').attr('data-index', index);

        const $img = $('<img>')
            .attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjM0MCIgdmlld0JveD0iMCAwIDMwMCAzNDAiIGZpbGw9IiNmMGY0ZjgiPjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMzQwIiBmaWxsPSIjZTVlNWU1Ii8+PHRleHQgeD0iMTUwIiB5PSIxNzAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+TG9hZGluZy4uLjwvdGV4dD48L3N2Zz4=')
            .attr('data-src', item.src)
            .attr('alt', item.title)
            .attr('loading', 'lazy');

        const $caption = $('<p class="caption"></p>').text(item.title);
        const $hoverText = $('<span class="hover-text"></span>').text(item.hoverText);

        $photoDiv.append($img, $caption, $hoverText);
        $gallery.append($photoDiv);
    });
}