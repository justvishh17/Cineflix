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

    // Trailer modal event listeners
    document.getElementById('trailer-modal')?.addEventListener('click', e => {
        // Close modal when clicking outside the content
        if (e.target.id === 'trailer-modal') {
            closeTrailerPopup();
        }
    });
    
    // Close trailer modal with Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && document.getElementById('trailer-modal').classList.contains('active')) {
            closeTrailerPopup();
        }
    });

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
window.openTrailerPopup = openTrailerPopup;
window.closeTrailerPopup = closeTrailerPopup;

/**
 * Opens the trailer popup with YouTube video
 * @param {Object} movie The movie object containing title, year, and trailer info
 */
function openTrailerPopup(movie) {
    const modal = document.getElementById('trailer-modal');
    const title = document.getElementById('trailer-title');
    const year = document.getElementById('trailer-year');
    const iframe = document.getElementById('trailer-iframe');
    
    // Set movie details
    title.textContent = movie.title;
    year.textContent = movie.year;
    
    // Generate YouTube embed URL
    // For now, we'll use a placeholder trailer ID if movie doesn't have trailer_url
    const trailerId = movie.trailer_url || 'dQw4w9WgXcQ'; // Rick Roll as fallback
    const embedUrl = `https://www.youtube.com/embed/${trailerId}?autoplay=1&rel=0&modestbranding=1`;
    
    iframe.src = embedUrl;
    modal.classList.add('active');
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

/**
 * Closes the trailer popup and stops video
 */
function closeTrailerPopup() {
    const modal = document.getElementById('trailer-modal');
    const iframe = document.getElementById('trailer-iframe');
    
    // Stop video by clearing src
    iframe.src = '';
    modal.classList.remove('active');
    
    // Re-enable body scroll
    document.body.style.overflow = '';
}