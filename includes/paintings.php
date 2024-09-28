<?php
include 'db_connect.php';

// Get filter parameters
$artist = isset($_GET['artist']) ? $_GET['artist'] : '';
$style = isset($_GET['style']) ? $_GET['style'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

error_log("Artist: $artist, Style: $style, Search: $search"); // Log parameters


// Build the SQL query
$sql = "SELECT P.Title, P.Style, P.Finished, P.ImagePath AS image_url, A.Name as artist_name 
        FROM Paintings P 
        INNER JOIN Artists A ON P.ArtistID = A.ArtistID 
        WHERE 1";

if (!empty($artist) && $artist != 'Show All') {
    $sql .= " AND A.Name = :artist";
}
if (!empty($style) && $style != 'Show All') {
    $sql .= " AND P.Style = :style";
}
if (!empty($search)) {
    $sql .= " AND P.Title LIKE :search";
}

error_log("SQL Query: $sql");

$stmt = $pdo->prepare($sql);

// Bind the values
if (!empty($artist) && $artist != 'Show All') {
    $stmt->bindValue(':artist', $artist);
}
if (!empty($style) && $style != 'Show All') {
    $stmt->bindValue(':style', $style);
}
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


error_log("Results Count: " . count($results)); 

header('Content-Type: application/json'); // Ensure the content type is JSON
echo json_encode($results);
