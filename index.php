
<?php
    require_once 'db_connect.php';

    // This new query joins the media and likes tables to count the likes for each movie.
    $sql = "
        SELECT
            m.*,
            COUNT(l.media_id) AS like_count
        FROM
            media m
        LEFT JOIN
            likes l ON m.id = l.media_id
        GROUP BY
            m.id
        ORDER BY
            m.id DESC;
    ";
    

    $media_result = $conn->query($sql);
    $all_media = [];
    if ($media_result && $media_result->num_rows > 0) {
        while($row = $media_result->fetch_assoc()) {
            $all_media[] = $row;
        }
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineFlix - Your Movie Universe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    
   <script>
        const allMedia = <?php echo json_encode($all_media); ?>;
        const currentUser = <?php echo isset($_SESSION['user']) ? json_encode($_SESSION['user']) : 'null'; ?>;
    </script>

    <div id="home-page" class="page active">
        <header>
            <nav>
                <div class="nav-logo" onclick="showPage('home')">
                    <i class="fas fa-popcorn"></i>
                    <span>CineFlix</span>
                </div>
                <div class="nav-links" id="nav-links"></div>
            </nav>
        </header>
        <main>
<div id="user-dashboard-page" class="page">
    <i class="fas fa-arrow-left back-arrow" onclick="showPage('home')"></i>
    <header>
        <nav>
            <div class="nav-logo" onclick="showPage('home')">
                <i class="fas fa-popcorn"></i>
                <span>CineFlix</span>
            </div>
            <div class="nav-links" id="dashboard-nav-links"></div>
        </nav>
    </header>
    <main class="admin-dashboard-container text-white" style="padding-top: 100px;">
        <div class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gray-800 rounded-lg mb-8">
            <img id="dash-profile-pic" src="" alt="Profile Picture" class="w-32 h-32 rounded-full border-4 border-gray-600">
            <div>
                <h1 id="dash-username" class="text-3xl font-bold">Username</h1>
                <p id="dash-email" class="text-gray-400">email@example.com</p>
                <div class="mt-4">
                    <span id="dash-sub-status" class="text-lg font-semibold text-yellow-400">Subscription: None</span>
                    <button id="cancel-sub-btn" class="btn btn-secondary ml-4 hidden">Cancel Subscription</button>
                </div>
            </div>
        </div>
        
        <div class="dashboard-section">
            <h2 class="text-2xl font-bold mb-4">Watch History</h2>
            <div id="watch-history-grid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                </div>
        </div>
    </main>
</div>
            <section class="hero-section">
                <h1 class="text-4xl md:text-5xl font-bold">Discover Movies & Series</h1>
                <p class="mt-4 text-lg">Stream anywhere. Cancel anytime.</p>
                 <button id="ai-assistant-btn" class="btn ai-button mt-6">✨ AI Assistant</button>
            </section>
            <section id="movie-gallery-container" class="movie-gallery">
                <div class="movie-category">
                    <section id="movie-gallery-container" class="movie-gallery">

    <div id="wishlist-category" class="movie-category" style="display: none;">
        <h2 class="text-2xl font-bold mb-4">My Wishlist ❤️</h2>
        <div id="wishlist-home-grid" class="movie-grid"></div>
    </div>
    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">Anime✨</h2>
        <div id="anime-grid" class="movie-grid"></div>
    </div>

    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">comedy movies😁</h2>
        <div id="comedy-grid" class="movie-grid"></div>
    </div>

    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">Hollywood✨</h2>
        <div id="movie-grid" class="movie-grid"></div>
    </div>

    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">Bollywood</h2>
        <div id="bollywood-grid" class="movie-grid"></div>
    </div>

    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">Web Series🏆</h2>
        <div id="web-series-grid" class="movie-grid"></div>
    </div>

    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">Most Viewed</h2>
        <div id="most-viewed-grid" class="movie-grid"></div>
    </div>
    
    <div class="movie-category">
        <h2 class="text-2xl font-bold mb-4">All Movies & Series</h2>
        <div id="all-movies-grid" class="movie-grid"></div>
    </div>
            </section>
        </main>
    </div>
    <div id="wishlist-page" class="page">
    <i class="fas fa-arrow-left back-arrow" onclick="showPage('home')"></i>

    <div class="wishlist-header">
        <div class="wishlist-header-overlay">
            <h1 class="text-5xl font-bold uppercase tracking-wider">My Wishlist</h1>
        </div>
    </div>

    <main class="wishlist-container">
        <div id="wishlist-grid" class="movie-grid">
            </div>

        <div id="wishlist-empty" class="hidden text-center py-16">
            <i class="fas fa-film text-6xl text-gray-600 mb-4"></i>
            <h2 class="text-3xl font-bold">Your Wishlist is Empty</h2>
            <p class="text-gray-400 mt-2">Add movies and series you want to watch by clicking the 'Wishlist' button on any title.</p>
        </div>
    </main>
</div>

    <div id="login-page" class="page">
        <div class="auth-container">
            <i class="fas fa-arrow-left back-arrow" onclick="showPage('home')"></i>
            <form id="login-form" class="auth-form" novalidate autocomplete="off">
                <h2 class="text-2xl font-bold text-center mb-6">User Login</h2>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="login-username"  name="username" placeholder="Username" required autocomplete="new-password">
                </div>
                <div class="error-message" id="login-username-error"></div>
                <div class="input-group relative">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="login-password" name="password" placeholder="Password" required autocomplete="new-password">
                    <span class="password-toggle absolute right-12 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 "><i class="fas fa-eye"></i></span>
                </div>
                <div class="error-message" id="login-password-error"></div>
                <button type="submit" class="btn">Login</button>
                <p class="auth-switch">Don't have an account? <a onclick="showPage('signup')">Sign Up</a></p>
                <p class="auth-switch">Are you an admin? <a onclick="showPage('admin-login')">Admin Login</a></p>
            </form>
        </div>
    </div>
    
    <div id="signup-page" class="page">
        <div class="auth-container">
            <i class="fas fa-arrow-left back-arrow" onclick="showPage('login')"></i>
            <form id="signup-form" class="auth-form" novalidate autocomplete="off">
                <h2 class="text-2xl font-bold text-center mb-6">Create Account</h2>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="signup-username"  name="username" placeholder="Username" required minlength="3">
                </div>
                <div class="error-message" id="signup-username-error"></div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="signup-email" name="email" placeholder="Email ID" required>
                </div>
                 <div class="error-message" id="signup-email-error"></div>
                <div class="input-group relative">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="signup-password" name="password" placeholder="Password" required autocomplete="new-password">
                    <span class="password-toggle absolute right-12 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 "><i class="fas fa-eye"></i></span>
                </div>
                <div class="error-message" id="signup-password-error"></div>
                <div class="input-group relative">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="signup-confirm-password" name="confirm-password" placeholder="Re-write Password" required autocomplete="new-password">
                    <span class="password-toggle absolute right-12 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 "><i class="fas fa-eye"></i></span>
                </div>
                <div class="error-message" id="signup-confirm-password-error"></div>
                <button type="submit" class="btn">Sign Up</button>
                <p class="auth-switch">Already have an account? <a onclick="showPage('login')">Login</a></p>
            </form>
        </div>
    </div>
    
    <div id="admin-login-page" class="page">
         <div class="auth-container">
            <i class="fas fa-arrow-left back-arrow" onclick="showPage('home')"></i>
            <form id="admin-login-form" class="auth-form" novalidate autocomplete="off">
                <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>
                <p class="admin-login-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                This is a restricted area, only for authorized persons!.
                </p>
                <div class="input-group">
                    <i class="fas fa-user-shield"></i>
                    <input type="text" id="admin-username" name="username" placeholder="Admin Username" required autocomplete="new-password">
                </div>
                <div class="input-group relative">
                    <i class="fas fa-key"></i>
                    <input type="password" id="admin-password" name="password" placeholder="Password" required autocomplete="new-password">
                    <span class="password-toggle absolute right-12 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 "><i class="fas fa-eye"></i></span>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
    
    <div id="subscription-page" class="page">
        <i class="fas fa-arrow-left back-arrow" onclick="showPage('home')"></i>
        <div class="subscription-container">
            <h1 class="text-4xl md:text-5xl font-bold">Choose The Plan That's Right For You</h1>
            <p class="mt-4 text-lg text-gray-400">Join CineFlix and watch on any device, anytime.</p>
            <div class="plan-cards">
                <div class="plan-card" data-plan="Basic" data-price="9.99">
                     <h3 class="text-2xl font-bold">Basic</h3>
                     <p class="text-4xl font-bold my-4">$9.99<span class="text-lg font-normal text-gray-400">/mo</span></p>
                     <ul class="text-left space-y-3 flex-grow">
                         <li><i class="fas fa-check text-green-500 mr-2"></i>Good video quality (720p)</li>
                         <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 1 device at a time</li>
                         <li><i class="fas fa-times text-red-500 mr-2"></i>No downloads</li>
                     </ul>
                     <button class="btn">Select Plan</button>
                </div>
                <div class="plan-card" data-plan="Standard" data-price="15.99">
                    <h3 class="text-2xl font-bold">Standard</h3>
                    <p class="text-4xl font-bold my-4">$15.99<span class="text-lg font-normal text-gray-400">/mo</span></p>
                    <ul class="text-left space-y-3 flex-grow">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Great video quality (1080p)</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 2 devices at once</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Downloads on 2 devices</li>
                    </ul>
                    <button class="btn">Select Plan</button>
                </div>
                <div class="plan-card popular" data-plan="Diamond" data-price="19.99">
                    <div class="popular-badge">Most Popular</div>
                    <h3 class="text-2xl font-bold">Diamond</h3>
                    <p class="text-4xl font-bold my-4">$19.99<span class="text-lg font-normal text-gray-400">/mo</span></p>
                    <ul class="text-left space-y-3 flex-grow">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Best video quality (4K+HDR)</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 4 devices at once</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Downloads on 4 devices</li>
                    </ul>
                    <button class="btn">Select Plan</button>
                </div>
                <div class="plan-card" data-plan="Diamond+" data-price="25.99">
                    <h3 class="text-2xl font-bold">Diamond+</h3>
                    <p class="text-4xl font-bold my-4">$25.99<span class="text-lg font-normal text-gray-400">/mo</span></p>
                    <ul class="text-left space-y-3 flex-grow">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Ultimate video quality (4K+HDR)</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 6 devices at once</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Downloads on 6 devices</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Early access to new releases</li>
                    </ul>
                    <button class="btn">Select Plan</button>
                    
                </div>
                <h2 class="text-3xl font-bold w-full text-center mt-16 mb-4">Annual Plans (Save over 15%)</h2>

                <div class="plan-card" data-plan="Basic Annual" data-price="99.99">
                    <h3 class="text-2xl font-bold">Basic Annual</h3>
                    <p class="text-4xl font-bold my-4">$99.99<span class="text-lg font-normal text-gray-400">/year</span></p>
                    <ul class="text-left space-y-3 flex-grow">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Good video quality (720p)</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 1 device at a time</li>
                        <li><i class="fas fa-times text-red-500 mr-2"></i>No downloads</li>
                    </ul>
                <button class="btn">Select Plan</button>
                </div>

<div class="plan-card" data-plan="Standard Annual" data-price="159.99">
    <h3 class="text-2xl font-bold">Standard Annual</h3>
    <p class="text-4xl font-bold my-4">$159.99<span class="text-lg font-normal text-gray-400">/year</span></p>
    <ul class="text-left space-y-3 flex-grow">
        <li><i class="fas fa-check text-green-500 mr-2"></i>Great video quality (1080p)</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 2 devices at once</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Downloads on 2 devices</li>
    </ul>
    <button class="btn">Select Plan</button>
</div>

<div class="plan-card" data-plan="Diamond Annual" data-price="199.99">
    <h3 class="text-2xl font-bold">Diamond Annual</h3>
    <p class="text-4xl font-bold my-4">$199.99<span class="text-lg font-normal text-gray-400">/year</span></p>
    <ul class="text-left space-y-3 flex-grow">
        <li><i class="fas fa-check text-green-500 mr-2"></i>Best video quality (4K+HDR)</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 4 devices at once</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Downloads on 4 devices</li>
    </ul>
    <button class="btn">Select Plan</button>
</div>
<div class="plan-card" data-plan="Diamond+ Annual" data-price="259.99">
    <h3 class="text-2xl font-bold">Diamond+ Annual</h3>
    <p class="text-4xl font-bold my-4">$259.99<span class="text-lg font-normal text-gray-400">/year</span></p>
    <ul class="text-left space-y-3 flex-grow">
        <li><i class="fas fa-check text-green-500 mr-2"></i>Ultimate video quality (4K+HDR)</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Watch on 6 devices at once</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Downloads on 6 devices</li>
        <li><i class="fas fa-check text-green-500 mr-2"></i>Early access to new releases</li>
    </ul>
    <button class="btn">Select Plan</button>
</div>
            </div>
        </div>
    </div>

    <div id="payment-page" class="page">
        <div class="auth-container">
            <i class="fas fa-arrow-left back-arrow" onclick="showPage('subscription')"></i>
            <form id="payment-form" class="auth-form" autocomplete="off">
    <h2 class="text-2xl font-bold text-center mb-6">Complete Your Purchase</h2>
    <p class="mb-5 text-center">You selected: <strong id="selected-plan-text" class="text-yellow-400"></strong></p>
    
    <div class="input-group"><i class="fas fa-envelope"></i><input type="email" placeholder="Email for receipt" required></div>
    <div class="input-group"><i class="fas fa-mobile-alt"></i><input type="tel" pattern="[0-9]{10}" placeholder="Mobile Number" required></div>
    
    <div class="input-group">
        <i class="fas fa-credit-card"></i>
        <select id="payment-method" required>
            <option value="" disabled selected>Select Payment Method</option>
            <option value="credit-card">Credit Card</option>
            <option value="debit-card">Debit Card</option>
            <option value="paypal">PayPal</option>
            <option value="upi">UPI</option>
        </select>
    </div>

    <div id="dynamic-payment-fields">
        <div id="card-details" class="payment-field hidden">
            <div class="input-group"><i class="fas fa-credit-card"></i><input type="text" id="card-number" pattern="[0-9]{16}" placeholder="Card Number (16 digits)" ></div>
            <div class="grid grid-cols-2 gap-4">
                <div class="input-group"><i class="fas fa-calendar-alt"></i><input type="text" id="expiry-date" pattern="(0[1-9]|1[0-2])\/([0-9]{2})" placeholder="Expiry (MM/YY)"></div>
                <div class="input-group"><i class="fas fa-lock"></i><input type="text" id="cvv" pattern="[0-9]{3,4}" placeholder="CVV"></div>
            </div>
        </div>

        <div id="upi-details" class="payment-field hidden">
            <div class="input-group"><i class="fas fa-mobile-alt"></i><input type="text" id="upi-id" placeholder="Enter UPI ID (e.g., user@bank)"></div>
        </div>
    </div>
    <button type="submit" class="btn">Pay Now</button>
</form>
        </div>
    </div>

    <div id="admin-dashboard-page" class="page">
        <header class="admin-header">
            <i class="fas fa-arrow-left back-arrow" onclick="showPage('home')"></i>
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <button class="btn btn-secondary" data-action="logout">Logout</button>
        </header>
        <main class="admin-dashboard-container">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-800 p-6 rounded-lg text-center">
                    <h3 class="text-lg text-gray-400">Total Users</h3>
                    <p id="total-users" class="text-4xl font-bold mt-2">0</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg text-center">
                    <h3 class="text-lg text-gray-400">Total Subscriptions</h3>
                    <p id="total-subs" class="text-4xl font-bold mt-2">0</p>
                </div>
            </div>
            <div class="dashboard-section">
                <h2 class="text-2xl font-bold mb-4">Manage Users</h2>
                <div class="overflow-x-auto">
                    <table id="users-table" class="min-w-full">

                    <div id="wishlist-category" class="movie-category" style="display: none;">
        <h2 class="text-2xl font-bold mb-4">My Wishlist ❤️</h2>
        <div id="wishlist-home-grid" class="movie-grid"></div>
    </div>
    <thead>
        <tr>
            <th class="p-3">Username</th>
            <th class="p-3">Email</th>
            <th class="p-3">Subscription</th>
            <th class="p-3">Role</th>
            <th class="p-3">Actions</th> </tr>
    </thead>
    <tbody></tbody>
</table>
                </div>
            </div>
             <div class="dashboard-section">
                <h2 class="text-2xl font-bold mb-4">Manage Media</h2>
                <div class="overflow-x-auto">
                    <table id="media-table" class="min-w-full">
                        <thead><tr>
                        <th class="p-3">Poster</th>
                        <th class="p-3">Title</th>
                        <th class="p-3">Year</th>
                        <th class="p-3">Rating</th>
                        <th class="p-3">Exclusive</th>
                        <th class="p-3">Actions</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="dashboard-section">
                <h2 class="text-2xl font-bold mb-4">Add New Media</h2>
                <form id="add-media-form" class="auth-form max-w-none">
                     <input type="text" id="add-media-title" class="w-full p-2 mb-4 bg-gray-800 rounded" placeholder="Title" required>
                     <input type="number" id="add-media-year" class="w-full p-2 mb-4 bg-gray-800 rounded" placeholder="Year" required>
                     <input type="text" id="add-media-rating" class="w-full p-2 mb-4 bg-gray-800 rounded" placeholder="Rating" required>
                     <input type="text" id="add-media-poster" class="w-full p-2 mb-4 bg-gray-800 rounded" placeholder="Poster Image URL" required>
                     <textarea id="add-media-desc" class="w-full p-2 mb-4 bg-gray-800 rounded" placeholder="Description" required></textarea>
                     <input type="text" id="add-media-trailer" class="w-full p-2 mb-4 bg-gray-800 rounded" placeholder="Trailer URL">
                     <button type="button" id="add-generate-desc-btn" class="btn ai-button w-full mb-4">✨ Generate Description</button>
                     <label class="flex items-center gap-2 mb-4"><input type="checkbox" id="add-media-exclusive"> Is Exclusive?</label>
                      <label class="flex items-center gap-2 mb-4"><input type="checkbox" id="add-media-type"> Is Web Series?</label>
                     <button type="submit" class="btn">Add Media</button>
                </form>
            </div>
        </main>
    </div>

    <div id="success-popup" class="popup">
        <div class="popup-content">
            <span class="close-popup" onclick="closePopupAndGoHome()">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Subscribed Successfully! 🎉</h2>
            <p>You now have access to all exclusive content.</p>
            <a href="#" class="btn mt-4" onclick="closePopupAndGoHome()">Go to Home</a>
        </div>
    </div>

    <div id="success-popup" class="popup">
        <div class="popup-content">
            <span class="close-popup" onclick="closePopupAndGoHome()">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Unsubscribed 😔</h2>
            <p>Your subscription has been successfully cancelled.</p>
            <a href="#" class="btn mt-4" onclick="closePopupAndGoHome()">Go to Home</a>
        </div>
    </div>
    
    <div id="ai-assistant-modal" class="popup">
        <div class="modal-content">
            <span class="close-popup" id="close-ai-modal">&times;</span>
            <h2 class="text-2xl font-bold mb-4">CineFlix AI Assistant ✨</h2>
            <p class="mb-4 text-gray-400">What are you in the mood for? Ask me for a recommendation!</p>
            <div class="flex gap-2">
                <input type="text" id="ai-prompt-input" class="flex-grow bg-gray-700 text-white rounded p-2" placeholder="e.g., a sci-fi movie from the 90s">
                <button id="ai-prompt-submit" class="btn ai-button">Ask</button>
            </div>
            <p id="ai-response-area" class="mt-4 text-gray-300"></p>
        </div>
    </div>
    <div id="edit-user-modal" class="popup">
    <div class="popup-content">
        <span class="close-popup" onclick="this.parentElement.parentElement.classList.remove('active')">&times;</span>
        <h2 class="text-2xl font-bold mb-4">Edit User</h2>
        <form id="edit-user-form" class="auth-form max-w-none text-left">
            <input type="hidden" id="edit-user-id">

            <label>Username</label>
            <input type="text" id="edit-user-username" class="w-full p-2 mb-4 bg-gray-800 rounded" readonly>

            <label>Subscription Plan</label>
            <select id="edit-user-subscription" class="w-full p-2 mb-4 bg-gray-800 rounded">
                <option value="None">None</option>
                <option value="Basic">Basic</option>
                <option value="Standard">Standard</option>
                <option value="Diamond">Diamond</option>
                <option value="Diamond+">Diamond+</option>
            </select>

            <label>Role</label>
            <select id="edit-user-role" class="w-full p-2 mb-4 bg-gray-800 rounded">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

    <div id="edit-media-modal" class="popup">
        <div class="popup-content">
            <span class="close-popup" onclick="this.parentElement.parentElement.classList.remove('active')">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Edit Media</h2>
            <form id="edit-media-form" class="auth-form max-w-none text-left">
                <input type="hidden" id="edit-media-id">
                <label>Title</label><input type="text" id="edit-media-title" class="w-full p-2 mb-4 bg-gray-800 rounded" required>
                <label>Year</label><input type="number" id="edit-media-year" class="w-full p-2 mb-4 bg-gray-800 rounded" required>
                <label>Rating</label><input type="text" id="edit-media-rating" class="w-full p-2 mb-4 bg-gray-800 rounded" required>
                <label>Poster URL</label><input type="text" id="edit-media-poster" class="w-full p-2 mb-4 bg-gray-800 rounded" required>
                <label>Description</label><textarea id="edit-media-desc" class="w-full p-2 mb-4 bg-gray-800 rounded" required></textarea>
                <label>Trailer URL</label><input type="text" id="edit-media-trailer" class="w-full p-2 mb-4 bg-gray-800 rounded">
                <button type="button" id="edit-generate-desc-btn" class="btn ai-button w-full mb-4">✨ Generate Description</button>
                <label class="flex items-center gap-2 mb-4"><input type="checkbox" id="edit-media-exclusive"> Is Exclusive?</label>
                <label class="flex items-center gap-2 mb-4"><input type="checkbox" id="edit-media-type"> Is Web Series?</label>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <div id="info-popup" class="popup">
        <div class="popup-content">
            <span class="close-popup" onclick="this.parentElement.parentElement.classList.remove('active')">&times;</span>
            <h2 id="info-popup-title" class="text-2xl font-bold mb-4">AI Suggestions</h2>
            <div id="info-popup-text" class="text-left text-lg"></div>
        </div>
    </div>
    <div id="confirm-modal" class="popup">
    <div class="popup-content">
        <h2 class="text-2xl font-bold mb-4">Are you sure?</h2>
        <p id="confirm-message" class="mb-6 text-gray-300"></p>
        <div class="flex justify-center gap-4">
            <button id="confirm-no-btn" class="btn btn-secondary">Cancel</button>
            <button id="confirm-yes-btn" class="btn">Confirm</button>
        </div>
    </div>
</div>
<div id="trailer-modal" class="popup">
        <div class="trailer-popup-content">
            <span class="close-popup" onclick="closeTrailerPopup()">&times;</span>
            <div class="trailer-header">
                <h2 id="trailer-title" class="text-2xl font-bold mb-2">Movie Title</h2>
                <p id="trailer-year" class="text-gray-400 mb-4">Year</p>
            </div>
            <div class="trailer-container">
                <iframe id="trailer-iframe" src="" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    
    <script src="js/script.js"></script>
    <div id="custom-alert" class="custom-alert"><p id="custom-alert-message"></p></div>

</body>
</html>