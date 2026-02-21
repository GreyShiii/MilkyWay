<?php
require_once __DIR__ . '/../helpers/lang.php';
require_once __DIR__ . '/../helpers/didyouknow.php';

$DIDYOUKNOW_SECTIONS = didyouknow_sections();
?>

<main class="page didk-page">

  <section class="page-title-wrap">
    <h1 class="page-title"><?= htmlspecialchars(t('didk_title')) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars(t('didk_sub')) ?></p>
  </section>

  <section class="article-cats">
    <?php foreach ($DIDYOUKNOW_SECTIONS as $sec): ?>
      <a class="article-cat" href="<?= htmlspecialchars($sec['link']) ?>">
        <img
          class="article-cat-img"
          src="<?= htmlspecialchars($sec['image']) ?>"
          alt="<?= htmlspecialchars($sec['title_text'] ?? '') ?>"
        >

        <div class="article-cat-ribbon <?= htmlspecialchars($sec['ribbon_class']) ?>">
          <?= htmlspecialchars($sec['title_text'] ?? '') ?>
        </div>
      </a>
    <?php endforeach; ?>
  </section>

</main>
