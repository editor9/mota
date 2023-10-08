
jQuery.noConflict();

jQuery(document).ready(function($) {
  $(".navbar-toggler").click(function () {
    $("#navigation").toggleClass("show");
  });

  $(document).ready(function() {
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementsByClassName("open-modal")[0]; //getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

console.log("before btn check");
// When the user clicks on the button, open the modal
if (btn != null) {
  console.log("in btn check");
  btn.onclick = function() {
    modal.style.display = "block";
}
} 


// When the user clicks on <span> (x), close the modal
if (span != null) {
  span.onclick = function() {
    modal.style.display = "none";
  }
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
      modal.style.display = "none";
  }
}

});
});