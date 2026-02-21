<?php
require_once __DIR__ . '/../helpers/videos.php';
require_once __DIR__ . '/../helpers/lang.php';

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

$title  = (string)($video['title'] ?? '');
$author = (string)($video['author'] ?? '');
$desc   = (string)($video['description'] ?? '');
$src    = (string)($video['src'] ?? '');
?>

<main class="page watch-view-page">

  <div class="watch-top">
    <a class="watch-back" href="index.php?page=watch">← <?= htmlspecialchars(t('back')) ?></a>
  </div>

  <div class="watch-player">
    <video controls playsinline>
      <source src="<?= htmlspecialchars($src) ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>

  <h2 class="watch-view-title"><?= htmlspecialchars($title) ?></h2>

  <?php if ($author !== ''): ?>
    <div class="watch-view-meta">
      <div class="watch-author-row">
        <span class="watch-view-author"><?= htmlspecialchars($author) ?></span>
      </div>
    </div>
  <?php endif; ?>

  <?php if (trim($desc) !== ''): ?>
    <section class="watch-desc-card" id="descCard">
      <div class="watch-desc-head">
        
        <button class="watch-desc-toggle" type="button" id="descToggle">Show more</button>
      </div>

      <p class="watch-view-desc" id="descText"><?= htmlspecialchars($desc) ?></p>
    </section>

    <script>
      (function () {
        const btn = document.getElementById('descToggle');
        const card = document.getElementById('descCard');
        const text = document.getElementById('descText');
        if (!btn || !card || !text) return;

        const isShort = text.textContent.trim().length < 160;
        if (isShort) {
          btn.style.display = 'none';
          card.classList.add('is-open');
          return;
        }

        btn.addEventListener('click', function () {
          const open = card.classList.toggle('is-open');
          btn.textContent = open ? 'Show less' : 'Show more';
        });
      })();
    </script>
  <?php endif; ?>

</main>