<?php
// helpers/lang.php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['lang'])) {
  $_SESSION['lang'] = 'en'; 
}

function lang(): string {
  return $_SESSION['lang'] ?? 'en';
}

function set_lang(string $code): void {
  $code = strtolower(trim($code));
  $_SESSION['lang'] = in_array($code, ['en', 'fil'], true) ? $code : 'en';
}

function t(string $key): string {
  $dict = [
    'en' => [
      'menu_language' => 'Language',
      'menu_clinic'   => 'Clinic Connect',
      'menu_about'    => 'About Us',
      'menu_feedback' => 'Feedback',
      'nav_home'      => 'Home',
      'nav_watch'     => 'Watch & Learn',
      'nav_articles'  => 'Latch Library',
      'nav_locator'   => 'Breastfeeding Buddy',

      'lang_title'    => 'Select Language',
      'lang_en'       => 'English',
      'lang_fil'      => 'Filipino',

      'locator_title' => 'Breastfeed Buddy',
      'locator_sub'   => 'Breastfeeding Station Locator',
      'search_ph'     => 'Search by location or address...',
    ],
    'fil' => [
      'menu_language' => 'Wika',
      'menu_clinic'   => 'Clinic Connect',
      'menu_about'    => 'Tungkol sa Amin',
      'menu_feedback' => 'Puna',

      'nav_home'      => 'Home',
      'nav_watch'     => 'Panoorin at Matuto',
      'nav_articles'  => 'Latch Library',
      'nav_locator'   => 'Breastfeeding Buddy',

      'lang_title'    => 'Pumili ng Wika',
      'lang_en'       => 'Ingles',
      'lang_fil'      => 'Filipino',

      'locator_title' => 'Breastfeed Buddy',
      'locator_sub'   => 'Tagahanap ng Breastfeeding Station',
      'search_ph'     => 'Maghanap ng lokasyon o address...',
    ],
  ];

  $l = lang();
  return $dict[$l][$key] ?? $dict['en'][$key] ?? $key;
}
