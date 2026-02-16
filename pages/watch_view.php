<?php
require_once __DIR__ . '/../helpers/videos.php';

$id = (int)($_GET['id'] ?? 0);

$video = null;
foreach ($VIDEOS as $v) {
  if ((int)$v['id'] === $id) {
    $video = $v;
    break;
  }
}

if (!$video) {
  echo "<main class='page'><p>Video not found.</p></main>";
  return;
}
?>

<main class="page watch-view-page">

  <div class="watch-top">
    <a class="watch-back" href="/MilkyWay/index.php?page=watch">← Back</a>
  </div>

  <h2 class="watch-title"><?= htmlspecialchars($video['title']) ?></h2>

  <div class="watch-player">
    <video controls playsinline>
      <source src="<?= htmlspecialchars($video['src']) ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>

  <p class="watch-info">
    Duration: <strong><?= htmlspecialchars($video['duration']) ?></strong> •
    Category: <strong><?= htmlspecialchars(ucfirst($video['category'])) ?></strong>
  </p>

</main>