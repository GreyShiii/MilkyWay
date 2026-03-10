<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/auth.php';

require_guest();

$cfg = require __DIR__ . '/../config/env.php';

$state = bin2hex(random_bytes(16));
$_SESSION['google_oauth_state'] = $state;

$params = [
  'client_id' => $cfg['GOOGLE_CLIENT_ID'],
  'redirect_uri' => $cfg['GOOGLE_REDIRECT_URI'],
  'response_type' => 'code',
  'scope' => 'openid email profile',
  'state' => $state,
  'prompt' => 'select_account',
];

$url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
header("Location: $url");
exit;