<?php
session_start();
require_once __DIR__ . '/../public/config/db.php';

$cats = [];
$catRes = $conn->query("SELECT category_name, category_slug FROM categories ORDER BY sort_order ASC, category_name ASC");
if ($catRes) while ($row = $catRes->fetch_assoc()) $cats[] = $row;

$active = trim($_GET['cat'] ?? 'all');
if ($active === '') $active = 'all';

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

// ✅ Load global head (main.css)
include __DIR__ . '/../layout/head.php';
?>

<!-- ✅ Load watch-only CSS -->
<link rel="stylesheet" href="/MILKYWAY/public/css/watch.css?v=1">

<main class="page watch-page">
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

  <nav class="tabs">
    <a class="tab <?= $active === 'all' ? 'is-active' : '' ?>" href="?cat=all">All</a>
    <?php foreach ($cats as $c): ?>
      <?php $slug = $c['category_slug']; ?>
      <a class="tab <?= $active === $slug ? 'is-active' : '' ?>" href="?cat=<?= e($slug) ?>">
        <?= e($c['category_name']) ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <section class="video-list" id="videoList">
    <?php if (!$videos): ?>
      <div class="empty-card">No videos found.</div>
    <?php else: ?>
      <?php foreach ($videos as $v): ?>
        <?php
          $thumb = $v['thumbnail_url'] ?: '/MILKYWAY/public/images/placeholder-thumb.png';
          $dur = formatDuration($v['duration_seconds']);
        ?>
        <article class="video-card"
                 data-title="<?= e($v['video_title']) ?>"
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
    player.src = "";
  }
  closeBtn.addEventListener('click', closeModal);
  modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

  document.getElementById('videoList').addEventListener('click', (e) => {
    const card = e.target.closest('.video-card');
    if (!card) return;
    openModal(card.dataset.title || "Video", card.dataset.url || "");
  });
</script>

</body>
</html>
