/* $(window).scroll(function () {
  if ($(this).scrollTop() > 1) {
    $(".page-title").addClass("sticky");
  } else {
    $(".page-title").removeClass("sticky");
  }
}); */
jQuery.noConflict();

jQuery(document).ready(function($) {
  $(".navbar-toggler").click(function () {
    $("#navigation").toggleClass("show");
  });

  // Handle the click event for the "Contact Us" button
  $(".modal-trigger").click(function(e) {
    e.preventDefault();
    console.log('Modal trigger clicked');
    if (!$(".contact-modal").is(":visible")) { // Check if the modal is not already visible
      $(".contact-modal").fadeIn();
    }
  });

  // Handle the click event for the "Close" button
  $(".close-button").click(function() {
    console.log('Close button clicked');
    $(".contact-modal").fadeOut();
  });
});

  


/*
jQuery(document).ready(function($) {
  // Open the modal when a trigger element with class "modal-trigger" is clicked
  $('.modal-trigger').click(function(e) {
    e.preventDefault(); // Prevent the default link behavior
    //console.log('Modal trigger clicked'); // Add this line for debugging
    $('.contact-modal').addClass('active');
  });

  // Close the modal when the close button with class "close-button" is clicked
  $('.close-button').click(function() {
    //console.log('Close button clicked'); // Add this line for debugging
    $('.contact-modal').removeClass('active');
  });
});
*/

