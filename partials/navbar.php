<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../helpers/auth.php';
$u = auth_user();
?>
<header class="header">
  <div class="topbar">
    <div class="topbar-spacer"></div>
    <div class="logo">
      <img class="logo-img" src="<?= BASE_URL ?>/public/images/logo.png" alt="Milky Way">
      <div class="logo-text">Milky Way</div>
    </div>
    <div class="topbar-spacer"></div>
  </div>

  <div class="subbar" style="gap:10px;">
    <div class="group-12">MilkyWay</div>

    <div style="display:flex;align-items:center;gap:10px;">
      <?php if (!$u): ?>
        <a href="<?= BASE_URL ?>/auth/login.php" style="text-decoration:none;font-weight:900;color:#ff6f7a;font-size:12px;">Login</a>
        <a href="<?= BASE_URL ?>/auth/register.php" style="text-decoration:none;font-weight:900;color:#ff6f7a;font-size:12px;">Register</a>
        <a href="<?= BASE_URL ?>/auth/google_start.php"
           style="text-decoration:none;font-weight:900;color:#111827;font-size:12px;background:#fff;border:1px solid rgba(0,0,0,0.12);
                  padding:6px 10px;border-radius:999px;box-shadow:0 6px 14px rgba(0,0,0,0.06);">
          Google
        </a>
      <?php else: ?>
        <div style="position:relative;">
          <details style="cursor:pointer;">
            <summary style="list-style:none;display:flex;align-items:center;gap:8px;font-weight:900;color:#111827;font-size:12px;">
              <?= htmlspecialchars($u['username'] ?: 'User') ?> ▾
            </summary>

            <div style="position:absolute;right:0;margin-top:8px;background:#fff;border-radius:12px;
                        border:1px solid rgba(0,0,0,0.10);box-shadow:0 10px 22px rgba(0,0,0,0.08);overflow:hidden;min-width:160px;">
              <a href="<?= BASE_URL ?>/index.php?page=dashboard"
                 style="display:block;padding:10px 12px;text-decoration:none;color:#111827;font-weight:800;font-size:12px;">
                Dashboard
              </a>
              <a href="<?= BASE_URL ?>/auth/logout.php"
                 style="display:block;padding:10px 12px;text-decoration:none;color:#ff6f7a;font-weight:900;font-size:12px;border-top:1px solid rgba(0,0,0,0.06);">
                Logout
              </a>
            </div>
          </details>
        </div>
      <?php endif; ?>
    </div>
  </div>
</header>