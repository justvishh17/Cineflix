// js/auth.js - Authentication and user management

/**
 * Updates the navigation UI based on user login status
 */
function updateHeaderUI() {
    const navLinks = document.getElementById('nav-links');
    if (!navLinks) return;

    if (state.currentUser) { // This block runs if a user IS logged in
        let adminButton = '', userButtons = '', subscriptionInfoHTML = '';

        if (state.currentUser.role === 'admin' || state.currentUser.role === 'super_admin') {
            adminButton = `<a href="#" class="btn" onclick="showPage('admin-dashboard')">Admin</a>`;
        } else {
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
        
        // Update dashboard navigation if it exists
        const dashboardNavLinks = document.getElementById('dashboard-nav-links');
        if (dashboardNavLinks) {
            dashboardNavLinks.innerHTML = loggedInLinks;
        }
        
        const wishlistNav = document.getElementById('wishlist-nav-links');
        if(wishlistNav) wishlistNav.innerHTML = loggedInLinks;

    } else { // This block runs if NO user is logged in
        navLinks.innerHTML = `
            <a href="#" class="btn" data-action="showSubscription">Subscribe</a>
            <a href="#" class="btn btn-secondary" data-action="showLogin">Login</a>
        `;
    }
}

/**
 * Handles user logout
 */
async function handleLogout() {
    await fetch('api/logout.php');
    window.location.reload();
}

/**
 * Handles user login form submission
 * @param {Event} e Form submit event
 */
async function handleLogin(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('api/login.php', { method: 'POST', body: formData });
        const result = await response.json();
        
        if (result.success) {
            // Update the global state with user information from the login response
            state.currentUser = result.user;
            
            // Show success message
            showCustomAlert('Login successful! Welcome back, ' + result.user.username + '!');
            
            // Update the header UI to show logged-in state
            updateHeaderUI();
            
            // Show the home page
            showPage('home');
            
            // Refresh movie grids to show user-specific content
            renderHomepageWishlist();
            
        } else {
            showCustomAlert(result.message);
        }
    } catch (error) {
        console.error('Login error:', error);
        showCustomAlert('Login failed. Please try again.');
    }
}

/**
 * Handles user signup form submission
 * @param {Event} e Form submit event
 */
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

/**
 * Handles admin login form submission
 * @param {Event} e Form submit event
 */
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

// Export functions if using modules (optional for direct script inclusion)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        updateHeaderUI,
        handleLogout,
        handleLogin,
        handleSignup,
        handleAdminLogin
    };
}