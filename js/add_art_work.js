//For adding artwork

document.getElementById('addPaintingForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Collect form data
    const title = document.getElementById('title').value;
    const artist = document.getElementById('artist').value;
    const style = document.getElementById('style').value;
    const media = document.getElementById('media').value;
    const finished = document.getElementById('finished').value;
    const imageUrl = document.getElementById('image_url').value;


    //Form validation to ensure no empty fields
 if (!title || !artist || !style || !media || !finished || !imageUrl) {
    alert('All fields are required.');
    return; // Stop submission if validation fails
 }

    // Send the data to the server via fetch
    fetch('../includes/add_art_work.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            title: title,
            artist: artist,
            style: style,
            media: media,
            finished: finished,
            image_url: imageUrl
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Painting added successfully
            alert('Painting added successfully!');


            //Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addPaintingModal'));
            modal.hide();


            // Reload paintings to show the newly added one
            fetchPaintings();
        } else {
            // Handle server errors
            alert('Error adding painting: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});