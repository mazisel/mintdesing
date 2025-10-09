/* HOME SLIDER */
var home_slider = new Swiper(".home_slider", {
  lazy: true,
  loop: true,
  navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', },
  pagination: {el: ".swiper-pagination", clickable: true,},
  autoplay: {delay: 5000, },
});
/* COMMENT SLIDER */
var home_slider = new Swiper(".comment_slider", {
  lazy: true,
  loop: true,
  navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', },
  pagination: {el: ".swiper-pagination", clickable: true,},
  autoplay: {delay: 5000, },
});



/* REFERENCE SLIDER */
var swiper = new Swiper(".ilan_slider", {
  loop: true,
  slidesPerView: 2,
  spaceBetween: 30,
  autoplay: {delay: 5000, },
  breakpoints: {
    400: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    640: {
      slidesPerView: 4,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 5,
      spaceBetween: 40,
    },
    1024: {
      slidesPerView: 6,
      spaceBetween: 50,
    },
  },
});













// /* REFERENCE SLIDER */
// var swiper = new Swiper(".reference_slider", {
//   loop: true,
//   slidesPerView: 2,
//   spaceBetween: 30,
//   autoplay: {delay: 5000, },
//   breakpoints: {
//     400: {
//       slidesPerView: 3,
//       spaceBetween: 20,
//     },
//     640: {
//       slidesPerView: 4,
//       spaceBetween: 20,
//     },
//     768: {
//       slidesPerView: 5,
//       spaceBetween: 40,
//     },
//     1024: {
//       slidesPerView: 6,
//       spaceBetween: 50,
//     },
//   },
// });




