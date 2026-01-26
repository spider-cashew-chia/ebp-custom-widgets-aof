(function () {
  // Function to initialize the widget
  // This is called when GSAP and ScrollTrigger are ready
  function initWidget() {
    // Find all text block widgets on the page
    // Each widget instance needs its own GSAP ScrollTrigger setup
    const textBlockWidgets = document.querySelectorAll('.ebp-text-block-1[data-widget-id]');

    // Loop through each widget instance
    textBlockWidgets.forEach(function (widget) {
      // Check if GSAP and ScrollTrigger are available
      // These libraries need to be loaded for the animation to work
      if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP or ScrollTrigger not loaded');
        return;
      }

      // Register ScrollTrigger plugin with GSAP
      // This is required for ScrollTrigger to work properly
      gsap.registerPlugin(ScrollTrigger);

      // Get the team list container
      // This contains all the team member items
      const teamList = widget.querySelector('.ebp-text-block-1-team-list');
      if (!teamList) return;

      // Get all team member elements
      // These are the individual items that will be displayed one at a time
      const teamMembers = teamList.querySelectorAll('.ebp-text-block-1-team-member');
      if (teamMembers.length === 0) return;

      // Get the image container for hover display
      // This shows the featured image when hovering over a team member
      const imageContainer = widget.querySelector('.ebp-text-block-1-team-image');
      const imageImg = widget.querySelector('.ebp-text-block-1-team-image-img');

      // Get the counter elements for dynamic number display
      // This shows the current position (e.g., "01 - 04")
      const counterCurrent = widget.querySelector('.ebp-text-block-1-counter-current');
      const counterTotal = widget.querySelector('.ebp-text-block-1-counter-total');

      // Get the total number of team members
      // This helps calculate scroll progress
      const teamCount = teamMembers.length;

      // Get the viewport height and calculate member height
      // This is needed to center the active member
      const viewportHeight = window.innerHeight;
      
      // Function to calculate member height
      // This measures the actual height of a team member including margins
      function calculateMemberHeight() {
        if (teamMembers.length === 0) return 0;
        
        // Use the first member to measure (it should be visible initially)
        const firstMember = teamMembers[0];
        const rect = firstMember.getBoundingClientRect();
        const styles = window.getComputedStyle(firstMember);
        const marginBottom = parseInt(styles.marginBottom) || 0;
        
        // Return height plus margin
        return rect.height + marginBottom;
      }
      
      // Calculate initial member height
      let memberHeight = calculateMemberHeight();
      
      // Recalculate on window resize to handle responsive changes
      let resizeTimeout;
      window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
          memberHeight = calculateMemberHeight();
        }, 250);
      });

      // Set initial state - show all team members
      // Active member has full opacity and no blur, inactive ones have reduced opacity and blur
      teamMembers.forEach(function (member, index) {
        if (index === 0) {
          // First member is active - full opacity, no blur
          gsap.set(member, { 
            opacity: 1, 
            display: 'block',
            filter: 'blur(0px)'
          });
        } else {
          // All other members are inactive - reduced opacity and blur
          gsap.set(member, { 
            opacity: 0.5, 
            display: 'block',
            filter: 'blur(5px)'
          });
        }
      });

      // Initialize counter to show first team member (01)
      // This sets the initial display before any scrolling happens
      if (counterCurrent) {
        counterCurrent.textContent = '01';
      }

      // Create ScrollTrigger to pin the widget and control team member display
      // This pins the section while scrolling and shows one team member at a time
      const scrollTrigger = ScrollTrigger.create({
        trigger: widget, // The widget itself is the trigger
        start: 'top top', // Animation starts when top of widget hits top of viewport
        end: () => `+=${teamCount * 100}vh`, // End after scrolling through all team members (100vh per member)
        pin: true, // Pin the widget in place while scrolling
        pinSpacing: true, // Disable pin spacing to prevent unwanted padding,
        scrub: 1, // Smooth scrubbing tied to scroll position
        anticipatePin: 1, // Helps prevent layout shifts
        onUpdate: function (self) {
          // Calculate which team member should be visible based on scroll progress
          // Progress goes from 0 to 1 as user scrolls through the pinned section
          const progress = self.progress;
          
          // Calculate current index based on progress
          // Each team member gets an equal portion of the scroll
          const currentIndex = Math.min(
            Math.floor(progress * teamCount),
            teamCount - 1
          );

          // Update all team members - active one is sharp, others are blurred
          teamMembers.forEach(function (member, index) {
            if (index === currentIndex) {
              // Active team member - full opacity, no blur
              gsap.set(member, { 
                opacity: 1, 
                display: 'block',
                filter: 'blur(0px)'
              });
            } else {
              // Inactive team members - reduced opacity and blur
              gsap.set(member, { 
                opacity: 0.5, 
                display: 'block',
                filter: 'blur(5px)'
              });
            }
          });

          // Calculate the translation needed to center the active member
          // We need to move the list up so the active member is in the center of the viewport
          if (memberHeight > 0 && teamList) {
            // Recalculate member height in case it changed
            memberHeight = calculateMemberHeight();
            
            // Calculate the total offset of the current member from the top
            // Each member is spaced by memberHeight (including margin)
            const memberOffset = currentIndex * memberHeight;
            
            // Calculate how much we need to translate to center the member
            // We want the center of the active member to be at the center of the viewport
            // So: translateY = viewportCenter - (memberTop + memberCenter)
            const viewportCenter = window.innerHeight / 2;
            const memberCenter = memberHeight / 2;
            const translateY = viewportCenter - memberOffset - memberCenter;
            
            // Apply the translation to the team list smoothly
            gsap.to(teamList, {
              y: translateY,
              duration: 0.3,
              ease: 'power2.out'
            });
          }

          // Update the counter to show current position
          // Format: "01 - 04", "02 - 04", etc.
          if (counterCurrent) {
            // Add 1 to currentIndex because we want 1-based numbering (01, 02, etc.)
            const currentNumber = currentIndex + 1;
            // Pad with zero to ensure 2-digit format (01, 02, 03, etc.)
            const formattedNumber = String(currentNumber).padStart(2, '0');
            counterCurrent.textContent = formattedNumber;
          }

          // Update the featured image to show the current team member's image
          // This automatically displays the image as the user scrolls
          updateTeamMemberImage(currentIndex);
        },
        onLeave: function () {
          // When leaving the pinned section, ensure the last team member is active
          // This ensures the final state is correct when unpinning
          const lastIndex = teamCount - 1;
          teamMembers.forEach(function (member, index) {
            if (index === lastIndex) {
              // Last member is active - full opacity, no blur
              gsap.set(member, { 
                opacity: 1, 
                display: 'block',
                filter: 'blur(0px)'
              });
            } else {
              // Other members are inactive - reduced opacity and blur
              gsap.set(member, { 
                opacity: 0.5, 
                display: 'block',
                filter: 'blur(5px)'
              });
            }
          });

          // Center the last member
          if (memberHeight > 0 && teamList) {
            memberHeight = calculateMemberHeight();
            const memberOffset = lastIndex * memberHeight;
            const viewportCenter = window.innerHeight / 2;
            const memberCenter = memberHeight / 2;
            const translateY = viewportCenter - memberOffset - memberCenter;
            gsap.to(teamList, {
              y: translateY,
              duration: 0.3,
              ease: 'power2.out'
            });
          }

          // Update counter to show last team member
          if (counterCurrent) {
            const formattedNumber = String(teamCount).padStart(2, '0');
            counterCurrent.textContent = formattedNumber;
          }

          // Update image to show last team member's image
          updateTeamMemberImage(teamCount - 1);
        },
        onEnterBack: function () {
          // When scrolling back into the section, show the first team member as active
          teamMembers.forEach(function (member, index) {
            if (index === 0) {
              // First member is active - full opacity, no blur
              gsap.set(member, { 
                opacity: 1, 
                display: 'block',
                filter: 'blur(0px)'
              });
            } else {
              // Other members are inactive - reduced opacity and blur
              gsap.set(member, { 
                opacity: 0.5, 
                display: 'block',
                filter: 'blur(5px)'
              });
            }
          });

          // Center the first member
          if (memberHeight > 0 && teamList) {
            memberHeight = calculateMemberHeight();
            const memberOffset = 0;
            const viewportCenter = window.innerHeight / 2;
            const memberCenter = memberHeight / 2;
            const translateY = viewportCenter - memberOffset - memberCenter;
            gsap.to(teamList, {
              y: translateY,
              duration: 0.3,
              ease: 'power2.out'
            });
          }

          // Update counter to show first team member
          if (counterCurrent) {
            counterCurrent.textContent = '01';
          }

          // Update image to show first team member's image
          updateTeamMemberImage(0);
        },
      });

      // Function to update the featured image for a team member
      // This shows the image of the currently active team member
      function updateTeamMemberImage(memberIndex) {
        if (imageContainer && imageImg && teamMembers[memberIndex]) {
          // Get the image URL from the data attribute
          const imageUrl = teamMembers[memberIndex].getAttribute('data-image');
          const teamName = teamMembers[memberIndex].querySelector('.ebp-text-block-1-team-name')?.textContent || '';

          if (imageUrl) {
            // Set the image source and alt text
            imageImg.src = imageUrl;
            imageImg.alt = teamName;

            // Animate the image container to visible
            // This creates a smooth fade-in effect
            gsap.to(imageContainer, {
              opacity: 1,
              duration: 0.3,
              ease: 'power2.out',
            });
          }
        }
      }

      // Initialize image container with first team member's image
      // Show the first team member's image on page load
      if (teamMembers.length > 0) {
        updateTeamMemberImage(0);
        
        // Center the first member on initial load
        if (memberHeight > 0 && teamList) {
          memberHeight = calculateMemberHeight();
          const memberOffset = 0;
          const viewportCenter = window.innerHeight / 2;
          const memberCenter = memberHeight / 2;
          const translateY = viewportCenter - memberOffset - memberCenter;
          gsap.set(teamList, {
            y: translateY
          });
        }
      } else {
        // If no team members, hide the image container
        if (imageContainer) {
          gsap.set(imageContainer, { opacity: 0 });
        }
      }
    });
  }

  // Wait for GSAP and ScrollTrigger to be available
  // Check if they're already loaded, otherwise wait for them
  function checkAndInit() {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      // Both are loaded, initialize the widget
      initWidget();
    } else {
      // Wait a bit and check again
      // This handles cases where scripts load after DOMContentLoaded
      setTimeout(checkAndInit, 100);
    }
  }

  // Start checking when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', checkAndInit);
  } else {
    // DOM is already ready, check immediately
    checkAndInit();
  }
})();
