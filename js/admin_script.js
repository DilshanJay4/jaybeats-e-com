document.addEventListener('DOMContentLoaded', () => {
   const userBtn = document.querySelector('#user-btn');
   const profileDropdown = document.querySelector('#profile-dropdown');
   const menuBtn = document.querySelector('#menu-btn');
   const sidebar = document.querySelector('#sidebar');

   if (userBtn && profileDropdown) {
      userBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         profileDropdown.classList.toggle('active');
      });

      document.addEventListener('click', (e) => {
         if (!profileDropdown.contains(e.target) && !userBtn.contains(e.target)) {
            profileDropdown.classList.remove('active');
         }
      });
   }

   if (menuBtn && sidebar) {
      menuBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         sidebar.classList.toggle('active');
      });

      document.addEventListener('click', (e) => {
         if (window.innerWidth <= 991 && !sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
            sidebar.classList.remove('active');
         }
      });
   }

   // Product image selector on update_product.php
   const subImages = document.querySelectorAll('.update-product .image-container .sub-images img');
   const mainImage = document.querySelector('.update-product .image-container .main-image img');

   if (subImages && mainImage) {
      subImages.forEach(img => {
         img.addEventListener('click', () => {
            mainImage.src = img.getAttribute('src');
         });
      });
   }
});