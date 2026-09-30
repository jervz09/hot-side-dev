<?php

declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/email_content_notif.php';
require_once __DIR__ . '/sendEmails.php';

// Whitelisted, sanitized inputs (this endpoint is POSTed by the admin UI
// after a reservation status change)
$allowedKeys = [
    'party_size',
    'reservation_dt',
    'restaurant_no',
    'customer_name',
    'customer_number',
    'customer_email',
    'reservation_status',
    'reason_cancellation',
];

$data = [];
foreach ($allowedKeys as $key) {
    $value = $_POST[$key] ?? '';
    $data[$key] = is_string($value) ? trim(strip_tags($value)) : '';
}

if ($data['customer_email'] === '' || !filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    exit('Invalid customer email.');
}

$statusLabels = [
    'Approved' => 'Approved',
    'Cancelled' => 'Cancelled',
    'Pending' => 'Pending',
];
$status = $statusLabels[$data['reservation_status']] ?? 'Reservation';

$subject_email = $status . ' Reservation';
$body = prepareEmailContentNotif(
    htmlspecialchars($data['party_size'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['reservation_dt'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['restaurant_no'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['customer_name'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['customer_number'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['customer_email'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['reservation_status'], ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($data['reason_cancellation'], ENT_QUOTES, 'UTF-8')
);

// Note: SMTP credentials are read from the environment via sendEmails.php/config.php
sendEmailNotification($data['customer_email'], $subject_email, $body);
