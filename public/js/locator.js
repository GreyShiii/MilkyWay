const CAVITE_CENTER = { lat: 14.2766, lng: 120.862 };
const RADIUS_METERS = 12000;

const CAVITE_BOUNDS_SW = { lat: 13.65, lng: 120.70 };
const CAVITE_BOUNDS_NE = { lat: 14.53, lng: 121.05 };

const MODE_CONFIG = {
  clinic: {
    keywords: ["lying-in clinic", "maternity clinic", "clinic", "hospital"],
  },
  station: {
    keywords: [
      "breastfeeding station",
      "lactation room",
      "nursing room",
      "mother's room",
      "pumping room",
    ],
  },
};

let map, placesService, infoWindow, geocoder, autocomplete;
let caviteBounds;
let activeMode = "clinic";
let searchCenter = CAVITE_CENTER;
let markers = [];
let markersByPlaceId = new Map();

window.initMap = function initMap() {
  const mapEl = document.getElementById("map");
  if (!mapEl) {
    console.error("Map container #map not found.");
    return;
  }

  caviteBounds = new google.maps.LatLngBounds(
    new google.maps.LatLng(CAVITE_BOUNDS_SW.lat, CAVITE_BOUNDS_SW.lng),
    new google.maps.LatLng(CAVITE_BOUNDS_NE.lat, CAVITE_BOUNDS_NE.lng)
  );

  map = new google.maps.Map(mapEl, {
    center: searchCenter,
    zoom: 12,
    disableDefaultUI: true,
    zoomControl: true,
  });

  placesService = new google.maps.places.PlacesService(map);
  infoWindow = new google.maps.InfoWindow();
  geocoder = new google.maps.Geocoder();

  setupModeButtons();
  setupSearchBar();   
  setupAutocomplete();   
  fetchAndRender();
};

function isInsideCavite(latLng) {
  return caviteBounds && caviteBounds.contains(latLng);
}

function showCaviteOnlyMessageAndClear() {
  clearMarkers();
  renderList([], "Cavite only. Please search within Cavite.");
}

function setupModeButtons() {
  const btnClinic = document.getElementById("btnClinic");
  const btnStation = document.getElementById("btnStation");

  if (btnClinic) btnClinic.addEventListener("click", () => setMode("clinic"));
  if (btnStation) btnStation.addEventListener("click", () => setMode("station"));
}

function setupSearchBar() {
  const input = document.getElementById("searchInput");
  const gpsBtn = document.querySelector(".gps-btn");

  if (input) {
    input.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        const q = input.value.trim();
        if (!q) return;
        geocodeAndGo(q);
      }
    });
  }

  if (gpsBtn) {
    gpsBtn.addEventListener("click", () => {
      if (!navigator.geolocation) {
        alert("Geolocation not supported.");
        return;
      }

      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const loc = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
          if (!isInsideCavite(loc)) {
            map.panTo(loc);
            map.setZoom(12);
            showCaviteOnlyMessageAndClear();
            return;
          }

          searchCenter = { lat: loc.lat(), lng: loc.lng() };
          map.panTo(loc);
          map.setZoom(13);
          fetchAndRender();
        },
        () => alert("Location permission denied or unavailable."),
        { enableHighAccuracy: true, timeout: 10000 }
      );
    });
  }
}

function setupAutocomplete() {
  const input = document.getElementById("searchInput");
  if (!input) return;

  autocomplete = new google.maps.places.Autocomplete(input, {
    fields: ["geometry", "name", "formatted_address", "place_id"],
    types: ["geocode"],
    componentRestrictions: { country: "ph" }, 
  });

  autocomplete.bindTo("bounds", map);

  autocomplete.addListener("place_changed", () => {
    const place = autocomplete.getPlace();

    if (!place || !place.geometry || !place.geometry.location) {
      const q = input.value.trim();
      if (q) geocodeAndGo(q);
      return;
    }

    const loc = place.geometry.location;

    map.panTo(loc);
    map.setZoom(13);

    if (!isInsideCavite(loc)) {
      showCaviteOnlyMessageAndClear();
      return;
    }

    searchCenter = { lat: loc.lat(), lng: loc.lng() };
    fetchAndRender();
  });

  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") e.preventDefault();
  });
}

function geocodeAndGo(query) {
  if (!geocoder) return;

  renderList([], "Searching location...");

  geocoder.geocode({ address: query }, (results, status) => {
    if (status !== "OK" || !results || !results[0]) {
      renderList([], "Location not found. Try a more specific place.");
      return;
    }

    const loc = results[0].geometry.location;

    map.panTo(loc);
    map.setZoom(13);

    if (!isInsideCavite(loc)) {
      showCaviteOnlyMessageAndClear();
      return;
    }

    searchCenter = { lat: loc.lat(), lng: loc.lng() };
    fetchAndRender();
  });
}

function setMode(mode) {
  if (activeMode === mode) return;
  activeMode = mode;

  const btnClinic = document.getElementById("btnClinic");
  const btnStation = document.getElementById("btnStation");

  if (btnClinic) btnClinic.classList.toggle("is-active", mode === "clinic");
  if (btnStation) btnStation.classList.toggle("is-active", mode === "station");

  fetchAndRender();
}

function fetchAndRender() {
  if (!placesService) return;

  const centerLatLng = new google.maps.LatLng(searchCenter.lat, searchCenter.lng);
  if (!isInsideCavite(centerLatLng)) {
    showCaviteOnlyMessageAndClear();
    return;
  }

  clearMarkers();
  renderList([], "Loading nearby results...");

  const keywords = MODE_CONFIG[activeMode]?.keywords || [];
  if (!keywords.length) {
    renderList([], "No keywords configured for this mode.");
    return;
  }

  const resultsById = new Map();
  let pending = keywords.length;

  keywords.forEach((keyword) => {
    placesService.nearbySearch(
      {
        location: searchCenter,
        radius: RADIUS_METERS,
        keyword,
      },
      (results, status) => {
        pending--;

        if (status === google.maps.places.PlacesServiceStatus.OK && results) {
          results.forEach((r) => {
            if (r.place_id) resultsById.set(r.place_id, r);
          });
        }

        if (pending === 0) {
          const unique = [...resultsById.values()];

          const places = unique
            .filter((r) => r.geometry && r.geometry.location)
            .map((r) => ({
              placeId: r.place_id,
              name: r.name || "Unnamed place",
              lat: r.geometry.location.lat(),
              lng: r.geometry.location.lng(),
              address: r.vicinity || "",
              openNow: r.opening_hours?.open_now,
            }));

          addPins(places);
          renderList(places);
        }
      }
    );
  });
}

function addPins(places) {
  markersByPlaceId.clear();

  places.forEach((p) => {
    const marker = new google.maps.Marker({
      position: { lat: p.lat, lng: p.lng },
      map,
      title: p.name,
    });

    marker.addListener("click", () => focusPlace(p, marker));

    markers.push(marker);
    markersByPlaceId.set(p.placeId, marker);
  });
}

function renderList(places, emptyMessage = "No results found. Try switching mode.") {
  const list = document.getElementById("nearbyList");
  if (!list) return;

  list.innerHTML = "";

  if (!places.length) {
    list.innerHTML = `<div class="place-card">${escapeHtml(emptyMessage)}</div>`;
    return;
  }

  places.forEach((p) => {
    const openLabel =
      p.openNow === true ? "Open now" : p.openNow === false ? "Closed" : "Hours unknown";

    const card = document.createElement("div");
    card.className = "place-card";
    card.innerHTML = `
  <h3 class="place-name">${escapeHtml(p.name)}</h3>

  <div class="place-meta">
    <div class="meta-row">
      <img class="meta-ic" src="public/images/location.png" alt="Location" loading="lazy">
      <span>${escapeHtml(p.address)}</span>
    </div>

    <div class="meta-row">
      <img class="meta-ic" src="public/images/clock.png" alt="Hours" loading="lazy">
      <span>${escapeHtml(openLabel)}</span>
    </div>
  </div>
`;


    card.addEventListener("click", () => {
      const marker = markersByPlaceId.get(p.placeId);
      if (marker) focusPlace(p, marker);
      else {
        map.panTo({ lat: p.lat, lng: p.lng });
        map.setZoom(16);
      }
    });

    list.appendChild(card);
  });
}

function focusPlace(place, marker) {
  map.panTo(marker.getPosition());
  map.setZoom(16);

  infoWindow.setContent(`
    <div style="font-family: Arial; font-size: 12px;">
      <strong>${escapeHtml(place.name)}</strong><br/>
      ${escapeHtml(place.address)}<br/>
      <a target="_blank" rel="noopener"
         href="https://www.google.com/maps/dir/?api=1&destination=${place.lat},${place.lng}">
        Directions
      </a>
    </div>
  `);

  infoWindow.open({ anchor: marker, map });
}

function clearMarkers() {
  markers.forEach((m) => m.setMap(null));
  markers = [];
  markersByPlaceId.clear();
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, (m) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;",
  })[m]);
}
