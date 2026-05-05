function getCsrfToken() {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    return tokenMeta ? tokenMeta.getAttribute('content') : null;
}

function showNotification(message, isError = false) {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${isError ? '#dc3545' : '#28a745'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: fadeIn 0.3s ease;
        transition: opacity 0.3s ease;
    `;

    if (!document.getElementById('notification-keyframe')) {
        const style = document.createElement('style');
        style.id = 'notification-keyframe';
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(notification);
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function openEditModal(postId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/admin/blog/${postId}/edit`, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            document.getElementById('edit-post-id').value = data.id;
            document.getElementById('edit-title').value = data.title;
            document.getElementById('edit-message').value = data.message;
            document.getElementById('edit-modal').classList.add('show');
        } else {
            alert('Ошибка при загрузке данных записи');
        }
    };

    xhr.onerror = function() {
        alert('Ошибка соединения с сервером');
    };

    xhr.send();
}

function savePost() {
    const postId = document.getElementById('edit-post-id').value;
    const title = document.getElementById('edit-title').value.trim();
    const message = document.getElementById('edit-message').value.trim();

    if (!title || !message) {
        alert('Заполните тему и текст сообщения');
        return;
    }

    if (!postId) {
        alert('Ошибка: ID поста не найден');
        return;
    }

    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        console.error('CSRF-токен не найден');
        alert('Ошибка безопасности: CSRF-токен не найден');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('PUT', `/admin/blog/${postId}`, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const resp = JSON.parse(xhr.responseText);
            if (resp.success) {
                const row = document.getElementById(`post-row-${resp.post.id}`);
                if (row) {
                    const titleSpan = row.querySelector('.post-title');
                    if (titleSpan) titleSpan.textContent = resp.post.title;
                }
                closeEditModal();
                showNotification('Запись успешно обновлена');
            }
        } else if (xhr.status === 422) {
            const errors = JSON.parse(xhr.responseText);
            let errorMsg = 'Ошибки валидации:\n';
            for (const key in errors.errors) {
                errorMsg += errors.errors[key].join('\n') + '\n';
            }
            alert(errorMsg);
        } else {
            alert('Ошибка при сохранении. Код: ' + xhr.status);
        }
    };

    xhr.onerror = function() {
        alert('Ошибка соединения с сервером');
    };

    xhr.send(JSON.stringify({
        title: title,
        message: message,
        author: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Admin'
    }));
}

function closeEditModal() {
    const modal = document.getElementById('edit-modal');
    if (modal) {
        modal.classList.remove('show');
    }
}

function bindEditorEvents() {
    // Открытие модального окна при клике на "Изменить"
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('edit-post-btn')) {
            const postId = e.target.getAttribute('data-post-id');
            if (postId) openEditModal(postId);
        }
    });

    const saveBtn = document.getElementById('save-edit-btn');
    if (saveBtn) {
        saveBtn.addEventListener('click', savePost);
    }

    const modal = document.getElementById('edit-modal');
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeEditModal();
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modalEl = document.getElementById('edit-modal');
            if (modalEl && modalEl.classList.contains('show')) closeEditModal();
        }
    });
}

export function initBlogEditor() {
    bindEditorEvents();
}

if (document.querySelector('.blog-editor-form, .blog-preview-list')) {
    document.addEventListener('DOMContentLoaded', initBlogEditor);
}
