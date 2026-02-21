<?php require_once __DIR__ . '/../helpers/lang.php'; ?>

<main class="page locator-page">

  <section class="page-title-wrap">
    <h1 class="page-title"><?= htmlspecialchars(t('locator_title')) ?></h1>
    <p class="page-subtitle"><?= htmlspecialchars(t('locator_sub')) ?></p>
  </section>

  <div class="locator-shell">

    <div class="locator-top">

      <section class="locator-search">
        <div class="search-pill">
          <span class="search-ic">
            <img class="search-icon" src="/MILKYWAY/public/images/search.png" alt="">
          </span>

          <input
            id="searchInput"
            type="text"
            placeholder="<?= htmlspecialchars(t('search_ph')) ?> ..."
            autocomplete="off"
          />

          <button class="gps-btn" type="button" aria-label="Use my location">
            <img class="target-location" src="/MILKYWAY/public/images/target-location.png" alt="">
          </button>
        </div>
      </section>

      <section class="mode-row">
        <button id="btnClinic" class="mode-btn is-active" type="button"><?= htmlspecialchars(t('mode_clinic')) ?></button>
        <button id="btnStation" class="mode-btn" type="button"><?= htmlspecialchars(t('mode_station')) ?></button>
      </section>

    </div>

    <section class="locator-map">
      <section class="map-card">
        <div id="map"></div>
      </section>
    </section>

    <section class="locator-results">
      <section id="nearbyList" class="places-list"></section>
    </section>

  </div>
</main>

<script src="/MILKYWAY/public/js/locator.js"></script>

<script>
(async () => {
  try {
    const res = await fetch("/MILKYWAY/api/maps_key.php", { cache: "no-store" });
    const data = await res.json();

    if (!data || !data.key) {
      console.error("Missing Google Maps key:", data);
      return;
    }

    if (window.__mapsLoaded) return;
    window.__mapsLoaded = true;

    const s = document.createElement("script");
    s.src = `https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(data.key)}&libraries=places&callback=initMap&loading=async`;
    s.async = true;
    s.defer = true;
    document.body.appendChild(s);
  } catch (err) {
    console.error("Failed to load maps key:", err);
  }
})();
</script>
