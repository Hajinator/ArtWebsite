<?php 
//This script handles adding paintings to the database.
 
header('Content-Type: application/json');
include 'db_connect.php'; //Connect to database


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'] ?? null;
    $artistId = $_POST['artistId'] ?? null;
    $style = $_POST['style'] ?? null;
    $media = $_POST['media'] ?? null;
    $finished = $_POST['finished'] ?? null;


    //Check's that all fields have been entered in modal
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type']; // Get the MIME type
    
        // Allowed MIME types for images
        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/jfif'
        ];
    
        // Check if the uploaded file is an allowed type
        if (!in_array($imageType, $allowedTypes)) {
            echo json_encode(["message" => "Invalid image type."]);
            exit;
        }
    
        // Read the file contents
        $imageBlob = file_get_contents($imageTmpPath);
    
        // Prepare the SQL statement to insert the BLOB
        $stmt = $pdo->prepare("INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID, Image) VALUES (:title, :finished, :media, :style, :artistId, :image)");
    
        // Set values
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':artistId', $artistId);
        $stmt->bindValue(':style', $style);
        $stmt->bindValue(':media', $media);
        $stmt->bindValue(':finished', $finished);
        $stmt->bindValue(':image', $imageBlob, PDO::PARAM_LOB);
    
        // Execute
        if ($stmt->execute()) {
            echo json_encode(["message" => "Painting added successfully."]);
        } else {
            echo json_encode(["message" => "Error adding painting"]);
        }
    } else {
        echo json_encode(["message" => "No image uploaded or upload error"]);
    }
}