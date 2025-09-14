// js/movie-manager.js - Movie rendering and display logic

/**
 * Renders all movie categories and grids
 */
function renderMovies() {
    movies.forEach(m => m.rating = parseFloat(m.rating));
    populateGrid(document.getElementById('most-viewed-grid'), movies.filter(m => m.rating >= 8.9).sort((a, b) => b.rating - a.rating));
    populateGrid(document.getElementById('movie-grid'), [...movies].sort((a) => a.type === 'movie' ? -1 : 1).filter(m => m.type === 'movie'));
    populateGrid(document.getElementById('web-series-grid'), [...movies].sort((a) => a.type === 'web-series' ? -1 : 1).filter(m => m.type === 'web-series'));
    populateGrid(document.getElementById('all-movies-grid'), [...movies].sort((a, b) => a.title.localeCompare(b.title)));
    populateGrid(document.getElementById('anime-grid'), [...movies].sort((a) => a.type === 'anime' ? -1 : 1).filter(m => m.type === 'anime'));
    populateGrid(document.getElementById('bollywood-grid'), [...movies].sort((a) => a.type === 'bollywood' ? -1 : 1).filter(m => m.type === 'bollywood'));

    // All-Time Favorites Logic (Based on Score)
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
}

/**
 * Renders the most liked movies category
 */
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

/**
 * Populates a grid element with movie cards
 * @param {HTMLElement} gridElement The grid container element
 * @param {Array} movieList Array of movie objects to display
 */
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
        
        // Movie card stats
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

/**
 * Handles clicks on movie gallery cards and buttons
 * @param {Event} e Click event
 */
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

    // Handle click on the card itself - open trailer popup
    if (!state.currentUser) {
        showCustomAlert('Please log in to watch trailers.');
        showPage('login');
        return;
    }
    const isSubscribed = state.currentUser.subscription !== 'None';
    if (movie.exclusive == 1 && !isSubscribed) {
        showCustomAlert('This content is exclusive! Please subscribe to watch.');
        showPage('subscription');
        return;
    }
    
    // Open trailer popup
    openTrailerPopup(movie);
    logToWatchHistory(mediaId);
}

/**
 * Logs a movie to the user's watch history
 * @param {string} mediaId The ID of the media to log
 */
function logToWatchHistory(mediaId) {
    if (!state.currentUser) return;
    fetch('api/add_to_history.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mediaId: mediaId })
    });
}

// Export functions if using modules (optional for direct script inclusion)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        renderMovies,
        renderMostLikedCategory,
        populateGrid,
        handleMovieGalleryClick,
        logToWatchHistory
    };
}