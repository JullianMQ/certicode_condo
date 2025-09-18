import './bootstrap';

// Sidebar functionality for seamless toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('toggleSidebarMobile');
    const hamburgerIcon = document.getElementById('toggleSidebarMobileHamburger');
    const closeIcon = document.getElementById('toggleSidebarMobileClose');

    function toggleSidebar() {
        const isHidden = sidebar.classList.contains('hidden');
        
        if (isHidden) {
            // Show sidebar
            sidebar.classList.remove('hidden');
            
            // No backdrop - keep content fully visible
            
            // Toggle icons
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            }
        } else {
            // Hide sidebar
            sidebar.classList.add('hidden');
            
            // Toggle icons
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }
    }

    // Toggle button event listener
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    // Backdrop click to close sidebar
    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', toggleSidebar);
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        initializeSidebar();
    });

    // Initialize sidebar state based on screen size
    function initializeSidebar() {
        if (window.innerWidth >= 1024) {
            // Desktop: show sidebar
            sidebar.classList.remove('hidden');
        } else {
            // Mobile: hide sidebar by default
            sidebar.classList.add('hidden');
            
            // Reset icons
            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }
    }
    
    // Initialize on load
    initializeSidebar();
});
