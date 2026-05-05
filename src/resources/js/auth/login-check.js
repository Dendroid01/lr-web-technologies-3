function initLoginCheck() {
    const loginInput = document.getElementById('login');
    const availabilitySpan = document.getElementById('login-availability');

    if (!loginInput || !availabilitySpan) return;

    let checkTimeout = null;

    function checkLoginAvailability() {
        const login = loginInput.value.trim();

        if (!login) {
            availabilitySpan.textContent = '';
            return;
        }

        const oldFrame = document.getElementById('login-check-frame');
        if (oldFrame) {
            oldFrame.remove();
        }

        const iframe = document.createElement('iframe');
        iframe.id = 'login-check-frame';
        iframe.style.display = 'none';

        const checkUrl = window.checkLoginUrl + '?login=' + encodeURIComponent(login);
        iframe.src = checkUrl;

        iframe.onload = function() {
            try {
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                let availableNode = null;

                if (doc.querySelector) {
                    availableNode = doc.querySelector('available');
                } else {
                    const nodes = doc.getElementsByTagName('available');
                    availableNode = nodes.length ? nodes[0] : null;
                }

                if (availableNode) {
                    const available = availableNode.textContent;

                    if (available === 'false') {
                        availabilitySpan.textContent = 'Этот логин уже занят';
                        availabilitySpan.style.color = 'red';
                    } else if (available === 'true') {
                        availabilitySpan.textContent = 'Логин свободен';
                        availabilitySpan.style.color = 'green';
                    }
                } else {
                    availabilitySpan.textContent = '';
                }
            } catch (e) {
                availabilitySpan.textContent = '';
            }
        };

        iframe.onerror = function() {
            availabilitySpan.textContent = 'Ошибка проверки';
            availabilitySpan.style.color = 'orange';
        };

        document.body.appendChild(iframe);
    }

    loginInput.addEventListener('input', function() {
        if (checkTimeout) clearTimeout(checkTimeout);
        checkTimeout = setTimeout(checkLoginAvailability, 500);
    });

    loginInput.addEventListener('blur', checkLoginAvailability);
}

export function initLoginCheckModule() {
    initLoginCheck();
}

if (document.querySelector('.auth-card form')) {
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.checkLoginUrl === 'undefined') {
            const loginCheckMeta = document.querySelector('meta[name="login-check-url"]');
            window.checkLoginUrl = loginCheckMeta ? loginCheckMeta.getAttribute('content') : '/check-login';
        }
        initLoginCheck();
    });
}
