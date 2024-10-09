<?php
//This script handles fetching and filtering paintings from the database.
 //It allows the user to filter paintings by artist name, style, and a search term and implementing pagination
 //to limit the number of paintings displayed

include 'db_connect.php'; // Database connection file

// Get filter parameters
$artist = isset($_GET['artist']) ? $_GET['artist'] : ''; //Artist filter
$style = isset($_GET['style']) ? $_GET['style'] : ''; //Style Filter
$search = isset($_GET['search']) ? $_GET['search'] : ''; //Search Term
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page, default is 1
$limit = 6; // Number of paintings per page
$offset = ($page - 1) * $limit; // Calculate the offset for pagination


// Build the SQL query for fetching paintings
$sql = "SELECT P.PaintingID, P.Title, P.Style, P.Finished, P.Media, P.Image AS image_blob, A.Name as artist_name,
        P.ArtistID
        FROM Paintings P 
        INNER JOIN Artists A ON P.ArtistID = A.ArtistID 
        WHERE 1";


//Add conditions based on filters if selected
if ($artist && $artist != 'Show All') {
    $sql .= " AND A.Name = :artist"; //Filter by Artist
}
if ($style && $style != 'Show All') {
    $sql .= " AND P.Style = :style"; //Filter by style
}
if ($search) {
    $sql .= " AND P.Title LIKE :search"; //Filter by search
}

//Set pagination limits to query
$sql .= " LIMIT :limit OFFSET :offset";

//Prepare query
$stmt = $pdo->prepare($sql);

// Bind the values to the prepared statement
if ($artist && $artist != 'Show All') {
    $stmt->bindValue(':artist', $artist);
}
if ($style && $style != 'Show All') {
    $stmt->bindValue(':style', $style);
}
if ($search) {
    $stmt->bindValue(':search', "%$search%");
}


//Bind limit and offset
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);


//Execute the query and fetch the paintings
$stmt->execute();
$paintings = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Convert the binary BLOB data into base64 and prepare image source
foreach ($paintings as &$painting) {
    if ($painting['image_blob']) {
        $painting['image_blob'] = 'data:image/png;base64,' . base64_encode($painting['image_blob']);
    } else {
        $painting['image_blob'] = ''; // Set empty string if no image
    }
}

//Build a second query to get total number of filtered paintings for pagination
$totalSql = "SELECT COUNT(*) FROM Paintings P INNER JOIN Artists A ON P.ArtistID = A.ArtistID WHERE 1";
if ($artist && $artist != 'Show All') {
    $totalSql .= " AND A.Name = :artist"; //Apply artist filter
}
if ($style && $style != 'Show All') {
    $totalSql .= " AND P.Style = :style"; //Apply style filter
}
if ($search) {
    $totalSql .= " AND P.Title LIKE :search"; //Apply search filter
}


$totalStmt = $pdo->prepare($totalSql);

//Bind values
if ($artist && $artist != 'Show All') {
    $totalStmt->bindValue(':artist', $artist);
}
if ($style && $style != 'Show All') {
    $totalStmt->bindValue(':style', $style);
}
if ($search) {
    $totalStmt->bindValue(':search', "%$search%");
}

//Execute the binded query
$totalStmt->execute();
$totalCount = $totalStmt->fetchColumn();
$totalPages = ceil($totalCount / $limit); //Caclulate number of pages

// Return the results and pagination info as JSON
header('Content-Type: application/json');
echo json_encode([
    'paintings' => $paintings,
    'pages' => $totalPages,
    'debug' => $paintings // Add this line for debugging
]);
