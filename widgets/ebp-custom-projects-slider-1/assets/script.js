/**
 * EBP Custom Projects Slider 1 – Swiper with cube effect
 * Requires Swiper (ebp-swiper-bundle.min) to be enqueued before this script.
 */
(function () {
  'use strict';

  function initSliders() {
    // Target every cube slider instance on the page (supports multiple widgets)
    const containers = document.querySelectorAll('.ebp-projects-slider-1 .ebp-projects-slider-1-swiper');
    if (!containers.length) return;

    containers.forEach(function (el) {
      // Skip if already initialised (e.g. after Elementor refresh)
      if (el.swiper) return;
      // Don't init if there are no slides (repeater empty)
      if (!el.querySelectorAll('.swiper-slide').length) return;

      new Swiper(el, {
        effect: 'cube',
        speed: 800, // Cube transition duration in ms (default 300; increase to slow down)
        grabCursor: true,
        cubeEffect: {
          shadow: true,
          slideShadows: true,
          shadowOffset: 20,
          shadowScale: 0.94,
        },
        pagination: {
          el: el.querySelector('.swiper-pagination'),
          clickable: true,
        },
        navigation: {
          nextEl: el.querySelector('.swiper-button-next'),
          prevEl: el.querySelector('.swiper-button-prev'),
        },
        loop: true,
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSliders);
  } else {
    initSliders();
  }

  // Re-init when Elementor frontend reloads the widget
  if (typeof window.elementorFrontend !== 'undefined') {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/ebp_custom_projects_slider_1.default', function () {
      initSliders();
    });
  }
})();
