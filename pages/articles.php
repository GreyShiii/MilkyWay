<?php
require_once __DIR__ . '/../helpers/articles.php';
?>

<main class="page articles-page">

  <section class="articles-head">
    <h1>Latch Library</h1>
    <p>Articles</p>
  </section>

  <section class="article-cats">
    <?php foreach ($ARTICLE_CATEGORIES as $c): ?>
      <a class="article-cat"
         href="/MILKYWAY/index.php?page=articles_cat&cat=<?= htmlspecialchars($c['slug']) ?>">

        <div class="article-cat-placeholder">Category</div>

        <div class="article-cat-ribbon <?= htmlspecialchars($c['ribbon_class']) ?>">
          <?= htmlspecialchars($c['name']) ?>
        </div>
      </a>
    <?php endforeach; ?>
  </section>

</main>
