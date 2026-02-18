<?php
require_once __DIR__ . '/../helpers/articles.php';

$id = (int)($_GET['id'] ?? 0);

$article = null;
foreach ($ARTICLES as $a) {
  if ((int)$a['id'] === $id) { $article = $a; break; }
}

if (!$article) {
  echo "<main class='page'><p>Article not found.</p></main>";
  return;
}

$cat = $article['cat'] ?? 'intro';
?>

<main class="page article-view-page">

  <a class="article-back" href="/MILKYWAY/index.php?page=articles_cat&cat=<?= htmlspecialchars($cat) ?>">&larr; Back</a>

  <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>
  <p class="article-author"><?= htmlspecialchars($article['author']) ?></p>

  <?php if (!empty($article['overview'])): ?>
    <p class="article-overview"><?= htmlspecialchars($article['overview']) ?></p>
  <?php endif; ?>

  <div class="article-content">
    <?= nl2br(htmlspecialchars($article['content'] ?? '')) ?>
  </div>

</main>
