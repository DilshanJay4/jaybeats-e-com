// ── Navbar & profile toggles ──────────────────────────────────
const navbar  = document.querySelector('.header .flex .navbar');
const profile = document.querySelector('.header .flex .profile');

document.querySelector('#menu-btn').onclick = () => {
   navbar.classList.toggle('active');
   profile.classList.remove('active');
};

document.querySelector('#user-btn').onclick = () => {
   profile.classList.toggle('active');
   navbar.classList.remove('active');
};

window.onscroll = () => {
   navbar.classList.remove('active');
   profile.classList.remove('active');
};

// ── Page loader ───────────────────────────────────────────────
function loader() {
   const el = document.querySelector('.loader');
   if (el) el.style.display = 'none';
}
function fadeOut() { setInterval(loader, 2000); }
window.onload = fadeOut;

// ── Number input max-length guard ─────────────────────────────
document.querySelectorAll('input[type="number"]').forEach(n => {
   n.oninput = () => {
      if (n.value.length > n.maxLength) n.value = n.value.slice(0, n.maxLength);
   };
});

// ── Dark / Light mode toggle ──────────────────────────────────
(function initTheme() {
   // Persist preference in localStorage
   const saved = localStorage.getItem('jb-theme') || 'light';
   document.documentElement.setAttribute('data-theme', saved);
   updateToggleIcon(saved);

   const btn = document.getElementById('theme-toggle');
   if (!btn) return;

   btn.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme');
      const next    = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('jb-theme', next);
      updateToggleIcon(next);
   });
})();

function updateToggleIcon(theme) {
   const btn = document.getElementById('theme-toggle');
   if (!btn) return;
   btn.innerHTML = theme === 'dark'
      ? '<i class="fas fa-sun"></i>'
      : '<i class="fas fa-moon"></i>';
   btn.title = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
}