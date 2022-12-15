<?php

$errors = [];

// LOGIN user
if (isset($_POST['update_privacy_btn'])) {
    if (isset($_POST['npassword']) && $_POST['npassword'] !== $_POST['npasswordConf']) {
        $errors['npasswordConf'] = 'The new password and new confirm password do not match.';
    }
    if (isset($_POST['cpassword']) && $_POST['cpassword'] !== $_POST['cpasswordConf']) {
        $errors['cpasswordConf'] = 'The current password and current confirm password do not match.';
    }

    if ($_POST['cpassword'] == $_POST['npassword']) {
        $errors['validate_password'] = 'The new password and the old password must not be the same.';
    }
    $_SESSION['type'] = "alert-danger";
    if (count($errors) === 0) {
        $query = "SELECT * FROM users WHERE user_id=? LIMIT 1";
        if($stmt = $conn->prepare($query)) { // assuming $mysqli is the connection
            $stmt->bind_param('s', $_POST['user_id']); // s means `String String`
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if (password_verify($_POST['cpassword'], $user['password'])) { // if password matches
                    $stmt->close();

                    $password = password_hash($_POST['npassword'], PASSWORD_DEFAULT); //encrypt password
                    $_query = "UPDATE `users` SET `password` = '$password' WHERE user_id = ?";
                    if($_stmt = $conn->prepare($_query)) { // assuming $mysqli is the connection
                        $_stmt->bind_param('s', $_POST['user_id']); // s means `String String`
                        if ($_stmt->execute()) {
                            $_result = $_stmt->get_result();
                            $errors['success'] = "Password Successfully updated.";
                            $_SESSION['type'] = "alert-success";
                            if(isset($_POST['logout_session'])){
                                $_SESSION['for_logout'] = true;
                            }
                        }
                    }

                } else { // if password does not match
                    $errors['login_fail'] = "Incorrect current password";
                }
            } else {
                $_SESSION['message'] = "Database error. Login failed!";
                $_SESSION['type'] = "alert-danger";
            }
        } else {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            $_SESSION['error'] = $error;
            $_SESSION['type'] = "alert-danger";
        }
    }
}
?>