<?php require_once __DIR__ . '/../helpers/lang.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="/MILKYWAY/public/css/main.css">

  <script>
    window.__I18N = <?= json_encode(tjs([
                      'loc_cavite_only',
                      'loc_loading',
                      'loc_no_results',
                      'loc_searching',
                      'loc_not_found',
                      'loc_geo_not_supported',
                      'loc_permission_denied',
                      'fb_alert_pick_star',
                      'fb_save_fail'
                    ]), JSON_UNESCAPED_UNICODE) ?>;

    window.T = function(key) {
      return (window.__I18N && window.__I18N[key]) ? window.__I18N[key] : key;
    };
  </script>


</head>