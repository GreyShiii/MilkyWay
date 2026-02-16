<?php
require_once __DIR__ . '/../helpers/articles.php';

$cat = strtolower(trim($_GET['cat'] ?? 'intro'));

// find category
$category = null;
foreach ($ARTICLE_CATEGORIES as $c) {
  if ($c['slug'] === $cat) { $category = $c; break; }
}
if (!$category) { $category = $ARTICLE_CATEGORIES[0]; $cat = $category['slug']; }

// filter articles
$filtered = array_values(array_filter($ARTICLES, fn($a) => ($a['cat'] ?? '') === $cat));
?>

<main class="page articles-cat-page">

  <section class="articles-cat-hero">
    <img class="articles-cat-hero-img" src="<?= htmlspecialchars($category['hero']) ?>" alt="">
    <a class="articles-cat-back" href="/MILKYWAY/index.php?page=articles">&larr; All Articles</a>
    <div class="articles-cat-ribbon <?= htmlspecialchars($category['ribbon_class']) ?>">
      <?= htmlspecialchars($category['name']) ?>
    </div>
  </section>

  <section class="articles-grid">
    <?php foreach ($filtered as $a): ?>
      <a class="article-card" href="/MILKYWAY/index.php?page=article_view&id=<?= (int)$a['id'] ?>">
        <div class="article-thumb"></div>
        <div class="article-card-meta">
          <p class="article-card-title"><?= htmlspecialchars($a['title']) ?></p>
          <p class="article-card-author"><?= htmlspecialchars($a['author']) ?></p>
        </div>
      </a>
    <?php endforeach; ?>

    <?php if (count($filtered) === 0): ?>
      <p class="articles-empty">No articles yet in this category.</p>
    <?php endif; ?>
  </section>

</main>
