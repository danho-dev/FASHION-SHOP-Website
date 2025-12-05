// // Shopping cart
// (function() {
 
//   $("#cart").on("click", function() {
//     $(".shopping-cart").fadeToggle( "fast");
//   });
  
// })();

// // Form đăng ký
// function validateForm() {
//     var pass = document.forms["myForm"]["password"].value;
//     var confirm_pass = document.forms["myForm"]["confirmPassword"].value;
//     if ( pass != confirm_pass) {
//         alert("Bạn phải nhập 2 mật khẩu khớp với nhau!");
//         return false;
//     }
// }

/* --- Mobile Menu Toggle --- */
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.header__navbar-mobile-toggle');
    const collapsibleMenu = document.querySelector('.header__navbar-collapsible-menu');

    if (mobileToggle && collapsibleMenu) {
        mobileToggle.addEventListener('click', function() {
            collapsibleMenu.classList.toggle('is-open');
        });
    }
});