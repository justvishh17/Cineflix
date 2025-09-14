<?php
// api/delete_user.php

header('Content-Type: application/json');
require_once '../config/db_connect.php';

// Security: Only admins can perform this action
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] === 'super_admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// --- Get the User ID from the POST request (JSON format) ---
$data = json_decode(file_get_contents('php://input'), true);
$userIdToDelete = $data['id'] ?? 0;
$adminUserId = $_SESSION['user']['id'];

// Security: Prevent an admin from deleting their own account
if ($userIdToDelete == $adminUserId) {
    echo json_encode(['success' => false, 'message' => 'You cannot delete your own admin account.']);
    exit();
}
if (empty($userIdToDelete) || !is_numeric($userIdToDelete)) {
    echo json_encode(['success' => false, 'message' => 'Invalid User ID provided.']);
    exit();
}

// Prepare and execute the deletion
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userIdToDelete);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found or already deleted.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
}

$stmt->close();
$conn->close();
?>