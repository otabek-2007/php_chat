const themeIcon = document.getElementById('theme-icon')
// Get the hamburger and menu elements
const hamburger = document.querySelector('.hamburger')
const menu = document.querySelector('.menu')

// Dark mode-ni faollashtirish yoki o'chirish
themeIcon.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode')

  // Tema holatini saqlash
  if (document.body.classList.contains('dark-mode')) {
    localStorage.setItem('theme', 'dark')
  } else {
    localStorage.setItem('theme', 'light')
  }
})

// Sahifa yuklanganda saqlangan tema holatini tekshirish
window.addEventListener('load', () => {
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode')
  }
})

// Toggle the "active" class when the hamburger is clicked
hamburger.addEventListener('click', () => {
  menu.classList.toggle('active')
})
