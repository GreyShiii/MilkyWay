<?php
require_once __DIR__ . '/../helpers/articles.php';
?>

<main class="page articles-page">

  <section class="page-title-wrap">
    <h1 class="page-title">Latch Library</h1>
    <p class="page-subtitle">Articles</p>
  </section>


  <section class="article-cats">
    <?php foreach ($ARTICLE_CATEGORIES as $c): ?>
      <a class="article-cat"
        href="/MILKYWAY/index.php?page=articles_cat&cat=<?= htmlspecialchars($c['slug']) ?>">

        <img class="article-cat-img"
          src="<?= htmlspecialchars($c['hero']) ?>"
          alt="<?= htmlspecialchars($c['name']) ?>">

        <div class="article-cat-ribbon <?= htmlspecialchars($c['ribbon_class']) ?>">
          <?= htmlspecialchars($c['name']) ?>
        </div>
      </a>
    <?php endforeach; ?>
  </section>

</main>