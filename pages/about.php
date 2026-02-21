<?php require_once __DIR__ . '/../helpers/lang.php'; ?>

<main class="page about-page">

  <section class="about-hero">
    <div class="about-hero-inner">
      <img class="about-logo" src="/MILKYWAY/public/images/logo-name.png" alt="Milky Way">
      <h2 class="about-subtitle"><?= htmlspecialchars(t('about_team')) ?></h2>
    </div>
  </section>

  <section class="about-team">

    <div class="team-grid team-grid-top">

      <div class="team-card">
        <div class="team-avatar">
          <img src="/MILKYWAY/public/images/about/arvin.png" alt="Lingal Arvin M.">
        </div>
        <div class="team-name">Lingal, Arvin M.</div>
        <div class="team-role"><?= htmlspecialchars(t('about_role')) ?></div>
      </div>

      <div class="team-card">
        <div class="team-avatar">
          <img src="/MILKYWAY/public/images/about/james.png" alt="Macatangay, James">
        </div>
        <div class="team-name">Macatangay, James</div>
        <div class="team-role"><?= htmlspecialchars(t('about_role')) ?></div>
      </div>

    </div>

    <div class="team-grid team-grid-bottom">

      <div class="team-card">
        <div class="team-avatar">
          <img src="/MILKYWAY/public/images/about/sheryll.png" alt="Galit, Sheryll R.">
        </div>
        <div class="team-name">Galit, Sheryll R.</div>
        <div class="team-role"><?= htmlspecialchars(t('about_role')) ?></div>
      </div>

      <div class="team-card team-card-feature">
        <div class="team-avatar team-avatar-feature">
          <img src="/MILKYWAY/public/images/about/marielle.png" alt="Bauto, Marielle P.">
        </div>
        <div class="team-name">Bauto, Marielle P.</div>
        <div class="team-role"><?= htmlspecialchars(t('about_role')) ?></div>
      </div>

      <div class="team-card">
        <div class="team-avatar">
          <img src="/MILKYWAY/public/images/about/krisnadasi.png" alt="Felix, Krishnadasi M.">
        </div>
        <div class="team-name">Felix, Krishnadasi M.</div>
        <div class="team-role"><?= htmlspecialchars(t('about_role')) ?></div>
      </div>

    </div>

  </section>

  <section class="about-box">
    <p><?= htmlspecialchars(t('about_paragraph')) ?></p>
  </section>

</main>