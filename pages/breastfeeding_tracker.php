<?php
require_once __DIR__ . '/../helpers/auth.php';

require_login();

// determine if this session is a guest visit; no redirect here
$isGuest = function_exists('is_guest') && is_guest();

// only fetch user data for real users
$user = $isGuest ? null : auth_user();
?>
<?php if (!$isGuest): ?>
<main class="page breastfeeding-page">
  <div class="page-title-wrap">
    <h1 class="page-title">Breastfeeding Tracker</h1>
    <p class="page-subtitle">Track your baby's feeding session.</p>
  </div>

  <section class="bf-card" id="bfCard">

    <h2 class="bf-title">Breastfeeding</h2>
    <p class="bf-subtitle" id="bfSubtitle">Tap to start tracking</p>

    <div class="bf-actions" id="bfActionsDefault">
      <button type="button" class="bf-btn bf-btn-start" id="startBtn">
        <span class="bf-btn-icon">▶</span>
        <span>Start Breastfeeding</span>
      </button>
    </div>

    <div class="bf-actions bf-actions-active" id="bfActionsActive" hidden>
      <button type="button" class="bf-btn bf-btn-stop bf-btn-stop-wide" id="stopBtn">
        <span class="bf-btn-icon">■</span>
        <span>Stop Breastfeeding</span>
      </button>
    </div>

    <div class="bf-recording" id="bfRecording" hidden>
      <span class="bf-recording-dot"></span>
      <span id="bfRecordingText">Recording...</span>
    </div>

    <div class="bf-result" id="bfResult" hidden>
      <p class="bf-result-label">Session recorded</p>
      <p class="bf-result-time">
        <span id="bfResultDuration">0:00</span> <small id="bfResultUnit">min</small>
      </p>
    </div>
  </section>

  <section class="bf-history-wrap">
    <div class="bf-history-head">
      <h3 class="bf-history-title">History</h3>
      <button type="button" class="bf-clear-btn" id="clearHistoryBtn">Clear all</button>
    </div>

    <div class="bf-empty" id="bfEmptyState">
      No breastfeeding sessions recorded yet. Start your first feeding session.
    </div>

    <div class="bf-history-list" id="bfHistoryList"></div>
  </section>
</main>
<?php else: ?>
<!-- guest sees only modal; content is intentionally omitted -->
<main class="page breastfeeding-page"></main>
<?php endif; ?>

<?php if (!$isGuest): ?>
<script>
  window.MILKYWAY_BF = {
    historyUrl: '<?= BASE_URL ?>/api/breastfeeding_history.php',
    saveUrl: '<?= BASE_URL ?>/api/breastfeeding_save.php',
    clearUrl: '<?= BASE_URL ?>/api/breastfeeding_clear.php',
    deleteUrl: '<?= BASE_URL ?>/api/breastfeeding_delete.php',
    deleteIconUrl: '<?= BASE_URL ?>/public/images/delete.png',
    userId: <?php echo (int) $user['id']; ?>
  };
</script>
<script src="<?= BASE_URL ?>/public/js/breastfeeding_tracker.js"></script>
<?php endif; ?>

<?php if ($isGuest): ?>
<script>
  (function(){
    function tryOpen(){
      if (typeof openLoginPrompt === 'function') {
        openLoginPrompt();
      } else {
        setTimeout(tryOpen, 30);
      }
    }
    document.addEventListener('DOMContentLoaded', tryOpen);
  })();
</script>
<?php endif; ?>