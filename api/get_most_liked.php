<?php
// api/get_most_liked.php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

// This SQL query counts the likes for each movie and returns the top 10.
$sql = "
    SELECT
        m.*,
        COUNT(l.media_id) AS like_count
    FROM
        media m
    LEFT JOIN
        likes l ON m.id = l.media_id
    GROUP BY
        m.id
    ORDER BY
        like_count DESC
    LIMIT 10;
";

$result = $conn->query($sql);
$mostLiked = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mostLiked[] = $row;
    }
}

echo json_encode(['success' => true, 'data' => $mostLiked]);
$conn->close();
?>