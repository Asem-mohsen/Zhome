const menu = document.querySelector(".menu");
const menuInner = menu.querySelector(".menu__inner");
const menuArrow = menu.querySelector(".menu__arrow");
const menuTitle = menu.querySelector(".menu__title");
const burger = document.querySelector(".burger");
const overlay = document.querySelector(".overlay");
let subMenu;
let currentMenuLevel = 1;

// Function to update the data-menu-id attribute for a menu item
function updateMenuId(level) {
  menu.setAttribute("data-menu-id", level);
}

// Navbar Menu Toggle Function
function toggleMenu() {
  menu.classList.toggle("is-active");
  overlay.classList.toggle("is-active");
  menuTitle.textContent = ""; // Reset menu header
  menu.querySelector(".menu__header").classList.remove("is-active");
  currentMenuLevel = 1; // Reset menu level when main menu is toggled

  updateMenuId(currentMenuLevel);
}

// Show Mobile Submenu Function
function showSubMenu(children) {
  subMenu = children.querySelector(".submenu");
  if (subMenu) {
    subMenu.classList.add("is-active");
    subMenu.style.animation = "slideLeft 0.35s ease forwards";

    const menuItemTitle = children.querySelector(".menu__link").textContent; // Get submenu title
    menuTitle.textContent = menuItemTitle;
    menu.querySelector(".menu__header").classList.add("is-active");

    // Increment level only when entering a submenu (not within submenu)
    if (children.classList.contains("menu__dropdown")) {
      currentMenuLevel++;
    } 

    updateMenuId(currentMenuLevel);
  }
}

// Hide Mobile Submenu Function
function hideSubMenu() {
  if (subMenu) {
    subMenu.style.animation = "slideRight 0.35s ease forwards";
    setTimeout(() => {
      subMenu.classList.toggle("is-active");
    }, 300);

    const previousMenuItem = subMenu.parentNode; // Get parent of the submenu
    if (previousMenuItem) {
      // Update menu title based on parent menu item (if applicable)
      if (previousMenuItem.classList.contains("menu__dropdown") && currentMenuLevel > 1) {
        const parentTitle = previousMenuItem.querySelector(".menu__link").textContent;
        menuTitle.textContent = parentTitle;
        currentMenuLevel--; // Decrement level only if closing a submenu within another menu item
      } else {
        menuTitle.textContent = ""; // Clear header text for main menu
        currentMenuLevel = 1; // Set level to 1 explicitly for main menu
      }
    }
    updateMenuId(currentMenuLevel);
  }
}

// Toggle Mobile Submenu Function
function toggleSubMenu(e) {
  if (!menu.classList.contains("is-active")) {
    return;
  }
  if (e.target.closest(".menu__dropdown")) {
    const children = e.target.closest(".menu__dropdown");
    if (subMenu && subMenu === children) { // Check if clicking the same submenu again (to close)
      hideSubMenu();
    } else { 
      showSubMenu(children);
    }
  }
}

// Fixed Navbar Menu on Window Resize
window.addEventListener("resize", () => {
  if (window.innerWidth >= 768) {
    if (menu.classList.contains("is-active")) {
      toggleMenu(); // Ensure toggleMenu is called on resize
    }
  }
});

// Initialize All Event Listeners
burger.addEventListener("click", toggleMenu);
overlay.addEventListener("click", toggleMenu);
menuArrow.addEventListener("click", hideSubMenu);
menuTitle.addEventListener("click", hideSubMenu); // You can decide if clicking the header should also hide the submenu
menuInner.addEventListener("click", toggleSubMenu);

// Set initial data-menu-id attributes
updateMenuId(currentMenuLevel);