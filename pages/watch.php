<?php
require_once __DIR__ . '/../helpers/videos.php';

$cat = $_GET['cat'] ?? 'all';
$cat = strtolower(trim($cat));

// whitelist valid categories (prevents broken links)
$valid = array_map(fn($c) => $c['slug'], $VIDEO_CATEGORIES);
if (!in_array($cat, $valid, true)) {
  $cat = 'all';
}

// filter
$filtered = array_values(array_filter($VIDEOS, function($v) use ($cat) {
  return $cat === 'all' || ($v['category'] ?? '') === $cat;
}));
?>


<main class="page watch-page">

    <section class="watch-head">
        <h1>Watch &amp; Learn</h1>
        <p>Video Library</p>
    </section>

    <section class="watch-chips">
        <?php foreach ($VIDEO_CATEGORIES as $c): ?>
            <a class="chip <?= $cat === $c['slug'] ? 'is-active' : '' ?>"
                href="/MilkyWay/index.php?page=watch&cat=<?= htmlspecialchars($c['slug']) ?>">
                <?= htmlspecialchars($c['name']) ?>
            </a>
        <?php endforeach; ?>
    </section>

    <section class="watch-list">
  <?php if (count($filtered) === 0): ?>
    <div class="empty-card">No videos in this category yet.</div>
  <?php endif; ?>

  <?php foreach ($filtered as $v): ?>
    <a class="watch-card" href="/MilkyWay/index.php?page=watch_view&id=<?= (int)$v['id'] ?>">
      <div class="watch-thumb">
        <img src="<?= htmlspecialchars($v['thumb']) ?>" alt="">
        <span class="watch-play">▶</span>
        <span class="watch-dur"><?= htmlspecialchars($v['duration']) ?></span>
      </div>

      <div class="watch-meta">
  <p class="watch-title"><?= htmlspecialchars($v['title']) ?></p>
  <p class="watch-author"><?= htmlspecialchars($v['author']) ?></p>

  <?php if (!empty($v['description'])): ?>
    <p class="watch-desc"><?= htmlspecialchars($v['description']) ?></p>
  <?php endif; ?>
</div>
    </a>
  <?php endforeach; ?>
</section>

</main>