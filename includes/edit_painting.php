<?php
include 'db_connect.php'; // Database connection file

header('Content-Type: application/json');
include 'db_connect.php'; // Database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $paintingId = $_POST['paintingId'] ?? null;
    $title = $_POST['title'] ?? null;
    $artistId = $_POST['artistId'] ?? null;
    $style = $_POST['style'] ?? null;
    $media = $_POST['media'] ?? null;
    $finished = $_POST['finished'] ?? null;

    // Check that all required fields are present
    if (empty($paintingId) || empty($title) || empty($artistId) || empty($style) || empty($media) || empty($finished)) {
        echo json_encode(["message" => "All fields are required."]);
        exit;
    }

    try {
        // Prepare the SQL update statement
        $stmt = $pdo->prepare("UPDATE Paintings SET Title = :title, ArtistID = :artistId, Style = :style, Media = :media, Finished = :finished WHERE PaintingID = :paintingId");

        // Bind values
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':artistId', $artistId);
        $stmt->bindValue(':style', $style);
        $stmt->bindValue(':media', $media);
        $stmt->bindValue(':finished', $finished);
        $stmt->bindValue(':paintingId', $paintingId, PDO::PARAM_INT);

        // Execute and check for errors
        if ($stmt->execute()) {
            echo json_encode(["message" => "Painting updated successfully."]);
        } else {
            echo json_encode(["message" => "Error updating painting"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["message" => "Database error: " . $e->getMessage()]);
    }
}