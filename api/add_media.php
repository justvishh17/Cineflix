<?php
// api/add_media.php

header('Content-Type: application/json');
require_once '../config/db_connect.php';

session_start(); // ✅ Needed for $_SESSION

// --- Security Check: Ensure user is super admin ---
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super_admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// --- Receive and Sanitize POST Data ---
$title = $_POST['title'] ?? '';
$year = $_POST['year'] ?? 0;
$rating = $_POST['rating'] ?? 0.0;
$poster = $_POST['poster'] ?? '';
$description = $_POST['description'] ?? '';
$exclusive = isset($_POST['exclusive']) && $_POST['exclusive'] === 'true' ? 1 : 0;
$type = $_POST['type'] ?? 'movie';


// --- Server-Side Validation ---
if (empty($title) || empty($year) || empty($poster) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

if (!is_numeric($year) || !is_numeric($rating)) {
    echo json_encode(['success' => false, 'message' => 'Year and Rating must be numeric.']);
    exit();
}

// --- Prepare and Execute SQL Statement ---
$sql = "INSERT INTO media (title, year, rating, poster, description, exclusive, type) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database prepare failed: ' . $conn->error]);
    exit();
}

// Bind parameters (s = string, i = integer, d = double)
$stmt->bind_param("sidssis", $title, $year, $rating, $poster, $description, $exclusive, $type);

// --- Return JSON Response ---
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Media added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add media: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>