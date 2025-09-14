// js/script.js - FINAL AND COMPLETE VERSION

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

// --- GLOBAL STATE ---
let movies = allMedia; // Received from index.php
let state = {
    selectedPlan: null,
    currentUser: currentUser, // Received from index.php
};


// --- CORE SCRIPT INITIALIZATION ---
document.addEventListener('DOMContentLoaded', () => {
    if (sessionStorage.getItem('showSuccessPopup') === 'true') {
        document.getElementById('success-popup').classList.add('active');
        sessionStorage.removeItem('showSuccessPopup'); // Clear the flag
    }

    updateHeaderUI();
    renderMovies();
    renderHomepageWishlist();
    renderMostLikedCategory();
    setupEventListeners();
    setupPasswordToggles();
});



function setupEventListeners() {
    
document.getElementById('wishlist-page')?.addEventListener('click', e => {
    const removeButton = e.target.closest('.remove-wishlist-btn');
    if (removeButton) {
        handleRemoveFromWishlist(removeButton.dataset.mediaId);
    }
  
});
 
    document.querySelector('nav')?.addEventListener('click', e => {
        const action = e.target.closest('[data-action]')?.dataset.action;
        if (action === 'logout') handleLogout();
    });
    const navLinks = document.getElementById('nav-links');
    navLinks?.addEventListener('click', e => {
        const target = e.target.closest('a');
        if (!target || target.getAttribute('onclick')) return;
        const action = target.dataset.action;
        if (action === 'showLogin') showPage('login');
        if (action === 'showSubscription') showPage('subscription');
    });

    // All Forms
    document.getElementById('login-form')?.addEventListener('submit', handleLogin);
    document.getElementById('signup-form')?.addEventListener('submit', handleSignup);
    document.getElementById('admin-login-form')?.addEventListener('submit', handleAdminLogin);
    document.getElementById('payment-form')?.addEventListener('submit', handlePayment);

    // Consolidated Movie Gallery Click Handler
    document.getElementById('movie-gallery-container')?.addEventListener('click', handleMovieGalleryClick);

    // Plan Selection
    document.querySelectorAll('.plan-card').forEach(card => card.addEventListener('click', handlePlanSelection));

    // Payment Method Dropdown
    document.getElementById('payment-method')?.addEventListener('change', handlePaymentMethodChange);

    // User Dashboard Buttons
    document.getElementById('cancel-sub-btn')?.addEventListener('click', handleCancelSubscription);

    // AI Assistant Modal Buttons
    document.getElementById('ai-assistant-btn')?.addEventListener('click', () => document.getElementById('ai-assistant-modal').classList.add('active'));
    document.getElementById('close-ai-modal')?.addEventListener('click', () => document.getElementById('ai-assistant-modal').classList.remove('active'));
    document.getElementById('ai-prompt-submit')?.addEventListener('click', handleAIAssistant);

    
    setupAdminEventListeners();
}



function showPage(pageId) {
    document.querySelectorAll('.page').forEach(page => page.classList.remove('active'));
    const targetPage = document.getElementById(pageId + '-page');
    if (targetPage) {
        targetPage.classList.add('active');
        if (pageId === 'admin-dashboard') renderAdminDashboard();
    }
    window.scrollTo(0, 0);
}

// In js/script.js, REPLACE your old updateHeaderUI function with this one.

// In js/script.js, REPLACE your old updateHeaderUI function with this one.

// In js/script.js, REPLACE your old updateHeaderUI function with this one.

// In js/script.js, REPLACE your old updateHeaderUI function with this one.

function updateHeaderUI() {
    const navLinks = document.getElementById('nav-links');
    if (!navLinks) return;

    if (state.currentUser) { // This block runs if a user IS logged in
        let adminButton = '', userButtons = '', subscriptionInfoHTML = '';

        if (state.currentUser.role === 'admin' || state.currentUser.role === 'super_admin') {
            // CHANGED: This now opens the dashboard in the same page
            adminButton = `<a href="#" class="btn" onclick="showPage('admin-dashboard')">Admin</a>`;
        } else {
            // CHANGED: This now opens the dashboard in the same page
            userButtons = `
                <a href="#" class="btn" onclick="renderUserDashboard()">My Dashboard</a>
                <a href="#" class="btn" onclick="renderWishlistPage()">My Wishlist</a>
            `;
        }

        if (state.currentUser.subscription !== 'None') {
            subscriptionInfoHTML = `<a href="#" onclick="showPage('subscription')" class="btn btn-plan">Plan: ${state.currentUser.subscription}</a><a href="#" class="btn btn-secondary" onclick="handleCancelSubscription()">Cancel</a>`;
        } else {
            subscriptionInfoHTML = `<a href="#" class="btn" onclick="showPage('subscription')">Subscription</a>`;
        }

        const loggedInLinks = `
            <div class="flex items-center gap-4">
                <span class="text-white">Welcome, ${state.currentUser.username}!</span>
                ${adminButton}
                ${userButtons}
                ${subscriptionInfoHTML}
                <a href="#" class="btn btn-secondary" data-action="logout">Logout</a>
            </div>
        `;
        
        navLinks.innerHTML = loggedInLinks;
        
        const wishlistNav = document.getElementById('wishlist-nav-links');
        if(wishlistNav) wishlistNav.innerHTML = loggedInLinks;

    } else { // This block runs if NO user is logged in
        navLinks.innerHTML = `
            <a href="#" class="btn" data-action="showSubscription">Subscribe</a>
            <a href="#" class="btn btn-secondary" data-action="showLogin">Login</a>
        `;
    }
}

function renderMovies() {
    movies.forEach(m => m.rating = parseFloat(m.rating));
    populateGrid(document.getElementById('most-viewed-grid'), movies.filter(m => m.rating >= 8.9).sort((a, b) => b.rating - a.rating));
    populateGrid(document.getElementById('movie-grid'), [...movies].sort((a) => a.type === 'movie' ? -1 : 1).filter(m => m.type === 'movie'));
    populateGrid(document.getElementById('web-series-grid'), [...movies].sort((a) => a.type === 'web-series' ? -1 : 1).filter(m => m.type === 'web-series'));
    populateGrid(document.getElementById('all-movies-grid'), [...movies].sort((a, b) => a.title.localeCompare(b.title)));
    populateGrid(document.getElementById('anime-grid'), [...movies].sort((a) => a.type === 'anime' ? -1 : 1).filter(m => m.type === 'anime'));
    populateGrid(document.getElementById('bollywood-grid'), [...movies].sort((a) => a.type === 'bollywood' ? -1 : 1).filter(m => m.type === 'bollywood'));

}
// In js/script.js, inside the renderMovies function,
// REPLACE the old "All-Time Favorites Logic" with this:

// --- START: New All-Time Favorites Logic (Based on Score) ---
const favoritesGrid = document.getElementById('favorites-grid');
if (favoritesGrid) {
    // Find the highest number of likes to create a normalized score
    const maxLikes = Math.max(...movies.map(m => m.like_count), 1); // Use 1 to avoid division by zero

    const moviesWithScores = movies.map(movie => {
        // Normalize rating (0 to 1) and likes (0 to 1)
        const normalizedRating = (movie.rating || 0) / 10;
        const normalizedLikes = (movie.like_count || 0) / maxLikes;

        // Calculate a weighted score: 60% for rating, 40% for likes
        const score = (normalizedRating * 0.6) + (normalizedLikes * 0.4);

        return { ...movie, score: score };
    });

    // Sort movies by the new score in descending order and take the top 12
    const favoriteMovies = moviesWithScores.sort((a, b) => b.score - a.score).slice(0, 12);
    
    populateGrid(favoritesGrid, favoriteMovies);
}
// --- END: New Logic ---
async function renderMostLikedCategory() {
    const mostLikedGrid = document.getElementById('most-liked-grid');
    if (!mostLikedGrid) return;

    try {
        const response = await fetch('api/get_most_liked.php');
        const result = await response.json();

        if (result.success && result.data.length > 0) {
            populateGrid(mostLikedGrid, result.data);
        } else {
            // Hides the category if there are no liked movies
            mostLikedGrid.parentElement.style.display = 'none';
        }
    } catch (error) {
        console.error("Failed to load most liked movies:", error);
        mostLikedGrid.parentElement.style.display = 'none';
    }
}

// In js/script.js, replace your populateGrid function

function populateGrid(gridElement, movieList) {
    if (!gridElement) return;
    gridElement.innerHTML = '';
    movieList.forEach(movie => {
        const movieCard = document.createElement('div');
        movieCard.className = 'movie-card';
        movieCard.dataset.title = movie.title;
        movieCard.dataset.mediaId = movie.id;

        const isExclusive = movie.exclusive == 1;
        const lockIcon = isExclusive ? `<div class="exclusive-lock"><i class="fas fa-star"></i></div>` : '';
        
        // New HTML for the stats container
        const statsHTML = `
            <div class="movie-card-stats">
                <div class="movie-card-rating">
                    <i class="fas fa-star text-yellow-400"></i> ${movie.rating}
                </div>
                <div class="movie-card-likes">
                    <i class="fas fa-heart text-red-500"></i> ${movie.like_count}
                </div>
            </div>
        `;

        movieCard.innerHTML = `
            ${statsHTML}
            ${lockIcon}
            <img src="${movie.poster}" alt="${movie.title}" onerror="this.src='https://placehold.co/300x450/141414/FFF?text=Poster+Not+Found'">
            <div class="movie-card-info">
                <h3 class="font-bold">${movie.title} (${movie.year})</h3>
                <p class="text-sm text-gray-400 mt-1 movie-description">${movie.description}</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    <button class="btn btn-secondary text-xs wishlist-btn"><i class="fas fa-plus"></i> Wishlist</button>
                </div>
            </div>
        `;
        gridElement.appendChild(movieCard);
    });
}


// --- EVENT HANDLER FUNCTIONS ---

async function handleLogout() {
    await fetch('api/logout.php');
    window.location.reload();
}

async function handleLogin(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const response = await fetch('api/login.php', { method: 'POST', body: formData });
    const result = await response.json();
    if (result.success) {
        window.location.reload();
    } else {
        showCustomAlert(result.message);
    }
}

async function handleSignup(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const response = await fetch('api/signup.php', { method: 'POST', body: formData });
    const result = await response.json();
    if (result.success) {
        showCustomAlert('Account created successfully! Please login.');
        showPage('login');
    } else {
        showCustomAlert(result.message);
    }
}

async function handleAdminLogin(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const response = await fetch('api/admin_login.php', { method: 'POST', body: formData });
    const result = await response.json();
    if (result.success) {
        window.location.reload();
    } else {
        showCustomAlert(result.message);
    }
}

function handlePlanSelection(e) {
    if (!state.currentUser) {
        showCustomAlert('You must be logged in to subscribe.');
        showPage('login');
        return;
    }
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    const selectedCard = e.target.closest('.plan-card');
    selectedCard.classList.add('selected');
    state.selectedPlan = { name: selectedCard.dataset.plan, price: selectedCard.dataset.price };
    document.getElementById('selected-plan-text').textContent = `${state.selectedPlan.name} Plan - $${state.selectedPlan.price}`;
    showPage('payment');
}

function handlePaymentMethodChange(e) {
    const selectedMethod = e.target.value;
    document.getElementById('card-details').classList.toggle('hidden', selectedMethod !== 'credit-card' && selectedMethod !== 'debit-card');
    document.getElementById('upi-details').classList.toggle('hidden', selectedMethod !== 'upi');
    const payButton = document.querySelector('#payment-form button');
    payButton.textContent = (selectedMethod === 'paypal') ? 'Proceed to PayPal' : 'Pay Now';
}

// In js/script.js, REPLACE this function
async function handlePayment(e) {
    e.preventDefault();
    if (!state.currentUser || !state.selectedPlan) return;

    const paymentMethod = document.getElementById('payment-method').value;

    // Create a FormData object to send all the necessary data
    const formData = new FormData();
    formData.append('plan', state.selectedPlan.name);
    formData.append('price', state.selectedPlan.price); // <-- Sending the price
    formData.append('method', paymentMethod); // <-- Sending the payment method

    // First, subscribe the user in the background
    const response = await fetch('api/subscribe.php', { method: 'POST', body: formData });
    const result = await response.json();

    if (!result.success) {
        showCustomAlert(result.message || 'An error occurred during subscription.');
        return;
    }

    // Now, handle the redirect or success message
    if (paymentMethod === 'paypal') {
        window.location.href = 'paypal.html';
    } else {
        state.currentUser.subscription = state.selectedPlan.name;
        document.getElementById('success-popup').classList.add('active');
    }
}
// In js/script.js, add this function
// In js/script.js, REPLACE your old handleCancelSubscription function with this one.

// In js/script.js, REPLACE your old handleCancelSubscription function with this one.

// In js/script.js, REPLACE your old handleCancelSubscription function with this one.

// In js/script.js, REPLACE your old handleCancelSubscription function with this one.

// In js/script.js, REPLACE your old handleCancelSubscription function with this one.

async function handleCancelSubscription() {
    const userConfirmed = await showCustomConfirm('Are you sure you want to cancel your subscription? This action cannot be undone.');
    
    if (userConfirmed) {
        const response = await fetch('api/cancel_subscription.php', { method: 'POST' });
        const result = await response.json();
        
        if (result.success) {
            // --- START: New Success Pop-up Logic ---
            
            // 1. Get the existing success pop-up and its text elements
            const successPopup = document.getElementById('success-popup');
            const popupTitle = successPopup.querySelector('h2');
            const popupMessage = successPopup.querySelector('p');

            // 2. Change the text to a cancellation message
            popupTitle.innerHTML = 'Unsubscribed 😔'; // Use innerHTML to render the emoji
            popupMessage.textContent = 'Your subscription has been successfully cancelled.';
            
            // 3. Show the pop-up
            successPopup.classList.add('active');

            // 4. Update the user's state and the header UI immediately
            state.currentUser.subscription = 'None';
            updateHeaderUI();
            
            // --- END: New Logic ---

        } else {
            // If cancellation fails, show the custom alert
            showCustomAlert(result.message);
        }
    }
}

function handleMovieGalleryClick(e) {
    const movieCard = e.target.closest('.movie-card');
    if (!movieCard) return;

    const mediaId = movieCard.dataset.mediaId;
    const movie = movies.find(m => m.id == mediaId);
    if (!movie) return;

    // Handle button clicks inside the card
    if (e.target.closest('button')) {
        if (e.target.closest('.wishlist-btn')) {
            // We now pass the button element itself to the handler
            handleWishlistClick(mediaId, e.target.closest('.wishlist-btn'));
        } else if (e.target.closest('.get-ai-summary-btn')) {
            handleGetAiSummary(e.target.closest('button'));
        }
        return;
    }

    // Handle click on the card itself
    if (!state.currentUser) {
        showCustomAlert('Please log in to watch any movie or series.');
        showPage('login');
        return;
    }
    const isSubscribed = state.currentUser.subscription !== 'None';
    if (movie.exclusive == 1 && !isSubscribed) {
        showCustomAlert('This content is exclusive! Please subscribe to watch.');
        showPage('subscription');
        return;
    }
    showCustomAlert(`Now playing: ${movie.title}`);
    logToWatchHistory(mediaId);
}


async function renderHomepageWishlist() {
    if (!state.currentUser) return;
    const response = await fetch('api/get_wishlist.php');
    const result = await response.json();
    if (result.success && result.wishlist.length > 0) {
        const wishlistCategory = document.getElementById('wishlist-category');
        wishlistCategory.style.display = 'block';
        populateGrid(document.getElementById('wishlist-home-grid'), result.wishlist);
    }
}

async function renderWishlistPage() {
    showPage('wishlist');
    const wishlistGrid = document.getElementById('wishlist-grid');
    const emptyMessage = document.getElementById('wishlist-empty');
    wishlistGrid.innerHTML = '<p class="text-gray-400">Loading your wishlist...</p>';
    emptyMessage.classList.add('hidden');

    const response = await fetch('api/get_wishlist.php');
    const result = await response.json();

    if (result.success && result.wishlist.length > 0) {
        wishlistGrid.innerHTML = ''; // Clear loading message
        result.wishlist.forEach(movie => {
            wishlistGrid.innerHTML += `
                <div class="wishlist-item" id="wishlist-item-${movie.id}">
                    <div class="wishlist-item-poster">
                        <img src="${movie.poster}" alt="${movie.title}">
                    </div>
                    <div class="wishlist-item-details">
                        <h3 class="text-2xl font-bold">${movie.title} (${movie.year})</h3>
                        <p class="description mt-2">${movie.description}</p>
                        <div class="wishlist-item-actions">
                            <button class="btn play-btn" data-media-id="${movie.id}" data-title="${movie.title}">Play Now</button>
                            <button class="btn btn-secondary remove-wishlist-btn" data-media-id="${movie.id}">Remove</button>
                        </div>
                    </div>
                </div>
            `;
        });
    } else if (result.success) {
        wishlistGrid.innerHTML = '';
        emptyMessage.classList.remove('hidden');
    } else {
        showCustomAlert(result.message);
        emptyMessage.classList.remove('hidden');
    }
}

async function handleWishlistClick(mediaId, buttonElement) {
    if (!state.currentUser) {
        showCustomAlert('Please log in to create a wishlist.');
        showPage('login');
        return;
    }

    const response = await fetch('api/add_to_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mediaId: mediaId })
    });
    const result = await response.json();

    showCustomAlert(result.message);

    // --- START: New Instant Update Logic ---
    if (result.success) {
        // 1. Update the button's appearance
        if (buttonElement) {
            buttonElement.innerHTML = '<i class="fas fa-check"></i> Added';
            buttonElement.classList.add('in-wishlist');
            buttonElement.disabled = true;
        }

        // 2. Re-render the wishlist category on the homepage
        renderHomepageWishlist();
    }
    // --- END: New Logic ---
}



async function handleRemoveFromWishlist(mediaId) {
    if (!state.currentUser) return;

    const response = await fetch('api/remove_from_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mediaId: mediaId })
    });
    const result = await response.json();
    showCustomAlert(result.message);

    if (result.success) {
        // Remove the item from the page without a full reload
        document.getElementById(`wishlist-item-${mediaId}`)?.remove();
        
        // Check if the wishlist is now empty and show the message if it is
        if (document.querySelectorAll('.wishlist-item').length === 0) {
            document.getElementById('wishlist-empty').classList.remove('hidden');
        }
    }
}



async function renderUserDashboard() {
    showPage('user-dashboard');
    const response = await fetch('api/get_user_dashboard.php');
    const data = await response.json();
    if (!data.success) {
        showCustomAlert(data.message);
        showPage('login');
        return;
    }
    document.getElementById('dash-profile-pic').src = data.userDetails.profile_pic_url;
    document.getElementById('dash-username').textContent = data.userDetails.username;
    document.getElementById('dash-email').textContent = data.userDetails.email;
    document.getElementById('dash-sub-status').textContent = `Subscription: ${data.userDetails.subscription}`;
    const cancelBtn = document.getElementById('cancel-sub-btn');
    cancelBtn.classList.toggle('hidden', data.userDetails.subscription === 'None');
    const historyGrid = document.getElementById('watch-history-grid');
    historyGrid.innerHTML = '';
    if (data.watchHistory.length > 0) {
        data.watchHistory.forEach(movie => {
            historyGrid.innerHTML += `<div class="movie-card" data-media-id="${movie.id}" data-title="${movie.title}"><img src="${movie.poster}" alt="${movie.title}"></div>`;
        });
    } else {
        historyGrid.innerHTML = '<p class="text-gray-400">Your watch history is empty.</p>';
    }
}

async function handleCancelSubscription() {
    if (confirm('Are you sure you want to cancel your subscription?')) {
        const response = await fetch('api/cancel_subscription.php', { method: 'POST' });
        const result = await response.json();
        showCustomAlert(result.message);
        if (result.success) renderUserDashboard();
    }
}

function logToWatchHistory(mediaId) {
    if (!state.currentUser) return;
    fetch('api/add_to_history.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mediaId: mediaId })
    });
}

// --- ADMIN FUNCTIONS ---

function setupAdminEventListeners() {
    document.querySelector('#admin-dashboard-page [data-action="logout"]')?.addEventListener('click', handleLogout);
    document.getElementById('add-media-form')?.addEventListener('submit', handleAddMedia);
    document.getElementById('edit-media-form')?.addEventListener('submit', handleEditMedia);
    document.getElementById('media-table')?.addEventListener('click', handleMediaTableClick);
    document.getElementById('users-table')?.addEventListener('click', handleUsersTableClick);
    document.getElementById('edit-user-form')?.addEventListener('submit', handleEditUser);
    document.getElementById('add-generate-desc-btn')?.addEventListener('click', () => handleGenerateDescription('add'));
    document.getElementById('edit-generate-desc-btn')?.addEventListener('click', () => handleGenerateDescription('edit'));
}

// In js/script.js, REPLACE your old renderAdminDashboard function with this one

// In js/script.js, REPLACE your old renderAdminDashboard function with this one.

async function renderAdminDashboard() {
    const response = await fetch('api/get_dashboard_data.php');
    const data = await response.json();

    if (!data.success) {
        showCustomAlert(data.message || 'Failed to load admin data.');
        return;
    }

    document.getElementById('total-users').textContent = data.totalUsers;
    document.getElementById('total-subs').textContent = data.totalSubs;
    
    // This variable checks if the logged-in user is an 'admin' OR a 'super_admin'
    const isAdmin = (state.currentUser && (state.currentUser.role === 'admin' || state.currentUser.role === 'super_admin'));
    
    // --- Manage Users Table ---
    const usersTableBody = document.querySelector('#users-table tbody');
    usersTableBody.innerHTML = '';
    data.users.forEach(user => {
        // Only a super_admin can manage other users
        const isSuperAdmin = (state.currentUser && state.currentUser.role === 'super_admin');
        let actionButtons = '<span>Actions</span>';
        if (isSuperAdmin) {
            actionButtons = `
                <button class="action-btn user-edit-btn" data-id="${user.id}" data-username="${user.username}" data-role="${user.role}" data-subscription="${user.subscription}"><i class="fas fa-edit"></i></button>
                <button class="action-btn user-delete-btn" data-id="${user.id}"><i class="fas fa-trash"></i></button>
            `;
        }
        usersTableBody.innerHTML += `<tr><td class="p-3">${user.username}</td><td class="p-3">${user.email}</td><td class="p-3">${user.subscription}</td><td class="p-3">${user.role}</td><td class="p-3">${actionButtons}</td></tr>`;
    });

    // --- Manage Media Table ---
    const mediaTableBody = document.querySelector('#media-table tbody');
    mediaTableBody.innerHTML = '';
    data.media.forEach(media => {
        let actionButtons = '<span>View Only</span>';
        // This 'if' statement correctly checks for BOTH roles
        if (isAdmin) {
            actionButtons = `
                <button class="action-btn edit-btn" data-id="${media.id}"><i class="fas fa-edit"></i></button>
                <button class="action-btn delete-btn" data-id="${media.id}"><i class="fas fa-trash"></i></button>
            `;
        }
        mediaTableBody.innerHTML += `<tr><td class="p-3"><img src="${media.poster}" class="poster-thumb"></td><td class="p-3">${media.title}</td><td class="p-3">${media.year}</td><td class="p-3">${media.rating}</td><td class="p-3">${media.exclusive == 1 ? 'Yes' : 'No'}</td><td class="p-3">${actionButtons}</td></tr>`;
    });
}

async function handleAddMedia(e) { /* ... form submission for adding media ... */ }
async function handleEditMedia(e) { /* ... form submission for editing media ... */ }
async function handleMediaTableClick(e) { /* ... logic for edit/delete media buttons ... */ }
async function handleUsersTableClick(e) { /* ... logic for edit/delete user buttons ... */ }
async function handleEditUser(e) { /* ... form submission for editing a user ... */ }


// --- HELPER & AI FUNCTIONS ---

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

const closePopupAndGoHome = () => {
    document.getElementById('success-popup').classList.remove('active');
    window.location.reload();
};

async function callGeminiAPI(prompt) {
    const apiKey = "";
    if (!apiKey) return "AI feature not configured.";
    const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${apiKey}`;
    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ contents: [{ parts: [{ text: prompt }] }] })
        });
        if (!response.ok) return "Error connecting to AI.";
        const result = await response.json();
        return result.candidates?.[0]?.content?.parts?.[0]?.text || "No response from AI.";
    } catch (error) {
        return "Error connecting to AI.";
    }
}

async function handleAIAssistant() { /* ... AI assistant logic ... */ }
async function handleGetAiSummary(button) { /* ... AI summary logic ... */ }
async function handleFindSimilar(button) { /* ... Find similar logic ... */ }
async function handleGenerateDescription(formPrefix) { /* ... Generate description logic ... */ }



/**
 * The core function that communicates with the Google Gemini API.
 * @param {string} prompt The question to send to the AI.
 * @returns {Promise<string>} The text response from the AI.
 */
async function callGeminiAPI(prompt) {
    // IMPORTANT: Paste your Google AI Studio API Key here.
    const apiKey = "PASTE YOUR KEY HERE";

    if (!apiKey || apiKey === "PASTE YOUR KEY HERE") {
        showCustomAlert("AI feature is not configured. API Key is missing.");
        return null;
    }
    const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${apiKey}`;

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ contents: [{ parts: [{ text: prompt }] }] })
        });
        if (!response.ok) {
            console.error("API Error Response:", await response.text());
            return "Error: Could not connect to the AI service.";
        }
        const result = await response.json();
        return result.candidates?.[0]?.content?.parts?.[0]?.text || "The AI did not provide a response.";
    } catch (error) {
        console.error("Fetch Error:", error);
        return "Error: Could not connect to the AI service.";
    }
}

/**
 * Handles the main AI Assistant modal for movie recommendations.
 */
async function handleAIAssistant() {
    const input = document.getElementById('ai-prompt-input');
    const responseArea = document.getElementById('ai-response-area');
    const query = input.value.trim();
    if (!query) return;

    responseArea.textContent = 'Thinking...';
    const movieList = JSON.stringify(movies.map(m => m.title));
    const prompt = `From this list of available titles: ${movieList}. Please recommend the single best title that matches this user's request: "${query}". Respond with ONLY the exact title from the list. If no title is a good match, respond with "None".`;
    
    const recommendedTitle = await callGeminiAPI(prompt);
    
    document.querySelectorAll('.movie-card').forEach(card => card.classList.remove('highlight'));
    
    if (recommendedTitle && recommendedTitle.toLowerCase() !== 'none' && !recommendedTitle.includes("Error")) {
        const cleanedTitle = recommendedTitle.trim().replace(/["'.]/g, ""); // Clean the title
        const matchedCard = document.querySelector(`.movie-card[data-title="${cleanedTitle}"]`);
        if (matchedCard) {
            responseArea.textContent = `I recommend "${cleanedTitle}". I've highlighted it for you!`;
            matchedCard.classList.add('highlight');
            matchedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => document.getElementById('ai-assistant-modal').classList.remove('active'), 2500);
        } else {
            responseArea.textContent = `I found a match, "${cleanedTitle}", but couldn't locate it on the page.`;
        }
    } else {
        responseArea.textContent = "Sorry, I couldn't find a good match in our current library.";
    }
    input.value = '';
}

/**
 * Generates a new summary for a movie card.
 * @param {HTMLElement} button The button that was clicked.
 */
async function handleGetAiSummary(button) {
    const card = button.closest('.movie-card');
    const title = card.dataset.title;
    const descriptionEl = card.querySelector('.movie-description');

    button.innerHTML = 'Generating...';
    button.disabled = true;

    const prompt = `Generate a new, one-sentence, and exciting spoiler-free summary for the movie or series titled "${title}".`;
    const summary = await callGeminiAPI(prompt);

    if (summary && !summary.includes("Error")) {
        descriptionEl.textContent = summary;
        button.remove(); // Remove the button after use
    } else {
        showCustomAlert(summary || 'Could not generate AI summary.');
        button.innerHTML = '✨ AI Summary';
        button.disabled = false;
    }
}

/**
 * Generates a description for the admin forms.
 * @param {string} formPrefix Either 'add' or 'edit'.
 */
async function handleGenerateDescription(formPrefix) {
    const title = document.getElementById(`${formPrefix}-media-title`).value.trim();
    const year = document.getElementById(`${formPrefix}-media-year`).value.trim();
    const descTextarea = document.getElementById(`${formPrefix}-media-desc`);
    const button = document.getElementById(`${formPrefix}-generate-desc-btn`);

    if (!title || !year) {
        showCustomAlert('Please enter a Title and Year first.');
        return;
    }

    button.innerHTML = 'Generating...';
    button.disabled = true;

    const prompt = `Generate a compelling, one-sentence, spoiler-free description for the movie or series titled "${title}" (${year}).`;
    const description = await callGeminiAPI(prompt);

    if (description && !description.includes("Error")) {
        descTextarea.value = description.trim();
    } else {
        showCustomAlert(description || 'Could not generate a description.');
    }
    
    button.innerHTML = '✨ Generate Description';
    button.disabled = false;
}

