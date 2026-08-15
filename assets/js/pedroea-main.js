(function ($) {
  "use strict";

  // Fire a callback once the element scrolls into view (falls back to immediate).
  function onScrollIntoView(el, callback) {
    if (!el) return;
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            callback();
            observer.disconnect();
          }
        });
      }, { threshold: 0.15 });
      observer.observe(el);
    } else {
      callback();
    }
  }

  // testimonial js code
  function pedroea_testimonial_slider($scope, $) {
    const slider = $(".pea-testimonial-slider", $scope)[0];
    const testimonialId = $scope[0].id;
    const paginationEl = $scope.find(".pea-swiper-pagination")[0];

    if (!slider) {
      return;
    }

    // convert string to number
    const slidestoshow = stringToNumber(slider.getAttribute('data-slidestoshow'));
    const slider_desktop_small_item = stringToNumber(slider.getAttribute('data-desktop-small-items'));
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
      return string === 'yes';
    }

    let next = null;
    let prev = null;

    function connectNav(navContainer) {
      if (!navContainer) return;
      next = navContainer.querySelector(".pea-button-next") || next;
      prev = navContainer.querySelector(".pea-button-prev") || prev;
    }

    const sliderId = slider.getAttribute("id");

    if (sliderId) {
      connectNav($(`.pea-testimonial-nav#${sliderId}`)[0]);
    }

    if (testimonialId) {
      connectNav($(`.pea-testimonial-nav#${testimonialId}`)[0]);
    }

    if (!next && !prev) {
      const allNavs = document.querySelectorAll(".pea-testimonial-nav");
      if (allNavs.length === 1) {
        connectNav(allNavs[0]);
      }
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
      pagination: paginationEl ? {
        el: paginationEl,
        clickable: slider_pagination_click,
      } : false,
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

  // ticker js code
  function pedroea_ticker($scope, $) {
    const wrap  = $scope.find('.pea-ticker-wrap')[0];
    const track = $scope.find('.pea-ticker-track')[0];
    if (!wrap || !track) return;

    if (wrap.getAttribute('data-ticker-init')) return;
    wrap.setAttribute('data-ticker-init', '1');

    const speed     = parseFloat(wrap.getAttribute('data-speed')) || 50;
    const direction = wrap.getAttribute('data-direction') || 'left';
    const pause     = wrap.getAttribute('data-pause') === 'yes';

    const content = track.querySelector('.pea-ticker-content');
    if (!content) return;

    const original = content.innerHTML;
    content.innerHTML = original;

    // grow the strip until it covers at least double the container width so
    // short content still loops seamlessly
    let copies = 1;
    while (content.scrollWidth < wrap.clientWidth * 2 && copies < 8) {
      content.innerHTML += original;
      copies++;
    }

    // keep an even number of copies so the -50% translate loops seamlessly
    if (copies % 2 !== 0) {
      content.innerHTML += original;
    }

    const totalWidth = content.scrollWidth / 2;
    const duration   = totalWidth / speed;

    const styleId = 'pea-ticker-style-' + ($scope[0].id || Math.random().toString(36).slice(2));

    let styleEl = document.getElementById(styleId);
    if (!styleEl) {
      styleEl = document.createElement('style');
      styleEl.id = styleId;
      document.head.appendChild(styleEl);
    }

    const animName = 'pea-tick-' + styleId.replace('pea-ticker-style-', '');
    styleEl.textContent = '@keyframes ' + animName + ' {' +
      (direction === 'right'
        ? '0% { transform: translateX(-50%); } 100% { transform: translateX(0); }'
        : '0% { transform: translateX(0); } 100% { transform: translateX(-50%); }') +
    '}';

    content.style.animation = 'none';
    void content.offsetWidth;
    content.style.animation = animName + ' ' + duration + 's linear infinite';

    if (pause) {
      wrap.addEventListener('mouseenter', function () {
        wrap.classList.add('is-paused');
      });
      wrap.addEventListener('mouseleave', function () {
        wrap.classList.remove('is-paused');
      });
    }

  }

  // 360 rotation js code
  function pedroea_threesixty_rotation($scope, $) {
    var viewer = $scope.find('.pedroea-360-viewer')[0];
    if (!viewer) return;

    var frameEl  = viewer.querySelector('.pedroea-360-frame');
    var frames   = JSON.parse(viewer.getAttribute('data-frames') || '[]');
    var total    = parseInt(viewer.getAttribute('data-total')) || frames.length;
    var autoplay = viewer.getAttribute('data-autoplay') || 'none';
    var speed    = parseInt(viewer.getAttribute('data-autoplay-speed')) || 2000;
    var magnify  = viewer.getAttribute('data-magnify') === 'yes';
    var magAmt   = parseInt(viewer.getAttribute('data-magnify-amount')) || 200;

    if (frames.length < 2) return;

    var current   = 0;
    var isPlaying = autoplay === 'autoplay';
    var playTimer = null;
    var magnified = false;

    // preload images
    var loaded = [];
    for (var i = 0; i < frames.length; i++) {
      var img = new Image();
      img.src = frames[i];
      loaded.push(img);
    }

    function showFrame(index) {
      current = ((index % total) + total) % total;
      frameEl.src = frames[current];
    }

    // drag to rotate
    var isDown = false;
    var startX = 0;

    function onRotateMouseDown(e) {
      if (magnified) return;
      isDown = true;
      startX = e.clientX || e.pageX;
    }

    function onRotateMouseMove(e) {
      if (!isDown || magnified) return;
      var x = e.clientX || e.pageX;
      var diff = startX - x;
      if (Math.abs(diff) > 5) {
        var dir = diff > 0 ? 1 : -1;
        showFrame(current + dir);
        startX = x;
      }
    }

    function onRotateMouseUp() {
      isDown = false;
    }

    viewer.addEventListener('mousedown', onRotateMouseDown);

    // touch rotate
    viewer.addEventListener('touchstart', function (e) {
      if (magnified) return;
      var t = e.touches[0];
      isDown = true;
      startX = t.clientX || t.pageX;
    }, { passive: true });

    viewer.addEventListener('touchmove', function (e) {
      if (!isDown || magnified) return;
      var t = e.touches[0];
      var x = t.clientX || t.pageX;
      var diff = startX - x;
      if (Math.abs(diff) > 5) {
        var dir = diff > 0 ? 1 : -1;
        showFrame(current + dir);
        startX = x;
      }
    }, { passive: true });

    viewer.addEventListener('touchend', function () {
      isDown = false;
    });

    // autoplay
    function startAutoplay() {
      stopAutoplay();
      isPlaying = true;
      playTimer = setInterval(function () {
        showFrame(current + 1);
      }, speed);
    }

    function stopAutoplay() {
      isPlaying = false;
      if (playTimer) {
        clearInterval(playTimer);
        playTimer = null;
      }
    }

    if (autoplay === 'autoplay') {
      startAutoplay();
    }

    // button play
    if (autoplay === 'button') {
      var playBtn = $scope.find('.pedroea-360-play-btn')[0];
      if (playBtn) {
        playBtn.addEventListener('click', function () {
          if (isPlaying) {
            stopAutoplay();
          } else {
            startAutoplay();
          }
          var playIcon  = playBtn.querySelector('.pedroea-360-play-icon');
          var pauseIcon = playBtn.querySelector('.pedroea-360-pause-icon');
          if (playIcon && pauseIcon) {
            playIcon.style.display  = isPlaying ? 'none' : '';
            pauseIcon.style.display = isPlaying ? '' : 'none';
          }
        });
      }
    }

    // magnify
    if (magnify) {
      var magBtn = viewer.querySelector('.pedroea-360-magnify-btn');
      if (magBtn) {
        magBtn.addEventListener('click', function () {
          magnified = !magnified;
          magBtn.classList.toggle('is-active');
          viewer.classList.toggle('is-magnified');
          if (magnified) {
            frameEl.style.transform = 'scale(' + (magAmt / 100) + ')';
            frameEl.style.transformOrigin = 'center center';
            frameEl.style.cursor = 'grab';
          } else {
            frameEl.style.transform = '';
            frameEl.style.cursor = '';
          }
        });
      }
    }

    // window drag handlers (rotation + pan), registered on mousedown and
    // removed on mouseup so multiple widget instances never accumulate listeners
    var panX = 0, panY = 0, panStartX = 0, panStartY = 0, isPanning = false;

    function onPanMouseDown(e) {
      if (!magnified) return;
      isPanning = true;
      panStartX = e.clientX - panX;
      panStartY = e.clientY - panY;
    }

    function onPanMouseMove(e) {
      if (!isPanning || !magnified) return;
      panX = e.clientX - panStartX;
      panY = e.clientY - panStartY;
      frameEl.style.transform = 'scale(' + (magAmt / 100) + ') translate(' + panX + 'px, ' + panY + 'px)';
    }

    function onPanMouseUp() {
      isPanning = false;
      removeDragListeners();
    }

    function onRotateMouseUpCleanup() {
      isDown = false;
      removeDragListeners();
    }

    function addDragListeners() {
      window.addEventListener('mousemove', onRotateMouseMove);
      window.addEventListener('mouseup', onRotateMouseUpCleanup);
      window.addEventListener('mousemove', onPanMouseMove);
      window.addEventListener('mouseup', onPanMouseUp);
    }

    function removeDragListeners() {
      window.removeEventListener('mousemove', onRotateMouseMove);
      window.removeEventListener('mouseup', onRotateMouseUpCleanup);
      window.removeEventListener('mousemove', onPanMouseMove);
      window.removeEventListener('mouseup', onPanMouseUp);
    }

    viewer.addEventListener('mousedown', function (e) {
      if (magnified) {
        onPanMouseDown(e);
      } else {
        onRotateMouseDown(e);
      }
      addDragListeners();
    });
  }

  // counter js code
  function pedroea_counter($scope, $) {
    var numberEl = $scope.find('.pedroea-counter-number')[0];
    if (!numberEl || numberEl.getAttribute('data-animated')) return;
    numberEl.setAttribute('data-animated', '1');

    onScrollIntoView(numberEl, function () {
      var start    = parseInt(numberEl.getAttribute('data-start')) || 0;
      var end      = parseInt(numberEl.getAttribute('data-end')) || 100;
      var duration = parseInt(numberEl.getAttribute('data-duration')) || 2000;
      var sep      = numberEl.getAttribute('data-separator') === 'yes';

      var startTime = Date.now();

      var timer = setInterval(function () {
        var elapsed = Date.now() - startTime;
        var progress = Math.min(elapsed / duration, 1);
        var current = Math.round(start + (end - start) * progress);
        numberEl.textContent = sep
          ? current.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
          : current;
        if (progress >= 1) {
          clearInterval(timer);
        }
      }, 16);
    });
  }

  // modal popup js code
  function pedroea_modal_popup($scope, $) {
    const trigger = $scope.find('.pea-modal-trigger')[0];
    if (!trigger) return;

    const modalId = trigger.getAttribute('data-modal');
    const overlay = document.getElementById(modalId);
    if (!overlay) return;

    const closeBtn = overlay.querySelector('.pea-modal-close');
    const closeOverlay = overlay.getAttribute('data-close-overlay') !== 'false';
    const closeEsc = overlay.getAttribute('data-close-esc') !== 'false';

    function open() {
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function close() {
      overlay.classList.remove('active');
      document.body.style.overflow = '';
    }

    trigger.addEventListener('click', open);

    if (closeBtn) {
      closeBtn.addEventListener('click', close);
    }

    if (closeOverlay) {
      overlay.addEventListener('click', function (e) {
        if (e.target === overlay) close();
      });
    }

    if (closeEsc) {
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('active')) {
          close();
        }
      });
    }
  }

  // advanced tabs js code
  function pedroea_advanced_tabs($scope, $) {
    const nav = $scope.find('.pea-tabs-nav')[0];
    if (!nav) return;

    nav.addEventListener('click', function (e) {
      const btn = e.target.closest('.pea-tab-btn');
      if (!btn) return;

      const idx = btn.getAttribute('data-tab');
      const container = btn.closest('.pea-advanced-tabs');
      if (!container) return;

      container.querySelectorAll('.pea-tab-btn').forEach(function (b) {
        b.classList.remove('active');
      });
      container.querySelectorAll('.pea-tab-content').forEach(function (c) {
        c.classList.remove('active');
      });
      btn.classList.add('active');
      const content = container.querySelector('.pea-tab-content[data-tab="' + idx + '"]');
      if (content) content.classList.add('active');
    });
  }

  // video popup js code
  function pedroea_video_popup($scope, $) {
    const wrap = $scope.find('.pea-video-wrap')[0];
    if (!wrap) return;

    const playBtn = wrap.querySelector('.pea-video-play-btn');
    const modal   = wrap.querySelector('.pea-video-modal');
    const close   = wrap.querySelector('.pea-video-close');
    const iframe  = wrap.querySelector('iframe');
    const video   = wrap.querySelector('video');
    const videoUrl = wrap.getAttribute('data-video');

    if (!playBtn || !modal || !close) return;

    playBtn.addEventListener('click', function () {
      modal.classList.add('active');
      if (iframe && videoUrl) {
        iframe.src = videoUrl;
      }
      if (video && videoUrl) {
        video.src = videoUrl;
        video.play();
      }
      document.body.style.overflow = 'hidden';
    });

    close.addEventListener('click', function () {
      modal.classList.remove('active');
      if (iframe) {
        iframe.src = '';
      }
      if (video) {
        video.pause();
      }
      document.body.style.overflow = '';
    });

    modal.addEventListener('click', function (e) {
      if (e.target === modal) {
        close.click();
      }
    });
  }

  // progress bar js code
  function pedroea_progress_bar($scope, $) {
    const wrapper = $scope.find('.pea-progress-bar')[0];
    if (!wrapper) return;

    const percent  = parseInt(wrapper.getAttribute('data-percent')) || 0;
    const duration = parseInt(wrapper.getAttribute('data-duration')) || 1500;

    const fill = wrapper.querySelector('.pea-progress-fill');
    if (!fill) return;

    if (wrapper.classList.contains('pea-progress-animated')) return;
    wrapper.classList.add('pea-progress-animated');

    onScrollIntoView(wrapper, function () {
      const startTime = Date.now();
      function animate() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const current = Math.round(percent * progress);
        fill.style.width = current + '%';
        if (progress < 1) {
          requestAnimationFrame(animate);
        }
      }
      requestAnimationFrame(animate);
    });
  }

  // image carousel js code
  function pedroea_image_carousel($scope, $) {
    const wrapper = $scope.find('.pea-image-carousel')[0];
    if (!wrapper) return;

    const slidesPerView  = parseInt(wrapper.getAttribute('data-slides-per-view')) || 3;
    const slidesTablet   = parseInt(wrapper.getAttribute('data-slides-per-view-tablet')) || slidesPerView;
    const slidesMobile   = parseInt(wrapper.getAttribute('data-slides-per-view-mobile')) || slidesTablet;
    const spaceBetween   = parseInt(wrapper.getAttribute('data-space-between')) || 16;
    const autoplay       = wrapper.getAttribute('data-autoplay') === 'yes';
    const autoplaySpeed  = parseInt(wrapper.getAttribute('data-autoplay-speed')) || 3000;
    const pauseHover     = wrapper.getAttribute('data-pause-hover') === 'yes';
    const loop           = wrapper.getAttribute('data-loop') === 'yes';
    const showArrows     = wrapper.getAttribute('data-arrows') === 'yes';
    const showPagination = wrapper.getAttribute('data-pagination') === 'yes';
    const paginationType = wrapper.getAttribute('data-pagination-type') || 'bullets';

    const swiperEl = wrapper.querySelector('.swiper');
    if (!swiperEl) return;

    const paginationEl = wrapper.querySelector('.swiper-pagination');
    const prevEl       = wrapper.querySelector('.pea-carousel-prev');
    const nextEl       = wrapper.querySelector('.pea-carousel-next');

    new Swiper(swiperEl, {
      slidesPerView: slidesMobile,
      spaceBetween: spaceBetween,
      loop: loop,
      autoplay: autoplay ? { delay: autoplaySpeed, pauseOnMouseEnter: pauseHover, disableOnInteraction: false } : false,
      grabCursor: true,
      navigation: {
        nextEl: nextEl,
        prevEl: prevEl,
      },
      pagination: paginationEl ? {
        el: paginationEl,
        type: paginationType,
        clickable: true,
      } : false,
      breakpoints: {
        768:  { slidesPerView: slidesTablet },
        1024: { slidesPerView: slidesPerView },
      },
    });
  }

  // countdown js code
  function pedroea_countdown($scope, $) {
    const wrap = $scope.find('.pea-countdown')[0];
    if (!wrap) return;

    const targetStr = wrap.getAttribute('data-target');
    if (!targetStr) return;

    function parseTarget(str) {
      const m = str.match(/^(\d{4})-(\d{2})-(\d{2})[T ](\d{2}):(\d{2})(?::(\d{2}))?/);
      if (m) {
        return new Date(+m[1], +m[2] - 1, +m[3], +m[4], +m[5], +(m[6] || 0)).getTime();
      }
      return new Date(str).getTime();
    }

    const target = parseTarget(targetStr);
    if (isNaN(target)) return;

    const showDays    = wrap.getAttribute('data-days') !== 'no';
    const showHours   = wrap.getAttribute('data-hours') !== 'no';
    const showMinutes = wrap.getAttribute('data-minutes') !== 'no';
    const showSeconds = wrap.getAttribute('data-seconds') !== 'no';

    function pad(n) {
      return n < 10 ? '0' + n : '' + n;
    }

    function tick() {
      const now     = new Date().getTime();
      let diff      = Math.max(0, target - now);
      const days    = Math.floor(diff / 86400000); diff -= days * 86400000;
      const hours   = Math.floor(diff / 3600000);  diff -= hours * 3600000;
      const minutes = Math.floor(diff / 60000);    diff -= minutes * 60000;
      const seconds = Math.floor(diff / 1000);

      wrap.querySelectorAll('.pea-cd-item').forEach(function (item) {
        const unit = item.getAttribute('data-unit');
        const digit = item.querySelector('.pea-cd-digit');
        if (!digit) return;
        switch (unit) {
          case 'days':    digit.textContent = pad(days);    break;
          case 'hours':   digit.textContent = pad(hours);   break;
          case 'minutes': digit.textContent = pad(minutes); break;
          case 'seconds': digit.textContent = pad(seconds); break;
        }
      });
    }

    tick();
    setInterval(tick, 1000);
  }

  // progress ring js code
  function pedroea_progress_ring($scope, $) {
    const svg = $scope.find('.pea-pr-svg')[0];
    if (!svg) return;

    const bar = svg.querySelector('.pea-pr-bar');
    if (!bar) return;

    const offset   = parseFloat(svg.getAttribute('data-offset'));
    const circ     = parseFloat(svg.getAttribute('data-circ'));
    const duration = parseInt(svg.getAttribute('data-duration')) || 1200;

    if (svg.classList.contains('pea-pr-animated')) return;
    svg.classList.add('pea-pr-animated');

    onScrollIntoView(svg, function () {
      const startTime = Date.now();
      function animate() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const current = offset + (circ - offset) * (1 - progress);
        bar.setAttribute('stroke-dashoffset', circ - (circ - current));
        if (progress < 1) {
          requestAnimationFrame(animate);
        } else {
          bar.setAttribute('stroke-dashoffset', offset);
        }
      }
      // wait a frame so initial paint is set
      requestAnimationFrame(function () {
        bar.setAttribute('stroke-dashoffset', circ);
        requestAnimationFrame(animate);
      });
    });
  }

  // image comparison js code
  function pedroea_image_comparison($scope, $) {
    const wrap = $scope.find('.pea-image-comparison')[0];
    if (!wrap) return;

    const before    = wrap.querySelector('.pea-ic-before');
    const handle    = wrap.querySelector('.pea-ic-handle');
    const isVertical = wrap.getAttribute('data-orientation') === 'vertical';
    const defaultOffset = parseFloat(wrap.getAttribute('data-offset')) || 50;

    let isDragging = false;

    function setPosition(pct) {
      pct = Math.max(0, Math.min(100, pct));
      if (isVertical) {
        before.style.height = pct + '%';
        handle.style.top = pct + '%';
      } else {
        before.style.width = pct + '%';
        handle.style.left = pct + '%';
      }
    }

    setPosition(defaultOffset);

    function getPosition(e) {
      const rect = wrap.getBoundingClientRect();
      const clientX = e.clientX || (e.touches ? e.touches[0].clientX : 0);
      const clientY = e.clientY || (e.touches ? e.touches[0].clientY : 0);
      if (isVertical) {
        return ((clientY - rect.top) / rect.height) * 100;
      }
      return ((clientX - rect.left) / rect.width) * 100;
    }

    wrap.addEventListener('mousedown', function (e) {
      isDragging = true;
      setPosition(getPosition(e));
    });

    window.addEventListener('mousemove', function (e) {
      if (!isDragging) return;
      setPosition(getPosition(e));
    });

    window.addEventListener('mouseup', function () {
      isDragging = false;
    });

    wrap.addEventListener('touchstart', function (e) {
      isDragging = true;
      setPosition(getPosition(e));
    }, { passive: true });

    wrap.addEventListener('touchmove', function (e) {
      if (!isDragging) return;
      setPosition(getPosition(e));
    }, { passive: true });

    wrap.addEventListener('touchend', function () {
      isDragging = false;
    });
  }

  // off-canvas js code
  function pedroea_off_canvas($scope, $) {
    const root = $scope.find('.pea-off-canvas')[0];
    if (!root) return;

    const trigger = root.querySelector('.pea-oc-trigger');
    const overlay = root.querySelector('.pea-oc-overlay');
    const panel   = root.querySelector('.pea-oc-panel');
    if (!trigger || !overlay || !panel) return;

    const closeBtn = panel.querySelector('.pea-oc-close');
    const closeOverlay = overlay.getAttribute('data-close-overlay') !== 'false';
    const closeEsc = overlay.getAttribute('data-close-esc') !== 'false';

    function open() {
      overlay.classList.add('active');
      panel.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function close() {
      overlay.classList.remove('active');
      panel.classList.remove('active');
      document.body.style.overflow = '';
    }

    trigger.addEventListener('click', open);

    if (closeBtn) {
      closeBtn.addEventListener('click', close);
    }

    if (closeOverlay) {
      overlay.addEventListener('click', function (e) {
        if (e.target === overlay) close();
      });
    }

    if (closeEsc) {
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && panel.classList.contains('active')) {
          close();
        }
      });
    }
  }

  function pedroea_animated_headline($scope, $) {
    const root = $scope.find('.pea-animated-headline')[0];
    if (!root) return;

    const style  = root.getAttribute('data-style');
    const words  = JSON.parse(root.getAttribute('data-words') || '[]');
    const speed  = parseInt(root.getAttribute('data-speed') || '2500', 10);
    const tSpeed = parseInt(root.getAttribute('data-typed-speed') || '80', 10);
    const wordEl = root.querySelector('.pea-ah-rotated-word');
    if (!wordEl || words.length < 2) return;

    let index = 0;
    let timer = null;

    if (style === 'typed') {
      let charIndex = 0;
      let deleting = false;

      function typeLoop() {
        const current = words[index];
        if (!deleting) {
          charIndex++;
          wordEl.textContent = current.slice(0, charIndex);
          if (charIndex === current.length) {
            deleting = true;
            timer = setTimeout(typeLoop, speed);
            return;
          }
        } else {
          charIndex--;
          wordEl.textContent = current.slice(0, charIndex);
          if (charIndex === 0) {
            deleting = false;
            index = (index + 1) % words.length;
          }
        }
        timer = setTimeout(typeLoop, deleting ? tSpeed / 2 : tSpeed);
      }
      typeLoop();
      return;
    }

    function rotate() {
      index = (index + 1) % words.length;
      wordEl.textContent = words[index];
      wordEl.classList.remove('pea-ah-anim');
      void wordEl.offsetWidth;
      wordEl.classList.add('pea-ah-anim');
    }

    timer = setInterval(rotate, speed);
  }

  let fbSdkPromise = null;

  function pedroea_fb_load_sdk() {
    if (window.FB && window.FB.XFBML) {
      return Promise.resolve();
    }
    if (fbSdkPromise) {
      return fbSdkPromise;
    }
    fbSdkPromise = new Promise(function (resolve) {
      const script = document.createElement('script');
      script.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v18.0';
      script.async = true;
      script.defer = true;
      script.onload = function () {
        if (window.FB && window.FB.XFBML) {
          window.FB.init({ xfbml: true, version: 'v18.0' });
        }
        resolve();
      };
      script.onerror = resolve;
      document.body.appendChild(script);
    });
    return fbSdkPromise;
  }

  function pedroea_fb_widget($scope, $) {
    const root = $scope.find('.pea-fb-wrap')[0];
    if (!root) return;

    pedroea_fb_load_sdk().then(function () {
      if (window.FB && window.FB.XFBML) {
        window.FB.XFBML.parse(root);
      }
    });
  }

  function pedroea_form($scope, $) {
    const form = $scope.find('.pea-form')[0];
    if (!form) return;

    const messageBox = $scope.find('.pea-form-message')[0];
    const submitBtn  = form.querySelector('.pea-form-submit');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const fields = [];
      const inputs = form.querySelectorAll('.pea-form-control');
      let valid = true;

      inputs.forEach(function (input) {
        const type = input.getAttribute('data-type') || input.type;

        if (input.type === 'hidden' || input.className.indexOf('pea-form-hp') !== -1) return;

        if (input.type === 'radio' || input.type === 'checkbox') {
          if (input.required && !form.querySelector('input[name="' + input.name + '"]:checked')) {
            valid = false;
            input.closest('.pea-form-option').classList.add('pea-form-error');
          }
          return;
        }

        let value = input.value.trim();
        const isReq = input.hasAttribute('required');

        if (type === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
          valid = false;
          input.classList.add('pea-form-error');
        } else if (isReq && !value) {
          valid = false;
          input.classList.add('pea-form-error');
        } else {
          input.classList.remove('pea-form-error');
        }

        const label = form.querySelector('label[for="' + input.id + '"]');
        fields.push({ name: input.name, label: label ? label.textContent.replace('*', '').trim() : input.name, value: value });
      });

      if (!valid) {
        showFormMessage(messageBox, form.getAttribute('data-error') || 'Please fill in the required fields.', 'error');
        return;
      }

      form.classList.add('is-loading');
      submitBtn.disabled = true;

      const data = new URLSearchParams();
      data.append('action', 'pedroea_form_submit');
      data.append('nonce', (window.pedroea_form_data && window.pedroea_form_data.nonce) || '');
      data.append('form_id', form.getAttribute('data-form-id') || '');
      data.append('to', form.getAttribute('data-email-to') || '');
      data.append('subject', form.getAttribute('data-email-subject') || '');
      data.append('pea_hp', form.querySelector('.pea-form-hp') ? form.querySelector('.pea-form-hp').value : '');
      data.append('fields', JSON.stringify(fields));

      const url = (window.pedroea_form_data && window.pedroea_form_data.ajaxurl) || '/wp-admin/admin-ajax.php';

      fetch(url, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }, body: data.toString() })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          form.classList.remove('is-loading');
          submitBtn.disabled = false;
          if (json && json.success) {
            const redirect = form.getAttribute('data-redirect');
            if (redirect) {
              window.location.href = redirect;
              return;
            }
            showFormMessage(messageBox, form.getAttribute('data-success') || 'Your message has been sent successfully.', 'success');
            form.reset();
          } else {
            showFormMessage(messageBox, form.getAttribute('data-error') || 'Something went wrong. Please try again.', 'error');
          }
        })
        .catch(function () {
          form.classList.remove('is-loading');
          submitBtn.disabled = false;
          showFormMessage(messageBox, form.getAttribute('data-error') || 'Something went wrong. Please try again.', 'error');
        });
    });
  }

  function showFormMessage(box, text, type) {
    if (!box) return;
    box.textContent = text;
    box.className = 'pea-form-message pea-form-' + type;
    box.hidden = false;
  }

  function pedroea_hotspot($scope, $) {
    const root = $scope.find('.pea-hotspot')[0];
    if (!root) return;

    const trigger = root.getAttribute('data-trigger') || 'click';
    const dots = root.querySelectorAll('.pea-hotspot-dot');

    dots.forEach(function (dot) {
      const toggle = function () {
        dot.classList.toggle('active');
      };

      if (trigger === 'hover') {
        dot.addEventListener('mouseenter', function () { dot.classList.add('active'); });
        dot.addEventListener('mouseleave', function () { dot.classList.remove('active'); });
      } else {
        dot.addEventListener('click', function (e) {
          e.stopPropagation();
          const wasActive = dot.classList.contains('active');
          dots.forEach(function (d) { d.classList.remove('active'); });
          if (!wasActive) dot.classList.add('active');
        });
      }
    });

    document.addEventListener('click', function (e) {
      if (!root.contains(e.target)) {
        dots.forEach(function (d) { d.classList.remove('active'); });
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

      // ticker
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_ticker.default",
      pedroea_ticker
    );

      // counter
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_counter.default",
      pedroea_counter
    );

      // 360 rotation
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_threesixty_rotation.default",
      pedroea_threesixty_rotation
    );

      // modal popup
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_modal_popup.default",
      pedroea_modal_popup
    );

      // advanced tabs
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_advanced_tabs.default",
      pedroea_advanced_tabs
    );

      // video popup
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_video_popup.default",
      pedroea_video_popup
    );

      // progress bar
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_progress_bar.default",
      pedroea_progress_bar
    );

      // image carousel
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_image_carousel.default",
      pedroea_image_carousel
    );

      // countdown
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_countdown.default",
      pedroea_countdown
    );

      // progress ring
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_progress_ring.default",
      pedroea_progress_ring
    );

      // image comparison
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_image_comparison.default",
      pedroea_image_comparison
    );

      // off-canvas menu
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_off_canvas.default",
      pedroea_off_canvas
    );

      // animated headline
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_animated_headline.default",
      pedroea_animated_headline
    );

      // form
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_form.default",
      pedroea_form
    );

      // hotspot
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_hotspot.default",
      pedroea_hotspot
    );

      // facebook widgets
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_facebook_button.default",
      pedroea_fb_widget
    );
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_facebook_comments.default",
      pedroea_fb_widget
    );
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_facebook_embed.default",
      pedroea_fb_widget
    );
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pedroea_facebook_page.default",
      pedroea_fb_widget
    );

  });

})(jQuery);
