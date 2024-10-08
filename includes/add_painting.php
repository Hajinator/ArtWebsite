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
    if (empty($title) || empty($artistId) || empty($style) || empty($media) || empty($finished)) {
        echo json_encode(["message" => "All fields are required."]);
        exit;
    }


    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageFileName = basename($_FILES['image']['name']);
        $uploadDir = 'C:/xampp/htdocs/ArtWebsite/images/500_wide/'; //Files get uploaded in here
        $imageDestination = $uploadDir . $imageFileName;

        // Move the uploaded file to the destination
        if (move_uploaded_file($imageTmpPath, $imageDestination)) {
            // File successfully uploaded, insert into database
            $relativeImagePath = 'images/500_wide/' . $imageFileName; //Set file path

            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID, ImagePath) VALUES (:title, :finished, :media, :style, :artistId, :imageUrl)");

            // Set values
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':artistId', $artistId);
            $stmt->bindValue(':style', $style);
            $stmt->bindValue(':media', $media);
            $stmt->bindValue(':finished', $finished);
            $stmt->bindValue(':imageUrl', $relativeImagePath); // Save the relative path to the image

            // Execute
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