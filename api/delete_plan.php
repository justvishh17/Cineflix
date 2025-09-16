<?php
// api/delete_plan.php

header('Content-Type: application/json');
require_once '../db_connect.php';

// --- Security Check: Only a super_admin can delete plans ---
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super_admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access. Super admin permission required.']);
    exit();
}

// --- Get the Plan ID from the POST request ---
// We expect the data to be sent as JSON, so we decode the request body.
$data = json_decode(file_get_contents('php://input'));
$planId = $data->id ?? null;

// --- Validate the received ID ---
if (empty($planId) || !is_numeric($planId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing Plan ID.']);
    exit();
}

// --- Prepare the SQL DELETE statement to prevent SQL injection ---
$sql = "DELETE FROM plans WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database prepare failed: ' . $conn->error]);
    exit();
}

// Bind the integer ID parameter
$stmt->bind_param("i", $planId);

// --- Execute the statement and respond accordingly ---
if ($stmt->execute()) {
    // Check if any row was actually deleted
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Plan deleted successfully.']);
    } else {
        // No rows were affected, meaning the ID was not found
        echo json_encode(['success' => false, 'message' => 'Plan not found or already deleted.']);
    }
} else {
    // The execute call failed for some reason
    echo json_encode(['success' => false, 'message' => 'Failed to delete plan: ' . $stmt->error]);
}

// --- Clean up and close connections ---
$stmt->close();
$conn->close();

?>