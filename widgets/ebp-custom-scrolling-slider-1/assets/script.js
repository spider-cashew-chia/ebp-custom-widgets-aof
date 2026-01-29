/**
 * EBP Custom Scrolling Slider 1 – 5 slides visible, continuous auto-scroll, loop.
 * No pause between slides (delay: 0) so motion never stops.
 */
(function () {
  "use strict";

  function initSliders() {
    const containers = document.querySelectorAll(
      ".ebp-scrolling-slider-1 .ebp-scrolling-slider-1-swiper"
    );
    if (!containers.length) return;

    containers.forEach(function (el) {
      if (el.swiper) return;
      if (!el.querySelectorAll(".swiper-slide").length) return;

      new Swiper(el, {
        slidesPerView: 5,
        slidesPerGroup: 1,
        spaceBetween: 16,
        loop: true,
        speed: 2000, // Higher = slower movement
        autoplay: {
          delay: 0, // 👈 no pauses
          disableOnInteraction: false,
        },

        freeMode: {
          enabled: true,
          momentum: false, // 👈 critical for smooth motion
        },
        breakpoints: {
          320: { slidesPerView: 2, slidesPerGroup: 1 },
          640: { slidesPerView: 3, slidesPerGroup: 1 },
          1024: { slidesPerView: 4, slidesPerGroup: 1 },
          1280: { slidesPerView: 5, slidesPerGroup: 1 },
        },
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSliders);
  } else {
    initSliders();
  }

  if (typeof window.elementorFrontend !== "undefined") {
    window.elementorFrontend.hooks.addAction(
      "frontend/element_ready/ebp_custom_scrolling_slider_1.default",
      function () {
        initSliders();
      }
    );
  }
})();
