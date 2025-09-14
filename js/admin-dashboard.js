// js/admin-dashboard.js - Admin dashboard functionality

/**
 * Sets up admin-specific event listeners
 */
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

/**
 * Renders the admin dashboard with user and media data
 */
async function renderAdminDashboard() {
    const response = await fetch('api/get_dashboard_data.php');
    const data = await response.json();

    if (!data.success) {
        showCustomAlert(data.message || 'Failed to load admin data.');
        return;
    }

    document.getElementById('total-users').textContent = data.totalUsers;
    document.getElementById('total-subs').textContent = data.totalSubs;
    
    // Check if the logged-in user is an 'admin' OR a 'super_admin'
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
        if (isAdmin) {
            actionButtons = `
                <button class="action-btn edit-btn" data-id="${media.id}"><i class="fas fa-edit"></i></button>
                <button class="action-btn delete-btn" data-id="${media.id}"><i class="fas fa-trash"></i></button>
            `;
        }
        mediaTableBody.innerHTML += `<tr><td class="p-3"><img src="${media.poster}" class="poster-thumb"></td><td class="p-3">${media.title}</td><td class="p-3">${media.year}</td><td class="p-3">${media.rating}</td><td class="p-3">${media.exclusive == 1 ? 'Yes' : 'No'}</td><td class="p-3">${actionButtons}</td></tr>`;
    });
}

/**
 * Handles adding new media through the admin form
 * @param {Event} e Form submit event
 */
async function handleAddMedia(e) { 
    e.preventDefault();
    const formData = new FormData();
    formData.append('title', document.getElementById('add-media-title').value);
    formData.append('year', document.getElementById('add-media-year').value);
    formData.append('rating', document.getElementById('add-media-rating').value);
    formData.append('poster', document.getElementById('add-media-poster').value);
    formData.append('description', document.getElementById('add-media-desc').value);
    formData.append('exclusive', document.getElementById('add-media-exclusive').checked ? 1 : 0);
    formData.append('type', document.getElementById('add-media-type').checked ? 'web-series' : 'movie');

    const response = await fetch('api/add_media.php', { method: 'POST', body: formData });
    const result = await response.json();
    showCustomAlert(result.message);
    if (result.success) {
        document.getElementById('add-media-form').reset();
        renderAdminDashboard();
    }
}

/**
 * Handles editing existing media through the admin form
 * @param {Event} e Form submit event
 */
async function handleEditMedia(e) { 
    e.preventDefault();
    const formData = new FormData();
    formData.append('id', document.getElementById('edit-media-id').value);
    formData.append('title', document.getElementById('edit-media-title').value);
    formData.append('year', document.getElementById('edit-media-year').value);
    formData.append('rating', document.getElementById('edit-media-rating').value);
    formData.append('poster', document.getElementById('edit-media-poster').value);
    formData.append('description', document.getElementById('edit-media-desc').value);
    formData.append('exclusive', document.getElementById('edit-media-exclusive').checked ? 1 : 0);
    formData.append('type', document.getElementById('edit-media-type').checked ? 'web-series' : 'movie');

    const response = await fetch('api/update_media.php', { method: 'POST', body: formData });
    const result = await response.json();
    showCustomAlert(result.message);
    if (result.success) {
        document.getElementById('edit-media-modal').classList.remove('active');
        renderAdminDashboard();
    }
}

/**
 * Handles clicks on the media table (edit/delete buttons)
 * @param {Event} e Click event
 */
async function handleMediaTableClick(e) { 
    const editBtn = e.target.closest('.edit-btn');
    const deleteBtn = e.target.closest('.delete-btn');
    
    if (editBtn) {
        const mediaId = editBtn.dataset.id;
        // Populate edit form with existing data
        const media = movies.find(m => m.id == mediaId);
        if (media) {
            document.getElementById('edit-media-id').value = media.id;
            document.getElementById('edit-media-title').value = media.title;
            document.getElementById('edit-media-year').value = media.year;
            document.getElementById('edit-media-rating').value = media.rating;
            document.getElementById('edit-media-poster').value = media.poster;
            document.getElementById('edit-media-desc').value = media.description;
            document.getElementById('edit-media-exclusive').checked = media.exclusive == 1;
            document.getElementById('edit-media-type').checked = media.type === 'web-series';
            document.getElementById('edit-media-modal').classList.add('active');
        }
    }
    
    if (deleteBtn) {
        const mediaId = deleteBtn.dataset.id;
        const confirmed = await showCustomConfirm('Are you sure you want to delete this media?');
        if (confirmed) {
            const response = await fetch('api/delete_media.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: mediaId })
            });
            const result = await response.json();
            showCustomAlert(result.message);
            if (result.success) renderAdminDashboard();
        }
    }
}

/**
 * Handles clicks on the users table (edit/delete buttons)
 * @param {Event} e Click event
 */
async function handleUsersTableClick(e) { 
    const editBtn = e.target.closest('.user-edit-btn');
    const deleteBtn = e.target.closest('.user-delete-btn');
    
    if (editBtn) {
        document.getElementById('edit-user-id').value = editBtn.dataset.id;
        document.getElementById('edit-user-username').value = editBtn.dataset.username;
        document.getElementById('edit-user-subscription').value = editBtn.dataset.subscription;
        document.getElementById('edit-user-role').value = editBtn.dataset.role;
        document.getElementById('edit-user-modal').classList.add('active');
    }
    
    if (deleteBtn) {
        const userId = deleteBtn.dataset.id;
        const confirmed = await showCustomConfirm('Are you sure you want to delete this user?');
        if (confirmed) {
            const response = await fetch('api/delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId })
            });
            const result = await response.json();
            showCustomAlert(result.message);
            if (result.success) renderAdminDashboard();
        }
    }
}

/**
 * Handles editing user details through the admin form
 * @param {Event} e Form submit event
 */
async function handleEditUser(e) { 
    e.preventDefault();
    const formData = new FormData();
    formData.append('id', document.getElementById('edit-user-id').value);
    formData.append('subscription', document.getElementById('edit-user-subscription').value);
    formData.append('role', document.getElementById('edit-user-role').value);

    const response = await fetch('api/update_user.php', { method: 'POST', body: formData });
    const result = await response.json();
    showCustomAlert(result.message);
    if (result.success) {
        document.getElementById('edit-user-modal').classList.remove('active');
        renderAdminDashboard();
    }
}

// Export functions if using modules (optional for direct script inclusion)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        setupAdminEventListeners,
        renderAdminDashboard,
        handleAddMedia,
        handleEditMedia,
        handleMediaTableClick,
        handleUsersTableClick,
        handleEditUser
    };
}