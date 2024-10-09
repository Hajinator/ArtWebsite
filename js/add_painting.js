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
fetch(`../includes/get_painting_blob.php?id=${painting.paintingId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch painting BLOB: ' + response.statusText);
            }
            return response.blob(); // Return the response as a Blob
        })
        .then(blob => {
            const fullImageBlob = URL.createObjectURL(blob); // Create a local URL for the Blob

            // Create new card for the painting
            const card = document.createElement('div');
            card.className = 'card col-md-4'; // Add Bootstrap classes for styling
            card.innerHTML = `
                <img src="${fullImageBlob}" class="card-img-top" alt="${painting.title}">
                <div class="card-body">
                    <h5 class="card-title">${painting.title}</h5>
                    <p class="card-text">Artist ID: ${painting.artistId}</p>
                    <p class="card-text">Style: ${painting.style}</p>
                    <p class="card-text">Media: ${painting.media}</p>
                    <p class="card-text">Finished: ${painting.finished}</p>
                    <button type="button" class="btn btn-outline-danger" onclick="deletePainting(${painting.paintingId})">Delete</button>
                    <button type="button" class="btn btn-outline-warning" onclick="openEditModal(${painting.paintingId}, '${painting.title}', '${painting.artistId}', '${painting.style}', '${painting.media}', '${painting.finished}')">Edit</button>
                </div>
            `;
            
            // Append the new card to the paintingCards container in artwork.php
            paintingCards.appendChild(card);
        })
        .catch(error => {
            console.error('Error fetching painting BLOB:', error);
        });


  