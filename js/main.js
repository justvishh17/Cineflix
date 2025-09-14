// js/main.js - Main application coordinator and initialization

// --- GLOBAL STATE ---
let movies = allMedia; // Received from index.php
let state = {
    selectedPlan: null,
    currentUser: currentUser, // Received from index.php
};

// --- CORE SCRIPT INITIALIZATION ---
document.addEventListener('DOMContentLoaded', () => {
    // Check for success popup flag
    if (sessionStorage.getItem('showSuccessPopup') === 'true') {
        document.getElementById('success-popup').classList.add('active');
        sessionStorage.removeItem('showSuccessPopup'); // Clear the flag
    }

    // Initialize all components
    updateHeaderUI();
    renderMovies();
    renderHomepageWishlist();
    renderMostLikedCategory();
    setupEventListeners();
    setupPasswordToggles();
});

/**
 * Sets up all event listeners for the application
 */
function setupEventListeners() {
    // Wishlist page click handlers
    document.getElementById('wishlist-page')?.addEventListener('click', e => {
        const removeButton = e.target.closest('.remove-wishlist-btn');
        if (removeButton) {
            handleRemoveFromWishlist(removeButton.dataset.mediaId);
        }
    });
 
    // Navigation logout handler
    document.querySelector('nav')?.addEventListener('click', e => {
        const action = e.target.closest('[data-action]')?.dataset.action;
        if (action === 'logout') handleLogout();
    });

    // Navigation links handler
    const navLinks = document.getElementById('nav-links');
    navLinks?.addEventListener('click', e => {
        const target = e.target.closest('a');
        if (!target || target.getAttribute('onclick')) return;
        const action = target.dataset.action;
        if (action === 'showLogin') showPage('login');
        if (action === 'showSubscription') showPage('subscription');
    });

    // Form handlers
    document.getElementById('login-form')?.addEventListener('submit', handleLogin);
    document.getElementById('signup-form')?.addEventListener('submit', handleSignup);
    document.getElementById('admin-login-form')?.addEventListener('submit', handleAdminLogin);
    document.getElementById('payment-form')?.addEventListener('submit', handlePayment);

    // Movie gallery click handler
    document.getElementById('movie-gallery-container')?.addEventListener('click', handleMovieGalleryClick);

    // Plan selection
    document.querySelectorAll('.plan-card').forEach(card => card.addEventListener('click', handlePlanSelection));

    // Payment method dropdown
    document.getElementById('payment-method')?.addEventListener('change', handlePaymentMethodChange);

    // User dashboard buttons
    document.getElementById('cancel-sub-btn')?.addEventListener('click', handleCancelSubscription);

    // AI Assistant modal buttons
    document.getElementById('ai-assistant-btn')?.addEventListener('click', () => document.getElementById('ai-assistant-modal').classList.add('active'));
    document.getElementById('close-ai-modal')?.addEventListener('click', () => document.getElementById('ai-assistant-modal').classList.remove('active'));
    document.getElementById('ai-prompt-submit')?.addEventListener('click', handleAIAssistant);

    // Setup admin event listeners
    setupAdminEventListeners();
}

// Make key functions available globally for onclick handlers
window.showPage = showPage;
window.renderUserDashboard = renderUserDashboard;
window.renderWishlistPage = renderWishlistPage;
window.handleCancelSubscription = handleCancelSubscription;
window.renderAdminDashboard = renderAdminDashboard;
window.closePopupAndGoHome = closePopupAndGoHome;