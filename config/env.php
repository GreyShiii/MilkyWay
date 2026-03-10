<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Application URL
  |--------------------------------------------------------------------------
  | Local development example:
  | http://localhost/MILKYWAY
  |
  | Production example:
  | https://milkywaybf.com
  */
  'APP_URL' => 'http://localhost' . BASE_URL,


  /*
  |--------------------------------------------------------------------------
  | Google Maps API Key
  |--------------------------------------------------------------------------
  | Replace with your Google Maps API key if using maps.
  */
  'GOOGLE_MAPS_KEY' => 'YOUR_GOOGLE_MAPS_API_KEY',


  /*
  |--------------------------------------------------------------------------
  | Google OAuth (Login with Google)
  |--------------------------------------------------------------------------
  | These values should come from your Google Cloud Console.
  | https://console.cloud.google.com/
  */
  'GOOGLE_CLIENT_ID' => 'YOUR_GOOGLE_CLIENT_ID',
  'GOOGLE_CLIENT_SECRET' => 'YOUR_GOOGLE_CLIENT_SECRET',

  'GOOGLE_REDIRECT_URI' => 'http://localhost' . BASE_URL . '/auth/google_callback.php',


  /*
  |--------------------------------------------------------------------------
  | SMTP Email Configuration
  |--------------------------------------------------------------------------
  | Example for Gmail SMTP
  |
  | IMPORTANT:
  | Use a Gmail App Password, NOT your real Gmail password.
  | https://support.google.com/accounts/answer/185833
  */
  'SMTP_HOST' => 'smtp.gmail.com',
  'SMTP_PORT' => 587,
  'SMTP_USER' => 'YOUR_SMTP_EMAIL@example.com',
  'SMTP_PASS' => 'YOUR_SMTP_APP_PASSWORD',
  'SMTP_SECURE' => 'tls',


  /*
  |--------------------------------------------------------------------------
  | Mail Sender
  |--------------------------------------------------------------------------
  */
  'MAIL_FROM' => 'YOUR_SMTP_EMAIL@example.com',
  'MAIL_FROM_NAME' => 'MilkyWay',


  /*
  |--------------------------------------------------------------------------
  | Email Verification Expiration
  |--------------------------------------------------------------------------
  | Time before verification links expire.
  */
  'VERIFY_TTL_HOURS' => 24,

];