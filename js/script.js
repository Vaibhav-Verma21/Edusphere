// Toggle mobile navigation menu
document.addEventListener('DOMContentLoaded', function() {
  const mobileMenuButton = document.querySelector('.md\\:hidden.text-gray-600');
  const mobileMenu = document.querySelector('.md\\:hidden.mt-4');

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', function() {
      // Toggle the 'hidden' class on the mobile menu
      mobileMenu.classList.toggle('hidden');
    });
  }

  // Add functionality for collapsible search in courses.html
  const searchToggle = document.getElementById('search-toggle');
  const searchContainer = document.getElementById('search-container');
  
  if (searchToggle && searchContainer) {
    searchToggle.addEventListener('click', function() {
      // Toggle the visibility of search container
      searchContainer.classList.toggle('hidden');
      
      // Change the icon based on the visibility
      const iconExpand = searchToggle.querySelector('.icon-expand');
      const iconCollapse = searchToggle.querySelector('.icon-collapse');
      
      if (iconExpand && iconCollapse) {
        iconExpand.classList.toggle('hidden');
        iconCollapse.classList.toggle('hidden');
      }
    });
  }

  // Handle dark mode toggle
  const themeToggle = document.getElementById('theme-toggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', function() {
      document.body.classList.toggle('dark-mode');
    });
  }
});