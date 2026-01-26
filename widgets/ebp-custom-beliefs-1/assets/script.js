(function () {
  // Function to initialize the scratch card functionality
  // This runs when the DOM is ready
  function initScratchCards() {
    // Find all belief items on the page
    // Each item needs its own scratch canvas
    const beliefItems = document.querySelectorAll('.ebp-beliefs-1-item');

    // Loop through each belief item
    beliefItems.forEach(function (item) {
      // Get the canvas element for this item
      // This is the overlay that gets "scratched" away
      const canvas = item.querySelector('.ebp-beliefs-1-item-scratch-canvas');
      const overlay = item.querySelector('.ebp-beliefs-1-item-scratch-overlay');
      const tooltip = item.querySelector('.ebp-beliefs-1-item-tooltip');

      // Skip if canvas doesn't exist
      if (!canvas || !overlay) return;

      // Function to update canvas size
      // This ensures the canvas always matches the item size
      function updateCanvasSize() {
        const rect = item.getBoundingClientRect();
        const width = rect.width;
        const height = rect.height;

        // Set canvas size to match the item
        // This ensures the scratch effect covers the entire content
        canvas.width = width;
        canvas.height = height;
        
        return { width, height };
      }

      // Initialize canvas size
      const { width, height } = updateCanvasSize();

      // Get the 2D drawing context
      // This is what we use to draw on the canvas
      const ctx = canvas.getContext('2d');

      // Fill the canvas with black background
      // This creates the overlay that gets scratched away
      ctx.fillStyle = '#000000';
      ctx.fillRect(0, 0, width, height);

      // Set the composite operation to destination-out
      // This makes drawing erase instead of draw, revealing content underneath
      ctx.globalCompositeOperation = 'destination-out';

      // Track whether user is currently scratching
      // This prevents drawing when mouse/touch is not pressed
      let isScratching = false;
      let lastX = null;
      let lastY = null;

      // Function to get coordinates from mouse or touch event
      // This normalizes mouse and touch events to work the same way
      function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches && e.touches.length > 0) {
          // Touch event
          return {
            x: e.touches[0].clientX - rect.left,
            y: e.touches[0].clientY - rect.top,
          };
        } else {
          // Mouse event
          return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top,
          };
        }
      }

      // Function to scratch at a specific point
      // This draws a circle and connects to previous point for smooth scratching
      function scratchAt(x, y) {
        // Set line properties for smooth scratching
        ctx.lineWidth = 40; // Width of the scratch line
        ctx.lineCap = 'round'; // Rounded ends for smoother look
        ctx.lineJoin = 'round'; // Rounded joins between line segments
        
        // If we have a previous point, draw a line to connect them
        // This creates a smooth scratch path instead of disconnected circles
        if (lastX !== null && lastY !== null) {
          ctx.beginPath();
          ctx.moveTo(lastX, lastY);
          ctx.lineTo(x, y);
          ctx.stroke();
        }
        
        // Draw a circle at the current point
        // This ensures we always erase something, even on first click
        ctx.beginPath();
        ctx.arc(x, y, 20, 0, Math.PI * 2);
        ctx.fill();
        
        // Store current position for next scratch
        lastX = x;
        lastY = y;
      }

      // Mouse events for desktop
      // These handle clicking and dragging with the mouse
      canvas.addEventListener('mousedown', function (e) {
        isScratching = true;
        const coords = getCoordinates(e);
        // Reset last position on new scratch
        lastX = coords.x;
        lastY = coords.y;
        scratchAt(coords.x, coords.y);
        // Hide tooltip when user starts scratching
        if (tooltip) {
          tooltip.style.display = 'none';
        }
      });

      canvas.addEventListener('mousemove', function (e) {
        if (isScratching) {
          const coords = getCoordinates(e);
          scratchAt(coords.x, coords.y);
        }
      });

      canvas.addEventListener('mouseup', function () {
        isScratching = false;
        // Reset last position when done scratching
        lastX = null;
        lastY = null;
      });

      canvas.addEventListener('mouseleave', function () {
        isScratching = false;
        // Reset last position when mouse leaves
        lastX = null;
        lastY = null;
      });

      // Touch events for mobile devices
      // These handle touching and dragging with fingers
      canvas.addEventListener('touchstart', function (e) {
        e.preventDefault(); // Prevent scrolling while scratching
        isScratching = true;
        const coords = getCoordinates(e);
        // Reset last position on new scratch
        lastX = coords.x;
        lastY = coords.y;
        scratchAt(coords.x, coords.y);
        // Hide tooltip when user starts scratching
        if (tooltip) {
          tooltip.style.display = 'none';
        }
      });

      canvas.addEventListener('touchmove', function (e) {
        e.preventDefault(); // Prevent scrolling while scratching
        if (isScratching) {
          const coords = getCoordinates(e);
          scratchAt(coords.x, coords.y);
        }
      });

      canvas.addEventListener('touchend', function (e) {
        e.preventDefault();
        isScratching = false;
        // Reset last position when done scratching
        lastX = null;
        lastY = null;
      });

      canvas.addEventListener('touchcancel', function () {
        isScratching = false;
        // Reset last position on cancel
        lastX = null;
        lastY = null;
      });

      // Function to update tooltip position to follow cursor
      // This positions the tooltip near the mouse cursor
      function updateTooltipPosition(e) {
        if (!tooltip) return;
        
        const rect = item.getBoundingClientRect();
        const mouseX = e.clientX;
        const mouseY = e.clientY;
        
        // Position tooltip offset from cursor
        // Offset it slightly so it doesn't cover the cursor
        const offsetX = 15;
        const offsetY = -40;
        
        // Calculate position relative to the item
        const tooltipX = mouseX - rect.left + offsetX;
        const tooltipY = mouseY - rect.top + offsetY;
        
        // Update tooltip position
        tooltip.style.left = tooltipX + 'px';
        tooltip.style.top = tooltipY + 'px';
        tooltip.style.transform = 'none'; // Remove center transform
      }

      // Show tooltip on hover and make it follow cursor (desktop only)
      // This gives users a hint to interact with the item
      item.addEventListener('mouseenter', function () {
        if (tooltip) {
          tooltip.style.display = 'block';
        }
      });

      // Update tooltip position as cursor moves
      item.addEventListener('mousemove', function (e) {
        if (tooltip && tooltip.style.display !== 'none') {
          updateTooltipPosition(e);
        }
      });

      item.addEventListener('mouseleave', function () {
        if (tooltip) {
          tooltip.style.display = 'none';
        }
      });

      // Handle window resize
      // Recalculate canvas size if window is resized
      let resizeTimeout;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
          const { width: newWidth, height: newHeight } = updateCanvasSize();
          
          // Redraw the overlay with black background
          ctx.globalCompositeOperation = 'source-over';
          ctx.fillStyle = '#000000';
          ctx.fillRect(0, 0, newWidth, newHeight);
          
          ctx.globalCompositeOperation = 'destination-out';
        }, 250);
      });
    });
  }

  // Initialize when DOM is ready
  // This ensures all elements are loaded before we try to access them
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScratchCards);
  } else {
    // DOM is already ready
    initScratchCards();
  }

  // Also initialize after Elementor loads
  // Elementor widgets might load dynamically, so we check periodically
  if (typeof elementorFrontend !== 'undefined') {
    elementorFrontend.hooks.addAction('frontend/element_ready/ebp_custom_beliefs_1.default', function () {
      initScratchCards();
    });
  }
})();
