// JavaScript for fetching and displaying paintings with filter options and pagination

//Create variables for selected artist, style and current page for pagination
let selectedArtist = 'Show All';
let selectedStyle = 'Show All';
let currentPage = 1;


//Fetch paintings from the server and display them using Bootstrap cards
//Function accepts filter values for artist, style, a search term, and the page number
function fetchPaintings(artist = 'Show All', style = 'Show All', search = '', page = 1) {
    const url = `../includes/paintings.php?artist=${artist}&style=${style}&search=${search}&page=${page}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log("Fetched data:", data);
            const paintingCards = document.getElementById('paintingCards'); //Container for Bootstrap cards
            paintingCards.innerHTML = '';


            //Show a message if no paintings are found
            if (data.length === 0) {
            paintingCards.innerHTML = '<p>No paintings found.</p>';
            }

            // Loop through each painting and create a Bootstrap card for it
            data.paintings.forEach(painting => {
                const fullImageUrl = `http://localhost/ArtWebsite/${painting.image_url}`;
                paintingCards.innerHTML += `
                    <div class="col-md-4">
                        <div class="card mb-3 mt-3">
                            <img src="${fullImageUrl}" class="card-img-top" alt="${painting.title} onerror="this.onerror=null;this.src='path/to/default-image.jpg';">
                            <div class="card-body">
                                <h5 class="card-title"><strong>${painting.Title}</strong></h5>
                                <p class="card-text">Artist: ${painting.artist_name}</p>
                                <p class="card-text">Style: ${painting.Style }</p>
                                <p class="card-text">Type: ${painting.Media }</p>
                                <p class="card-text">Finished: ${painting.Finished}</p>
                                <button type="button" class="btn btn-outline-warning">Edit</button>
                                <button type="button" class="btn btn-outline-danger">Delete</button>
                            </div>
                        </div>
                    </div>`;
            });
            //Render pagination based on total pages and current page
            renderPagination(data.pages, page); 
        })
        .catch(error => console.error('Error fetching paintings:', error));
}


// Render pagination controls based on total number of pages and the current page
function renderPagination(totalPages, currentPage) {
    const paginationContainer = document.getElementById('paginationContainer');
    paginationContainer.innerHTML = ''; // Clear existing pagination

    for (let i = 1; i <= totalPages; i++) {
        paginationContainer.innerHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="fetchPaintings(selectedArtist, selectedStyle, document.getElementById('searchInput').value, ${i})">${i}</a>
            </li>`;
    }
}


 //Select artist from dropdown and apply filter
 function selectArtist(artist) {
    selectedArtist = artist;
    applyFilters();
}


 //Select style from dropdown and apply filter
function selectStyle(style) {
    selectedStyle = style;
    applyFilters();
}


// Apply filters and fetch paintings based on selected artist, style, and search term
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    currentPage = 1;
    if (search === '') {
        // If the search is empty, optionally fetch all paintings
        fetchPaintings(selectedArtist, selectedStyle, '', currentPage); // Fetch all paintings
    } else {
        fetchPaintings(selectedArtist, selectedStyle, search, currentPage);
    }
}



//Event listener to apply filters when typing
document.getElementById('searchInput').addEventListener('input', function() {
    applyFilters();
});


//Handle add painting button click to show the modal
document.getElementById('addPainting').addEventListener('click', function() {
    var modal = new bootstrap.Modal(document.getElementById('addPaintingModal'));
    modal.show();
});


//Initially load all paintings
window.onload = function() {
    fetchPaintings(selectedArtist, selectedStyle, '', currentPage);
};