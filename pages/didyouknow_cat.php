<?php
require_once __DIR__ . '/../helpers/didyouknow.php';

$DIDYOUKNOW_SECTIONS = didyouknow_sections();

$defaultCat = $DIDYOUKNOW_SECTIONS[0]['slug'];
$cat = $_GET['cat'] ?? $defaultCat;

$section = $DIDYOUKNOW_SECTIONS[0];
foreach ($DIDYOUKNOW_SECTIONS as $s) {
  if (($s['slug'] ?? '') === $cat) {
    $section = $s;
    break;
  }
}
?>

<main class="page didk-cat-page">

  <section class="didk-cat-hero">
    <a class="articles-cat-back"
      href="/MILKYWAY/index.php?page=didyouknow">
      &larr; <?= htmlspecialchars(t('didk_all_categories')) ?>
    </a>

    <div class="didk-cat-hero-inner">
      <div class="didk-cat-kicker">Did U Know?</div>
      <h2 class="didk-cat-title">
        <?= htmlspecialchars($section['title_text'] ?? '') ?>
      </h2>
    </div>
  </section>

  <section class="didk-facts">
    <?php foreach (($section['facts_html'] ?? []) as $factHtml): ?>
      <?= $factHtml ?>
    <?php endforeach; ?>
  </section>

</main>