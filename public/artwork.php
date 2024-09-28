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
<!--Body with bootstrap classes and navigation bar-->
<body>
    <header class="d-flex justify-content-center align-items-center p-3">
            <nav>
                <ul class="nav_links d-flex flex-wrap justify-content-center mb-0">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="artwork.php">Artwork</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </nav>
    </header>

    <div class="container">
    <div class="filter-controls mb-3" style="width: 100%;">
    <div class="d-flex" style="width: 100%; justify-content: space-between;">
        <!-- Artist Dropdown -->
        <div class="dropdown me-2">  
            <button class="btn btn-secondary dropdown-toggle" type="button" id="artistDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                Artists
            </button>
            <ul class="dropdown-menu" id="artistFilter" aria-labelledby="artistDropdown">
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Show All')">Show All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'August Renoir')">August Renoir</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Michelangelo')">Michelangelo</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Vincent Van Gogh')">Vincent Van Gogh</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Leonardo da Vinci')">Leonardo da Vinci</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Claude Monet')">Claude Monet</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Pablo Picasso')">Pablo Picasso</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Salvador Dali')">Salvador Dali</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('artist', 'Paul Cezanne')">Paul Cezanne</a></li>
            </ul>
        </div>

        <div class="dropdown me-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="styleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Style
            </button>
            <ul class="dropdown-menu" id="styleFilter" aria-labelledby="styleDropdown">
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Show All')">Show All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Impressionism')">Impressionism</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Mannerism')">Mannerism</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Realism')">Realism</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Portrait')">Portrait</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Cubism')">Cubism</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterPaintings('style', 'Surrealism')">Surrealism</a></li>
            </ul>
        </div>

        <div class="d-flex align-items-center mb-3"> <!-- Flex container for alignment -->
    <button class="btn btn-secondary me-2 btn-custom" type="button" id="addPainting"> <!-- Add 'me-2' for margin -->
        Add Painting
    </button>
        <div class="input-group flex-grow-1" style="width: 255px;">
                <input type="text" class="form-control" id="searchInput" placeholder="Search for paintings" aria-label="Search for paintings">
                <button class="btn btn-secondary" type="button" onclick="filterPaintings('search', document.getElementById('searchInput').value)">Search</button>
            </div>
        </div>
    </div>
</div> 

        <div id="paintingCards" class="row g-3"></div>
    </div>
</div>

<script>
        let selectedArtist = 'Show All';
        let selectedStyle = 'Show All';

        // Fetch and display paintings
        function fetchPaintings(artist = 'Show All', style = 'Show All', search = '') {
            const url = `../includes/paintings.php?artist=${artist}&style=${style}&search=${search}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const paintingCards = document.getElementById('paintingCards');
                    paintingCards.innerHTML = ''; // Clear previous results

                    if (data.length === 0) {
            paintingCards.innerHTML = '<p>No paintings found.</p>'; // Inform user no results
        }

                    // Loop through each painting and create a Bootstrap card
                    data.forEach(painting => {
                        console.log(painting);
                        const fullImageUrl = `http://localhost/ArtWebsite/${painting.image_url}`;
                        console.log(fullImageUrl);
                        paintingCards.innerHTML += `
                            <div class="col-md-4">
                                <div class="card mb-3 mt-3">
                                    <img src="${fullImageUrl}" class="card-img-top" alt="${painting.title} onerror="this.onerror=null;this.src='path/to/default-image.jpg';">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>${painting.Title}</strong></h5>
                                        <p class="card-text">Artist: ${painting.artist_name}</p>
                                        <p class="card-text">Style: ${painting.Style }</p>
                                        <p class="card-text">Finished: ${painting.Finished}</p>
                                        <button type="button" class="btn btn-outline-warning">Edit</button>
                                        <button type="button" class="btn btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>`;
                    });
                })
                .catch(error => console.error('Error fetching paintings:', error));
        }

        // Select artist from dropdown
        function selectArtist(artist) {
            selectedArtist = artist;
            applyFilters();
        }

        // Select style from dropdown
        function selectStyle(style) {
            selectedStyle = style;
            applyFilters();
        }

        // Apply filters and fetch paintings based on selected artist, style, and search term
        function applyFilters() {
            const search = document.getElementById('searchInput').value;
            fetchPaintings(selectedArtist, selectedStyle, search);
        }

        // Initially load all paintings
        window.onload = function() {
            fetchPaintings(); // Load all paintings on page load
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>