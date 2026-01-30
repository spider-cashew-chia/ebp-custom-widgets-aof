(function () {
  // One scratch surface for the whole beliefs zone so the user can scratch
  // across multiple items at once (3 on row 1, 2 on row 2, absolute layout).
  function initScratchCards() {
    const scratchZones = document.querySelectorAll(
      ".ebp-beliefs-1-scratch-zone"
    );

    scratchZones.forEach(function (zone) {
      const canvas = zone.querySelector(".ebp-beliefs-1-scratch-canvas");
      const tooltip = zone.querySelector(".ebp-beliefs-1-item-tooltip");

      if (!canvas) return;

      // Size canvas to the zone so it covers all items
      function updateCanvasSize() {
        const rect = zone.getBoundingClientRect();
        const width = rect.width;
        const height = rect.height;
        canvas.width = width;
        canvas.height = height;
        return { width, height };
      }

      const { width, height } = updateCanvasSize();
      const ctx = canvas.getContext("2d");

      // Full overlay that gets scratched away
      ctx.fillStyle = "#000000";
      ctx.fillRect(0, 0, width, height);
      ctx.globalCompositeOperation = "destination-out";

      let isScratching = false;
      let lastX = null;
      let lastY = null;

      function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches && e.touches.length > 0) {
          return {
            x: e.touches[0].clientX - rect.left,
            y: e.touches[0].clientY - rect.top,
          };
        }
        return {
          x: e.clientX - rect.left,
          y: e.clientY - rect.top,
        };
      }

      function scratchAt(x, y) {
        ctx.lineWidth = 150;
        ctx.lineCap = "round";
        ctx.lineJoin = "round";

        if (lastX !== null && lastY !== null) {
          ctx.beginPath();
          ctx.moveTo(lastX, lastY);
          ctx.lineTo(x, y);
          ctx.stroke();
        }

        ctx.beginPath();
        ctx.arc(x, y, 20, 0, Math.PI * 2);
        ctx.fill();

        lastX = x;
        lastY = y;
      }

      canvas.addEventListener("mousedown", function (e) {
        isScratching = true;
        const coords = getCoordinates(e);
        lastX = coords.x;
        lastY = coords.y;
        scratchAt(coords.x, coords.y);
        if (tooltip) tooltip.style.display = "none";
      });

      canvas.addEventListener("mousemove", function (e) {
        if (isScratching) {
          const coords = getCoordinates(e);
          scratchAt(coords.x, coords.y);
        }
      });

      canvas.addEventListener("mouseup", function () {
        isScratching = false;
        lastX = null;
        lastY = null;
      });

      canvas.addEventListener("mouseleave", function () {
        isScratching = false;
        lastX = null;
        lastY = null;
      });

      canvas.addEventListener("touchstart", function (e) {
        e.preventDefault();
        isScratching = true;
        const coords = getCoordinates(e);
        lastX = coords.x;
        lastY = coords.y;
        scratchAt(coords.x, coords.y);
        if (tooltip) tooltip.style.display = "none";
      });

      canvas.addEventListener("touchmove", function (e) {
        e.preventDefault();
        if (isScratching) {
          const coords = getCoordinates(e);
          scratchAt(coords.x, coords.y);
        }
      });

      canvas.addEventListener("touchend", function (e) {
        e.preventDefault();
        isScratching = false;
        lastX = null;
        lastY = null;
      });

      canvas.addEventListener("touchcancel", function () {
        isScratching = false;
        lastX = null;
        lastY = null;
      });

      function updateTooltipPosition(e) {
        if (!tooltip) return;
        const rect = zone.getBoundingClientRect();
        const offsetX = 15;
        const offsetY = -40;
        const tooltipX = e.clientX - rect.left + offsetX;
        const tooltipY = e.clientY - rect.top + offsetY;
        tooltip.style.left = tooltipX + "px";
        tooltip.style.top = tooltipY + "px";
        tooltip.style.transform = "none";
      }

      zone.addEventListener("mouseenter", function () {
        if (tooltip) tooltip.style.display = "block";
      });

      zone.addEventListener("mousemove", function (e) {
        if (tooltip && tooltip.style.display !== "none") {
          updateTooltipPosition(e);
        }
      });

      zone.addEventListener("mouseleave", function () {
        if (tooltip) tooltip.style.display = "none";
      });

      let resizeTimeout;
      window.addEventListener("resize", function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
          const { width: newWidth, height: newHeight } = updateCanvasSize();
          ctx.globalCompositeOperation = "source-over";
          ctx.fillStyle = "#000000";
          ctx.fillRect(0, 0, newWidth, newHeight);
          ctx.globalCompositeOperation = "destination-out";
        }, 250);
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initScratchCards);
  } else {
    initScratchCards();
  }

  if (typeof elementorFrontend !== "undefined") {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/ebp_custom_beliefs_1.default",
      function () {
        initScratchCards();
      }
    );
  }
})();
