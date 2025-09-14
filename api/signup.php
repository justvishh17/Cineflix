<?php
// api/signup.php

// Set the response header to JSON
header('Content-Type: application/json');

// Include the database connection
require_once '../config/db_connect.php';

// --- Get data from the POST request ---
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// --- Server-Side Validation ---

// Check for empty fields
if (empty($username)) {
    echo json_encode(['success' => false, 'message' => 'Username is required.', 'field' => 'username']);
    exit();
}
if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required.', 'field' => 'email']);
    exit();
}
if (empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Password is required.', 'field' => 'password']);
    exit();
}

// Validate username length
if (strlen($username) < 3) {
    echo json_encode(['success' => false, 'message' => 'Username must be at least 3 characters.', 'field' => 'username']);
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.', 'field' => 'email']);
    exit();
}

// Validate password complexity (at least 8 chars, 1 uppercase, 1 lowercase, 1 number)
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Password must be 8+ characters, with an uppercase, lowercase, and number.', 'field' => 'password']);
    exit();
}

// --- Check if username or email already exists ---
$sql = "SELECT username, email FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $existingUser = $result->fetch_assoc();
    if ($existingUser['username'] === $username) {
        echo json_encode(['success' => false, 'message' => 'This username is already taken.', 'field' => 'username']);
    } else {
        echo json_encode(['success' => false, 'message' => 'This email is already registered.', 'field' => 'email']);
    }
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();


// --- Hash the password for secure storage ---
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


// --- Insert the new user into the database ---
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

// Bind parameters
$stmt->bind_param("sss", $username, $email, $hashedPassword);

// Execute the statement and provide a response
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Account created successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'An error occurred during registration. Please try again.']);
}

// --- Clean up ---
$stmt->close();
$conn->close();

?>