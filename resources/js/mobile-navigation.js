/**
 * Mobile Navigation Menu
 * Handles the slide-out drawer navigation for mobile devices
 */

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('mobile-menu-button');
    const closeButton = document.getElementById('mobile-close-button');
    const drawer = document.getElementById('mobile-drawer');
    const nav = document.getElementById('mobile-nav');
    const overlay = document.getElementById('mobile-overlay');

    if (!menuButton || !closeButton || !drawer || !nav || !overlay) {
        return; // Exit if elements don't exist
    }

    /**
     * Calculate and store the scrollbar width to prevent layout shift
     */
    function getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }

    /**
     * Opens the mobile navigation menu
     * - Adds padding to compensate for scrollbar removal
     * - Prevents body scroll
     * - Moves focus to close button for accessibility
     */
    function openMenu() {
        const scrollbarWidth = getScrollbarWidth();

        // Compensate for scrollbar width to prevent layout shift
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = `${scrollbarWidth}px`;
        }

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Show drawer and animate in
        drawer.classList.remove('pointer-events-none');
        drawer.classList.add('pointer-events-auto');
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-50');
        nav.classList.remove('translate-x-full');
        nav.classList.add('translate-x-0');

        // Move focus to close button for keyboard accessibility
        setTimeout(() => {
            closeButton.focus();
        }, 300); // Wait for animation to complete
    }

    /**
     * Closes the mobile navigation menu
     * - Removes padding compensation
     * - Restores body scroll
     * - Returns focus to menu button
     */
    function closeMenu() {
        // Remove padding compensation
        document.body.style.paddingRight = '';

        // Restore body scroll
        document.body.style.overflow = '';

        // Animate out and hide drawer
        overlay.classList.remove('opacity-50');
        overlay.classList.add('opacity-0');
        nav.classList.remove('translate-x-0');
        nav.classList.add('translate-x-full');

        // Remove pointer events after animation completes
        setTimeout(() => {
            drawer.classList.remove('pointer-events-auto');
            drawer.classList.add('pointer-events-none');
        }, 300);

        // Return focus to menu button
        menuButton.focus();
    }

    // Event listeners
    menuButton.addEventListener('click', openMenu);
    closeButton.addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !drawer.classList.contains('pointer-events-none')) {
            closeMenu();
        }
    });

    // Close menu when clicking navigation links (better UX)
    const navLinks = nav.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Small delay to allow navigation to proceed
            setTimeout(closeMenu, 100);
        });
    });
});
