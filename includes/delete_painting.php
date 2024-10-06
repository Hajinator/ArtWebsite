<?php
//This script handles the deletion of paintings.

include 'db_connect.php'; //Include database connection

//set contents to JSON
header('Content-Type: application/json');

// Decode JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the 'paintingId' is present in the request data.
if (!isset($data['paintingId'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Artist ID is required.'
    ]);
    exit;
}

// Extract paintingId
$paintingId = $data['paintingId'] ?? null;

try {
    //Prepare teh delete statemant
    $stmt = $pdo->prepare("DELETE FROM paintings WHERE PaintingID = :paintingId");
    $stmt->bindParam(':paintingId', $paintingId, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Painting deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Painting not found or already deleted.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete painting.'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}