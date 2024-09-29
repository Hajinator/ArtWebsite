<?php
include 'db_connect.php';

// Get filter parameters
$artist = isset($_GET['artist']) ? $_GET['artist'] : '';
$style = isset($_GET['style']) ? $_GET['style'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page, default is 1
$limit = 6; // Number of paintings per page
$offset = ($page - 1) * $limit; // Calculate the offset for SQL query

error_log("Artist: $artist, Style: $style, Search: $search"); // Log parameters


// Build the SQL query
$sql = "SELECT P.Title, P.Style, P.Finished, P.Media, P.ImagePath AS image_url, A.Name as artist_name 
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

$sql .= " LIMIT :limit OFFSET :offset";

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
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

$countSql = "SELECT COUNT(*) FROM Paintings P INNER JOIN Artists A ON P.ArtistID = A.ArtistID WHERE 1";
if (!empty($artist) && $artist != 'Show All') {
    $countSql .= " AND A.Name = :artist";
}
if (!empty($style) && $style != 'Show All') {
    $countSql .= " AND P.Style = :style";
}
if (!empty($search)) {
    $countSql .= " AND P.Title LIKE :search";
}
$countStmt = $pdo->prepare($countSql);
if (!empty($artist) && $artist != 'Show All') {
    $countStmt->bindValue(':artist', $artist);
}
if (!empty($style) && $style != 'Show All') {
    $countStmt->bindValue(':style', $style);
}
if (!empty($search)) {
    $countStmt->bindValue(':search', "%$search%");
}

$countStmt->execute();
$totalCount = $countStmt->fetchColumn();

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Get total number of paintings

// Return the results along with pagination data
header('Content-Type: application/json');
echo json_encode([
    'paintings' => $results,
    'total' => $totalCount,
    'pages' => ceil($totalCount / $limit), // Calculate total pages
]);