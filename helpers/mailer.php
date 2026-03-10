<?php
require_once __DIR__ . '/../vendor/autoload.php';

function env_config(): array {
  static $cfg = null;
  if ($cfg === null) $cfg = require __DIR__ . '/../config/env.php';
  return $cfg;
}

function send_email(string $to, string $subject, string $html): bool {
  $cfg = env_config();

  if (class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
    try {
      $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

      $mail->isSMTP();
      $mail->Host = $cfg['SMTP_HOST'];
      $mail->SMTPAuth = true;
      $mail->Username = $cfg['SMTP_USER'];
      $mail->Password = $cfg['SMTP_PASS'];
      $mail->Port = (int)$cfg['SMTP_PORT'];

      if (!empty($cfg['SMTP_SECURE'])) {
        $mail->SMTPSecure = $cfg['SMTP_SECURE'];
      }

      $mail->setFrom($cfg['MAIL_FROM'], $cfg['MAIL_FROM_NAME']);
      $mail->addAddress($to);
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $html;

      return $mail->send();
    } catch (\Throwable $e) {
      error_log("Mailer error: " . $e->getMessage());
      return false;
    }
  }

  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=UTF-8\r\n";
  $headers .= "From: ".$cfg['MAIL_FROM_NAME']." <".$cfg['MAIL_FROM'].">\r\n";
  return @mail($to, $subject, $html, $headers);
}