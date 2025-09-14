// js/user-dashboard.js - User dashboard, wishlist, and subscription management

/**
 * Renders the user dashboard page
 */
async function renderUserDashboard() {
    console.log('renderUserDashboard called');
    showPage('user-dashboard');
    
    try {
        console.log('Fetching user dashboard data...');
        const response = await fetch('api/get_user_dashboard.php');
        const data = await response.json();
        console.log('Dashboard API response:', data);
        
        if (!data.success) {
            console.error('Dashboard API error:', data.message);
            showCustomAlert(data.message);
            showPage('login');
            return;
        }
    
        // Update user details
        const profilePic = document.getElementById('dash-profile-pic');
        if (profilePic) {
            profilePic.src = data.userDetails.profile_pic_url || 'https://i.pravatar.cc/150?u=' + encodeURIComponent(data.userDetails.username);
            profilePic.onerror = function() {
                this.src = 'https://i.pravatar.cc/150?u=' + encodeURIComponent(data.userDetails.username);
            };
        }
        
        const usernameEl = document.getElementById('dash-username');
        if (usernameEl) usernameEl.textContent = data.userDetails.username;
        
        const emailEl = document.getElementById('dash-email');
        if (emailEl) emailEl.textContent = data.userDetails.email;
        
        const subStatusEl = document.getElementById('dash-sub-status');
        if (subStatusEl) subStatusEl.textContent = `Subscription: ${data.userDetails.subscription}`;
        
        // Show/hide cancel subscription button
        const cancelBtn = document.getElementById('cancel-sub-btn');
        cancelBtn.classList.toggle('hidden', data.userDetails.subscription === 'None');
        
        // Render watch history
        const historyGrid = document.getElementById('watch-history-grid');
        historyGrid.innerHTML = '';
        if (data.watchHistory.length > 0) {
            data.watchHistory.forEach(movie => {
                const movieCard = document.createElement('div');
                movieCard.className = 'movie-card';
                movieCard.dataset.mediaId = movie.id;
                movieCard.dataset.title = movie.title;
                movieCard.innerHTML = `<img src="${movie.poster}" alt="${movie.title}" onerror="this.src='https://placehold.co/300x450/141414/FFF?text=Poster+Not+Found'">`;
                historyGrid.appendChild(movieCard);
            });
        } else {
            historyGrid.innerHTML = '<p class="text-gray-400 text-center py-8">Your watch history is empty.</p>';
        }
    } catch (error) {
        console.error('Error in renderUserDashboard:', error);
        showCustomAlert('Failed to load dashboard. Please try again.');
        showPage('home');
    }
}

/**
 * Renders the wishlist page
 */
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

/**
 * Renders the wishlist section on the homepage
 */
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

/**
 * Handles adding items to wishlist
 * @param {string} mediaId The media ID to add
 * @param {HTMLElement} buttonElement The button that was clicked
 */
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

    // Instant update logic
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
}

/**
 * Handles removing items from wishlist
 * @param {string} mediaId The media ID to remove
 */
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

/**
 * Handles plan selection for subscription
 * @param {Event} e Click event
 */
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

/**
 * Handles payment method change
 * @param {Event} e Change event
 */
function handlePaymentMethodChange(e) {
    const selectedMethod = e.target.value;
    document.getElementById('card-details').classList.toggle('hidden', selectedMethod !== 'credit-card' && selectedMethod !== 'debit-card');
    document.getElementById('upi-details').classList.toggle('hidden', selectedMethod !== 'upi');
    const payButton = document.querySelector('#payment-form button');
    payButton.textContent = (selectedMethod === 'paypal') ? 'Proceed to PayPal' : 'Pay Now';
}

/**
 * Handles payment form submission
 * @param {Event} e Form submit event
 */
async function handlePayment(e) {
    e.preventDefault();
    if (!state.currentUser || !state.selectedPlan) return;

    const paymentMethod = document.getElementById('payment-method').value;

    // Create a FormData object to send all the necessary data
    const formData = new FormData();
    formData.append('plan', state.selectedPlan.name);
    formData.append('price', state.selectedPlan.price);
    formData.append('method', paymentMethod);

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

/**
 * Handles subscription cancellation
 */
async function handleCancelSubscription() {
    const userConfirmed = await showCustomConfirm('Are you sure you want to cancel your subscription? This action cannot be undone.');
    
    if (userConfirmed) {
        const response = await fetch('api/cancel_subscription.php', { method: 'POST' });
        const result = await response.json();
        
        if (result.success) {
            // Get the existing success pop-up and its text elements
            const successPopup = document.getElementById('success-popup');
            const popupTitle = successPopup.querySelector('h2');
            const popupMessage = successPopup.querySelector('p');

            // Change the text to a cancellation message
            popupTitle.innerHTML = 'Unsubscribed 😔';
            popupMessage.textContent = 'Your subscription has been successfully cancelled.';
            
            // Show the pop-up
            successPopup.classList.add('active');

            // Update the user's state and the header UI immediately
            state.currentUser.subscription = 'None';
            updateHeaderUI();

        } else {
            // If cancellation fails, show the custom alert
            showCustomAlert(result.message);
        }
    }
}

// Export functions if using modules (optional for direct script inclusion)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        renderUserDashboard,
        renderWishlistPage,
        renderHomepageWishlist,
        handleWishlistClick,
        handleRemoveFromWishlist,
        handlePlanSelection,
        handlePaymentMethodChange,
        handlePayment,
        handleCancelSubscription
    };
}