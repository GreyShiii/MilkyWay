document.addEventListener("DOMContentLoaded", () => {
  const stars = document.querySelectorAll("#starRating .star");
  const submitBtn = document.getElementById("btnSubmitFeedback");
  const likeButtons = document.querySelectorAll("#likeGrid .like-card");

  const thanksOverlay = document.getElementById("thanksOverlay");
  const btnThanksClose = document.getElementById("btnThanksClose");

  let selectedRating = 0;

  function renderStars(fillUpTo) {
    stars.forEach((s) => {
      const shouldFill = Number(s.dataset.value) <= fillUpTo;
      s.classList.toggle("active", shouldFill);
      s.textContent = shouldFill ? "★" : "☆";
    });
  }

  function openThanks() {
    if (!thanksOverlay) return;
    thanksOverlay.classList.add("is-open");
    thanksOverlay.setAttribute("aria-hidden", "false");
  }

  function closeThanks() {
    if (!thanksOverlay) return;
    thanksOverlay.classList.remove("is-open");
    thanksOverlay.setAttribute("aria-hidden", "true");
  }

  btnThanksClose?.addEventListener("click", closeThanks);
  thanksOverlay?.addEventListener("click", (e) => {
    if (e.target === thanksOverlay) closeThanks();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeThanks();
  });

  stars.forEach((star) => {
    star.addEventListener("mouseenter", () => {
      renderStars(Number(star.dataset.value));
    });

    star.addEventListener("mouseleave", () => {
      renderStars(selectedRating);
    });

    star.addEventListener("click", () => {
      selectedRating = Number(star.dataset.value);
      renderStars(selectedRating);
    });
  });

  likeButtons.forEach((btn) => {
    btn.addEventListener("click", () => btn.classList.toggle("is-selected"));
  });

  submitBtn?.addEventListener("click", async () => {
    if (selectedRating < 1 || selectedRating > 5) {
      alert(T("fb_alert_pick_star"));
      return;
    }

    const liked = [];
    document
      .querySelectorAll("#likeGrid .like-card.is-selected")
      .forEach((b) => liked.push(b.dataset.like));

    submitBtn.disabled = true;

    try {
      const res = await fetch("process/save_feedback.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ rating: selectedRating, liked }),
      });

      const out = await res.json();
      if (!out.ok) throw new Error(out.error || "Save failed");

      selectedRating = 0;
      renderStars(0);
      likeButtons.forEach((btn) => btn.classList.remove("is-selected"));

      openThanks();
    } catch (e) {
      console.error(e);
      alert(T("fb_save_fail"));
    } finally {
      submitBtn.disabled = false;
    }
  });
});
