<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artwork</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/artwork.css">
</head>


<!-- PHP script-->

<body>
    <?php
    include '../includes/db_connect.php'; // Database connection

    // Fetch artists from the database to populate artist dropdown menu in modal
    try {
        $stmt = $pdo->query("SELECT ArtistID, Name FROM Artists");
        $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Could not fetch artists: " . $e->getMessage());
    }

    // Fetch styles from the database to populate style dropdown menu in modal
try {
    $stmt = $pdo->query("SELECT DISTINCT Style FROM Paintings");
    $styles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not fetch styles: " . $e->getMessage());
}
?>

    <!--Body with bootstrap classes and navigation bar-->
    <header class="d-flex justify-content-center align-items-center p-3 flex-column flex-md-row">
        <nav>
            <ul class="nav_links d-flex flex-wrap justify-content-center mb-0">
                <li><a href="index.php">Home</a></li>
                <li><a href="artwork.php">Artwork</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>


    <!--Container for dropdown menu, add and search buttons -->
    <div class="container">
        <div class="filter-controls mb-3" style="width: 100%;">
            <div class="d-flex" style="width: 100%; justify-content: space-between;">


                <!-- Artist Dropdown Menu -->
                <div class="dropdown me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="artistDropDown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Artists
                    </button>
                    <ul class="dropdown-menu" id="artistFilter" aria-labelledby="artistDropdown">
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Show All')">Show All</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('August Renoir')">August Renoir</a>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Michelangelo')">Michelangelo</a>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Vincent Van Gogh')">Vincent Van
                                Gogh</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Leonardo da Vinci')">Leonardo da
                                Vinci</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Claude Monet')">Claude Monet</a>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Pablo Picasso')">Pablo Picasso</a>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Salvador Dali')">Salvador Dali</a>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="selectArtist('Paul Cezanne')">Paul Cezanne</a>
                        </li>
                    </ul>
                </div>


                <!--Style Dropdown Menu -->
                <div class="dropdown me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="styleDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Style
                    </button>
                    <ul class="dropdown-menu" id="styleFilter" aria-labelledby="styleDropdown">
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Show All')">Show All</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Impressionism')">Impressionism</a>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Still-life')">Still-life</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Mannerism')">Mannerism</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Realism')">Realism</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Portrait')">Portrait</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Cubism')">Cubism</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selectStyle('Surrealism')">Surrealism</a></li>
                    </ul>
                </div>


                <!-- Add Painting Button -->
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-secondary me-2 btn-custom" type="button" id="addPainting">
                        Add Painting
                    </button>


                    <!-- Modal for Adding a Painting -->
                    <div class="modal fade" id="addPaintingModal" tabindex="-1" aria-labelledby="addPaintingModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPaintingModalLabel">Add a New Painting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Title -->
                                <div class="modal-body">
                                    <form id="addPaintingForm" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Enter painting title" required>
                                        </div>

                                        <!-- Artist Dropdown Menu -->
                                        <div class="mb-3">
                                            <label for="artistId" class="form-label">Artist</label>
                                            <select class="form-select" id="artistId" name="artistId" required>
                                                <option value="" disabled selected>Select an artist</option>
                                                <?php foreach ($artists as $artist): ?>
                                                <option value="<?php echo $artist['ArtistID']; ?>">
                                                    <?php echo htmlspecialchars($artist['Name']); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Style Drop Down Menu -->
                                        <div class="mb-3">
                                            <label for="style" class="form-label">Style</label>
                                            <select class="form-select" id="style" name="style" required>
                                                <option value="" disabled selected>Select a style</option>
                                                <?php foreach ($styles as $style): ?>
                                                <option value="<?php echo htmlspecialchars($style['Style']); ?>">
                                                    <?php echo htmlspecialchars($style['Style']); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Media -->
                                        <div class="mb-3">
                                            <label for="media" class="form-label">Media</label>
                                            <input type="text" class="form-control" id="media" name="media"
                                                placeholder="Enter media type" required> 
                                        </div>

                                        <!-- Finished -->
                                        <div class="mb-3">
                                            <label for="finished" class="form-label">Finished</label>
                                            <input type="text" class="form-control" id="finished" name="finished"
                                                placeholder="Enter finished year" required> 
                                        </div>

                                        <!-- Image File -->
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Upload Image</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*" required> 
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Painting</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal for editing painting -->
                    <div class="modal fade" id="editPaintingModal" tabindex="-1"
                        aria-labelledby="editPaintingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPaintingModalLabel">Edit Painting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editPaintingForm">
                                        <input type="hidden" id="editPaintingId" name="paintingId">
                                        <div class="mb-3">


                                        <!-- Title -->
                                            <label for="editTitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="editTitle" name="title"
                                                required>
                                        </div>


                                        <!-- Artist Dropdown Menu -->
                                        <div class="mb-3">
                                            <label for="editArtistId" class="form-label">Artist</label>
                                            <select class="form-select" id="editArtistId" name="artistId" required>
                                                <option value="" disabled selected>Select an artist</option>
                                                <?php foreach ($artists as $artist): ?>
                                                <option value="<?php echo $artist['ArtistID']; ?>">
                                                    <?php echo htmlspecialchars($artist['Name']); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>


                                        <!-- Style Drop Down Menu -->
                                        <div class="mb-3">
                                            <label for="editStyle" class="form-label">Style</label>
                                            <select class="form-select" id="editStyle" name="style" required>
                                                <option value="" disabled selected>Select a style</option>
                                                <?php foreach ($styles as $style): ?>
                                                <option value="<?php echo htmlspecialchars($style['Style']); ?>">
                                                    <?php echo htmlspecialchars($style['Style']); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>


                                        <!-- Media -->
                                        <div class="mb-3">
                                            <label for="editMedia" class="form-label">Media</label>
                                            <input type="text" class="form-control" id="editMedia" name="media"
                                                required>
                                        </div>


                                        <!-- Finished -->
                                        <div class="mb-3">
                                            <label for="editFinished" class="form-label">Finished</label>
                                            <input type="text" class="form-control" id="editFinished" name="finished"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Search Input box-->
                    <div class="input-group flex-grow-1" style="width: 255px;">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search for paintings"
                            aria-label="Search for paintings">
                        <button class="btn btn-secondary" type="button" onclick="applyFilters()">Search</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Create Row for Bootstrap cards to hold painting image and information inside-->
        <div id="paintingCards" class="row g-3"></div>
    </div>

    <!-- Import Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/artwork.js"></script>
    <script src="../js/add_painting.js"></script>
    <script src="../js/edit_painting.js"></script>
    <script src="../js/delete_painting.js"></script>


    <!-- Create navbar for Pagination -->
    <nav aria-label="Page navigation" class="pagination-container">
        <ul class="pagination justify-content-center" id="paginationContainer"></ul>
    </nav>


    <!-- Import Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>