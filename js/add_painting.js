//JavaScript for adding paintings to database and fetching them to display in bootstrap card

document.getElementById('addPaintingForm').addEventListener('submit', function(event) {
    event.preventDefault();
    addPainting();
});

function addPainting() {
    //Create variable to hold form data
    const formData = new FormData(document.getElementById('addPaintingForm'));

    //Send the form data using fetch and post methods 
    fetch('../includes/add_painting.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {

        //Check if network request was successful
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json(); //return response as json
    })
    .then(data => {
        console.log('Painting added successfully:', data);
        if (data.message === "Painting added successfully.") {

            // Hide the modal using jQuery and automatically reload webpage to display added painting
            $('#addPaintingModal').modal('hide'); 
            location.reload(); 

            // Create new painting object
            const newPainting = {
                title: formData.get('title'), 
                artistId: formData.get('artistId'), 
                style: formData.get('style'), 
                media: formData.get('media'), 
                finished: formData.get('finished'), 
                paintingId: data.paintingId,
                imageUrl: data.imagePath 
            };

            displayNewPainting(newPainting); //Display newPainting
        } else {
            console.error("Error adding painting:", data.message);
        }
    })
    .catch(error => {
        console.error('Error adding painting:', error);
    });
}


//Display newly added painting as a bootstrap card
function displayNewPainting(painting) {
    const paintingCards = document.getElementById('paintingCards'); //Call paintingCards container in artwork.php
    
    //Check if it exists
    if (!paintingCards) {
        console.error("Painting cards container not found.");
        return;
    }

    //Create new card for the painting
    const card = document.createElement('div');
    card.className = 'card col-md-4'; // Add Bootstrap classes for styling
    //card.setAttribute('data-id', painting.PaintingID);
    card.innerHTML = `
        <img src="${painting.imageUrl}" class="card-img-top" alt="${painting.title}">
        <div class="card-body">
            <h5 class="card-title">${painting.title}</h5>
            <p class="card-text">Artist ID: ${painting.artistId}</p>
            <p class="card-text">Style: ${painting.style}</p>
            <p class="card-text">Media: ${painting.media}</p>
            <p class="card-text">Finished: ${painting.finished}</p>
            <button type="button" class="btn btn-outline-danger" onclick="deletePainting(${painting.paintingId})">Delete</button>
        </div>
    `;
    
    // Append the new card to the paintingCards container in artwork.php
    paintingCards.appendChild(card); 
}
  