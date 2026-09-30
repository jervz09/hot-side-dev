<?php

declare(strict_types=1);

require_once __DIR__ . '/../controllers/db_con.php';

$party_size = 0;
if (isset($_POST['party_size']) && preg_match('/^[1-9][0-9]*$/', (string) $_POST['party_size'])) {
    $party_size = (int) $_POST['party_size'];
}

$reserved_date = (string) ($_POST['reserved_date'] ?? '');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $reserved_date)) {
    http_response_code(422);
    exit('Invalid date');
}

$reserved_time = (string) ($_POST['reserved_time'] ?? '');
if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $reserved_time)) {
    http_response_code(422);
    exit('Invalid time');
}

$check = DateTime::createFromFormat('Y-m-d H:i', $reserved_date . ' ' . substr($reserved_time, 0, 5));
if ($check === false || $check->format('Y-m-d H:i') !== $reserved_date . ' ' . substr($reserved_time, 0, 5)) {
    http_response_code(422);
    exit('Invalid date/time');
}

$start_time = date('H:i', strtotime('-45 minute', strtotime($reserved_date . ' ' . $reserved_time)));
$end_time = date('H:i:s', strtotime($reserved_date . ' ' . $reserved_time));

if ($party_size > 0) {
    $sql = 'SELECT COUNT(*) AS c
            FROM table_list t
            WHERE t.status > 0
              AND t.party_size >= ?
              AND t.table_id NOT IN (
                  SELECT r.table_id FROM reservation_list r
                  WHERE r.is_delete = 0 AND r.datetime BETWEEN ? AND ?)';
    $stmt = $conn->prepare($sql);
} else {
    $sql = 'SELECT COUNT(*) AS c
            FROM table_list t
            WHERE t.status > 0
              AND t.table_id NOT IN (
                  SELECT r.table_id FROM reservation_list r
                  WHERE r.is_delete = 0 AND r.datetime BETWEEN ? AND ?)';
    $stmt = $conn->prepare($sql);
}

if ($party_size > 0) {
    $windowStart = $reserved_date . ' ' . $start_time;
    $windowEnd = $reserved_date . ' ' . $end_time;
    $stmt->bind_param('iss', $party_size, $windowStart, $windowEnd);
} else {
    $windowStart = $reserved_date . ' ' . $start_time;
    $windowEnd = $reserved_date . ' ' . $end_time;
    $stmt->bind_param('ss', $windowStart, $windowEnd);
}

$stmt->execute();
$tables_count = (int) $stmt->get_result()->fetch_assoc()['c'];
$stmt->close();
?>
<tr style="display: none;" data-id="tr_available_tables">
    <td class="col top-border-brand text-left text-bold" style="width:70%">Available Tables : </th>
    <td id="tables_count" class="col top-border-brand text-center"><?= (int) $tables_count ?></td>
</tr>
