<?php

declare(strict_types=1);

require_once __DIR__ . '/../config.php';

// Create the Transport (credentials come from environment / config.php)
$transport = (new Swift_SmtpTransport(SMTP_HOST, SMTP_PORT, SMTP_ENCRYPTION))
    ->setUsername(SMTP_USERNAME)
    ->setPassword(SMTP_PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail(string $userEmail, string $token): bool
{
    global $mailer;

    $verifyUrl = APP_URL . '/controllers/verify_email.php?token=' . urlencode($token);

    $body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Verify your email</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background: #592f80;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
        <p>Thank you for signing up on our site. Please click on the link below to verify your account:.</p>
        <a href="' . htmlspecialchars($verifyUrl, ENT_QUOTES, 'UTF-8') . '">Verify Email!</a>
      </div>
    </body>

    </html>';

    // Create a message
    $message = (new Swift_Message('Verify your email'))
        ->setFrom(MAIL_FROM)
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    return $result > 0;
}
