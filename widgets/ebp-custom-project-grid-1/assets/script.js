(function () {
  // Run when DOM is ready
  // We need the grid markup to exist before we can attach ScrollTrigger
  function initGrid() {
    // Find all project grid widgets on the page
    // Each widget may have multiple image items that will act as scroll triggers
    const grids = document.querySelectorAll(".ebp-project-grid-1");

    grids.forEach(function (grid) {
      // Check if GSAP and ScrollTrigger are available
      // These are presumed enqueued per project setup
      if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
        return;
      }

      // Register ScrollTrigger with GSAP (required for it to work)
      gsap.registerPlugin(ScrollTrigger);

      // Get every image item (parent wrapper) – this is the scroll trigger
      const imageItems = grid.querySelectorAll(
        ".ebp-project-grid-1-item--image"
      );
      if (imageItems.length === 0) return;

      // Only even-positioned image items get the scroll animation (2nd, 4th, 6th…)
      imageItems.forEach(function (item, index) {
        if (index % 2 !== 1) return;

        // Trigger is the item wrapper; inner and img are animated
        const inner = item.querySelector(
          ".ebp-project-grid-1-item-inner--image"
        );
        const img = inner ? inner.querySelector("img") : null;
        if (!inner) return;

        const triggerConfig = {
          trigger: item,
          start: "top 80%",
          toggleActions: "play reverse play reverse",
        };

        // Set .ebp-project-grid-1-item-inner--image to 100px Y initially
        gsap.set(inner, { y: 200 });
        // Animate to 0 on scroll trigger
        gsap.to(inner, {
          y: 0,
          duration: 2,
          ease: "back.out(2.2)",
          scrollTrigger: triggerConfig,
        });
      });

      // Odd-positioned image items (1st, 3rd, 5th…): one timeline per item – X first, then scale
      imageItems.forEach(function (item, index) {
        if (index % 2 !== 0) return;

        const inner = item.querySelector(
          ".ebp-project-grid-1-item-inner--image"
        );
        const img = inner ? inner.querySelector("img") : null;
        if (!inner || !img) return;

        const triggerConfig = {
          trigger: item,
          start: "top 70%",
          toggleActions: "play reverse play reverse",
        };

        gsap.set(inner, { x: -50 });

        const tl = gsap.timeline({ scrollTrigger: triggerConfig });
        tl.to(inner, {
          x: 0,
          duration: 1.3,
          ease: "power2.out",
        }).from(
          img,
          {
            scale: 1.2,
            duration: 1.3,
            ease: "power2.out",
          },
          "-=0.5"
        );
      });
    });
  }

  // Run on DOM ready; also refresh ScrollTrigger after layout shifts if needed
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initGrid);
  } else {
    initGrid();
  }
})();
