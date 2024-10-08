//JavaScript for editing paintings.


//Function to open the edit modal in artwork.php and set values
function openEditModal(paintingId, title, artistId, style, media, finished) {
    document.getElementById('editPaintingId').value = paintingId;
    document.getElementById('editTitle').value = title;
    document.getElementById('editArtistId').value = artistId;
    document.getElementById('editStyle').value = style;
    document.getElementById('editMedia').value = media;
    document.getElementById('editFinished').value = finished;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('editPaintingModal'));
    modal.show();
}

document.getElementById('editPaintingForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const paintingId = formData.get('paintingId');

    // Send a request to the server to update the painting
    fetch(`../includes/edit_painting.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

            const modal = bootstrap.Modal.getInstance(document.getElementById('editPaintingModal'));
            modal.hide(); //Hide model after submitting edit modal
            fetchPaintings(selectedArtist, selectedStyle, document.getElementById('searchInput').value, currentPage);
        } else {
            console.error('Failed to update painting:', data.message);
        }
    })
    .catch(error => console.error('Error updating painting:', error));
});