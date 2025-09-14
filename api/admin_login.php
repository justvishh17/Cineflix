<?php
// api/admin_login.php
header('Content-Type: application/json');
require_once '../db_connect.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
    exit();
}

// --- START: The Fix ---
// The query now checks if the role is IN the list ('admin', 'super_admin')
$sql = "SELECT id, username, password, role, subscription FROM users WHERE username = ? AND role IN ('super_admin')";
// --- END: The Fix ---

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'subscription' => $user['subscription']
        ];
        echo json_encode(['success' => true, 'message' => 'Admin login successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials or not an admin account.']);
}

$stmt->close();
$conn->close();
?>