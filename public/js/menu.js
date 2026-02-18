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

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenu();
  });

  drawer.addEventListener("click", (e) => {
    const a = e.target.closest("a");
    if (a) closeMenu();
  });

  const langModal = document.getElementById("langModal");
  const openLang = document.getElementById("openLang");
  const closeLang = document.getElementById("closeLang");

  if (langModal && openLang && closeLang) {
    const open = () => {
      langModal.classList.add("is-open");
      langModal.setAttribute("aria-hidden", "false");
    };
    const close = () => {
      langModal.classList.remove("is-open");
      langModal.setAttribute("aria-hidden", "true");
    };

    openLang.addEventListener("click", open);
    closeLang.addEventListener("click", close);

    langModal.addEventListener("click", (e) => {
      if (e.target === langModal) close();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") close();
    });
  }

})();
