<?php
session_start();
require_once __DIR__ . '/helpers/lang.php';

$page = $_GET['page'] ?? 'intro';

$routes = [
  'intro'        => __DIR__ . '/pages/intro.php',
  'home'         => __DIR__ . '/pages/home.php',
  'watch'        => __DIR__ . '/pages/watch.php',
  'watch_view'   => __DIR__ . '/pages/watch_view.php',
  'articles'     => __DIR__ . '/pages/articles.php',
  'articles_cat' => __DIR__ . '/pages/articles_cat.php',
  'didyouknow'   => __DIR__ . '/pages/didyouknow.php',
  'locator'      => __DIR__ . '/pages/locator.php',
  'feedback'     => __DIR__ . '/pages/feedback.php',
  'about'        => __DIR__ . '/pages/about.php',
];

if (!isset($routes[$page])) {
  $page = 'home';
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
