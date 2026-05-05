const commentsLoaded = {};

let modalElement = null;
let currentCommentPostId = null;

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, function(m) {
        return map[m];
    });
}

function displayComments(postId, comments) {
    const container = document.querySelector(`#comments-${postId} .comments-list`);
    if (!container) return;

    container.innerHTML = '';

    if (!comments || comments.length === 0) {
        container.innerHTML = '<p class="empty-comments-message">Пока нет комментариев. Будьте первым!</p>';
        return;
    }

    comments.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.className = 'comment-item';
        commentDiv.id = `comment-${comment.id}`;
        commentDiv.innerHTML = `
            <div class="comment-header">
                <strong>${escapeHtml(comment.author)}</strong>
                <span class="comment-date">${escapeHtml(comment.date)}</span>
            </div>
            <div class="comment-text">${escapeHtml(comment.text)}</div>
        `;
        container.appendChild(commentDiv);
    });
}

function addNewComment(postId, commentId, author, text, date) {
    const container = document.querySelector(`#comments-${postId} .comments-list`);
    if (!container) return;

    const loadingMsg = container.querySelector('.loading-comments');
    if (loadingMsg) loadingMsg.remove();

    const emptyMsg = container.querySelector('.empty-comments-message');
    if (emptyMsg) emptyMsg.remove();

    if (document.getElementById(`comment-${commentId}`)) return;

    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment-item comment-new';
    commentDiv.id = `comment-${commentId}`;
    commentDiv.innerHTML = `
        <div class="comment-header">
            <strong>${escapeHtml(author)}</strong>
            <span class="comment-date">${escapeHtml(date)}</span>
        </div>
        <div class="comment-text">${escapeHtml(text)}</div>
    `;

    container.insertBefore(commentDiv, container.firstChild);

    setTimeout(() => {
        commentDiv.classList.remove('comment-new');
    }, 100);
}

function loadCommentsForPost(postId) {
    if (commentsLoaded[postId]) return;

    const container = document.querySelector(`#comments-${postId} .comments-list`);
    if (container) {
        container.innerHTML = '<p class="loading-comments">Загрузка комментариев...</p>';
    }

    const callbackName = `loadCommentsForPost_${postId}`;

    window[callbackName] = (comments) => {
        displayComments(postId, comments);
        commentsLoaded[postId] = true;
        delete window[callbackName];
    };

    const script = document.createElement('script');
    script.src = `/blog/${postId}/comments?callback=${callbackName}`;
    script.onerror = () => {
        if (container) {
            container.innerHTML = '<p class="error-message">Ошибка загрузки комментариев</p>';
        }
        delete window[callbackName];
        script.remove();
    };
    document.body.appendChild(script);
}

function createModalIfNeeded() {
    if (modalElement) return;

    const modalHtml = `
        <div class="blur-modal" id="comment-modal">
            <div class="blur-modal-content">
                <span class="blur-modal-close">&times;</span>
                <div class="blur-modal-body">
                    <h2 style="color: #0056b3; margin-bottom: 20px;">Новый комментарий</h2>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="comment-text" style="display: block; margin-bottom: 8px; font-weight: 600;">Текст комментария:</label>
                        <textarea id="comment-text" rows="4" placeholder="Введите ваш комментарий..." style="width: 100%; padding: 12px; border: 2px solid #d2b48c; border-radius: 8px; font-family: inherit; resize: vertical;"></textarea>
                        <small style="color: #666; display: block; margin-top: 5px;">Минимум 3 символа • Ctrl+Enter для отправки</small>
                    </div>
                    <div class="form-actions" style="display: flex; gap: 10px;">
                        <button type="button" id="submit-comment-btn" style="flex: 1; padding: 12px; background: #5a3e36; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">Отправить</button>
                        <button type="button" class="cancel-btn" style="padding: 12px 24px; background: #e2e8f0; color: #333; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Отмена</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    modalElement = document.getElementById('comment-modal');
}

function openCommentModal(postId) {
    createModalIfNeeded();
    currentCommentPostId = postId;
    const textarea = document.getElementById('comment-text');
    if (textarea) textarea.value = '';
    if (modalElement) {
        modalElement.classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => textarea?.focus(), 100);
    }
}

function closeCommentModal() {
    if (modalElement) {
        modalElement.classList.remove('show');
        document.body.style.overflow = '';
    }
    currentCommentPostId = null;
}

function submitComment() {
    if (!currentCommentPostId) {
        alert('Ошибка: не выбран пост для комментирования');
        return false;
    }

    const textarea = document.getElementById('comment-text');
    if (!textarea) return false;

    const text = textarea.value.trim();

    if (!text) {
        alert('Введите текст комментария');
        textarea.focus();
        return false;
    }

    if (text.length < 3) {
        alert('Комментарий должен содержать минимум 3 символа');
        textarea.focus();
        return false;
    }

    const submitBtn = document.getElementById('submit-comment-btn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';
    }

    const callbackName = `addCommentCallback_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;

    window[callbackName] = (response) => {
        if (response.success) {
            addNewComment(
                response.comment.blog_post_id,
                response.comment.id,
                response.comment.author,
                response.comment.text,
                response.comment.date
            );
            closeCommentModal();
        } else {
            alert('Ошибка: ' + (response.message || 'Не удалось добавить комментарий'));
        }
        delete window[callbackName];
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить';
        }
    };

    const script = document.createElement('script');
    script.src = `/blog/add-comment?blog_post_id=${encodeURIComponent(currentCommentPostId)}&text=${encodeURIComponent(text)}&callback=${callbackName}`;
    script.onerror = () => {
        alert('Не удалось отправить комментарий. Проверьте подключение.');
        delete window[callbackName];
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить';
        }
        script.remove();
    };
    document.body.appendChild(script);

    return true;
}

function bindEvents() {
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('add-comment-btn')) {
            const postId = e.target.getAttribute('data-post-id');
            if (postId) openCommentModal(postId);
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target.id === 'comment-modal' || e.target.classList.contains('blur-modal-close') || e.target.classList.contains('cancel-btn')) {
            closeCommentModal();
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target.id === 'submit-comment-btn') {
            e.preventDefault();
            submitComment();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
            const textarea = document.getElementById('comment-text');
            if (textarea && document.activeElement === textarea) {
                e.preventDefault();
                submitComment();
            }
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalElement?.classList.contains('show')) {
            closeCommentModal();
        }
    });
}

function loadAllComments() {
    const posts = document.querySelectorAll('.blog-post');
    posts.forEach(post => {
        const postId = post.getAttribute('data-post-id');
        if (postId) {
            loadCommentsForPost(postId);
        }
    });
}

function addStyles() {
    if (document.getElementById('blog-comments-styles')) return;

    const style = document.createElement('style');
    style.id = 'blog-comments-styles';
    style.textContent = `
        /* Стили для секции комментариев */
        .comments-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #edf2f7;
        }
        .comments-section h4 {
            margin-bottom: 15px;
            color: #2d3748;
            font-size: 1.1em;
        }
        .comments-list {
            margin-bottom: 15px;
            min-height: 40px;
        }
        .comment-item {
            padding: 12px 15px;
            margin-bottom: 8px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid #0056b3;
            transition: all 0.3s ease;
        }
        .comment-item:hover {
            background: #edf2f7;
            border-left-color: #004494;
        }
        .comment-item.comment-new {
            background: #e3f2fd;
            border-left-color: #2196F3;
            animation: commentHighlight 2s ease;
        }
        @keyframes commentHighlight {
            0% { background: #bbdefb; }
            100% { background: #f8fafc; }
        }
        .comment-header {
            margin-bottom: 5px;
            display: flex;
            align-items: baseline;
            gap: 10px;
        }
        .comment-header strong {
            color: #0056b3;
            font-size: 0.95em;
        }
        .comment-date {
            color: #718096;
            font-size: 0.85em;
        }
        .comment-text {
            color: #2d3748;
            font-size: 0.95em;
            line-height: 1.5;
        }
        .loading-comments, .empty-comments-message {
            color: #999;
            font-size: 0.9em;
            font-style: italic;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.9em;
        }
        .add-comment-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #0056b3, #004494);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95em;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,86,179,0.2);
        }
        .add-comment-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,86,179,0.3);
        }
        .add-comment-btn:active {
            transform: translateY(0);
        }

        /* Стили для модального окна комментариев */
        #comment-modal .form-group {
            margin-bottom: 20px;
        }
        #comment-modal label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        #comment-modal textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #d2b48c;
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            resize: vertical;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        #comment-modal textarea:focus {
            border-color: #a67c52;
            box-shadow: 0 0 8px rgba(166, 124, 82, 0.3);
        }
        #comment-modal .form-actions {
            display: flex;
            gap: 10px;
        }
        #submit-comment-btn {
            flex: 1;
            padding: 12px 24px;
            background: #5a3e36;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s;
        }
        #submit-comment-btn:hover:not(:disabled) {
            background: #7a5544;
        }
        #submit-comment-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .cancel-btn {
            padding: 12px 24px;
            background: #e2e8f0;
            color: #333;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .cancel-btn:hover {
            background: #cbd5e0;
        }
    `;
    document.head.appendChild(style);
}

export function initBlogComments() {
    addStyles();
    bindEvents();
    loadAllComments();
}

if (document.querySelector('.blog-posts')) {
    document.addEventListener('DOMContentLoaded', initBlogComments);
}
