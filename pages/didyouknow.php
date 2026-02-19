<?php
require_once __DIR__ . '/../helpers/didyouknow.php';
?>

<main class="page didk-page">

  <section class="page-title-wrap">
    <h1 class="page-title">Did U Know?</h1>
    <p class="page-subtitle">Trivia, Facts & Myths</p>
  </section>

  <section class="article-cats">

    <?php foreach ($DIDYOUKNOW_SECTIONS as $sec): ?>
      <div class="article-cat didk-static">

        <img class="article-cat-img"
          src="<?= htmlspecialchars($sec['image']) ?>"
          alt="<?= htmlspecialchars($sec['title']) ?>">

        <div class="article-cat-ribbon <?= htmlspecialchars($sec['ribbon_class']) ?>">
          <?= htmlspecialchars($sec['title']) ?>
        </div>

      </div>
    <?php endforeach; ?>

  </section>


</main>