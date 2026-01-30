/**
 * EBP Custom Hero 1 – ScrollTrigger: .ebp-hero-1-content is the trigger.
 * Animates .ebp-hero-1-heading to y: 0 on scroll, duration 1s.
 */
(function () {
  function initHeroScrollTrigger() {
    if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    document.querySelectorAll(".ebp-hero-1").forEach((hero) => {
      const content = hero.querySelector(".ebp-hero-1-content");
      const heading = hero.querySelector(".ebp-hero-1-heading");
      if (!content || !heading) return;

      gsap.to(heading, {
        y: 0,
        duration: 1,
        scrollTrigger: {
          trigger: content,
          start: "top 80%",
          toggleActions: "play none none none",
        },
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initHeroScrollTrigger);
  } else {
    initHeroScrollTrigger();
  }
})();
