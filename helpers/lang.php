<?php
// helpers/lang.php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['lang'])) {
  $_SESSION['lang'] = 'en'; // default
}

function lang(): string
{
  return $_SESSION['lang'] ?? 'en';
}

function set_lang(string $code): void
{
  $code = strtolower(trim($code));
  $_SESSION['lang'] = in_array($code, ['en', 'fil'], true) ? $code : 'en';
}

function t(string $key): string
{
  $dict = [
    'en' => [
      // Menu
      'menu_language' => 'Language',
      'menu_clinic'   => 'Clinic Connect',
      'menu_about'    => 'About Us',
      'menu_feedback' => 'MomMoments',

      // Bottom nav + footer labels
      'nav_home'      => 'Home',
      'nav_watch'     => 'Watch & Learn',
      'nav_articles'  => 'Latch Library',
      'nav_locator'   => 'Buddy',

      // Language modal
      'lang_title'    => 'Select Language',
      'lang_en'       => 'English',
      'lang_fil'      => 'Filipino',

      // Global
      'loading'       => 'Loading…',
      'back'          => 'Back',

      // Home
      'home_quote'    => '“Every drop of breast milk is a drop of strength, comfort, and protection.”',
      'home_daily_tip_title' => 'Daily Tip',
      'home_feature_watch'   => 'Watch & Learn',
      'home_feature_watch_sub' => 'Video Library',
      'home_feature_articles'  => 'Latch Library',
      'home_feature_articles_sub' => 'Articles',
      'home_feature_didk' => 'Did U Know?',
      'home_feature_didk_sub' => 'Facts & Myths',
      'home_feature_buddy' => 'Buddy',
      'home_feature_buddy_sub' => 'Find Locations',

      // Watch
      'watch_title' => 'Watch & Learn',
      'watch_sub'   => 'Video Library',
      'watch_empty' => 'No videos in this category yet.',
      'watch_duration' => 'Duration',
      'watch_category' => 'Category',

      // Articles
      'articles_title' => 'Latch Library',
      'articles_sub'   => 'Articles',
      'articles_all'   => 'All Articles',
      'articles_empty' => 'No articles yet.',

      // Did You Know
      'didk_title' => 'Did U Know?',
      'didk_sub'   => 'Trivia, Facts & Myths',
      'didk_all_categories' => 'All Categories',

      // Locator
      'locator_title' => 'Breastfeed Buddy',
      'locator_sub'   => 'Breastfeeding Station Locator',
      'search_ph'     => 'Search by location or address...',
      'mode_clinic'   => 'Clinic Connect',
      'mode_station'  => 'Breastfeeding Station',

      // Locator JS messages
      'loc_cavite_only' => 'Cavite only. Please search within Cavite.',
      'loc_loading'     => 'Loading nearby results...',
      'loc_no_results'  => 'No results found. Try switching mode.',
      'loc_searching'   => 'Searching location...',
      'loc_not_found'   => 'Location not found. Try a more specific place.',
      'loc_geo_not_supported' => 'Geolocation not supported.',
      'loc_permission_denied' => 'Location permission denied or unavailable.',

      // Feedback
      'fb_title' => 'How was your experience?',
      'fb_tap_to_rate' => 'Tap to rate',
      'fb_like_q' => 'What did you like the most?',
      'fb_like_design' => 'App Design',
      'fb_like_content' => 'Content Quality',
      'fb_like_easy' => 'Easy to Use',
      'fb_like_tips' => 'Helpful Tips',
      'fb_submit' => 'Submit Feedback',
      'fb_alert_pick_star' => 'Please select a star rating first.',
      'fb_save_fail' => 'Failed to save feedback. Please try again.',
      'fb_thanks_title' => 'Thank You!',
      'fb_thanks_msg'   => 'Your feedback helps us make MilkyWay better for all moms',
      'fb_close' => 'Close',
      'fb_app_rating' => 'App Rating',
      'fb_based_on' => 'Based on',
      'fb_review' => 'review',
      'fb_reviews' => 'reviews',

      // About Page
      'about_team' => 'Our Team',
      'about_paragraph' =>
      'We are a team of dedicated nursing students committed to supporting parents throughout their breastfeeding journey. Our mission is to empower families by providing accurate information, practical guidance, and reliable resources. Through this web application, we aim to make breastfeeding more accessible, manageable, and rewarding for both mothers and their babies, helping families build confidence and succeed every step of the way.',
      'about_role' => 'Student Nurse',
    ],

    'fil' => [
      // Menu
      'menu_language' => 'Wika',
      'menu_clinic'   => 'Clinic Connect',
      'menu_about'    => 'Tungkol sa Amin',
      'menu_feedback' => 'MomMoments',

      // Language modal
      'lang_title'    => 'Pumili ng Wika',
      'lang_en'       => 'Ingles',
      'lang_fil'      => 'Filipino',

      // Global
      'loading'       => 'Naglo-load…',
      'back'          => 'Bumalik',

      // Home
      'home_quote'    => '“Bawat patak ng gatas ng ina ay patak ng lakas, ginhawa, at proteksiyon.”',
      'home_daily_tip_title' => 'Pang araw-araw na tip',
      'home_feature_watch'   => 'Panoorin at Matuto',
      'home_feature_watch_sub' => 'Koleksyon ng Video',
      'home_feature_articles'  => 'Latch Library',
      'home_feature_articles_sub' => 'Mga Artikulo',
      'home_feature_didk' => 'Alam Mo Ba?',
      'home_feature_didk_sub' => 'Katotohanan at Mito',
      'home_feature_buddy' => 'Buddy',
      'home_feature_buddy_sub' => 'Maghanap ng Lokasyon',

      // Watch
      'watch_title' => 'Panoorin at Matuto',
      'watch_sub'   => 'Koleksyon ng Video',
      'watch_empty' => 'Wala pang video sa kategoryang ito.',
      'watch_duration' => 'Haba',
      'watch_category' => 'Kategorya',

      // Articles
      'articles_title' => 'Latch Library',
      'articles_sub'   => 'Mga Artikulo',
      'articles_all'   => 'Lahat ng Artikulo',
      'articles_empty' => 'Wala pang artikulo.',

      // Did You Know
      'didk_title' => 'Alam Mo Ba?',
      'didk_sub'   => 'Trivia, Katotohanan at Mito',
      'didk_all_categories' => 'Lahat ng Kategorya',

      // Locator
      'locator_title' => 'Breastfeed Buddy',
      'locator_sub'   => 'Tagahanap ng Breastfeeding Station',
      'search_ph'     => 'Maghanap ng lokasyon o address...',
      'mode_clinic'   => 'Clinic Connect',
      'mode_station'  => 'Breastfeeding Station',

      // Locator JS messages
      'loc_cavite_only' => 'Cavite lamang. Mangyaring maghanap sa loob ng Cavite.',
      'loc_loading'     => 'Naglo-load ng mga kalapit na resulta...',
      'loc_no_results'  => 'Walang nahanap. Subukang palitan ang mode.',
      'loc_searching'   => 'Naghahanap ng lokasyon...',
      'loc_not_found'   => 'Hindi nahanap ang lokasyon. Subukan ang mas tiyak na lugar.',
      'loc_geo_not_supported' => 'Hindi suportado ang geolocation.',
      'loc_permission_denied' => 'Tinanggihan o hindi available ang lokasyon.',

      // Feedback
      'fb_title' => 'Kumusta ang iyong karanasan?',
      'fb_tap_to_rate' => 'I-tap para mag-rate',
      'fb_like_q' => 'Ano ang pinakanagustuhan mo?',
      'fb_like_design' => 'Disenyo ng App',
      'fb_like_content' => 'Kalidad ng Nilalaman',
      'fb_like_easy' => 'Madaling Gamitin',
      'fb_like_tips' => 'Mga Kapaki-pakinabang na Tip',
      'fb_submit' => 'Ipasa ang Feedback',
      'fb_alert_pick_star' => 'Pumili muna ng star rating.',
      'fb_save_fail' => 'Hindi na-save ang feedback. Subukan muli.',
      'fb_thanks_title' => 'Maraming Salamat!',
      'fb_thanks_msg'   => 'Ang feedback mo ay tumutulong para mapabuti ang MilkyWay para sa lahat ng moms',
      'fb_close' => 'Isara',
      'fb_app_rating' => 'Rating ng App',
      'fb_based_on' => 'Batay sa',
      'fb_review' => 'review',
      'fb_reviews' => 'mga review',

      // About Page
      'about_team' => 'Ang Aming Team',
      'about_paragraph' =>
      'Kami ay isang pangkat ng masisigasig na nursing students na nakatuon sa pagsuporta sa mga magulang sa kanilang breastfeeding journey. Layunin naming bigyang-lakas ang mga pamilya sa pamamagitan ng pagbibigay ng tamang impormasyon, praktikal na gabay, at mapagkakatiwalaang mga sanggunian. Sa web application na ito, nais naming gawing mas madaling maabot, mas madaling gawin, at mas kapaki-pakinabang ang pagpapasuso para sa mga ina at sanggol — upang makatulong sa pagbuo ng kumpiyansa at tagumpay sa bawat hakbang.',
      'about_role' => 'Nursing Student',
    ],


  ];

  $l = lang();
  return $dict[$l][$key] ?? $dict['en'][$key] ?? $key;
}

/**
 * For arrays like: ['en' => '...', 'fil' => '...']
 */
function tr($value)
{
  if (is_array($value)) {
    $l = lang();
    // if the current language exists, return it (can be string or array)
    if (array_key_exists($l, $value)) return $value[$l];
    // fallback to english
    if (array_key_exists('en', $value)) return $value['en'];
    // fallback to first value
    $first = reset($value);
    return $first;
  }
  return $value;
}

/**
 * Send translations to JS
 */
function tjs(array $keys): array
{
  $out = [];
  foreach ($keys as $k) $out[$k] = t($k);
  return $out;
}
