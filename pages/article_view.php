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

$cat = $article['cat'] ?? $ARTICLE_CATEGORIES[0]['slug'];
?>

<main class="page article-view-page">
  <div class="article-shell">

    <a class="article-back" href="/MILKYWAY/index.php?page=articles_cat&cat=<?= htmlspecialchars($cat) ?>">&larr; Back</a>

    <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>

    <div class="article-meta">
      <span class="article-meta-label">By</span>
      <span class="article-meta-value"><?= htmlspecialchars($article['author'] ?? '') ?></span>

      <?php if (!empty($article['revised'])): ?>
        <span class="article-meta-dot">•</span>
        <span class="article-meta-label">Last revised</span>
        <span class="article-meta-value"><?= htmlspecialchars($article['revised']) ?></span>
      <?php endif; ?>
    </div>

    <?php if (!empty($article['overview'])): ?>
      <p class="article-overview"><?= htmlspecialchars($article['overview']) ?></p>
    <?php endif; ?>

    <?php if (!empty($article['thumb'])): ?>
      <div class="article-hero">
        <img src="<?= htmlspecialchars($article['thumb']) ?>" alt="">
      </div>
    <?php endif; ?>

    <article class="article-content">
      <?= render_article_content($article['content'] ?? '') ?>
    </article>

  </div>
</main>
