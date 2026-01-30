/**
 * Footer Policy Popup Handler
 * Handles opening and closing of policy popups when policy links are clicked
 */

(function () {
  "use strict";

  // Wait for DOM to be ready
  document.addEventListener("DOMContentLoaded", function () {
    // Find all footer widgets on the page
    const footerWidgets = document.querySelectorAll(".ebp-footer-1");

    footerWidgets.forEach(function (footerWidget) {
      initPolicyPopup(footerWidget);
    });

    // Split all P tags inside .site-main into words using GSAP SplitText
    initSiteMainSplitText();
  });

  /**
   * Palette colors for char hover (excluding black). From design system.
   */
  const HOVER_COLORS = [
    "#5850c7" /* Purple - PRIMARY #1 */,
    "#eef900" /* Yellow - PRIMARY #2 */,
    "#504b39" /* Olive */,
    "#00b76d" /* Bright Green */,
    "#ff0000" /* Red */,
  ];

  /**
   * Pick a random color from the hover palette.
   * @returns {string} HEX color
   */
  function getRandomHoverColor() {
    return HOVER_COLORS[Math.floor(Math.random() * HOVER_COLORS.length)];
  }

  /**
   * Find all P, H1, H2, H3 and split their text into words and letters using GSAP SplitText.
   * P tags: split only, grass-style animation via CSS.
   * Headings: split + on hover each char gets a random color from the palette.
   */
  function initSiteMainSplitText() {
    const siteMain = document.querySelector("body");
    if (!siteMain) {
      return;
    }

    const textElements = siteMain.querySelectorAll("p, h1, h2, h3");
    if (!textElements.length) {
      return;
    }

    if (typeof SplitText === "undefined") {
      return;
    }

    textElements.forEach(function (element) {
      if (!element.textContent.trim() || element.querySelector(".split-word")) {
        return;
      }

      const split = new SplitText(element, { type: "words,chars" });
      const isHeading = element.matches("h1, h2, h3");

      if (split.words && split.words.length) {
        split.words.forEach(function (wordSpan) {
          wordSpan.classList.add("split-word");
        });
      }

      if (split.chars && split.chars.length) {
        split.chars.forEach(function (charSpan) {
          charSpan.classList.add("split-char");

          // Color-on-hover only for headings; p keeps CSS grass animation
          if (isHeading) {
            charSpan.addEventListener("mouseenter", function () {
              this.style.color = getRandomHoverColor();
            });
            charSpan.addEventListener("mouseleave", function () {
              this.style.color = "";
            });
          }
        });
      }
    });
  }

  /**
   * Initialize policy popup functionality for a specific footer widget
   * @param {HTMLElement} footerWidget - The footer widget container element
   */
  function initPolicyPopup(footerWidget) {
    // Get the policy data from the JSON script tag
    const policiesDataScript = footerWidget.querySelector(
      ".ebp-footer-1-policies-data"
    );
    if (!policiesDataScript) {
      return; // No policies data found
    }

    let policiesData = {};
    try {
      policiesData = JSON.parse(policiesDataScript.textContent);
    } catch (e) {
      console.error("Error parsing policies data:", e);
      return;
    }

    // Get modal elements
    const modal = footerWidget.querySelector(".ebp-footer-1-policy-modal");
    const modalOverlay = footerWidget.querySelector(
      ".ebp-footer-1-policy-modal-overlay"
    );
    const modalContent = footerWidget.querySelector(
      ".ebp-footer-1-policy-modal-content"
    );
    const modalTitle = footerWidget.querySelector(
      ".ebp-footer-1-policy-modal-title"
    );
    const modalBody = footerWidget.querySelector(
      ".ebp-footer-1-policy-modal-body"
    );
    const closeButton = footerWidget.querySelector(
      ".ebp-footer-1-policy-modal-close"
    );

    if (!modal || !modalTitle || !modalBody) {
      return; // Required elements not found
    }

    // Get all policy trigger buttons
    const policyTriggers = footerWidget.querySelectorAll(
      ".ebp-footer-1-policy-trigger"
    );

    /**
     * Open the modal with the specified policy content
     * @param {number} policyIndex - The index of the policy to display
     */
    function openModal(policyIndex) {
      const policy = policiesData[policyIndex];

      if (!policy) {
        return; // Policy not found
      }

      // Set the modal title
      modalTitle.textContent = policy.title || "";
      modalTitle.id = "ebp-policy-modal-title";

      // Set the modal content (rich text)
      modalBody.innerHTML = policy.content || "";

      // Show the modal
      modal.classList.add("ebp-footer-1-policy-modal-active");
      document.body.style.overflow = "hidden"; // Prevent body scroll

      // Focus on the close button for accessibility
      if (closeButton) {
        closeButton.focus();
      }
    }

    /**
     * Close the modal
     */
    function closeModal() {
      modal.classList.remove("ebp-footer-1-policy-modal-active");
      document.body.style.overflow = ""; // Restore body scroll
    }

    // Add click event listeners to all policy trigger buttons
    policyTriggers.forEach(function (trigger) {
      trigger.addEventListener("click", function () {
        const policyIndex = this.getAttribute("data-policy-index");
        if (policyIndex !== null) {
          openModal(parseInt(policyIndex, 10));
        }
      });
    });

    // Close modal when clicking the overlay
    if (modalOverlay) {
      modalOverlay.addEventListener("click", closeModal);
    }

    // Close modal when clicking the close button
    if (closeButton) {
      closeButton.addEventListener("click", closeModal);
    }

    // Close modal when pressing Escape key
    document.addEventListener("keydown", function (e) {
      // Only close if this modal is active
      if (
        modal.classList.contains("ebp-footer-1-policy-modal-active") &&
        e.key === "Escape"
      ) {
        closeModal();
      }
    });

    // Close modal when clicking outside the modal content (but inside the modal)
    if (modalContent) {
      modalContent.addEventListener("click", function (e) {
        // Stop event from bubbling to overlay
        e.stopPropagation();
      });
    }
  }
})();
