document.addEventListener('DOMContentLoaded', function() {
    const mediaItemNewForm = document.getElementById('media_item_new_form');

    // Check if the form exists on the page
    if (!mediaItemNewForm) {
        return;
    }

    const itemTypeSelectorId = mediaItemNewForm.dataset.itemTypeSelectorId;
    const itemTypeSelector = document.getElementById(itemTypeSelectorId);

    const bookFields = document.getElementById('book_fields');
    const cdFields = document.getElementById('cd_fields');
    const dvdFields = document.getElementById('dvd_fields');

    function toggleSpecificFields() {
        if (!itemTypeSelector) return;

        const selectedType = itemTypeSelector.value;

        // Hide all specific fields first
        if (bookFields) bookFields.style.display = 'none';
        if (cdFields) cdFields.style.display = 'none';
        if (dvdFields) dvdFields.style.display = 'none';

        // Show fields based on selected type
        if (selectedType === 'book' && bookFields) {
            bookFields.style.display = 'block';
        } else if (selectedType === 'cd' && cdFields) {
            cdFields.style.display = 'block';
        } else if (selectedType === 'dvd' && dvdFields) {
            dvdFields.style.display = 'block';
        }
    }

    // Run on page load (for edit cases where type is already selected)
    toggleSpecificFields();

    // Run on change of selection
    if (itemTypeSelector) {
        itemTypeSelector.addEventListener('change', toggleSpecificFields);
    }
});
