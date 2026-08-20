<footer class="footer">
   <div class="footer-wrapper">
      <div class="footer-grid">
         
         <!-- Col 1: Brand & Social -->
         <div class="footer-col brand-col">
            <p class="brand-text">
               <strong>jaybeats</strong> is a premium audio marketplace built for true audiophiles, featuring top-tier headphones and sound gear.
            </p>
            <div class="social-buttons">
               <a href="#" class="neu-circle-btn" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
               <a href="#" class="neu-circle-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
               <a href="#" class="neu-circle-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
               <a href="#" class="neu-circle-btn" aria-label="Spotify"><i class="fab fa-spotify"></i></a>
            </div>
         </div>

         <!-- Col 2: Navigation -->
         <div class="footer-col">
            <h4 class="footer-heading">Jaybeats</h4>
            <ul class="footer-menu">
               <li><a href="home.php">Home</a></li>
               <li><a href="menu.php">Products</a></li>
               <li><a href="about.php">About Us</a></li>
               <li><a href="contact.php">Contact Us</a></li>
            </ul>
         </div>

         <!-- Col 3: Support -->
         <div class="footer-col">
            <h4 class="footer-heading">Support</h4>
            <ul class="footer-menu">
               <li><a href="orders.php">My Orders</a></li>
               <li><a href="cart.php">Shopping Cart</a></li>
               <li><a href="quick_view.php?pid=1">Featured <span class="badge-pill">v2.0</span></a></li>
               <li><a href="contact.php">Help Center</a></li>
            </ul>
         </div>

         <!-- Col 4: Newsletter -->
         <div class="footer-col newsletter-col">
            <h4 class="footer-heading">Subscribe</h4>
            <p class="newsletter-desc">
               Join our mailing list. We write rarely, but only the best content.
            </p>
            <form action="" method="post" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');" class="newsletter-form">
               <input type="email" placeholder="example@company.com" required class="neu-input">
               <button type="submit" class="neu-btn-submit">Subscribe</button>
            </form>
            <p class="privacy-note">We'll never share your details. See our <a href="#">Privacy Policy</a></p>
         </div>

      </div>

      <div class="footer-bottom-line">
         <p>&copy; <?= date('Y'); ?> <strong>jaybeats</strong>. All rights reserved.</p>
      </div>
   </div>
</footer>

<!-- Dark / Light mode toggle -->
<button id="theme-toggle" title="Toggle theme" aria-label="Toggle dark/light mode">
   <i class="fas fa-moon"></i>
</button>

<div class="loader">
   <img src="images/loader.gif" alt="">
</div>
