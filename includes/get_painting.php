<?php
include 'db_connect.php'; // Database connection file
header('Content-Type: application/json');

// Check if the paintingId is set in the GET request
if (!isset($_GET['paintingId'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Painting ID is required.'
    ]);
    exit;
}

$paintingId = $_GET['paintingId'];

try {
    // Prepare the SQL statement to fetch painting data
    $stmt = $pdo->prepare("SELECT * FROM Paintings WHERE PaintingID = :paintingId");
    $stmt->bindParam(':paintingId', $paintingId, PDO::PARAM_INT);
    $stmt->execute();

    // Check if a painting was found
    if ($stmt->rowCount() > 0) {
        $painting = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($painting); // Return painting data as JSON
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Painting not found.'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
