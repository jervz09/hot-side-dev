<?php

declare(strict_types=1);

require_once __DIR__ . '/../controllers/db_con.php';

header('Content-Type: application/json');

function fail(string $msg): void
{
    http_response_code(422);
    echo json_encode(['error' => $msg]);
    exit;
}

$party_size = 0;
if (isset($_POST['party_size']) && preg_match('/^[1-9][0-9]*$/', (string) $_POST['party_size'])) {
    $party_size = (int) $_POST['party_size'];
}

$reserved_date = (string) ($_POST['reserved_date'] ?? '');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $reserved_date)) {
    fail('Invalid date');
}

$reserved_time = (string) ($_POST['reserved_time'] ?? '');
if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $reserved_time)) {
    fail('Invalid time');
}

$check = DateTime::createFromFormat('Y-m-d H:i', $reserved_date . ' ' . substr($reserved_time, 0, 5));
if ($check === false || $check->format('Y-m-d H:i') !== $reserved_date . ' ' . substr($reserved_time, 0, 5)) {
    fail('Invalid date/time');
}

$start_time = date('H:i', strtotime('-45 minute', strtotime($reserved_date . ' ' . $reserved_time)));
$end_time = date('H:i:s', strtotime($reserved_date . ' ' . $reserved_time));

if ($party_size > 0) {
    $sql = 'SELECT t.table_id, t.table_no, t.coordinates, t.name, t.party_size
            FROM table_list t
            WHERE t.status > 0
              AND t.party_size >= ?
              AND t.table_id NOT IN (
                  SELECT r.table_id FROM reservation_list r
                  WHERE r.is_delete = 0 AND r.datetime BETWEEN ? AND ?)
            ORDER BY t.table_no';
    $stmt = $conn->prepare($sql);
    $windowStart = $reserved_date . ' ' . $start_time;
    $windowEnd = $reserved_date . ' ' . $end_time;
    $stmt->bind_param('iss', $party_size, $windowStart, $windowEnd);
} else {
    $sql = 'SELECT t.table_id, t.table_no, t.coordinates, t.name, t.party_size
            FROM table_list t
            WHERE t.status > 0
              AND t.table_id NOT IN (
                  SELECT r.table_id FROM reservation_list r
                  WHERE r.is_delete = 0 AND r.datetime BETWEEN ? AND ?)
            ORDER BY t.table_no';
    $stmt = $conn->prepare($sql);
    $windowStart = $reserved_date . ' ' . $start_time;
    $windowEnd = $reserved_date . ' ' . $end_time;
    $stmt->bind_param('ss', $windowStart, $windowEnd);
}

$stmt->execute();
$result = $stmt->get_result();

$tables = [];
while ($row = $result->fetch_assoc()) {
    $tables[$row['table_id']] = [
        'id' => $row['table_id'],
        'table_no' => $row['table_no'],
        'coordinates' => $row['coordinates'],
        'name' => $row['name'],
    ];
}
$stmt->close();

echo json_encode($tables);
