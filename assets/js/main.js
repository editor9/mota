$(window).scroll(function () {
  if ($(this).scrollTop() > 1) {
    $(".page-title").addClass("sticky");
  } else {
    $(".page-title").removeClass("sticky");
  }
});

jQuery(document).ready(function ($) {
  $(".navbar-toggler").click(function () {
    $("#navigation").toggleClass("show"); // Toggle the visibility of the mobile menu
  });
});
