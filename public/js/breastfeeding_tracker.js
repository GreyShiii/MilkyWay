(function () {
  const config = window.MILKYWAY_BF || {};

  const bfResultUnit = document.getElementById("bfResultUnit");
  const bfSubtitle = document.getElementById("bfSubtitle");
  const startBtn = document.getElementById("startBtn");
  const stopBtn = document.getElementById("stopBtn");
  const bfActionsDefault = document.getElementById("bfActionsDefault");
  const bfActionsActive = document.getElementById("bfActionsActive");
  const bfRecording = document.getElementById("bfRecording");
  const bfRecordingText = document.getElementById("bfRecordingText");
  const bfResult = document.getElementById("bfResult");
  const bfResultDuration = document.getElementById("bfResultDuration");
  const bfHistoryList = document.getElementById("bfHistoryList");
  const bfEmptyState = document.getElementById("bfEmptyState");
  const clearHistoryBtn = document.getElementById("clearHistoryBtn");

  let timerInterval = null;
  let elapsedSeconds = 0;
  let isRunning = false;
  let startDate = null;

  function pad(num) {
    return String(num).padStart(2, "0");
  }

  function formatDurationText(totalSeconds) {
    if (totalSeconds < 60) {
      return String(totalSeconds);
    }

    const mins = Math.floor(totalSeconds / 60);
    const secs = totalSeconds % 60;

    if (secs === 0) {
      return String(mins);
    }

    return `${mins}:${pad(secs)}`;
  }

  function getDurationUnit(totalSeconds) {
    if (totalSeconds < 60) {
      return totalSeconds === 1 ? "second" : "seconds";
    }

    return "min";
  }

  function formatDateLabel(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
      month: "short",
      day: "numeric",
      year: "numeric",
    });
  }

  function formatTimeLabel(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString("en-US", {
      hour: "numeric",
      minute: "2-digit",
    });
  }

  function toMysqlDateTime(dateObj) {
    const year = dateObj.getFullYear();
    const month = pad(dateObj.getMonth() + 1);
    const day = pad(dateObj.getDate());
    const hours = pad(dateObj.getHours());
    const minutes = pad(dateObj.getMinutes());
    const seconds = pad(dateObj.getSeconds());

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
  }

  function getOrdinal(num) {
    if (num % 100 >= 11 && num % 100 <= 13) return "th";

    switch (num % 10) {
      case 1:
        return "st";
      case 2:
        return "nd";
      case 3:
        return "rd";
      default:
        return "th";
    }
  }

  function resetIdleState() {
    isRunning = false;
    clearInterval(timerInterval);
    timerInterval = null;
    elapsedSeconds = 0;
    startDate = null;

    bfSubtitle.textContent = "Tap to start tracking";
    bfActionsDefault.hidden = false;
    bfActionsActive.hidden = true;
    bfRecording.hidden = true;
  }

  function startSession() {
    if (isRunning) return;

    startDate = new Date();
    elapsedSeconds = 0;
    isRunning = true;

    bfSubtitle.textContent = "Session in progress...";
    bfActionsDefault.hidden = true;
    bfActionsActive.hidden = false;
    bfRecording.hidden = false;
    bfRecordingText.textContent = "Recording...";
    bfResult.hidden = true;

    timerInterval = setInterval(function () {
      elapsedSeconds++;
    }, 1000);
  }

  async function stopSession() {
    if (!startDate || elapsedSeconds <= 0) {
      resetIdleState();
      return;
    }

    clearInterval(timerInterval);
    timerInterval = null;
    isRunning = false;

    const endedAtDate = new Date(startDate.getTime() + elapsedSeconds * 1000);
    const startedAt = toMysqlDateTime(startDate);
    const endedAt = toMysqlDateTime(endedAtDate);

    const durationText = formatDurationText(elapsedSeconds);
    const durationUnit = getDurationUnit(elapsedSeconds);

    const formData = new FormData();
    formData.append("started_at", startedAt);
    formData.append("ended_at", endedAt);
    formData.append("duration_seconds", String(elapsedSeconds));

    try {
      const response = await fetch(config.saveUrl, {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (!data.success) {
        alert(data.message || "Failed to save session.");
        resetIdleState();
        return;
      }

      resetIdleState();
      bfResult.hidden = false;
      bfResultDuration.textContent = durationText;
      if (bfResultUnit) {
        bfResultUnit.textContent = durationUnit;
      }

      await loadHistory();
    } catch (error) {
      alert("Something went wrong while saving the session.");
      resetIdleState();
    }
  }

  function buildGroupedSessions(rawSessions) {
    const grouped = {};

    rawSessions.forEach(function (session) {
      const dateLabel = formatDateLabel(session.started_at);

      if (!grouped[dateLabel]) {
        grouped[dateLabel] = [];
      }

      grouped[dateLabel].push(session);
    });

    return grouped;
  }

  async function deleteSession(sessionId) {
    const confirmed = window.confirm("Delete this breastfeeding session?");
    if (!confirmed) return;

    const formData = new FormData();
    formData.append("session_id", String(sessionId));

    try {
      const response = await fetch(config.deleteUrl, {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (!data.success) {
        alert(data.message || "Failed to delete session.");
        return;
      }

      await loadHistory();
    } catch (error) {
      alert("Something went wrong while deleting the session.");
    }
  }

  function renderHistory(sessions) {
    bfHistoryList.innerHTML = "";

    if (!sessions || !sessions.length) {
      bfEmptyState.hidden = false;
      clearHistoryBtn.style.display = "none";
      return;
    }

    bfEmptyState.hidden = true;
    clearHistoryBtn.style.display = "inline-block";

    const grouped = buildGroupedSessions(sessions);

    Object.keys(grouped).forEach(function (dateLabel) {
      const groupEl = document.createElement("div");
      groupEl.className = "bf-date-group";

      const dateEl = document.createElement("div");
      dateEl.className = "bf-date-label";
      dateEl.textContent = dateLabel;
      groupEl.appendChild(dateEl);

      const daySessions = grouped[dateLabel];

      daySessions.forEach(function (session, index) {
        const durationText = formatDurationText(
          Number(session.duration_seconds || 0),
        );
        const startTime = formatTimeLabel(session.started_at);
        const endTime = formatTimeLabel(session.ended_at);
        const feedNumber = index + 1;

        const card = document.createElement("div");
        card.className = "bf-session-card";
        card.innerHTML = `
          <div class="bf-session-left">
            <div class="bf-session-icon">◔</div>
            <div class="bf-session-meta">
              <p class="bf-session-name">${feedNumber}${getOrdinal(feedNumber)} feeding</p>
              <p class="bf-session-time">${startTime}</p>
              <p class="bf-session-range">Start: ${startTime} • End: ${endTime}</p>
            </div>
          </div>

          <div class="bf-session-right">
            <div class="bf-session-duration">
              ${durationText} <small>${getDurationUnit(Number(session.duration_seconds || 0))}</small>
            </div>
            <button type="button" class="bf-delete-btn" data-session-id="${session.id}" aria-label="Delete session">
              <img src="${window.MILKYWAY_BF.deleteIconUrl}" class="bf-delete-icon" alt="Delete">
            </button>
          </div>
        `;

        const deleteBtn = card.querySelector(".bf-delete-btn");
        deleteBtn.addEventListener("click", function () {
          deleteSession(session.id);
        });

        groupEl.appendChild(card);
      });

      bfHistoryList.appendChild(groupEl);
    });
  }

  async function loadHistory() {
    try {
      const response = await fetch(config.historyUrl, { method: "GET" });
      const data = await response.json();

      if (!data.success) {
        renderHistory([]);
        return;
      }

      renderHistory(data.sessions || []);
    } catch (error) {
      renderHistory([]);
    }
  }

  async function clearHistory() {
    const confirmed = window.confirm("Clear all breastfeeding history?");
    if (!confirmed) return;

    try {
      const response = await fetch(config.clearUrl, {
        method: "POST",
      });

      const data = await response.json();

      if (!data.success) {
        alert(data.message || "Failed to clear history.");
        return;
      }

      bfResult.hidden = true;
      await loadHistory();
    } catch (error) {
      alert("Something went wrong while clearing history.");
    }
  }

  if (startBtn) {
    startBtn.addEventListener("click", function () {
      startSession();
    });
  }

  if (stopBtn) {
    stopBtn.addEventListener("click", function () {
      stopSession();
    });
  }

  if (clearHistoryBtn) {
    clearHistoryBtn.addEventListener("click", function () {
      clearHistory();
    });
  }

  loadHistory();
})();
