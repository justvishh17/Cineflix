<?php
// api/subscribe.php (Corrected Version)
header('Content-Type: application/json');
require_once '../db_connect.php';

// --- Security Check: Ensure a user is logged in ---
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to subscribe.']);
    exit();
}

// --- Get the plan and user ID ---
$selectedPlan = $_POST['plan'] ?? '';
$userId = $_SESSION['user']['id'];

// --- Validate the received plan ---
$validPlans = ['Basic', 'Standard', 'Diamond', 'Diamond+', 'Basic Annual', 'Standard Annual', 'Diamond Annual', 'Diamond+ Annual'];
if (empty($selectedPlan) || !in_array($selectedPlan, $validPlans)) {
    echo json_encode(['success' => false, 'message' => 'Invalid subscription plan selected.']);
    exit();
}

// --- Prepare and execute the subscription UPDATE statement ---
$sql = "UPDATE users SET subscription = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// --- THIS LINE IS NOW CORRECT ---
// It now correctly binds both the plan name (string) and the user ID (integer).
$stmt->bind_param("si", $selectedPlan, $userId);

// --- Execute the statement and respond ---
if ($stmt->execute()) {
    // The subscription update was successful.
    $_SESSION['user']['subscription'] = $selectedPlan;

    // --- START: Payment Logging Code ---
    $planPrice = $_POST['price'] ?? 0.00;
    $paymentMethod = $_POST['method'] ?? 'Unknown';
    $transactionId = "CFLIX-" . uniqid();

    $paymentStmt = $conn->prepare("INSERT INTO payments (user_id, plan_name, amount, payment_method, transaction_id) VALUES (?, ?, ?, ?, ?)");
    $paymentStmt->bind_param("isdss", $userId, $selectedPlan, $planPrice, $paymentMethod, $transactionId);
    $paymentStmt->execute();
    $paymentStmt->close();
    // --- END: Payment Logging Code ---

    echo json_encode(['success' => true, 'message' => 'Subscription updated successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update subscription: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>