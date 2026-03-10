document.addEventListener("DOMContentLoaded", function () {
  const triggers = document.querySelectorAll(".view-activity-trigger");
  const overlay = document.getElementById("activityOverlay");
  const drawer = document.getElementById("activityDrawer");
  const closeBtn = document.getElementById("closeActivityDrawer");

  const drawerUserName = document.getElementById("drawerUserName");
  const drawerUserEmail = document.getElementById("drawerUserEmail");
  const drawerUserId = document.getElementById("drawerUserId");
  const drawerUserStatus = document.getElementById("drawerUserStatus");
  const drawerUserLogin = document.getElementById("drawerUserLogin");
  const drawerUserActive = document.getElementById("drawerUserActive");
  const drawerUserLogins = document.getElementById("drawerUserLogins");
  const drawerUserVisits = document.getElementById("drawerUserVisits");
  const drawerHistoryList = document.getElementById("drawerHistoryList");

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function openDrawer(trigger) {
    let history = [];

    try {
      history = JSON.parse(trigger.dataset.userHistory || "[]");
    } catch (err) {
      history = [];
    }

    drawerUserName.textContent = trigger.dataset.userName || "User";
    drawerUserEmail.textContent = trigger.dataset.userEmail || "—";
    drawerUserId.textContent = trigger.dataset.userId || "—";
    drawerUserStatus.textContent = trigger.dataset.userStatus || "—";
    drawerUserLogin.textContent = trigger.dataset.userLogin || "—";
    drawerUserActive.textContent = trigger.dataset.userActive || "—";
    drawerUserLogins.textContent = trigger.dataset.userLogins || "0";
    drawerUserVisits.textContent = trigger.dataset.userVisits || "0";

    drawerHistoryList.innerHTML = "";

    if (!history.length) {
      drawerHistoryList.innerHTML = `
        <div class="activity-history-empty">
          No activity history available yet.
        </div>
      `;
    } else {
      history.forEach((item) => {
        const row = document.createElement("div");
        row.className = "activity-history-item";
        row.innerHTML = `
          <div class="activity-history-dot"></div>
          <div class="activity-history-content">
            <h5>${escapeHtml(item.label || "Activity")}</h5>
            <p>${escapeHtml(item.page || "MilkyWay system")}</p>
            <span>${escapeHtml(item.time || "—")}</span>
          </div>
        `;
        drawerHistoryList.appendChild(row);
      });
    }

    overlay.hidden = false;
    drawer.setAttribute("aria-hidden", "false");
    document.body.classList.add("activity-drawer-open");
  }

  function closeDrawer() {
    overlay.hidden = true;
    drawer.setAttribute("aria-hidden", "true");
    document.body.classList.remove("activity-drawer-open");
  }

  triggers.forEach((trigger) => {
    trigger.addEventListener("click", function () {
      openDrawer(this);
    });

    trigger.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        openDrawer(this);
      }
    });
  });

  if (closeBtn) {
    closeBtn.addEventListener("click", closeDrawer);
  }

  if (overlay) {
    overlay.addEventListener("click", closeDrawer);
  }

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && document.body.classList.contains("activity-drawer-open")) {
      closeDrawer();
    }
  });
});