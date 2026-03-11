(function ($) {
  "use strict";

  // testimonial js code
  function pedroea_testimonial_slider($scope, $) {
    const slider = $(".pea-testimonial-slider", $scope)[0];
    const testimonialId = $scope[0].id;
    const paginationEl = $scope.find(".pea-swiper-pagination")[0];

    // convert string to number
    const slidestoshow = stringToNumber(slider.getAttribute('data-slidestoshow'));
    const slider_desktop_small_item = stringToNumber(slider.getAttribute('data-dekstop-small-items'));
    const slider_tablet_item = stringToNumber(slider.getAttribute('data-tablet-items'));
    const slider_mobile_item = stringToNumber(slider.getAttribute('data-mobile-items'));
    const slider_mobile_small_item = stringToNumber(slider.getAttribute('data-mobile-small-items'));
    const slider_spacebetween_item = stringToNumber(slider.getAttribute('data-spacebetween-items'));
    const slider_speed = stringToNumber(slider.getAttribute('data-speed'));

    // convert string to boolean
    const slider_autoplay = stringToBoolean(slider.getAttribute('data-autoplay'));
    const slider_loop = stringToBoolean(slider.getAttribute('data-loop'));
    const slider_pagination_click = stringToBoolean(slider.getAttribute('data-pagination-click'));

    function stringToNumber(string) {
      return parseInt(string, 10);
    }

    function stringToBoolean(string) {
      return Boolean(string);
    }

    let next = null;
    let prev = null;

    if (testimonialId) {
      const navContainer = $(`.pea-testimonial-nav#${testimonialId}`)[0];
      next = navContainer.querySelector(".pea-button-next");
      prev = navContainer.querySelector(".pea-button-prev");
    }

    new Swiper(slider, {
      slidesPerView: slidestoshow,
      loop: slider_loop,
      speed: slider_speed,
      autoplay: slider_autoplay,
      spaceBetween: slider_spacebetween_item,
      grabCursor: true,
      navigation: {
        nextEl: next,
        prevEl: prev,
      },
      pagination: {
        el: paginationEl,
        clickable: slider_pagination_click,
      },
      breakpoints: {
        480: { slidesPerView: slider_mobile_small_item },
        640: { slidesPerView: slider_mobile_item },
        768: { slidesPerView: slider_tablet_item },
        1024: { slidesPerView: slider_desktop_small_item },
        1440: { slidesPerView: slidestoshow },
      },
    });
  }

  // accordtion js code
  function pedroea_accordion($scope, $) {
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

  // filterable gallery js code
  function pedroea_filterable_gallery($scope, $) {
    $('.pea-filter').on('click', function () {
      var filterValue = $(this).attr('data-filter');
      var $gallery = $(this).closest('.pea-gallery-wrap').find('.pea-gallery');

      $(this).closest('.pea-filters').find('.pea-filter').removeClass('active');
      $(this).addClass('active');

      if (filterValue === '*') {
        $gallery.find('.pea-gallery-item').fadeIn(300);
      } else {
        $gallery.find('.pea-gallery-item').hide();
        $gallery.find(filterValue).fadeIn(300);
      }
    });
  }

  // content switcher js code
  function pedroea_content_switcher($scope, $) {
    const $root   = $scope.find('.pedroea-content-switcher');
    const $input  = $root.find('.pedroea-toggle-input');
    const $track  = $root.find('.pedroea-toggle-track');
    const $labels = $root.find('.pedroea-label');
    const $panels = $root.find('.pedroea-panel');

    function activate(index) {
      $labels.removeClass('active');
      $labels.filter('[data-index="' + index + '"]').addClass('active');
      $panels.removeClass('active');
      $panels.filter('[data-index="' + index + '"]').addClass('active');
    }

    $input.on('change', function () {
      const isOn = $(this).is(':checked');
      $track.toggleClass('active', isOn);
      activate(isOn ? 1 : 0);
    });

    $labels.on('click', function () {
      const idx = parseInt($(this).data('index'), 10);
      if (idx === 1 && !$input.is(':checked')) {
        $input.prop('checked', true).trigger('change');
      } else if (idx === 0 && $input.is(':checked')) {
        $input.prop('checked', false).trigger('change');
      }
    });
  }

  $(window).on("elementor/frontend/init", function () {

    // testimonial
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_testimonial.default",
      pedroea_testimonial_slider
    );

    // accordion
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_accordion.default",
      pedroea_accordion
    );

     // filterable gallery 
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_filterable_gallery.default",
      pedroea_filterable_gallery
    );

      // content switcher 
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_content_switcher.default",
      pedroea_content_switcher
    );

  });

})(jQuery);
