# JavaScript Module Structure

The original `script.js` file has been refactored into multiple, more manageable modules for better organization and maintainability.

## Module Overview

### 1. `utilities.js` - Core Utility Functions

- **Purpose**: Contains reusable utility functions used across the application
- **Key Functions**:
  - `showCustomConfirm()` - Custom confirmation dialog
  - `showCustomAlert()` - Custom alert messages
  - `setupPasswordToggles()` - Password show/hide functionality
  - `showPage()` - Page navigation utility
  - `closePopupAndGoHome()` - Success popup handler

### 2. `auth.js` - Authentication Module

- **Purpose**: Handles all user authentication and session management
- **Key Functions**:
  - `updateHeaderUI()` - Updates navigation based on user status
  - `handleLogin()` - User login form handler
  - `handleSignup()` - User registration handler
  - `handleLogout()` - User logout handler
  - `handleAdminLogin()` - Admin login handler

### 3. `movie-manager.js` - Movie Display Module

- **Purpose**: Manages movie rendering, filtering, and display logic
- **Key Functions**:
  - `renderMovies()` - Renders all movie categories
  - `populateGrid()` - Populates movie grids with data
  - `handleMovieGalleryClick()` - Handles movie card interactions
  - `renderMostLikedCategory()` - Renders most liked movies
  - `logToWatchHistory()` - Logs movie views to history

### 4. `user-dashboard.js` - User Features Module

- **Purpose**: Handles user dashboard, wishlist, and subscription management
- **Key Functions**:
  - `renderUserDashboard()` - Displays user dashboard
  - `renderWishlistPage()` - Displays wishlist page
  - `handleWishlistClick()` - Adds items to wishlist
  - `handleRemoveFromWishlist()` - Removes items from wishlist
  - `handlePlanSelection()` - Subscription plan selection
  - `handlePayment()` - Payment processing
  - `handleCancelSubscription()` - Subscription cancellation

### 5. `admin-dashboard.js` - Admin Features Module

- **Purpose**: Contains all admin-specific functionality
- **Key Functions**:
  - `renderAdminDashboard()` - Displays admin dashboard
  - `handleAddMedia()` - Adds new media content
  - `handleEditMedia()` - Edits existing media
  - `handleMediaTableClick()` - Media table interactions
  - `handleUsersTableClick()` - User management table interactions
  - `setupAdminEventListeners()` - Admin-specific event handlers

### 6. `ai-assistant.js` - AI Features Module

- **Purpose**: Handles AI-powered features for recommendations and content generation
- **Key Functions**:
  - `callGeminiAPI()` - Core API communication with Google Gemini
  - `handleAIAssistant()` - Movie recommendation assistant
  - `handleGetAiSummary()` - Generates AI movie summaries
  - `handleGenerateDescription()` - Generates descriptions for admin forms
  - `handleFindSimilar()` - Similar movie finder (placeholder)

### 7. `main.js` - Application Coordinator

- **Purpose**: Main application entry point and event coordination
- **Key Functions**:
  - `setupEventListeners()` - Sets up all application event listeners
  - Global state management
  - Application initialization
  - Cross-module function exposure for HTML onclick handlers

## Loading Order

The modules are loaded in a specific order to handle dependencies:

1. `utilities.js` - Base utilities needed by all modules
2. `auth.js` - Authentication functions
3. `movie-manager.js` - Movie display logic
4. `user-dashboard.js` - User-specific features
5. `admin-dashboard.js` - Admin-specific features
6. `ai-assistant.js` - AI features
7. `main.js` - Application coordinator and initialization

## Global Variables

- `movies` - Array of all media content from the database
- `state` - Application state object containing:
  - `currentUser` - Current logged-in user data
  - `selectedPlan` - Currently selected subscription plan

## Benefits of This Structure

1. **Maintainability**: Each module has a clear, focused responsibility
2. **Readability**: Smaller files are easier to navigate and understand
3. **Debugging**: Issues can be quickly isolated to specific modules
4. **Collaboration**: Multiple developers can work on different modules simultaneously
5. **Testing**: Individual modules can be tested in isolation
6. **Code Reuse**: Utility functions are centralized and reusable

## Working with the Modules

### Adding New Features

- Identify which module the new feature belongs to
- Add the function to the appropriate module
- Update the module's export list if using ES6 modules
- Add event listeners in the appropriate setup function

### Debugging

- Use browser dev tools to identify which module contains the issue
- Each module is clearly labeled with comments for easy identification
- Console errors will show the specific file where the issue occurred

### Future Improvements

- Consider converting to ES6 modules for better dependency management
- Add TypeScript for better type safety
- Implement unit tests for each module
- Add JSDoc documentation for all functions
