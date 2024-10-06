<?php 
//header('Content-Type: application/json');
include 'db_connect.php'; // Database connection file

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parse form data
    $title = $_POST['title'] ?? null;
    $artistId = $_POST['artistId'] ?? null;
    $style = $_POST['style'] ?? null;
    $media = $_POST['media'] ?? null;
    $finished = $_POST['finished'] ?? null;

    if (empty($title) || empty($artistId) || empty($style) || empty($media) || empty($finished)) {
        echo json_encode(["message" => "All fields are required."]);
        exit; // Exit early to prevent further processing
    }

    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageFileName = basename($_FILES['image']['name']);
        $uploadDir = 'C:/xampp/htdocs/ArtWebsite/images/500_wide/'; // Your upload directory
        $imageDestination = $uploadDir . $imageFileName;

        // Move the uploaded file to the destination
        if (move_uploaded_file($imageTmpPath, $imageDestination)) {
            // File successfully uploaded, insert into database
            $relativeImagePath = 'images/500_wide/' . $imageFileName; // Relative path for database storage

            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID, ImagePath) VALUES (:title, :finished, :media, :style, :artistId, :imageUrl)");

            // Bind parameters
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':artistId', $artistId);
            $stmt->bindValue(':style', $style);
            $stmt->bindValue(':media', $media);
            $stmt->bindValue(':finished', $finished);
            $stmt->bindValue(':imageUrl', $relativeImagePath); // Save the relative path to the image

            // Execute the statement and check for errors
            if ($stmt->execute()) {
                echo json_encode(["message" => "Painting added successfully."]);
            } else {
                $errorInfo = $stmt->errorInfo();
                echo json_encode(["message" => "Error adding painting", "error" => $errorInfo]);
            }
        } else {
            echo json_encode(["message" => "Error moving uploaded file"]);
        }
    } else {
        echo json_encode(["message" => "No image uploaded or upload error"]);
    }
}