/*!
 * Lightbox v1.0.0
 * Script for intialze  Carousel
 */
 jQuery(function($) {
    var swiper = new Swiper(".spm-portfolio-gallary", {
        slidesPerView: 1,
        spaceBetween: 20,
        slidesPerView: 4,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
          type: 'progressbar',
        },
        breakpoints: {
            // when window width is >= 0px
            0: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 320px
            320: {
              slidesPerView: 2,
              spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
              slidesPerView: 3,
              spaceBetween: 30
            },
            // when window width is >= 640px
            768: {
              slidesPerView: 3,
              spaceBetween: 40
            },

            900: {
                slidesPerView: 4,
                spaceBetween: 40
            }

          }
        // navigation: {
        //   nextEl: ".swiper-button-next",
        //   prevEl: ".swiper-button-prev",
        // },
      });
});