/* --- Mobile Menu Toggle --- */
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.header__navbar-mobile-toggle');
    const collapsibleMenu = document.querySelector('.header__navbar-collapsible-menu');

    if (mobileToggle && collapsibleMenu) {
        mobileToggle.addEventListener('click', function() {
            collapsibleMenu.classList.toggle('is-open');
        });
    }
    
    // Initialize Swiper after the DOM is fully loaded
    var swiper = new Swiper(".banner-slider", {
        loop: true, // Lặp lại slide
        autoplay: {
            delay: 3000, // Tự động chuyển slide sau 3 giây
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
});