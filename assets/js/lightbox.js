document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('photo-lightbox');
    const lightboxContent = document.getElementById('lightbox-content');
    const closeButton = document.getElementById('close-lightbox');
    const prevButton = document.getElementById('lightbox-arrow-prev');
    const nextButton = document.getElementById('lightbox-arrow-next');

    const photos = document.querySelectorAll('.photo-card');
    const photoArray = Array.from(photos);
    let currentPhotoIndex = 0;

    // Function to open the lightbox
    function openLightbox(photoSrc, reference, category) {
        lightboxContent.src = photoSrc;
        document.getElementById('lightbox-reference').textContent = reference;
        document.getElementById('lightbox-category').textContent = category;
        lightbox.style.display = 'block';
    }

    // Function to close the lightbox
    function closeLightbox() {
        lightbox.style.display = 'none';
    }

    // Function to load the previous image
    function loadPreviousImage() {
        if (currentPhotoIndex > 0) {
            currentPhotoIndex--;
            const previousPhoto = photoArray[currentPhotoIndex];
            const photoSrc = previousPhoto.querySelector('img').src;
            const reference = previousPhoto.dataset.reference;
            const category = previousPhoto.dataset.category;
            openLightbox(photoSrc, reference, category);
        }
    }

    // Function to load the next image
    function loadNextImage() {
        if (currentPhotoIndex < photoArray.length - 1) {
            currentPhotoIndex++;
            const nextPhoto = photoArray[currentPhotoIndex];
            const photoSrc = nextPhoto.querySelector('img').src;
            const reference = nextPhoto.dataset.reference;
            const category = nextPhoto.dataset.category;
            openLightbox(photoSrc, reference, category);
        }
    }

    // Close the lightbox when clicking the close button
    closeButton.addEventListener('click', closeLightbox);

    // Handle previous and next arrows
    prevButton.addEventListener('click', loadPreviousImage);
    nextButton.addEventListener('click', loadNextImage);

    // Close the lightbox when clicking outside it
    window.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    // Handle clicks on photos to open the lightbox using vanilla JavaScript
    const fullscreenIcons = document.querySelectorAll('.photo-card img.fullscreen-icon');
    fullscreenIcons.forEach(function (icon, index) {
        icon.addEventListener('click', function () {
            currentPhotoIndex = index;
            const photoCard = icon.closest('.photo-card');
            const photoSrc = photoCard.querySelector('img').src;
            const reference = photoCard.dataset.reference;
            const category = photoCard.dataset.category;
            openLightbox(photoSrc, reference, category);
        });
    });
});
