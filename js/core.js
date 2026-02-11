const ValidationUtils = {
  validateEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
  },

  validatePhone(phone) {
    const phoneRegex = /^\+(7|3)\d{9,12}$/;
    return phoneRegex.test(phone);
  },

  validateFIO(fio) {
    const fioParts = fio.trim().split(/\s+/);
    return fioParts.length === 3 && fioParts.every(part => part.length >= 2);
  },

  validateBirthdate(dateString) {
    const dateRegex = /^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$/;
    
    if (!dateRegex.test(dateString)) {
      return false;
    }
    
    const [month, day, year] = dateString.split('/').map(Number);
    const date = new Date(year, month - 1, day);
    
    return date.getFullYear() === year && 
           date.getMonth() === month - 1 && 
           date.getDate() === day;
  },

  validateGender(genderInputs) {
    return Array.from(genderInputs).some(input => input.checked);
  },

  validateAge(age) {
    return age !== '';
  },

  validateMessage(message) {
    return message.trim() !== '';
  },

  sanitizeHTML(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }
};

const CookieUtils = {
    getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) {
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
        }
        
        return null;
    },

    setCookie(name, value, expirationDays) {
        const date = new Date();
        date.setTime(date.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        
        document.cookie = name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";
    },

    deleteCookie(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    },

    getAllCookies() {
        const cookies = {};
        const cookieArray = document.cookie.split(';');
        
        cookieArray.forEach(cookie => {
            const [name, value] = cookie.trim().split('=');
            if (name && value) {
                cookies[name] = decodeURIComponent(value);
            }
        });
        
        return cookies;
    }
};

const HistoryTracker = {
    SESSION_STORAGE_KEY: 'session_page_visits',
    TOTAL_STORAGE_KEY: 'total_page_visits',

    init() {
        this.trackPageVisit();
    },

    trackPageVisit() {
        const currentPage = this.getCurrentPage();
        const timestamp = new Date().toISOString();

        this.updateSessionHistory(currentPage, timestamp);
        this.updateTotalHistory(currentPage, timestamp);
    },

    getCurrentPage() {
        const path = window.location.pathname;
        const page = path.split('/').pop() || 'index.html';
        return page;
    },

    updateSessionHistory(page, timestamp) {
        let sessionHistory = this.getSessionHistory();
        
        if (!sessionHistory[page]) {
            sessionHistory[page] = {
                count: 0,
                lastVisit: timestamp
            };
        }
        
        sessionHistory[page].count++;
        sessionHistory[page].lastVisit = timestamp;
        
        this.saveSessionHistory(sessionHistory);
    },

    updateTotalHistory(page, timestamp) {
        let totalHistory = this.getTotalHistory();
        
        if (!totalHistory[page]) {
            totalHistory[page] = {
                count: 0,
                lastVisit: timestamp
            };
        }
        
        totalHistory[page].count++;
        totalHistory[page].lastVisit = timestamp;
        
        this.saveTotalHistory(totalHistory);
    },

    getSessionHistory() {
        try {
            const history = sessionStorage.getItem(this.SESSION_STORAGE_KEY);
            return history ? JSON.parse(history) : {};
        } catch (error) {
            return {};
        }
    },

    saveSessionHistory(history) {
        try {
            sessionStorage.setItem(this.SESSION_STORAGE_KEY, JSON.stringify(history));
        } catch (error) {
        }
    },

    getTotalHistory() {
        try {
            const history = localStorage.getItem(this.TOTAL_STORAGE_KEY);
            return history ? JSON.parse(history) : {};
        } catch (error) {
            return {};
        }
    },

    saveTotalHistory(history) {
        try {
            localStorage.setItem(this.TOTAL_STORAGE_KEY, JSON.stringify(history));
        } catch (error) {
        }
    },

    clearSessionHistory() {
        try {
            sessionStorage.removeItem(this.SESSION_STORAGE_KEY);
        } catch (error) {
        }
    },

    clearTotalHistory() {
        try {
            localStorage.removeItem(this.TOTAL_STORAGE_KEY);
        } catch (error) {
        }
    },

    getPageDisplayName(pageId) {
        const pageNames = {
            'index.html': 'Главная страница',
            'about.html': 'Обо мне',
            'interests.html': 'Мои интересы',
            'study.html': 'Учёба',
            'gallery.html': 'Фотоальбом',
            'contacts.html': 'Контакты',
            'history.html': 'История просмотра',
            'test.html': 'Тест по физике'
        };
        
        return pageNames[pageId] || pageId;
    },

    formatDate(timestamp) {
        try {
            const date = new Date(timestamp);
            return date.toLocaleString('ru-RU', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (error) {
            return 'Неизвестно';
        }
    }
};

function updateDateTime() {
  const datetimeEl = document.getElementById('datetime');
  if (!datetimeEl) return;

  const now = new Date();

  const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
  const months = ['Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'];

  let hours = now.getHours().toString().padStart(2,'0');
  let minutes = now.getMinutes().toString().padStart(2,'0');
  let year = now.getFullYear();
  let month = months[now.getMonth()];
  let dayOfWeek = days[now.getDay()];

  let dateStr = `${hours}.${minutes}.${year} ${dayOfWeek}`;

  datetimeEl.textContent = dateStr;
}

setInterval(updateDateTime, 1000);
updateDateTime();