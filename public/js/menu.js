// public/js/menu.js

(function () {
  const body = document.body;
  const btn = document.getElementById("menuBtn");        // hamburger
  const overlay = document.getElementById("menuOverlay");
  const drawer = document.getElementById("menuDrawer");

  if (!btn || !overlay || !drawer) return;

  function openMenu() {
    body.classList.add("menu-open");
    overlay.setAttribute("aria-hidden", "false");
    drawer.setAttribute("aria-hidden", "false");
  }

  function closeMenu() {
    body.classList.remove("menu-open");
    overlay.setAttribute("aria-hidden", "true");
    drawer.setAttribute("aria-hidden", "true");
  }

  btn.addEventListener("click", () => {
    if (body.classList.contains("menu-open")) closeMenu();
    else openMenu();
  });

  overlay.addEventListener("click", closeMenu);

  // Close on ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenu();
  });

  // Close when a link inside menu is clicked
  drawer.addEventListener("click", (e) => {
    const a = e.target.closest("a");
    if (a) closeMenu();
  });
})();
