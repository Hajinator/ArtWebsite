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

    <div class="containter">
    <h5>Filter by</h5>
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

        <div class="input-group mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Search for paintings..." aria-label="Search for paintings">
                <button class="btn btn-outline-secondary" type="button" onclick="filterPaintings('search', document.getElementById('searchInput').value)">Search</button>
            </div>

        </div>
    </div>

        <div id="paintingCards" class="row"></div>
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
                        paintingCards.innerHTML += `
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <img src="${painting.image_url}" class="card-img-top" alt="${painting.title}">
                                    <div class="card-body">
                                        <h5 class="card-title">${painting.title}</h5>
                                        <p class="card-text">Artist: ${painting.artist_name}</p>
                                        <p class="card-text">Style: ${painting.style}</p>
                                    </div>
                                </div>
                            </div>`;
                    });
                })
                .catch(error => console.error('Error:', error));
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