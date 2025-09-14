<?php
// api/update_media.php

// Set the response header to JSON
header('Content-Type: application/json');

// Include the database connection, which also starts the session
require_once '../config/db_connect.php';

// --- Security Check: Ensure the user is an authenticated admin ---
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] === 'super_admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// --- Receive and Sanitize POST Data ---
$id = $_POST['id'] ?? 0;
$title = $_POST['title'] ?? '';
$year = $_POST['year'] ?? 0;
$rating = $_POST['rating'] ?? 0.0;
$poster = $_POST['poster'] ?? '';
$description = $_POST['description'] ?? '';
// Convert checkbox 'true'/'false' string from JS FormData to 1/0 for DB
$exclusive = (isset($_POST['exclusive']) && $_POST['exclusive'] === 'true') ? 1 : 0;
$type = $_POST['type'] ?? 'movie';

// --- Server-Side Validation ---
if (empty($id) || !is_numeric($id)) {
    echo json_encode(['success' => false, 'message' => 'A valid Media ID is required.']);
    exit();
}
if (empty($title) || empty($year) || empty($poster) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}
if (!is_numeric($year) || !is_numeric($rating)) {
    echo json_encode(['success' => false, 'message' => 'Year and Rating must be numeric.']);
    exit();
}

// --- Prepare the SQL UPDATE statement ---
$sql = "UPDATE media SET title = ?, year = ?, rating = ?, poster = ?, description = ?, exclusive = ?, type = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database prepare failed: ' . $conn->error]);
    exit();
}

// Bind parameters (s = string, i = integer, d = double)
$stmt->bind_param("sidssisi", $title, $year, $rating, $poster, $description, $exclusive, $type, $id);

// --- Execute the statement and respond ---
if ($stmt->execute()) {
    // Check if any row was actually updated.
    // Note: affected_rows can be 0 if the submitted data is the same as the existing data,
    // which is not an error. The execute() success is the main check.
    echo json_encode(['success' => true, 'message' => 'Media updated successfully.']);
} else {
    // The execute call failed
    echo json_encode(['success' => false, 'message' => 'Failed to update media: ' . $stmt->error]);
}

// --- Clean up ---
$stmt->close();
$conn->close();

?>