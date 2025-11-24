(function ($) {
  "use strict";

  function pea_testimonial_slider($scope, $) {
    // selector
    const slider =  $(".pea-testimonial-slider", $scope)[0];
    const next   =  $(".pea-button-next", $scope)[0];
    const prev   =  $(".pea-button-prev", $scope)[0];

    // Initialize Swiper
    if (slider) {
      new Swiper(slider, {
        slidesPerView: 3,
        loop: true,
        spaceBetween: 20,
        grabCursor: true,
        navigation: {
          nextEl: next,
          prevEl: prev,
        },
        pagination: {
          el: $scope.find(".pea-swiper-pagination")[0],
          clickable: true,
        },
        breakpoints: {
          640:  { slidesPerView: 1 },
          768:  { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        },
      });
    }
  }

  // accordtion js code
  function pea_accordion($scope, $) {
    const accordionTriggers = $scope[0].querySelectorAll('.pea-accordion-trigger');

    accordionTriggers.forEach(trigger => {
      trigger.addEventListener('click', function () {
        const accordionItem = this.parentElement;
        const isActive = accordionItem.classList.contains('active');

        $scope[0].querySelectorAll('.pea-accordion-item').forEach(item => {
          item.classList.remove('active');
        });

        if (!isActive) {
          accordionItem.classList.add('active');
        }
      });
    });
  }

  $(window).on("elementor/frontend/init", function () {

    // testimonial
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_testimonial.default",
       pea_testimonial_slider
    );
 
    // accordion 
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_accordion.default",
       pea_accordion
    );
  });

})(jQuery);


