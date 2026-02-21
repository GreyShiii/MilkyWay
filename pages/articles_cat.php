<?php
require_once __DIR__ . '/../helpers/lang.php';
require_once __DIR__ . '/../helpers/articles.php';

$defaultCat = $ARTICLE_CATEGORIES[0]['slug'] ?? 'intro';
$cat = $_GET['cat'] ?? $defaultCat;

$category = null;
foreach ($ARTICLE_CATEGORIES as $c) {
  if (($c['slug'] ?? '') === $cat) {
    $category = $c;
    break;
  }
}

if (!$category) {
  $category = $ARTICLE_CATEGORIES[0] ?? [
    'slug' => 'intro',
    'name' => ['en' => 'Articles', 'fil' => 'Mga Artikulo'],
    'hero' => '',
    'ribbon_class' => 'ribbon-pink',
  ];
  $cat = $category['slug'];
}

$filtered = array_values(
  array_filter($ARTICLES, fn($a) => (($a['cat'] ?? '') === $cat))
);
?>

<main class="page articles-cat-page">

  <section class="page-title-wrap">
    <h1 class="page-title"><?= htmlspecialchars(t('articles_title')) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars(t('articles_sub')) ?></p>
  </section>

  <section class="articles-cat-hero">
    <img
      class="articles-cat-hero-img"
      src="<?= htmlspecialchars((string)($category['hero'] ?? '')) ?>"
      alt="">

    <a class="articles-cat-back" href="index.php?page=articles">
      &larr; <?= htmlspecialchars(t('articles_all')) ?>
    </a>

    <div class="articles-cat-ribbon <?= htmlspecialchars((string)($category['ribbon_class'] ?? '')) ?>">
      <?= htmlspecialchars(tr($category['name'] ?? '')) ?>
    </div>
  </section>

  <section class="articles-grid-cards">
    <?php if (count($filtered) === 0): ?>
      <p class="articles-empty"><?= htmlspecialchars(t('articles_empty')) ?></p>
    <?php else: ?>
      <?php foreach ($filtered as $a): ?>
        <?php
          $link     = (string)($a['link'] ?? '#');
          $overview = tr($a['overview'] ?? 'No description yet.');
          $title    = tr($a['title'] ?? '');
          $author   = tr($a['author'] ?? '');
        ?>
        <a
          class="article-link-card"
          href="<?= htmlspecialchars($link) ?>"
          target="_blank"
          rel="noopener noreferrer">

          <p class="article-snippet">
            <?= htmlspecialchars($overview) ?>
          </p>

          <div class="article-divider"></div>

          <div class="article-meta">
            <div class="article-title">
              <?= htmlspecialchars($title) ?>
            </div>
            <div class="article-source">
              <?= htmlspecialchars($author) ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>

</main>
