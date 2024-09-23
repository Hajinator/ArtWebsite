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

    <h5>Filter by</h5>
    <div class="filter-controls mb-3" style="width: 100%;">
    <div class="d-flex" style="width: 100%; justify-content: space-between;">
        <div class="dropdown me-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Artists
            </button>
            <ul class="dropdown-menu" role="menu" aria-label="Dropdown menu">
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Show All</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">August Renoir</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Michelangelo</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Vincent Van Gogh</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Leonardo da Vinci</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Claude Monet</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Pablo Picasso</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Salvador Dali</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Paul Cezanne</a></li>
            </ul>
        </div>

        <div class="dropdown me-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Style
            </button>
            <ul class="dropdown-menu" role="menu" aria-label="Dropdown menu">
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Show All</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Impressionism</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Mannerism</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Realism</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Portrait</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Cubism</a></li>
                <li role="none"><a class="dropdown-item" href="#" role="menuitem">Surrealism</a></li>
            </ul>
        </div>

        <div class="input-group mb-3" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Search Painting" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">Search</span>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>