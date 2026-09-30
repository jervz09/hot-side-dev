<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Every action in this endpoint is admin-only. Previously this file had NO
 * authentication check, so anyone could create/delete users, menus and
 * reservations by POSTing directly to it.
 */
function require_admin(): void
{
    if (empty($_SESSION['id']) || (int) ($_SESSION['is_admin'] ?? 0) !== 1) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failed', 'msg' => 'Unauthorized.']);
        exit;
    }
}

function require_login(): void
{
    if (empty($_SESSION['id'])) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failed', 'msg' => 'Please log in first.']);
        exit;
    }
}

function json_response(array $resp): void
{
    header('Content-Type: application/json');
    echo json_encode($resp);
    exit;
}

function db(): mysqli
{
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
    return $conn;
}

/** Fetch a single integer column/value pair from POST. */
function post_int(string $key, int $default = 0): int
{
    return isset($_POST[$key]) && is_numeric($_POST[$key]) ? (int) $_POST[$key] : $default;
}

/** Fetch a trimmed string from POST. */
function post_str(string $key): string
{
    return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : '';
}

class Actions
{
    function save_floorplan(): string
    {
        $resp = ['status' => 'failed'];
        if (isset($_FILES['fp']) && !empty($_FILES['fp']['tmp_name'])) {
            if (!is_dir(__DIR__ . '/uploads/')) {
                mkdir(__DIR__ . '/uploads/');
            }
            $fname = '/uploads/floorplan.png';
            $thumb_file = $_FILES['fp']['tmp_name'];
            $file_type = mime_content_type($thumb_file);
            $info = getimagesize($thumb_file);
            if ($info === false) {
                $resp['msg'] = 'Floor Plan image has failed to upload.';
                return json_encode($resp);
            }
            if ($_FILES['fp']['size'] > 5 * 1024 * 1024) {
                $resp['msg'] = 'Floor Plan image must be 5MB or smaller.';
                return json_encode($resp);
            }
            [$width, $height] = $info;
            $t_image = imagecreatetruecolor(1000, 800);
            if (in_array($file_type, ['image/png', 'image/jpeg', 'image/jpg'], true)) {
                $gdImg = ($file_type === 'image/png') ? imagecreatefrompng($thumb_file) : imagecreatefromjpeg($thumb_file);
                imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, 1000, 800, $width, $height);
                if (is_file(__DIR__ . $fname)) {
                    unlink(__DIR__ . $fname);
                }
                $upload = imagepng($t_image, __DIR__ . $fname);
                imagedestroy($t_image);
                if ($upload) {
                    $resp['status'] = 'success';
                    $resp['msg'] = ' Floor Plan Successfully Updated.';
                    $_SESSION['flashdata']['type'] = 'success';
                    $_SESSION['flashdata']['msg'] = $resp['msg'];
                }
            } else {
                $resp['msg'] = 'Floor Plan image has failed to upload due to invalid file type.';
            }
        }
        return json_encode($resp);
    }

    function save_table(): string
    {
        $id = post_int('id');
        $table_no = post_int('table_no');
        $name = post_str('name');
        $description = post_str('description');
        $coordinates = post_str('coordinates');
        $status = post_int('status', 1);
        $party_size = post_int('party_size', 1);

        if ($table_no <= 0 || $name === '') {
            return json_encode(['status' => 'failed', 'msg' => 'Table number and name are required.']);
        }

        $conn = db();

        $stmt = $conn->prepare('SELECT COUNT(*) AS c FROM table_list WHERE table_no = ?' . ($id > 0 ? ' AND table_id != ?' : ''));
        if ($id > 0) {
            $stmt->bind_param('ii', $table_no, $id);
        } else {
            $stmt->bind_param('i', $table_no);
        }
        $stmt->execute();
        $count = (int) $stmt->get_result()->fetch_assoc()['c'];
        $stmt->close();

        if ($count > 0) {
            return json_encode(['status' => 'failed', 'msg' => 'Table Number already exists.']);
        }

        if ($id > 0) {
            $stmt = $conn->prepare('UPDATE table_list SET table_no = ?, name = ?, description = ?, coordinates = ?, status = ?, party_size = ? WHERE table_id = ?');
            $stmt->bind_param('isssiii', $table_no, $name, $description, $coordinates, $status, $party_size, $id);
            $msg = 'Table Details Successfully updated.';
        } else {
            $stmt = $conn->prepare('INSERT INTO table_list (table_no, name, description, coordinates, status, party_size) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('isssii', $table_no, $name, $description, $coordinates, $status, $party_size);
            $msg = 'Table Successfully added.';
        }

        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $msg;
            return json_encode(['status' => 'success', 'msg' => $msg]);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function delete_table(): string
    {
        $id = post_int('id');
        $stmt = db()->prepare('DELETE FROM table_list WHERE table_id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Table successfully deleted.';
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    /** True when [start,start+3h) overlaps an existing reservation for the table. */
    private function table_overlaps(int $tableId, int $startTs, int $excludeId = 0): bool
    {
        $stmt = db()->prepare('SELECT datetime FROM reservation_list WHERE table_id = ? AND reservation_id != ? AND is_delete = 0');
        $stmt->bind_param('ii', $tableId, $excludeId);
        $stmt->execute();
        $result = $stmt->get_result();
        $endTs = $startTs + 3 * 3600;
        while ($row = $result->fetch_assoc()) {
            $existingStart = strtotime((string) $row['datetime']);
            $existingEnd = $existingStart + 3 * 3600;
            if ($startTs < $existingEnd && $existingStart < $endTs) {
                $stmt->close();
                return true;
            }
        }
        $stmt->close();
        return false;
    }

    function save_reservation(): string
    {
        $id = post_int('id');
        $user_id = post_int('user_id');
        $table_id = post_int('table_id');
        $datetime = post_str('datetime');
        $status = post_int('status');
        $reason = post_str('reason');
        $other_reason = post_str('other_reason');

        $ts = strtotime($datetime);
        if ($table_id <= 0 || $user_id <= 0 || $ts === false) {
            return json_encode(['status' => 'failed', 'msg' => 'Table, user and a valid date/time are required.']);
        }

        if ($this->table_overlaps($table_id, $ts, $id)) {
            return json_encode(['status' => 'failed', 'msg' => 'Table is not available on the selected date and time.']);
        }

        $conn = db();
        if ($id > 0) {
            $stmt = $conn->prepare('UPDATE reservation_list SET user_id = ?, table_id = ?, datetime = ?, status = ?, reason = ?, other_reason = ? WHERE reservation_id = ?');
            $stmt->bind_param('iisisss', $user_id, $table_id, $datetime, $status, $reason, $other_reason, $id);
            $msg = 'Reservation Details Successfully updated.';
        } else {
            $stmt = $conn->prepare('INSERT INTO reservation_list (user_id, table_id, datetime, status, reason, other_reason) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iissss', $user_id, $table_id, $datetime, $status, $reason, $other_reason);
            $msg = 'Reservation Successfully added.';
        }
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $msg;
            return json_encode(['status' => 'success', 'msg' => $msg]);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function delete_reservation(): string
    {
        $id = post_int('id');
        $stmt = db()->prepare('DELETE FROM reservation_list WHERE reservation_id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Reservation successfully deleted.';
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    /** Reservation created by a logged-in customer (not the admin panel). */
    function user_reservation(): string
    {
        if (empty($_SESSION['id'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Please log in first.']);
        }

        $id = post_int('id');
        $table_id = post_int('table_id');
        $datetime = post_str('datetime');
        $status = post_int('status');
        $reason = post_str('reason');
        $other_reason = post_str('other_reason');
        $user_id = (int) $_SESSION['id']; // always the session user - not client-controlled

        $ts = strtotime($datetime);
        if ($table_id <= 0 || $ts === false) {
            return json_encode(['status' => 'failed', 'msg' => 'Table and a valid date/time are required.']);
        }

        if ($this->table_overlaps($table_id, $ts, $id)) {
            return json_encode(['status' => 'failed', 'msg' => 'Table is not available on the selected date and time.']);
        }

        $conn = db();
        if ($id > 0) {
            // customers may only edit their own reservations
            $stmt = $conn->prepare('UPDATE reservation_list SET table_id = ?, datetime = ?, status = ?, reason = ?, other_reason = ? WHERE reservation_id = ? AND user_id = ?');
            $stmt->bind_param('isissii', $table_id, $datetime, $status, $reason, $other_reason, $id, $user_id);
            $msg = 'Reservation Details Successfully updated.';
        } else {
            $stmt = $conn->prepare('INSERT INTO reservation_list (user_id, table_id, datetime, status, reason, other_reason) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iissss', $user_id, $table_id, $datetime, $status, $reason, $other_reason);
            $msg = 'Reservation Successfully added.';
        }
        $ok = $stmt->execute();
        $newId = (int) $conn->insert_id;
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $msg;
            return json_encode(['status' => 'success', 'msg' => $msg, 'reservation_id' => $id > 0 ? $id : $newId]);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function order_menu(): string
    {
        if (empty($_SESSION['id'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Please log in first.']);
        }

        $reservation_id = post_int('reservation_id');
        $menu_id = post_int('menu_id');
        $qty = max(1, post_int('qty', 1));

        if ($reservation_id <= 0 || $menu_id <= 0) {
            return json_encode(['status' => 'failed', 'msg' => 'Menu and reservation are required.']);
        }

        // customers may only order for their own reservation
        if ((int) ($_SESSION['is_admin'] ?? 0) !== 1) {
            $stmt = db()->prepare('SELECT COUNT(*) AS c FROM reservation_list WHERE reservation_id = ? AND user_id = ?');
            $stmt->bind_param('ii', $reservation_id, $_SESSION['id']);
            $stmt->execute();
            $own = (int) $stmt->get_result()->fetch_assoc()['c'] > 0;
            $stmt->close();
            if (!$own) {
                return json_encode(['status' => 'failed', 'msg' => 'Reservation not found.']);
            }
        }

        $conn = db();
        $stmt = $conn->prepare('INSERT INTO menu_order_list (menu_id, qty, reservation_id) VALUES (?, ?, ?)');
        $stmt->bind_param('iii', $menu_id, $qty, $reservation_id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Order Successfully added.';
            return json_encode(['status' => 'success', 'msg' => 'Order Successfully added.']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function update_reservation_status(): string
    {
        $reservation_id = post_int('reservation_id');
        $status = post_int('status');
        $reason = post_str('reason');
        $other_reason = post_str('other_reason');

        if ($reservation_id <= 0) {
            return json_encode(['status' => 'failed', 'msg' => 'Reservation not found.']);
        }

        // Customers may only update their own reservations (e.g. cancel)
        if ((int) ($_SESSION['is_admin'] ?? 0) !== 1) {
            $check = db()->prepare('SELECT COUNT(*) AS c FROM reservation_list WHERE reservation_id = ? AND user_id = ?');
            $check->bind_param('ii', $reservation_id, $_SESSION['id']);
            $check->execute();
            $own = (int) $check->get_result()->fetch_assoc()['c'] > 0;
            $check->close();
            if (!$own) {
                return json_encode(['status' => 'failed', 'msg' => 'Reservation not found.']);
            }
        }

        $stmt = db()->prepare('UPDATE reservation_list SET status = ?, reason = ?, other_reason = ? WHERE reservation_id = ?');
        $stmt->bind_param('issi', $status, $reason, $other_reason, $reservation_id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Reservation Successfully updated.';
            return json_encode(['status' => 'success', 'msg' => 'Reservation Successfully updated.']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function add_menu(): string
    {
        $menu_id = post_int('menu_id');
        $type = post_str('type');
        $name = post_str('name');
        $price = post_int('price');
        $image = post_str('base_menu_image');

        if ($name === '' || $type === '' || $price <= 0) {
            return json_encode(['status' => 'failed', 'msg' => 'Type, name and price are required.']);
        }

        $stmt = db()->prepare('INSERT INTO menu_list (type, name, price, base_menu_image) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssis', $type, $name, $price, $image);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Menu Successfully added.';
            return json_encode(['status' => 'success', 'msg' => 'Menu Successfully added.']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function update_menu(): string
    {
        $menu_id = post_int('menu_id');
        $type = post_str('type');
        $name = post_str('name');
        $price = post_int('price');
        $image = post_str('base_menu_image');

        if ($menu_id <= 0 || $name === '' || $type === '' || $price <= 0) {
            return json_encode(['status' => 'failed', 'msg' => 'Menu ID, type, name and price are required.']);
        }

        $stmt = db()->prepare('UPDATE menu_list SET type = ?, name = ?, price = ?, base_menu_image = ? WHERE menu_id = ?');
        $stmt->bind_param('ssisi', $type, $name, $price, $image, $menu_id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Menu Successfully updated.';
            return json_encode(['status' => 'success', 'msg' => 'Menu Successfully updated.']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function delete_menu(): string
    {
        $id = post_int('id');
        $stmt = db()->prepare('DELETE FROM menu_list WHERE menu_id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Menu successfully deleted.';
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function validate_update_password(): string
    {
        $user_id = post_int('user_id');
        $current_password = (string) ($_POST['current_password'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $re_password = (string) ($_POST['re_password'] ?? '');

        // Users may only change their own password unless they are admin
        $isSelf = $user_id === (int) ($_SESSION['id'] ?? 0);
        if (!$isSelf && (int) ($_SESSION['is_admin'] ?? 0) !== 1) {
            return json_encode(['status' => 'failed', 'msg' => 'Unauthorized.']);
        }

        if ($current_password === $password) {
        $resp = ['status' => 'failed', 'msg' => 'Password must differ from old password.'];
            return json_encode($resp);
        }
        if ($re_password !== $password) {
            return json_encode(['status' => 'failed', 'msg' => 'Your password and re-type password must match.']);
        }
        if (strlen($password) < 8) {
            return json_encode(['status' => 'failed', 'msg' => 'Password must be at least 8 characters.']);
        }

        $stmt = db()->prepare('SELECT password FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($row === null || !password_verify($current_password, (string) $row['password'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Incorrect current password.']);
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare('UPDATE users SET password = ? WHERE user_id = ?');
        $stmt->bind_param('si', $hash, $user_id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Update password.';
            return json_encode(['status' => 'success', 'msg' => 'Update password.']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function update_user(): string
    {
        $user_id = post_int('user_id');
        $username = post_str('username');
        $first_name = post_str('first_name');
        $last_name = post_str('last_name');
        $contact_no = post_str('contact_no');
        $address = post_str('address');
        $landmark = post_str('landmark');

        $isSelf = $user_id === (int) ($_SESSION['id'] ?? 0);
        $isAdmin = (int) ($_SESSION['is_admin'] ?? 0) === 1;

        // Non-admins may only update their own profile and never role_id
        if (!$isAdmin && !$isSelf) {
            return json_encode(['status' => 'failed', 'msg' => 'Unauthorized.']);
        }
        if ($username === '' || $first_name === '' || $last_name === '') {
            return json_encode(['status' => 'failed', 'msg' => 'Username, first name and last name are required.']);
        }

        $conn = db();
        if ($user_id > 0) {
            if ($isAdmin && !$isSelf) {
                // admin editing another user (users list page)
                $password = (string) ($_POST['password'] ?? '');
                if ($password !== '') {
                    if (strlen($password) < 8) {
                        return json_encode(['status' => 'failed', 'msg' => 'Password must be at least 8 characters.']);
                    }
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare('UPDATE users SET username = ?, first_name = ?, last_name = ?, contact_no = ?, address = ?, landmark = ?, password = ? WHERE user_id = ?');
                    $stmt->bind_param('ssssssssi', $username, $first_name, $last_name, $contact_no, $address, $landmark, $hash, $user_id);
                } else {
                    $stmt = $conn->prepare('UPDATE users SET username = ?, first_name = ?, last_name = ?, contact_no = ?, address = ?, landmark = ? WHERE user_id = ?');
                    $stmt->bind_param('ssssssi', $username, $first_name, $last_name, $contact_no, $address, $landmark, $user_id);
                }
            } else {
                $stmt = $conn->prepare('UPDATE users SET username = ?, first_name = ?, last_name = ?, contact_no = ?, address = ?, landmark = ? WHERE user_id = ?');
                $stmt->bind_param('ssssssi', $username, $first_name, $last_name, $contact_no, $address, $landmark, $user_id);
            }
            $ok = $stmt->execute();
            $stmt->close();
            $msg = 'User Successfully updated.';
        } else {
            $password = (string) ($_POST['password'] ?? '');
            if ($password === '' || strlen($password) < 8) {
                return json_encode(['status' => 'failed', 'msg' => 'Password (min 8 chars) is required for new users.']);
            }
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (username, first_name, last_name, contact_no, address, landmark, password) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssssss', $username, $first_name, $last_name, $contact_no, $address, $landmark, $hash);
            $ok = $stmt->execute();
            $stmt->close();
            $msg = 'User Successfully recorded.';
        }

        if ($ok) {
            if ($isSelf) {
                $_SESSION['username'] = $username;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['contact_no'] = $contact_no;
            }
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $msg;
            return json_encode(['status' => 'success', 'msg' => $msg]);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function delete_user(): string
    {
        $id = post_int('id');

        if ($id === (int) ($_SESSION['id'] ?? 0)) {
            return json_encode(['status' => 'failed', 'msg' => 'You cannot delete your own account.']);
        }

        $stmt = db()->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'User successfully deleted.';
            return json_encode(['status' => 'success']);
        }

        if ($ok) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function update_reason(): string
    {
        $reason_id = post_int('reason_id');
        $reason = post_str('reason');

        if ($reason === '') {
            return json_encode(['status' => 'failed', 'msg' => 'Reason is required.']);
        }

        $conn = db();
        if ($reason_id > 0) {
            $stmt = $conn->prepare('UPDATE reasons SET reason = ? WHERE reason_id = ?');
            $stmt->bind_param('si', $reason, $reason_id);
            $msg = 'Reason Successfully updated.';
        } else {
            $stmt = $conn->prepare('INSERT INTO reasons (reason) VALUES (?)');
            $stmt->bind_param('s', $reason);
            $msg = 'Reason Successfully recorded.';
        }
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $msg;
            return json_encode(['status' => 'success', 'msg' => $msg]);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }

    function delete_reason(): string
    {
        $id = post_int('id');
        $stmt = db()->prepare('DELETE FROM reasons WHERE reason_id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Reason successfully deleted.';
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failed', 'msg' => 'An error occurred.']);
    }
}

$a = $_GET['a'] ?? '';
$action = new Actions();

// Every action requires at least a logged-in session; the list below is
// admin-only. Customer actions (user_reservation, order_menu,
// update_reservation_status, validate_update_password) are additionally
// scoped to the session user inside their methods.
require_login();

$adminOnlyActions = [
    'save_floorplan',
    'save_table',
    'delete_table',
    'save_reservation',
    'delete_reservation',
    'add_menu',
    'update_menu',
    'delete_menu',
    'update_user',
    'delete_user',
    'update_reason',
    'delete_reason',
];

if (in_array($a, $adminOnlyActions, true)) {
    require_admin();
}

switch ($a) {
    case 'save_floorplan':
        echo $action->save_floorplan();
        break;
    case 'save_table':
        echo $action->save_table();
        break;
    case 'delete_table':
        echo $action->delete_table();
        break;
    case 'user_reservation':
        echo $action->user_reservation();
        break;
    case 'save_reservation':
        echo $action->save_reservation();
        break;
    case 'delete_reservation':
        echo $action->delete_reservation();
        break;
    case 'update_reservation_status':
        echo $action->update_reservation_status();
        break;
    case 'order_menu':
        echo $action->order_menu();
        break;
    case 'add_menu':
        echo $action->add_menu();
        break;
    case 'update_menu':
        echo $action->update_menu();
        break;
    case 'delete_menu':
        echo $action->delete_menu();
        break;
    case 'update_user':
        echo $action->update_user();
        break;
    case 'delete_user':
        echo $action->delete_user();
        break;
    case 'update_reason':
        echo $action->update_reason();
        break;
    case 'delete_reason':
        echo $action->delete_reason();
        break;
    case 'validate_update_password':
        echo $action->validate_update_password();
        break;
    default:
        http_response_code(400);
        echo json_encode(['status' => 'failed', 'msg' => 'Unknown action.']);
        break;
}
