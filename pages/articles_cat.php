<?php
require_once __DIR__ . '/../helpers/articles.php';

$defaultCat = $ARTICLE_CATEGORIES[0]['slug'];
$cat = $_GET['cat'] ?? $defaultCat;

$category = null;
foreach ($ARTICLE_CATEGORIES as $c) {
  if ($c['slug'] === $cat) {
    $category = $c;
    break;
  }
}
if (!$category) {
  $category = $ARTICLE_CATEGORIES[0];
  $cat = $category['slug'];
}

$filtered = array_values(
  array_filter($ARTICLES, fn($a) => ($a['cat'] ?? '') === $cat)
);
?>

<main class="page articles-cat-page">

  <section class="page-title-wrap">
    <h1 class="page-title">Latch Library</h1>
    <p class="page-subtitle">Articles</p>
  </section>


  <section class="articles-cat-hero">
    <img
      class="articles-cat-hero-img"
      src="<?= htmlspecialchars($category['hero']) ?>"
      alt="">

    <a class="articles-cat-back" href="/MILKYWAY/index.php?page=articles">
      &larr; All Articles
    </a>

    <div class="articles-cat-ribbon <?= htmlspecialchars($category['ribbon_class']) ?>">
      <?= htmlspecialchars($category['name']) ?>
    </div>
  </section>

  <section class="articles-grid-cards">

    <?php if (count($filtered) === 0): ?>
      <p class="articles-empty">No articles yet.</p>
    <?php else: ?>
      <?php foreach ($filtered as $a): ?>

        <a
          class="article-link-card"
          href="<?= htmlspecialchars($a['link']) ?>"
          target="_blank"
          rel="noopener noreferrer">

          <p class="article-snippet">
            <?= htmlspecialchars($a['overview'] ?? 'No description yet.') ?>
          </p>

          <div class="article-divider"></div>

          <div class="article-meta">
            <div class="article-title">
              <?= htmlspecialchars($a['title']) ?>
            </div>
            <div class="article-source">
              <?= htmlspecialchars($a['author']) ?>
            </div>
          </div>

        </a>

      <?php endforeach; ?>
    <?php endif; ?>

  </section>

</main>