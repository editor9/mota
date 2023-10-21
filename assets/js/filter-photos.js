jQuery(document).ready(function($) {
    // Function to update photos based on selected terms
    function updatePhotos() {
        var selectedCategories = $('#category-select').val();
        var selectedFormats = $('#format-select').val();
        var selectedSort = $('#sort-select').val();
    
        // AJAX request to fetch filtered photos
        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl, // WordPress AJAX URL
            data: {
                action: 'filter_photos', // Server-side function to handle filtering
                categories: selectedCategories,
                formats: selectedFormats,
                sort: selectedSort
            },
            success: function(response) {
                // Check if the response is empty or invalid JSON
                if (response.trim() === '') {
                    console.log('Empty response received.');
                } else {
                    // Parse the JSON response
                    try {
                        var data = JSON.parse(response);
                        if (data.content) {
                            // Replace the photo gallery with the updated content
                            $('.photo-gallery').html(data.content);
                        } else {
                            // Handle the case when there's no content
                            console.log('No content to display.');
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX Request Error:', textStatus, errorThrown);
            }
        });
    }
    
    // Listen for changes in selected terms and update photos
    $('#category-select, #format-select, #sort-select').on('change', updatePhotos);

    // Trigger updatePhotos on page load
    updatePhotos();
});
