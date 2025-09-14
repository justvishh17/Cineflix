<?php
// api/login.php

// Set the response header to JSON
header('Content-Type: application/json');

// Include the database connection script, which also starts the session
require_once '../config/db_connect.php';

// --- Get username and password from the POST request ---
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// --- Basic Validation ---
if (empty($username)) {
    echo json_encode(['success' => false, 'message' => 'Username or email is required.', 'field' => 'username']);
    exit();
}
if (empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Password is required.', 'field' => 'password']);
    exit();
}

// --- Prepare SQL statement to find the user by username OR email ---
// This prevents SQL injection attacks and allows login with either username or email
$sql = "SELECT id, username, email, password, role, subscription FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

// Bind the username parameter for both username and email fields
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();

// --- Verify User and Password ---
if ($result->num_rows === 1) {
    // A user with that username was found, now fetch their data
    $user = $result->fetch_assoc();

    // Securely verify the submitted password against the stored hash
    if (password_verify($password, $user['password'])) {
        // Passwords match! The user is authenticated.
        
        // Store user data in the session to keep them logged in
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'subscription' => $user['subscription']
        ];

        // Send a success response with user data back to the JavaScript
        echo json_encode([
            'success' => true, 
            'message' => 'Login successful!',
            'user' => $_SESSION['user']
        ]);
    } else {
        // The password was incorrect
        echo json_encode(['success' => false, 'message' => 'Incorrect password. Please try again.', 'field' => 'password']);
    }
} else {
    // No user was found with the provided username or email
    echo json_encode(['success' => false, 'message' => 'No user found with that username or email.', 'field' => 'username']);
}

// --- Clean up ---
$stmt->close();
$conn->close();

?>