function openEditModal(paintingId) {
    // Fetch the painting data from the server (you may need to create a new PHP endpoint for this)
    fetch(`../includes/get_painting.php?paintingId=${paintingId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the edit modal fields
                document.getElementById('editPaintingId').value = data.paintingId;
                document.getElementById('editTitle').value = data.title;
                document.getElementById('editArtistId').value = data.artistId;
                document.getElementById('editStyle').value = data.style;
                document.getElementById('editMedia').value = data.media;
                document.getElementById('editFinished').value = data.finished;

                // Show the edit modal
                var modal = new bootstrap.Modal(document.getElementById('editPaintingModal'));
                modal.show();
            } else {
                console.error('Painting data not found.');
            }
        })
        .catch(error => console.error('Error fetching painting data:', error));
}

document.getElementById('editPaintingForm').addEventListener('submit', function(event) {
    event.preventDefault();
    editPainting();
});

function editPainting() {
    const formData = new FormData(document.getElementById('editPaintingForm'));

    fetch('../includes/edit_painting.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Painting updated successfully.") {
            $('#editPaintingModal').modal('hide'); 
            location.reload(); // Reload to show updated painting
        } else {
            console.error("Error updating painting:", data.message);
        }
    })
    .catch(error => {
        console.error('Error updating painting:', error);
    });
}