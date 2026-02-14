<?php
session_start();
require_once __DIR__ . '/../config/db.php';

/*
  Access rules:
  - Guests allowed (is_guest)
  - Logged in viewers allowed
  - Admin/editor allowed
  If you want to force login for watch page, add a redirect check here.
*/

// Read categories for tabs
$cats = [];
$catRes = $conn->query("SELECT category_name, category_slug FROM categories ORDER BY sort_order ASC, category_name ASC");
if ($catRes) {
  while ($row = $catRes->fetch_assoc()) $cats[] = $row;
}

// Selected category slug
$active = $_GET['cat'] ?? 'all';
$active = trim($active);
if ($active === '') $active = 'all';

// Load videos
if ($active === 'all') {
  $stmt = $conn->prepare("
    SELECT v.video_id, v.video_title, v.thumbnail_url, v.duration_seconds, v.views, v.video_type, v.video_url,
           c.category_name, c.category_slug
    FROM videos v
    JOIN categories c ON c.category_id = v.category_id
    WHERE v.is_published = 1
    ORDER BY v.video_created_at DESC
  ");
  $stmt->execute();
} else {
  $stmt = $conn->prepare("
    SELECT v.video_id, v.video_title, v.thumbnail_url, v.duration_seconds, v.views, v.video_type, v.video_url,
           c.category_name, c.category_slug
    FROM videos v
    JOIN categories c ON c.category_id = v.category_id
    WHERE v.is_published = 1
      AND c.category_slug = ?
    ORDER BY v.video_created_at DESC
  ");
  $stmt->bind_param("s", $active);
  $stmt->execute();
}

$res = $stmt->get_result();
$videos = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
$stmt->close();

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function formatViews($n){
  $n = (int)$n;
  if ($n >= 1000000) return round($n/1000000, 1) . "M views";
  if ($n >= 1000) return round($n/1000, 1) . "k views";
  return $n . " views";
}

function formatDuration($seconds){
  $seconds = (int)$seconds;
  if ($seconds <= 0) return "";
  $m = floor($seconds / 60);
  $s = $seconds % 60;
  return $m . ":" . str_pad((string)$s, 2, "0", STR_PAD_LEFT);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Watch & Learn — Milky Way</title>
  <link rel="stylesheet" href="/MILKYWAY/public/css/main.css?v=1">
  <style>
    /* --- WATCH UI (keep lightweight) --- */
    .watch-page { padding-bottom: 110px; }

    .watch-topbar{
      background:#FFAAAC;
      padding:12px 14px;
      display:grid;
      grid-template-columns:44px 1fr 44px;
      align-items:center;
    }
    .watch-topbar .back-btn{
      width:44px;height:44px;border-radius:12px;
      display:grid;place-items:center;
      text-decoration:none;color:#fff;font-size:22px;
    }
    .watch-topbar .title{
      display:flex;justify-content:center;align-items:center;gap:10px;
      color:#fff;font-weight:900;font-size:18px;
    }
    .watch-topbar .title img{ width:28px;height:28px;object-fit:contain; }

    .watch-header{
      text-align:center;
      padding:12px 16px 6px;
    }
    .watch-header h1{
      margin:0;
      font-size:18px;
      color:#ff6f7a;
      font-weight:900;
      font-style:italic;
    }
    .watch-header p{
      margin:2px 0 0;
      font-size:11px;
      color:#6b7280;
    }

    .tabs{
      padding:10px 16px 8px;
      display:flex;
      gap:8px;
      overflow:auto;
      -webkit-overflow-scrolling: touch;
    }
    .tab{
      white-space:nowrap;
      border:1px solid rgba(0,0,0,.08);
      background:#fff;
      padding:7px 12px;
      border-radius:999px;
      font-size:11px;
      font-weight:800;
      text-decoration:none;
      color:#111;
    }
    .tab.is-active{
      background:#ff8f94;
      color:#fff;
      border-color:transparent;
    }

    .video-list{
      padding: 0 16px 18px;
      display:grid;
      gap:12px;
    }

    .video-card{
      background:#fff;
      border-radius:18px;
      padding:10px;
      display:grid;
      grid-template-columns: 160px 1fr;
      gap:12px;
      box-shadow: 0 10px 22px rgba(0,0,0,.08);
      cursor:pointer;
    }

    .thumb{
      position:relative;
      border-radius:14px;
      overflow:hidden;
      aspect-ratio: 16 / 10;
      background:#f3f4f6;
    }
    .thumb img{
      width:100%;height:100%;
      object-fit:cover;
      display:block;
      filter:brightness(.92);
    }

    .play{
      position:absolute; inset:0;
      display:grid; place-items:center;
      pointer-events:none;
    }
    .play::before{
      content:"";
      width:44px;height:44px;border-radius:999px;
      background: rgba(255,255,255,.92);
      box-shadow: 0 6px 18px rgba(0,0,0,.18);
    }
    .play::after{
      content:"";
      position:absolute;
      width:0;height:0;
      border-left:14px solid #ff6f7a;
      border-top:9px solid transparent;
      border-bottom:9px solid transparent;
      margin-left:4px;
    }

    .dur{
      position:absolute;
      right:8px; bottom:8px;
      background: rgba(0,0,0,.55);
      color:#fff;
      font-size:10px;
      padding:3px 7px;
      border-radius:999px;
    }

    .meta{
      display:flex;
      flex-direction:column;
      justify-content:center;
      gap:6px;
      min-width: 0;
    }
    .vtitle{
      margin:0;
      font-size:12px;
      font-weight:900;
      line-height:1.25;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
    }
    .vviews{
      font-size:10px;
      color:#6b7280;
    }
    .tag{
      display:inline-block;
      width:fit-content;
      font-size:10px;
      font-weight:800;
      color:#7c2d12;
      background: rgba(255,170,172,.30);
      padding:5px 10px;
      border-radius:999px;
    }

    /* Modal player */
    .modal{
      position:fixed; inset:0;
      background: rgba(0,0,0,.45);
      display:none;
      align-items:center;
      justify-content:center;
      padding:16px;
      z-index:2000;
    }
    .modal.is-open{ display:flex; }
    .sheet{
      width:100%;
      max-width:520px;
      background:#fff;
      border-radius:18px;
      overflow:hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,.25);
    }
    .sheet-top{
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:10px 12px;
      background:#FFAAAC;
      color:#fff;
      font-weight:900;
    }
    .close{
      border:0;background:transparent;
      color:#fff;font-size:18px;
      cursor:pointer;
    }
    .player{
      width:100%;
      aspect-ratio: 16/9;
      background:#000;
      display:block;
      border:0;
    }
    .sheet-body{
      padding:12px;
    }
    .sheet-title{ margin:0 0 6px; font-weight:900; }
    .sheet-sub{ margin:0; font-size:12px; color:#6b7280; }
  </style>
</head>
<body>

<main class="page watch-page">
  <!-- Top bar -->
  <header class="watch-topbar">
    <a class="back-btn" href="/MILKYWAY/index.php" aria-label="Back">←</a>

    <div class="title">
      <img src="/MILKYWAY/public/images/logo.png" alt="" onerror="this.style.display='none'">
      <span>Milky Way</span>
    </div>

    <div></div>
  </header>

  <section class="watch-header">
    <h1>Watch &amp; Learn</h1>
    <p>Video Library</p>
  </section>

  <!-- Tabs -->
  <nav class="tabs">
    <a class="tab <?= $active === 'all' ? 'is-active' : '' ?>" href="?cat=all">All</a>
    <?php foreach ($cats as $c): ?>
      <?php $slug = $c['category_slug']; ?>
      <a class="tab <?= $active === $slug ? 'is-active' : '' ?>" href="?cat=<?= e($slug) ?>">
        <?= e($c['category_name']) ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <!-- Videos -->
  <section class="video-list" id="videoList">
    <?php if (!$videos): ?>
      <div style="background:#fff;padding:14px;border-radius:16px;box-shadow:0 10px 22px rgba(0,0,0,.08);">
        No videos found.
      </div>
    <?php else: ?>
      <?php foreach ($videos as $v): ?>
        <?php
          $thumb = $v['thumbnail_url'] ?: '/MILKYWAY/public/images/placeholder-thumb.png';
          $dur = formatDuration($v['duration_seconds']);
        ?>
        <article class="video-card"
                 data-id="<?= (int)$v['video_id'] ?>"
                 data-title="<?= e($v['video_title']) ?>"
                 data-type="<?= e($v['video_type']) ?>"
                 data-url="<?= e($v['video_url']) ?>">
          <div class="thumb">
            <img src="<?= e($thumb) ?>" alt="">
            <div class="play"></div>
            <?php if ($dur): ?><div class="dur"><?= e($dur) ?></div><?php endif; ?>
          </div>
          <div class="meta">
            <h3 class="vtitle"><?= e($v['video_title']) ?></h3>
            <div class="vviews"><?= e(formatViews($v['views'])) ?></div>
            <div class="tag"><?= e($v['category_name']) ?></div>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>
</main>

<!-- Modal -->
<div class="modal" id="modal">
  <div class="sheet">
    <div class="sheet-top">
      <div>Watch</div>
      <button class="close" id="closeBtn" aria-label="Close">✕</button>
    </div>
    <iframe class="player" id="player" src="" allowfullscreen></iframe>
    <div class="sheet-body">
      <h3 class="sheet-title" id="mTitle"></h3>
      <p class="sheet-sub" id="mSub"></p>
    </div>
  </div>
</div>

<script>
  const modal = document.getElementById('modal');
  const player = document.getElementById('player');
  const closeBtn = document.getElementById('closeBtn');
  const mTitle = document.getElementById('mTitle');
  const mSub = document.getElementById('mSub');

  function openModal(title, url) {
    mTitle.textContent = title;
    mSub.textContent = "Tap outside to close";
    player.src = url;
    modal.classList.add('is-open');
  }

  function closeModal() {
    modal.classList.remove('is-open');
    player.src = ""; // stop video
  }

  closeBtn.addEventListener('click', closeModal);
  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });

  // Click a card to open
  document.getElementById('videoList').addEventListener('click', (e) => {
    const card = e.target.closest('.video-card');
    if (!card) return;

    const title = card.dataset.title || "Video";
    const type = card.dataset.type;
    const url = card.dataset.url;

    // Lightweight rule:
    // - If you store YouTube embed links, just use them directly.
    // - If you store uploaded mp4 path, we open a simple player page later.
    // For now: if it's a normal https embed, open it.
    openModal(title, url);
  });
</script>

</body>
</html>
