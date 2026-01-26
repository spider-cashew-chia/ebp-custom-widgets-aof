/**
 * Footer Policy Popup Handler
 * Handles opening and closing of policy popups when policy links are clicked
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Find all footer widgets on the page
        const footerWidgets = document.querySelectorAll('.ebp-footer-1');
        
        footerWidgets.forEach(function(footerWidget) {
            initPolicyPopup(footerWidget);
        });
    });

    /**
     * Initialize policy popup functionality for a specific footer widget
     * @param {HTMLElement} footerWidget - The footer widget container element
     */
    function initPolicyPopup(footerWidget) {
        // Get the policy data from the JSON script tag
        const policiesDataScript = footerWidget.querySelector('.ebp-footer-1-policies-data');
        if (!policiesDataScript) {
            return; // No policies data found
        }

        let policiesData = {};
        try {
            policiesData = JSON.parse(policiesDataScript.textContent);
        } catch (e) {
            console.error('Error parsing policies data:', e);
            return;
        }

        // Get modal elements
        const modal = footerWidget.querySelector('.ebp-footer-1-policy-modal');
        const modalOverlay = footerWidget.querySelector('.ebp-footer-1-policy-modal-overlay');
        const modalContent = footerWidget.querySelector('.ebp-footer-1-policy-modal-content');
        const modalTitle = footerWidget.querySelector('.ebp-footer-1-policy-modal-title');
        const modalBody = footerWidget.querySelector('.ebp-footer-1-policy-modal-body');
        const closeButton = footerWidget.querySelector('.ebp-footer-1-policy-modal-close');
        
        if (!modal || !modalTitle || !modalBody) {
            return; // Required elements not found
        }

        // Get all policy trigger buttons
        const policyTriggers = footerWidget.querySelectorAll('.ebp-footer-1-policy-trigger');

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
            modalTitle.textContent = policy.title || '';
            modalTitle.id = 'ebp-policy-modal-title';

            // Set the modal content (rich text)
            modalBody.innerHTML = policy.content || '';

            // Show the modal
            modal.classList.add('ebp-footer-1-policy-modal-active');
            document.body.style.overflow = 'hidden'; // Prevent body scroll

            // Focus on the close button for accessibility
            if (closeButton) {
                closeButton.focus();
            }
        }

        /**
         * Close the modal
         */
        function closeModal() {
            modal.classList.remove('ebp-footer-1-policy-modal-active');
            document.body.style.overflow = ''; // Restore body scroll
        }

        // Add click event listeners to all policy trigger buttons
        policyTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function() {
                const policyIndex = this.getAttribute('data-policy-index');
                if (policyIndex !== null) {
                    openModal(parseInt(policyIndex, 10));
                }
            });
        });

        // Close modal when clicking the overlay
        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeModal);
        }

        // Close modal when clicking the close button
        if (closeButton) {
            closeButton.addEventListener('click', closeModal);
        }

        // Close modal when pressing Escape key
        document.addEventListener('keydown', function(e) {
            // Only close if this modal is active
            if (modal.classList.contains('ebp-footer-1-policy-modal-active') && e.key === 'Escape') {
                closeModal();
            }
        });

        // Close modal when clicking outside the modal content (but inside the modal)
        if (modalContent) {
            modalContent.addEventListener('click', function(e) {
                // Stop event from bubbling to overlay
                e.stopPropagation();
            });
        }
    }
})();
