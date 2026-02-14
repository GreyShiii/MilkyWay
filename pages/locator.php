<main class="page locator-page">

  <section class="locator-title">
    <h1>Breastfeed Buddy</h1>
    <p>Breastfeeding Station Locator</p>
  </section>

  <section class="locator-search">
    <div class="search-pill">
      <span class="search-ic"><img class="search-icon" src="/MILKYWAY/public/images/search.png" alt=""></span>
      <input id="searchInput" type="text" placeholder="Search by location or address..."/>
      <button class="gps-btn" type="button" aria-label="Use my location"><img class="target-location" src="/MILKYWAY/public/images/target-location.png" alt=""></button>
    </div>
  </section>

  <section class="map-card">
  <div id="map" style="height:320px;"></div>
</section>

  <section class="mode-row">
    <button id="btnClinic" class="mode-btn is-active" type="button">Clinic Connect</button>
    <button id="btnStation" class="mode-btn" type="button">Breastfeeding Station</button>
  </section>

  <section id="nearbyList" class="places-list"></section>

</main>

<script src="/MILKYWAY/public/js/locator.js"></script>
<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEz5SMwsV207l8k5whdPbLzTd1xStzKOQ&libraries=places&callback=initMap&loading=async"
  async defer></script>
