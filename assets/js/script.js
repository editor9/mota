jQuery(document).ready(function($) {
  // Hamburger menu toggle
  $(".navbar-toggler").click(function() {
      $("#navigation").toggleClass("show");
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

 
    // An array to store image URLs for lightbox
    var imageUrls = [];
    // The index of the currently displayed image
    var currentImageIndex = 0;
  
    // Function to load the previous image
    function loadPreviousImage() {
      if (currentImageIndex > 0) {
        currentImageIndex--;
        var imageUrl = imageUrls[currentImageIndex];
        $('#lightbox-content').attr('src', imageUrl);
      }
    }
  
    // Function to load the next image
    function loadNextImage() {
      if (currentImageIndex < imageUrls.length - 1) {
        currentImageIndex++;
        var imageUrl = imageUrls[currentImageIndex];
        $('#lightbox-content').attr('src', imageUrl);
      }
    }
  
    // Handle opening the lightbox when the eye icon is clicked
    $('.photo-card i.fas.fa-eye').click(function() {
      var imageUrl = $(this).parent('.photo-card').data('image-url');
      $('#lightbox-content').attr('src', imageUrl);
      currentImageIndex = imageUrls.indexOf(imageUrl);
      $('#photo-lightbox').show();
    });
  
    // Handle closing the lightbox when the close button is clicked
    $('#close-lightbox').click(function() {
      $('#photo-lightbox').hide();
    });
  
    // Handle previous and next arrows
    $('#lightbox-arrow-prev').click(function() {
      loadPreviousImage();
    });
  
    $('#lightbox-arrow-next').click(function() {
      loadNextImage();
    });
  
    // Populate the 'imageUrls' array with image URLs from '.photo-card' elements
    $('.photo-card').each(function() {
      imageUrls.push($(this).data('image-url'));
    });
 
  
  // "Charger plus" button functionality
  var page = 2; // Start with the second page (since the first page is already loaded).
  $('#load-more').click(function() {
      $.ajax({
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
                  $('#load-more').hide();
                  console.log("button hidden");
              } else {
                  console.log("still have more photos");
                  $('.photo-gallery').append(response); // Append the new photos to the gallery.
                  page++; // Increment the page number.
                  console.log("photos appended");
              }
          },
      });
  });



});