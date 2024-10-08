<?php
include 'db_connect.php'; // Database connection file

// Check if POST data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paintingId = $_POST['paintingId'];
    $title = $_POST['title'];
    $artistId = $_POST['artistId'];
    $style = $_POST['style'];
    $media = $_POST['media'];
    $finished = $_POST['finished'];

    // Update the painting in the database
    $sql = "UPDATE Paintings SET Title = :title, ArtistID = :artistId, Style = :style, Media = :media, Finished = :finished WHERE PaintingID = :paintingId";
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':artistId', $artistId);
    $stmt->bindValue(':style', $style);
    $stmt->bindValue(':media', $media);
    $stmt->bindValue(':finished', $finished);
    $stmt->bindValue(':paintingId', $paintingId);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update painting.']);
    }
}
