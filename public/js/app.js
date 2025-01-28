document.addEventListener('DOMContentLoaded', () => {
  const body = document.body
  const themeSwitcher = document.getElementById('theme-icon')
  const hamburgerIcon = document.getElementById('hamburger-icon')
  const menuList = document.getElementById('menu-list')

  // Dark mode'ni brauzer localStorage orqali boshqarish
  const currentTheme = localStorage.getItem('theme')
  if (currentTheme === 'dark') {
    body.classList.add('dark-mode')
    themeSwitcher.classList.add('dark-mode')
    themeSwitcher.textContent = '🌙' // Dark mode'ni belgilash
  }

  // Dark mode toggler
  themeSwitcher.addEventListener('click', () => {
    body.classList.toggle('dark-mode')
    themeSwitcher.classList.toggle('dark-mode')

    if (body.classList.contains('dark-mode')) {
      themeSwitcher.textContent = '🌙'
      localStorage.setItem('theme', 'dark')
    } else {
      themeSwitcher.textContent = '🌞'
      localStorage.setItem('theme', 'light')
    }
  })

  // Hamburger menu toggler
  hamburgerIcon.addEventListener('click', () => {
    menuList.classList.toggle('show-menu')
  })
})
