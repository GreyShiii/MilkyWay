<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/helpers/lang.php';
require_once __DIR__ . '/helpers/auth.php';
require_once __DIR__ . '/helpers/activity.php';

$page = $_GET['page'] ?? 'intro';

$routes = [
  'intro'          => __DIR__ . '/pages/intro.php',
  'home'           => __DIR__ . '/pages/home.php',
  'tracker'        => __DIR__ . '/pages/breastfeeding_tracker.php',
  'watch'          => __DIR__ . '/pages/watch.php',
  'watch_view'     => __DIR__ . '/pages/watch_view.php',
  'articles'       => __DIR__ . '/pages/articles.php',
  'articles_cat'   => __DIR__ . '/pages/articles_cat.php',
  'article_view'   => __DIR__ . '/pages/article_view.php',
  'locator'        => __DIR__ . '/pages/locator.php',
  'buddy'          => __DIR__ . '/pages/locator.php',
  'didyouknow'     => __DIR__ . '/pages/didyouknow.php',
  'didyouknow_cat' => __DIR__ . '/pages/didyouknow_cat.php',
  'feedback'       => __DIR__ . '/pages/feedback.php',
  'about'          => __DIR__ . '/pages/about.php',
  'dashboard'      => __DIR__ . '/pages/dashboard.php',
  'admin_activity' => __DIR__ . '/pages/admin_activity.php',
];

if (!isset($routes[$page])) {
  http_response_code(404);
  exit("Page not found.");
}

$protected = [
  'home',
  'tracker',
  'dashboard',
  'watch',
  'watch_view',
  'articles',
  'articles_cat',
  'article_view',
  'locator',
  'buddy',
  'didyouknow',
  'didyouknow_cat',
  'feedback',
  'admin_activity'
];

if (in_array($page, $protected, true)) {
  require_login();

  $user = auth_user();
  if ($user && isset($user['id'])) {
    register_website_visit($conn, (int)$user['id']);
  }
}

require __DIR__ . '/layout/head.php';

if ($page !== 'intro') {
  require __DIR__ . '/components/header.php';
}

require $routes[$page];

if ($page !== 'intro') {
  require __DIR__ . '/components/footer.php';
}

require __DIR__ . '/layout/foot.php';