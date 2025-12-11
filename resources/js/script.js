// script.js
document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('themeToggle');
  const body = document.body;

  // Cek tema tersimpan
  if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark');
  }

  // Toggle tema
  toggleBtn.addEventListener('click', () => {
    body.classList.toggle('dark');
    if (body.classList.contains('dark')) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }
  });
});