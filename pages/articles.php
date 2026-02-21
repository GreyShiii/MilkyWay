<?php
require_once __DIR__ . '/../helpers/lang.php';
require_once __DIR__ . '/../helpers/articles.php';
?>

<main class="page articles-page">

  <section class="page-title-wrap">
    <h1 class="page-title"><?= htmlspecialchars(t('articles_title')) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars(t('articles_sub')) ?></p>
  </section>

  <section class="article-cats">
    <?php foreach (($ARTICLE_CATEGORIES ?? []) as $c): ?>
      <a class="article-cat"
         href="index.php?page=articles_cat&cat=<?= htmlspecialchars($c['slug'] ?? '') ?>">

        <img class="article-cat-img"
             src="<?= htmlspecialchars($c['hero'] ?? '') ?>"
             alt="<?= htmlspecialchars(tr($c['name'] ?? '')) ?>"
             loading="lazy">

        <div class="article-cat-ribbon <?= htmlspecialchars($c['ribbon_class'] ?? '') ?>">
          <?= htmlspecialchars(tr($c['name'] ?? '')) ?>
        </div>
      </a>
    <?php endforeach; ?>
  </section>

</main>
