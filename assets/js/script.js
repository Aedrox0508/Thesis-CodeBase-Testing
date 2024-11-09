document.querySelectorAll('.fingers').forEach(column => {
    const thumbSwitch = column.querySelector('.form-group:first-child input[type="checkbox"]');
    const comSwitches = column.querySelectorAll('.form-group:not(:first-child) input[type="checkbox"]');

    // Toggle all COM switches based on the thumb switch
    thumbSwitch.addEventListener('change', function() {
        const isChecked = this.checked;
        comSwitches.forEach(comSwitch => {
            comSwitch.checked = isChecked;
        });
    });
});

// Event listener for the modal to set the image and values
document.addEventListener('DOMContentLoaded', function() {
    var imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal

        // Get data attributes from the button
        var imageUrl = button.getAttribute('data-img'); // Extract image URL from data-* attribute
        var gestureId = button.getAttribute('data-id'); // Extract gesture ID
        var gestureValue = button.getAttribute('data-value'); // Extract gesture value

        console.log("Image URL: " + imageUrl); // Check the image URL

        // Set the image source and the input value in the modal
        document.getElementById('modalImage').src = imageUrl; // Set the image source
        document.getElementById('gestureId').value = gestureId; // Set the gesture ID input value
        document.getElementById('modalInput').value = gestureValue; // Set the current gesture value
    });

    // Clear image and input value when the modal is closed
    imageModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('modalImage').src = ''; // Clear the image src
        document.getElementById('modalInput').value = ''; // Clear the input value
        document.getElementById('gestureId').value = ''; // Clear the gesture ID input value
    });
});
