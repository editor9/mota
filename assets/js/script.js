// Ensure that jQuery is used without conflicts
jQuery.noConflict();

// Wrap all jQuery code within the jQuery document ready function
jQuery(document).ready(function($) {

  // Hamburger menu toggle
  jQuery(".navbar-toggler").click(function() {
    jQuery("#navigation").toggleClass("show");
  });

  // Handle modal opening
  var modal = document.getElementById('myModal');
  var contact_links = document.getElementsByClassName("open-modal");

  for (var i = 0; i < contact_links.length; i++) {
    var contact_link = contact_links[i];
    if (contact_link != null) {
      contact_link.onclick = function() {
        modal.style.display = "block";
      }
    }
  }

  // Handle modal closing
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  // "Charger plus" button functionality
  var page = 2; // Start with the second page (since the first page is already loaded).
  jQuery('#load-more').click(function() {
    jQuery.ajax({
      url: ajax_object.ajaxurl, // Use WordPress AJAX URL
      type: 'POST',
      data: {
        action: 'load_more_photos',
        page: page,
      },
      success: function(response) {
        if (response.trim() === '') {
          console.log("no more photos");
          // No more photos to load, so hide the "Charger plus" button.
          jQuery('#load-more').hide();
          console.log("button hidden");
        } else {
          console.log("still have more photos");
          jQuery('.photo-gallery').append(response); // Append the new photos to the gallery.
          page++; // Increment the page number.
          console.log("photos appended");
        }
      },
    });
  });

  // Function to update the photo display based on filters
  function updatePhotos() {
    const selectedCategory = jQuery("#categories").val();
    const selectedFormat = jQuery("#formats").val();
    const sortOrder = jQuery("#sort").val();

    // Use AJAX to fetch data from your server
    jQuery.ajax({
      url: ajax_object.ajaxurl, // Use the correct AJAX URL
      type: "POST",
      data: {
        action: "filter_sort_photos",
        category: selectedCategory,
        format: selectedFormat,
        sort: sortOrder,
      },
      success: function(response) {
        // The 'response' variable should contain the filtered and sorted data
        // Update your display based on the response
        displayPhotos(response);
      },
    });
  }

  function displayPhotos(photos) {
    // Get the element where you want to display photos
    const photoGallery = document.getElementById('photo');
  
    if (Array.isArray(photos)) { // Check if 'photos' is an array
      // Modify the innerHTML of the element
      photoGallery.innerHTML = ''; // Clear existing content
  
      photos.forEach(photo => {
        // Create elements to display your photos and append them to the photoGallery
        const photoElement = document.createElement('div');
        photoElement.classList.add('col', 'post-photo');
        const imgElement = document.createElement('img');
        imgElement.src = photo.url; // Replace with the appropriate property from your photo object
  
        photoElement.appendChild(imgElement);
        photoGallery.appendChild(photoElement);
      });
    } else {
      console.error("Photos are not in the expected format.");
    }
  }
  

  
  

  // Event listeners for filter changes
  jQuery("#categories, #formats, #sort").change(updatePhotos);

  // Event listener for label interactions (when labels are clicked)
  jQuery("label[for='categories'], label[for='formats'], label[for='sort']").click(function() {
    // Trigger the respective <select> element's click event
    const selectId = jQuery(this).attr('for');
    jQuery(`#${selectId}`).trigger('change');
  });

  // Initial photo display
  updatePhotos();

 

  console.log(ajax_object.ajaxurl); // Log the AJAX URL to the console
});
