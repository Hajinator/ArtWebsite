<?php
// Database connection
include 'db_connect.php'; // Replace with your actual database connection file

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

$title = $data['title'];
$artist = $data['artist'];
$style = $data['style'];
$media = $data['media'];
$imageUrl = $data['imageUrl'];

// Get ArtistID from artist name (assuming Artist names are unique)
$queryArtist = $pdo->prepare("SELECT ArtistID FROM Artists WHERE Name = :artist");
$queryArtist->execute(['artist' => $artist]);
$artistId = $queryArtist->fetchColumn();

if ($artistId) {
    // Insert new painting
    $stmt = $pdo->prepare("INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID, ImagePath) VALUES (:title, :finished, :media, :style, :artistId, :imageUrl)");
    $result = $stmt->execute([
        'title' => $title,
        'finished' => date('Y'), // You can update this to reflect a proper 'finished' year input from the form
        'media' => $media,
        'style' => $style,
        'artistId' => $artistId,
        'imageUrl' => $imageUrl
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add painting.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Artist not found.']);
}
