<?php
session_start();
require_once __DIR__ . '/helpers/lang.php';

$page = $_GET['page'] ?? 'home';

$routes = [
  'home'       => __DIR__ . '/pages/home.php',
  'watch'      => __DIR__ . '/pages/watch.php',
  'watch_view' => __DIR__ . '/pages/watch_view.php',
  'articles'   => __DIR__ . '/pages/articles.php',
  'locator'    => __DIR__ . '/pages/locator.php',
  'feedback'   => __DIR__ . '/pages/feedback.php',
  'about'      => __DIR__ . '/pages/about.php',
  'articles'     => __DIR__ . '/pages/articles.php',
  'articles_cat' => __DIR__ . '/pages/articles_cat.php',

];

if (!isset($routes[$page])) {
  $page = 'home';
}

require __DIR__ . '/layout/head.php';
require __DIR__ . '/components/header.php';  
require $routes[$page];
require __DIR__ . '/components/footer.php';   
require __DIR__ . '/layout/foot.php';
