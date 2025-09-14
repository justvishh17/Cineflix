// js/utilities.js - Core utility functions

/**
 * Displays a custom confirmation dialog (replaces browser confirm()).
 * @param {string} message The confirmation message to display.
 * @returns {Promise<boolean>} True if user clicks "Confirm", false if "Cancel".
 */
function showCustomConfirm(message) {
    return new Promise((resolve) => {
        const modal = document.getElementById('confirm-modal');
        const messageEl = document.getElementById('confirm-message');
        const yesBtn = document.getElementById('confirm-yes-btn');
        const noBtn = document.getElementById('confirm-no-btn');

        messageEl.textContent = message;
        modal.classList.add('active');

        function handleYes() {
            modal.classList.remove('active');
            cleanup();
            resolve(true);
        }

        function handleNo() {
            modal.classList.remove('active');
            cleanup();
            resolve(false);
        }

        function cleanup() {
            yesBtn.removeEventListener('click', handleYes);
            noBtn.removeEventListener('click', handleNo);
        }

        yesBtn.addEventListener('click', handleYes);
        noBtn.addEventListener('click', handleNo);
    });
}

/**
 * Displays a custom, non-blocking alert message.
 * @param {string} message The message to display.
 * @param {number} [duration=3000] How long the message stays visible in milliseconds.
 */
function showCustomAlert(message, duration = 3000) {
    const alertBox = document.getElementById('custom-alert');
    const alertMessage = document.getElementById('custom-alert-message');
    if (!alertBox || !alertMessage) return;
    alertMessage.textContent = message;
    alertBox.classList.add('show');
    setTimeout(() => {
        alertBox.classList.remove('show');
    }, duration);
}

/**
 * Sets up password toggle functionality for show/hide password icons
 */
function setupPasswordToggles() {
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const passwordInput = toggle.parentElement.querySelector('input');
            const icon = toggle.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
}

/**
 * Utility function for navigation between pages
 * @param {string} pageId The ID of the page to show
 */
function showPage(pageId) {
    document.querySelectorAll('.page').forEach(page => page.classList.remove('active'));
    const targetPage = document.getElementById(pageId + '-page');
    if (targetPage) {
        targetPage.classList.add('active');
        if (pageId === 'admin-dashboard') renderAdminDashboard();
    }
    window.scrollTo(0, 0);
}

/**
 * Closes success popup and redirects to home
 */
const closePopupAndGoHome = () => {
    document.getElementById('success-popup').classList.remove('active');
    window.location.reload();
};

// Export functions if using modules (optional for direct script inclusion)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        showCustomConfirm,
        showCustomAlert,
        setupPasswordToggles,
        showPage,
        closePopupAndGoHome
    };
}