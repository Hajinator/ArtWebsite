//JavaScript for deleting paintings.

function deletePainting(paintingId) {
    if (!confirm('Are you sure you want to delete this painting?')) {
        return;
    }

    // Send a DELETE request to the server to remove the painting
    fetch(`../includes/delete_painting.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ paintingId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the painting card from the UI
            const paintingCard = document.querySelector(`[data-id="${paintingId}"]`); // Use PaintingID for selector
            if (paintingCard) {
                paintingCard.remove();
            }
            location.reload(); //Reload page after deletion
        } else {
            console.error('Error deleting painting:', data.message);
        }
    })
    .catch(error => {
        console.error('Error deleting painting:', error);
    });
}

