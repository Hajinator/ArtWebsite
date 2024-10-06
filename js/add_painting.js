

document.getElementById('addPaintingForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way
    addPainting(); // Call the function to handle painting addition
});


function addPainting() {
    const formData = new FormData(document.getElementById('addPaintingForm'));


    const modalElement = document.getElementById('addPaintingModal');
    const modal = new bootstrap.Modal(modalElement);
    
    fetch('../includes/add_painting.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Painting added successfully:', data);


        

        // Assuming the response contains the painting details
        if (data.message === "Painting added successfully.") {
            modal.hide();

            const newPainting = {
                title: formData.get('title'), // Get from form data
                artistId: formData.get('artistId'), // Get from form data
                style: formData.get('style'), // Get from form data
                media: formData.get('media'), // Get from form data
                finished: formData.get('finished'), // Get from form data
                imageUrl: data.imagePath // Assuming this is part of your response
            };

            displayNewPainting(newPainting); // Call the function to display the new painting
        }
    })
    .catch(error => {
        console.error('Error adding painting:', error);
    });
}

function displayNewPainting(painting) {
    // Create a Bootstrap card element for the new painting
    const card = document.createElement('div');
    card.className = 'card';
    card.style.width = '18rem'; // Adjust as necessary
    card.innerHTML = `
        <img src="${painting.imageUrl}" class="card-img-top" alt="${painting.title}">
        <div class="card-body">
            <h5 class="card-title">${painting.title}</h5>
            <p class="card-text">Artist ID: ${painting.artistId}</p>
            <p class="card-text">Style: ${painting.style}</p>
            <p class="card-text">Media: ${painting.media}</p>
            <p class="card-text">Finished: ${painting.finished}</p>
        </div>
    `;

    // Append the new card to the container (assume container ID is 'paintingsContainer')
    const paintingsContainer = document.getElementById('paintingsContainer');
    paintingsContainer.appendChild(card);
}
  