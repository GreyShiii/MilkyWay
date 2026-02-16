<?php
include __DIR__ . "/layout/head.php";
include __DIR__ . "/components/header.php";
include __DIR__ . "/components/menu.php";

// ROUTER
$page = $_GET['page'] ?? 'home';

switch ($page) {
  case 'home':
    include __DIR__ . "/pages/home.php";
    break;

  case 'watch':
    include __DIR__ . "/pages/watch.php";
    break;

  case 'watch_view':
    include __DIR__ . "/pages/watch_view.php";
    break;

  case 'articles':
    include __DIR__ . "/pages/articles.php";
    break;

  case 'articles_cat':
    include __DIR__ . "/pages/articles_cat.php";
    break;

  case 'article_view':
    include __DIR__ . "/pages/article_view.php";
    break;

  case 'locator':
    include __DIR__ . "/pages/locator.php";
    break;

  case 'feedback':
    include __DIR__ . "/pages/feedback.php";
    break;

  default:
    include __DIR__ . "/pages/home.php";
    break;
}


include __DIR__ . "/components/footer.php";
include __DIR__ . "/layout/foot.php";
