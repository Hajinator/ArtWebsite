<!--This script is responsible for adding a new painting to the database-->

<?php
//Create database connection
include 'db_connect.php';


// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);


//Get data from posted data fields
$title = $data['title'];
$artist = $data['artist'];
$style = $data['style'];
$media = $data['media'];
$imageUrl = $data['imageUrl'];


// Fetch ArtistID from artist table based on artist name
$queryArtist = $pdo->prepare("SELECT ArtistID FROM Artists WHERE Name = :artist");
$queryArtist->execute(['artist' => $artist]);
$artistId = $queryArtist->fetchColumn(); //Get Artist ID


//Check if artist exists in database
if ($artistId) {
    //Prepare SQL query to insert a new painting
    $stmt = $pdo->prepare("INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID, ImagePath) VALUES (:title, :finished, :media, :style, :artistId, :imageUrl)");
    

    //Execute inser query with data
    $result = $stmt->execute([
        'title' => $title,
        'finished' => date('Y'), // You can update this to reflect a proper 'finished' year input from the form
        'media' => $media,
        'style' => $style,
        'artistId' => $artistId,
        'imageUrl' => $imageUrl
    ]);


    //Check if insert was successful
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add painting.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Artist not found.']);
}
