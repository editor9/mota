jQuery.noConflict();

jQuery(document).ready(function ($) {
  // Hamburger menu toggle
  $(".navbar-toggler").click(function () {
    $("#navigation").toggleClass("show");
  });

  // Handle modal opening
  var modal = document.getElementById("myModal");
  var contact_links = document.getElementsByClassName("open-modal");

  for (var i = 0; i < contact_links.length; i++) {
    var contact_link = contact_links[i];
    if (contact_link != null) {
      contact_link.onclick = function () {
        modal.style.display = "block";
      };
    }
  }

  // Handle modal closing
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  function appendNewPhotos(response) {
    if (response.success && response.data && response.data.content) {
      $(".photo-gallery").append(response.data.content);
    } else {
      console.error("Response structure is not as expected:", response);
    }
  }

  // "Charger plus" button functionality
  var page = 2; // Start with the second page (since the first page is already loaded).
  var loading = false; // Add a loading flag
  $("#load-more").click(function () {
    if (loading) {
      return; // If already loading, ignore the click
    }
    loading = true; // Set loading flag
    $.ajax({
      url: ajax_object.ajaxurl, // Use WordPress AJAX URL
      type: "POST",
      data: {
        action: "load_more_photos",
        page: page,
      },
      success: function (response) {
        if (typeof response === "string" && response.trim() === "") {
          console.log("no more photos");
          // No more photos to load, so hide the "Charger plus" button.
          $("#load-more").hide();
          console.log("button hidden");
        } else {
          console.log("still have more photos");
          // Call the appendNewPhotos function to append the new photos to the gallery.
          appendNewPhotos(response);
          page++; // Increment the page number.
          console.log("photos appended");
        }
      },
    });
  });

  $(".filter-label").click(function () {
    $(this).siblings(".filter-dropdown").toggle();
  });

  // Function to update photos based on     selected     terms
  function updatePhotos() {
    var selectedCategories = $("#category-select").val();
    var selectedFormats = $("#format-select").val();
    var selectedSort = $("#sort-select").val();
    console.log(
      "cat is " +
        selectedCategories +
        " format is " +
        selectedFormats +
        " sort is " +
        selectedSort
    );
    // AJAX request to fetch filtered photos
    $.ajax({
      type: "POST",
      url: ajax_object.ajaxurl, // WordPress AJAX URL
      data: {
        action: "filter_photos", // Server-side function to handle filtering
        category: selectedCategories,
        format: selectedFormats,
        sort: selectedSort,
        nonce: ajax_object.nonce,
      },
      success: function (response) {
        // Assuming "response" contains the JSON response you provided
        if (response.content) {
          console.log("Content received:", response.content);
          // Replace the photo gallery with the updated content
          $(".photo-gallery").html(response.content);
        } else {
          // Handle the case when there's no content
          console.log("No content to display.");
        }
      },

      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX Request Error:", textStatus, errorThrown);
      },
    });
  }

  // Trigger updatePhotos on page load
  $("#filter-form select").on("change", function () {
    updatePhotos(); // Call the updatePhotos function when the filters change
  });

  // JavaScript code for opening the single-photo.php page
  $(".photo-gallery").on("click", ".photo-card i.fas.fa-eye", function () {
    var photoCard = $(this).closest(".photo-card");
    var title = photoCard.data("title");
    console.log(title);

    // Remove accents from the title
    var titleWithoutAccents = removeEAccent(title);

    // Deduce the photoname from the title
    var photoname = deducePhotonameFromTitle(titleWithoutAccents);

    var url = "http://localhost:81/mota/photo/" + photoname + "/";

    // Open the URL in a new tab or window
    window.location.replace(url); //open(url, "_blank") to open in new window
  });

  // Function to deduce photoname from the title
  function deducePhotonameFromTitle(title) {
    // Remove special characters, replace spaces with hyphens, and convert to lowercase
    var titleModified = title
      .replace(/[^a-zA-Z0-9\s]/g, "") // Remove special characters
      .replace(/\s+/g, "-") // Replace spaces with hyphens
      .toLowerCase(); // Convert to lowercase

    // Remove trailing hyphens
    titleModified = titleModified.replace(/-+$/, "");
    return titleModified;
  }
  // Function to remove "é" accent from characters
  function removeEAccent(input) {
    return input
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .replace(/è|é|ê|ë/g, "e");
  }

  if (typeof jQuery == "undefined") {
    console.log("jQuery is not loaded.");
  } else {
    console.log("jQuery is loaded.");
  }
});
