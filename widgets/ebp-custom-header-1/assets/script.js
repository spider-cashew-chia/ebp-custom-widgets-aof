(function () {
  // Function to cycle through random characters for tagline
  // This creates a "glitch" effect by replacing each character with random ones
  function cycleTaglineCharacters(element) {
    // Get the original text from the data attribute
    const originalText = element.getAttribute("data-original-text");
    if (!originalText) return;

    // Characters to use for random cycling (letters, numbers, symbols)
    const chars =
      "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
    const duration = 2000; // 2 seconds
    const steps = 20; // Number of animation steps
    const stepDuration = duration / steps;
    let currentStep = 0;

    // Clear any existing interval
    if (element.cycleInterval) {
      clearInterval(element.cycleInterval);
    }

    // Start the animation
    element.cycleInterval = setInterval(() => {
      currentStep++;

      // Create new text with random characters
      let newText = "";
      for (let i = 0; i < originalText.length; i++) {
        // Calculate how many characters should be revealed
        // As we progress, more characters become the original
        const revealProgress = currentStep / steps;
        const shouldReveal =
          i < Math.floor(originalText.length * revealProgress);

        if (shouldReveal) {
          // Use original character
          newText += originalText[i];
        } else {
          // Use random character
          newText += chars[Math.floor(Math.random() * chars.length)];
        }
      }

      // Update the element text
      element.textContent = newText;

      // Stop when all characters are revealed
      if (currentStep >= steps) {
        clearInterval(element.cycleInterval);
        element.cycleInterval = null;
        // Ensure final text is exactly the original
        element.textContent = originalText;
      }
    }, stepDuration);
  }

  // Wait for DOM to be ready before initializing
  // This ensures all elements are available when the script runs
  function init() {
    try {
      // Pause the loader animation when a flag is set
      // Use ?pause-loader=1 or localStorage key "ebpPauseLoader" = "1"
      const params = new URLSearchParams(window.location.search);
      const shouldPause =
        params.get("pause-loader") === "1" ||
        window.localStorage.getItem("ebpPauseLoader") === "1";
      if (shouldPause) {
        return;
      }

      // Initialize home page load animation
      // This runs the character flicker animation on text fields, then fades them out and reveals the site
      const homeText1 = document.querySelector(".ebp-header-1-home-text-1");
      const homeText2 = document.querySelector(".ebp-header-1-home-text-2");
      const homeText3 = document.querySelector(".ebp-header-1-home-text-3");
      const homeText4 = document.querySelector(".ebp-header-1-home-text-4");
      const homeTextWrapper = document.querySelector(
        ".ebp-header-1-home-text-wrapper"
      );
      const homeBgImage = document.querySelector(".ebp-header-1-home-bg-image");

      // Only run if we're on the home page and have the animation elements
      if (homeTextWrapper || homeBgImage) {
        // Track when animations complete
        let text1Complete = false;
        let text2Complete = false;
        let text3Complete = false;
        let text4Complete = false;
        let animationsStarted = false;

        // Function to check if all animations are done and proceed with fade
        function checkAnimationComplete() {
          // Count how many text fields exist
          const textFields = [
            homeText1,
            homeText2,
            homeText3,
            homeText4,
          ].filter((el) => el !== null);
          const completedFields = [
            text1Complete,
            text2Complete,
            text3Complete,
            text4Complete,
          ].filter((complete) => complete === true);

          // Proceed when all existing text fields have completed their animations
          const shouldProceed =
            textFields.length > 0
              ? completedFields.length === textFields.length
              : true;

          if (shouldProceed) {
            // Wait 1 second after animations complete
            setTimeout(() => {
              // Fade out individual text elements (not the wrapper, since logo is inside it)
              if (homeText1) {
                homeText1.style.transition = "opacity 0.5s ease-out";
                homeText1.style.opacity = "0";
              }
              if (homeText2) {
                homeText2.style.transition = "opacity 0.5s ease-out";
                homeText2.style.opacity = "0";
              }
              if (homeText3) {
                homeText3.style.transition = "opacity 0.5s ease-out";
                homeText3.style.opacity = "0";
              }
              if (homeText4) {
                homeText4.style.transition = "opacity 0.5s ease-out";
                homeText4.style.opacity = "0";
              }

              // After fade out completes, start the masked reveal
              setTimeout(() => {
                if (homeBgImage) {
                  homeBgImage.classList.add("is-expanded");
                }

                // Fade the animation layer away once the reveal finishes
                setTimeout(() => {
                  const animationContainer = document.querySelector(
                    ".ebp-header-1-home-page-load-animation"
                  );
                  if (animationContainer) {
                    animationContainer.style.transition =
                      "opacity 0.6s ease-out";
                    animationContainer.style.opacity = "0";
                    animationContainer.style.visibility = "hidden";
                    animationContainer.style.pointerEvents = "none";
                  }
                }, 4000); // Match CSS .ebp-header-1-home-mask-logo transition (e.g. 4s = 4000)
              }, 500); // Wait for fade out to complete
            }, 1000); // Wait 1 second after flicker completes
          }
        }

        // Helper function to handle animation completion
        function handleTextAnimationComplete(element) {
          if (element === homeText1) {
            text1Complete = true;
          } else if (element === homeText2) {
            text2Complete = true;
          } else if (element === homeText3) {
            text3Complete = true;
          } else if (element === homeText4) {
            text4Complete = true;
          }
          checkAnimationComplete();
        }

        // Function to cycle characters for home page text
        // This is similar to cycleTaglineCharacters but tracks completion
        function cycleHomeTextCharacters(element) {
          const originalText = element.getAttribute("data-original-text");
          if (!originalText) {
            handleTextAnimationComplete(element);
            return;
          }

          const chars =
            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
          const duration = 2000; // 2 seconds
          const steps = 20;
          const stepDuration = duration / steps;
          let currentStep = 0;

          // Clear any existing interval
          if (element.cycleInterval) {
            clearInterval(element.cycleInterval);
          }

          // Store the original text content to restore it after animation
          const originalTextContent = element.textContent;

          // Start the animation
          element.cycleInterval = setInterval(() => {
            currentStep++;

            // Create new text with random characters
            let newText = "";
            for (let i = 0; i < originalText.length; i++) {
              // Calculate how many characters should be revealed
              const revealProgress = currentStep / steps;
              const shouldReveal =
                i < Math.floor(originalText.length * revealProgress);

              if (shouldReveal) {
                // Use original character
                newText += originalText[i];
              } else {
                // Use random character
                newText += chars[Math.floor(Math.random() * chars.length)];
              }
            }

            // Update the element text content
            element.textContent = newText;

            // Stop when all characters are revealed
            if (currentStep >= steps) {
              clearInterval(element.cycleInterval);
              element.cycleInterval = null;
              // Restore original text content
              element.textContent = originalTextContent;
              // Animation complete, trigger callback
              handleTextAnimationComplete(element);
            }
          }, stepDuration);
        }

        // Set initial opacity to 1 for text wrapper and text elements
        if (homeTextWrapper) {
          homeTextWrapper.style.opacity = "1";
        }
        if (homeText1) {
          homeText1.style.opacity = "1";
        }
        if (homeText2) {
          homeText2.style.opacity = "1";
        }
        if (homeText3) {
          homeText3.style.opacity = "1";
        }
        if (homeText4) {
          homeText4.style.opacity = "1";
        }

        // Start flicker animation on all text fields
        if (homeText1) {
          animationsStarted = true;
          cycleHomeTextCharacters(homeText1);
        }
        if (homeText2) {
          animationsStarted = true;
          cycleHomeTextCharacters(homeText2);
        }
        if (homeText3) {
          animationsStarted = true;
          cycleHomeTextCharacters(homeText3);
        }
        if (homeText4) {
          animationsStarted = true;
          cycleHomeTextCharacters(homeText4);
        }

        // If no text fields exist, proceed immediately
        if (!animationsStarted) {
          text1Complete = true;
          text2Complete = true;
          text3Complete = true;
          text4Complete = true;
          checkAnimationComplete();
        }
      }

      // Initialize tagline cycling on page load
      const taglineElement = document.querySelector(".ebp-header-1-tagline");
      if (taglineElement) {
        // Cycle on page load
        cycleTaglineCharacters(taglineElement);

        // Cycle on hover
        taglineElement.addEventListener("mouseenter", function () {
          cycleTaglineCharacters(this);
        });
      }
    } catch (error) {
      console.error("Error initializing tagline:", error);
    }

    // Initialize location rotation system
    // First location stays static, secondary locations rotate every 3 seconds
    const primaryLocation = document.querySelector(
      ".ebp-header-1-location-primary"
    );
    const secondaryLocations = Array.from(
      document.querySelectorAll(".ebp-header-1-location-secondary")
    );

    // If we have secondary locations, set up rotation
    if (secondaryLocations.length > 0) {
      // Hide all secondary locations initially
      secondaryLocations.forEach(function (location) {
        location.style.display = "none";
      });

      // Show the first secondary location
      let currentSecondaryIndex = 0;
      if (secondaryLocations.length > 0) {
        secondaryLocations[0].style.display = "";
        // Initialize character effect on first secondary location label and time
        const firstLabel = secondaryLocations[0].querySelector(
          ".ebp-header-1-location-label"
        );
        const firstTimeElement = secondaryLocations[0].querySelector(
          ".ebp-header-1-location-time[data-timezone]"
        );
        if (firstLabel) {
          cycleTaglineCharacters(firstLabel);
        }
        // Update and animate the time for the first secondary location
        if (firstTimeElement) {
          const timezone = firstTimeElement.getAttribute("data-timezone");
          try {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat("en-US", {
              timeZone: timezone,
              hour: "2-digit",
              minute: "2-digit",
              hour12: false,
            });
            const timeString = formatter.format(now);
            const gmtOffset = getGMTOffset(timezone);
            const fullTimeText = `${timeString} GMT ${gmtOffset}`;
            firstTimeElement.setAttribute("data-original-text", fullTimeText);
            firstTimeElement.textContent = fullTimeText;
            cycleTaglineCharacters(firstTimeElement);
          } catch (e) {
            const fallbackText = "--:-- GMT +0";
            firstTimeElement.setAttribute("data-original-text", fallbackText);
            firstTimeElement.textContent = fallbackText;
            cycleTaglineCharacters(firstTimeElement);
          }
        }
      }

      // Set up rotation interval (every 3 seconds)
      setInterval(function () {
        // Hide current secondary location
        secondaryLocations[currentSecondaryIndex].style.display = "none";

        // Move to next secondary location (loop back to start if needed)
        currentSecondaryIndex =
          (currentSecondaryIndex + 1) % secondaryLocations.length;

        // Show next secondary location
        const nextLocation = secondaryLocations[currentSecondaryIndex];
        nextLocation.style.display = "";

        // Update time immediately for the newly visible location
        const nextTimeElement = nextLocation.querySelector(
          ".ebp-header-1-location-time[data-timezone]"
        );
        if (nextTimeElement) {
          const timezone = nextTimeElement.getAttribute("data-timezone");
          try {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat("en-US", {
              timeZone: timezone,
              hour: "2-digit",
              minute: "2-digit",
              hour12: false,
            });
            const timeString = formatter.format(now);
            const gmtOffset = getGMTOffset(timezone);
            const fullTimeText = `${timeString} GMT ${gmtOffset}`;
            // Store the time text in data attribute for character effect
            nextTimeElement.setAttribute("data-original-text", fullTimeText);
            nextTimeElement.textContent = fullTimeText;
          } catch (e) {
            const fallbackText = "--:-- GMT +0";
            nextTimeElement.setAttribute("data-original-text", fallbackText);
            nextTimeElement.textContent = fallbackText;
          }
        }

        // Apply character effect to both the location label and time
        const nextLabel = nextLocation.querySelector(
          ".ebp-header-1-location-label"
        );
        if (nextLabel) {
          cycleTaglineCharacters(nextLabel);
        }
        if (nextTimeElement) {
          cycleTaglineCharacters(nextTimeElement);
        }
      }, 3000); // 3 seconds
    }

    // Initialize location label and time cycling for primary location
    // Primary location cycles on page load and on hover
    // Secondary locations are handled by the rotation system above
    if (primaryLocation) {
      const primaryLabel = primaryLocation.querySelector(
        ".ebp-header-1-location-label"
      );
      const primaryTimeElement = primaryLocation.querySelector(
        ".ebp-header-1-location-time[data-timezone]"
      );
      if (primaryLabel) {
        // Cycle on page load for primary location label
        cycleTaglineCharacters(primaryLabel);
        // Cycle on hover for primary location label
        primaryLabel.addEventListener("mouseenter", function () {
          cycleTaglineCharacters(this);
        });
      }
      if (primaryTimeElement) {
        // Ensure time has data-original-text set and cycle on page load
        const timezone = primaryTimeElement.getAttribute("data-timezone");
        if (timezone) {
          try {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat("en-US", {
              timeZone: timezone,
              hour: "2-digit",
              minute: "2-digit",
              hour12: false,
            });
            const timeString = formatter.format(now);
            const gmtOffset = getGMTOffset(timezone);
            const fullTimeText = `${timeString} GMT ${gmtOffset}`;
            primaryTimeElement.setAttribute("data-original-text", fullTimeText);
            primaryTimeElement.textContent = fullTimeText;
            // Cycle on page load for primary location time
            cycleTaglineCharacters(primaryTimeElement);
          } catch (e) {
            const fallbackText = "--:-- GMT +0";
            primaryTimeElement.setAttribute("data-original-text", fallbackText);
            primaryTimeElement.textContent = fallbackText;
            // Cycle on page load even with fallback
            cycleTaglineCharacters(primaryTimeElement);
          }
        }
        // Cycle on hover for primary location time
        primaryTimeElement.addEventListener("mouseenter", function () {
          // Update data-original-text with current time before animating
          const currentTimezone = this.getAttribute("data-timezone");
          if (currentTimezone) {
            try {
              const now = new Date();
              const formatter = new Intl.DateTimeFormat("en-US", {
                timeZone: currentTimezone,
                hour: "2-digit",
                minute: "2-digit",
                hour12: false,
              });
              const timeString = formatter.format(now);
              const gmtOffset = getGMTOffset(currentTimezone);
              const fullTimeText = `${timeString} GMT ${gmtOffset}`;
              this.setAttribute("data-original-text", fullTimeText);
            } catch (e) {
              this.setAttribute("data-original-text", "--:-- GMT +0");
            }
          }
          cycleTaglineCharacters(this);
        });
      }
    }

    // Function to get GMT offset for a timezone
    // This calculates the actual offset from UTC/GMT for the given timezone
    function getGMTOffset(timezone) {
      try {
        const now = new Date();

        // Get UTC time components
        const utcHours = now.getUTCHours();
        const utcMinutes = now.getUTCMinutes();

        // Get time in target timezone
        const targetFormatter = new Intl.DateTimeFormat("en-US", {
          timeZone: timezone,
          hour: "2-digit",
          minute: "2-digit",
          hour12: false,
        });

        const targetParts = targetFormatter.formatToParts(now);
        const targetHours = parseInt(
          targetParts.find((p) => p.type === "hour").value
        );
        const targetMinutes = parseInt(
          targetParts.find((p) => p.type === "minute").value
        );

        // Calculate difference in minutes
        const utcTotalMinutes = utcHours * 60 + utcMinutes;
        const targetTotalMinutes = targetHours * 60 + targetMinutes;

        let diffMinutes = targetTotalMinutes - utcTotalMinutes;

        // Handle day rollover (when timezone is ahead or behind UTC by more than 12 hours)
        if (diffMinutes > 720) {
          diffMinutes -= 1440; // Subtract a full day (24 hours)
        } else if (diffMinutes < -720) {
          diffMinutes += 1440; // Add a full day (24 hours)
        }

        // Convert to hours (round to nearest hour for GMT offset)
        const offsetHours = Math.round(diffMinutes / 60);

        // Format as +X or -X
        const sign = offsetHours >= 0 ? "+" : "";
        return `${sign}${offsetHours}`;
      } catch (e) {
        return "+0";
      }
    }

    // Function to update time for all location elements
    // This updates visible time elements and stores the time in data-original-text
    // for use with character effects
    function updateTimes() {
      const timeElements = document.querySelectorAll(
        ".ebp-header-1-location-time[data-timezone]"
      );

      timeElements.forEach(function (element) {
        // Only update times for visible elements (not hidden secondary locations)
        const location = element.closest(".ebp-header-1-location");
        if (location && location.style.display === "none") {
          return; // Skip hidden locations
        }

        const timezone = element.getAttribute("data-timezone");

        try {
          // Create a date formatter for the specific timezone
          const now = new Date();
          const formatter = new Intl.DateTimeFormat("en-US", {
            timeZone: timezone,
            hour: "2-digit",
            minute: "2-digit",
            hour12: false,
          });

          const timeString = formatter.format(now);
          const gmtOffset = getGMTOffset(timezone);

          // Format as "HH:MM GMT +X" (matching the image format)
          const fullTimeText = `${timeString} GMT ${gmtOffset}`;
          // Store in data attribute for character effects
          element.setAttribute("data-original-text", fullTimeText);
          // Only update text content if not currently animating
          // (check if there's an active interval)
          if (!element.cycleInterval) {
            element.textContent = fullTimeText;
          }
        } catch (e) {
          // Fallback if timezone is invalid
          const fallbackText = "--:-- GMT +0";
          element.setAttribute("data-original-text", fallbackText);
          if (!element.cycleInterval) {
            element.textContent = fallbackText;
          }
        }
      });
    }

    // Update times immediately
    updateTimes();

    // Update times every second
    setInterval(updateTimes, 1000);

    // Initialize menu hover featured image display
    // This applies featured images to the menu background element when hovering menu links
    // When moving from one link to another, images fade in/out smoothly
    // The menu background expands to full screen, so images appear behind the menu items
    // Define menuContainer here so it's available for both featured images and GSAP sections
    const menuContainer = document.querySelector(".menu-main-container");

    try {
      const menuBgForImages = document.querySelector(
        ".ebp-header-1-menu-toggle--menu-bg"
      );
      let currentHoveredLink = null;
      let currentImageElement = null;
      let nextImageElement = null;

      if (menuContainer && menuBgForImages) {
        // Get all menu links
        const menuLinks = menuContainer.querySelectorAll("a");

        // Function to show featured image for a link
        // This handles the fade in/out transition when switching between links
        function showFeaturedImage(link, imageUrl) {
          // If there's no image URL, remove all images and return
          if (!imageUrl) {
            // Remove all existing featured images immediately
            const existingImages = menuBgForImages.querySelectorAll(
              ".ebp-header-1-menu-featured-image"
            );
            existingImages.forEach((img) => {
              img.style.opacity = "0";
              img.style.transition = "opacity 0.2s ease-in-out";
              setTimeout(() => {
                if (img.parentNode) {
                  img.parentNode.removeChild(img);
                }
              }, 200);
            });
            currentImageElement = null;
            currentHoveredLink = null;
            return;
          }

          // If hovering the same link, do nothing
          if (currentHoveredLink === link) {
            return;
          }

          // Remove all existing featured images immediately
          // This ensures we don't accumulate multiple images when switching quickly
          const existingImages = menuBgForImages.querySelectorAll(
            ".ebp-header-1-menu-featured-image"
          );
          existingImages.forEach((img) => {
            // Fade out quickly, then remove
            img.style.opacity = "0";
            img.style.transition = "opacity 0.2s ease-in-out";
            setTimeout(() => {
              if (img.parentNode) {
                img.parentNode.removeChild(img);
              }
            }, 200);
          });

          // Create new image element for the new link
          // This will be positioned inside the menu background element
          nextImageElement = document.createElement("img");
          nextImageElement.src = imageUrl;
          nextImageElement.className = "ebp-header-1-menu-featured-image";
          nextImageElement.style.cssText = `
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          object-fit: cover;
          opacity: 0;
          transition: opacity 0.4s ease-in-out;
          z-index: 0;
        `;

          // Add image to menu background element (behind the menu items)
          menuBgForImages.appendChild(nextImageElement);

          // Force a reflow to ensure the image is in the DOM before animating
          void nextImageElement.offsetWidth;

          // Fade in the new image
          nextImageElement.style.opacity = "1";

          // Update current references
          currentImageElement = nextImageElement;
          currentHoveredLink = link;
          nextImageElement = null;
        }

        // Function to hide featured image
        // This is called when mouse leaves a link or the menu container
        function hideFeaturedImage() {
          // Remove all existing featured images immediately
          const existingImages = menuBgForImages.querySelectorAll(
            ".ebp-header-1-menu-featured-image"
          );
          existingImages.forEach((img) => {
            img.style.opacity = "0";
            img.style.transition = "opacity 0.2s ease-in-out";
            setTimeout(() => {
              if (img.parentNode) {
                img.parentNode.removeChild(img);
              }
            }, 200);
          });
          currentImageElement = null;
          currentHoveredLink = null;
        }

        // Add hover event listeners to each menu link
        menuLinks.forEach((link) => {
          // Get featured image URL from data attribute
          // The PHP file adds data-featured-image attribute to each link
          const featuredImageUrl = link.getAttribute("data-featured-image");

          // Mouse enter: show featured image
          link.addEventListener("mouseenter", function () {
            if (featuredImageUrl) {
              showFeaturedImage(this, featuredImageUrl);
            }
          });

          // Mouse leave: hide featured image
          link.addEventListener("mouseleave", function () {
            hideFeaturedImage();
          });
        });

        // Hide image when mouse leaves the entire menu container
        menuContainer.addEventListener("mouseleave", function () {
          hideFeaturedImage();
        });
      }
    } catch (error) {
      console.error("Error initializing menu featured images:", error);
    }

    // Initialize GSAP timeline animation for menu toggle on click
    // This animates the menu toggle element: first adds 100vh height, then adds 100vw width
    // The animation is reversible - clicking again will reverse the process
    try {
      const menuToggle = document.querySelector(".ebp-header-1-menu-toggle");
      const menuBg = document.querySelector(
        ".ebp-header-1-menu-toggle--menu-bg"
      );
      if (menuToggle && menuBg && typeof gsap !== "undefined") {
        // Track whether the menu is expanded or collapsed
        let isExpanded = false;

        // Store original dimensions from the menu-bg element
        const originalHeight = gsap.getProperty(menuBg, "height");
        const originalWidth = gsap.getProperty(menuBg, "width");

        // Find the span element inside the menu toggle button
        const menuToggleSpan = menuToggle.querySelector("span");

        // Find the menu items (menuContainer is already defined above)
        const menuItems = document.querySelectorAll(".menu-main-container li");

        // Set pointer-events to none initially on the menu container
        // This prevents interaction with the menu when it's closed
        if (menuContainer) {
          menuContainer.style.pointerEvents = "none";
        }

        // Add click event listener to trigger the animation
        menuToggle.addEventListener("click", function () {
          // Create a GSAP timeline for sequential animations
          const toggleTimeline = gsap.timeline();

          if (!isExpanded) {
            // Remove pointer-events: none from menu container when opening
            // This allows interaction with the menu when it's open
            if (menuContainer) {
              menuContainer.style.pointerEvents = "auto";
            }

            // Prevent body scrolling by making it fixed
            document.body.style.position = "fixed";
            document.body.style.width = "100%";

            // Expanding: first add 100vh to height, then add 100vw to width
            toggleTimeline.to(menuBg, {
              height: "+=100vh",
              duration: 1,
              ease: "power2.out",
            });

            toggleTimeline.to(menuBg, {
              width: "+=100vw",
              duration: 1,
              ease: "power2.out",
            });

            // Reveal menu items with stagger animation
            // Set pointer-events to auto and animate clip-path to reveal
            toggleTimeline.to(menuItems, {
              clipPath: "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
              duration: 0.5,
              ease: "power2.out",
              stagger: 0.1,
              onStart: function () {
                // Enable pointer events when animation starts
                menuItems.forEach(function (item) {
                  item.style.pointerEvents = "auto";
                });
              },
            });

            // Change text to "Close" when expanding
            if (menuToggleSpan) {
              menuToggleSpan.textContent = "Close";
            }

            isExpanded = true;
          } else {
            // Hide menu items with stagger animation (reverse)
            toggleTimeline.to(menuItems, {
              clipPath: "polygon(0% 0%, 0% 0%, 0% 100%, 0% 100%)",
              duration: 0.5,
              ease: "power2.out",
              stagger: 0.1,
              onComplete: function () {
                // Disable pointer events when animation completes
                menuItems.forEach(function (item) {
                  item.style.pointerEvents = "none";
                });
              },
            });

            // Collapsing: first remove 100vw from width, then remove 100vh from height
            toggleTimeline.to(menuBg, {
              width: originalWidth,
              duration: 1,
              ease: "power2.out",
            });

            toggleTimeline.to(menuBg, {
              height: originalHeight,
              duration: 1,
              ease: "power2.out",
              onComplete: function () {
                // Re-enable body scrolling
                document.body.style.position = "";
                document.body.style.width = "";
                // Reapply pointer-events: none to menu container when closing
                // This prevents interaction with the menu when it's closed
                if (menuContainer) {
                  menuContainer.style.pointerEvents = "none";
                }
              },
            });

            // Change text back to "Menu" when collapsing
            if (menuToggleSpan) {
              menuToggleSpan.textContent = "Menu";
            }

            isExpanded = false;
          }
        });
      }
    } catch (error) {
      console.error("Error initializing menu toggle:", error);
    }
  }

  // Run initialization when DOM is ready
  // Since the script is loaded in the footer, DOM should already be ready
  // But we'll use DOMContentLoaded as a safety measure
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    // DOM is already ready, run immediately
    init();
  }
})();
