<?php
// api/update_user.php

header('Content-Type: application/json');
require_once '../db_connect.php';

// Security: ONLY a 'super_admin' can perform this action
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] !== 'super_admin')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}


$userId = $_POST['id'] ?? 0;
$role = $_POST['role'] ?? 'user';
$subscription = $_POST['subscription'] ?? 'None';
$superAdminMakingChangeId = $_SESSION['user']['id'];

// Validation
if (empty($userId) || !is_numeric($userId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid User ID.']);
    exit();
}

// A super_admin cannot demote their own account. They must be demoted by another super_admin.
if ($userId == $superAdminMakingChangeId && $role !== 'super_admin') {
    echo json_encode(['success' => false, 'message' => 'Error: You cannot remove your own super admin status.']);
    exit();
}

// Prepare and execute the update
$sql = "UPDATE users SET role = ?, subscription = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $role, $subscription, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
}

$stmt->close();
$conn->close();
?>