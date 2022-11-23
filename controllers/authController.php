<?php
require_once 'sendEmails.php';
$username = "";
$email = "";
$errors = [];

include 'db_con.php';

// SIGN UP USER
if (isset($_POST['signup-btn'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username required';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email required';
    }
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = 'First Name required';
    }
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = 'Last Name required';
    }
    if (empty($_POST['contact_no'])) {
        $errors['contact_no'] = 'Contact Number required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }
    if (isset($_POST['password']) && $_POST['password'] !== $_POST['passwordConf']) {
        $errors['passwordConf'] = 'The two passwords do not match';
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];

    // $token = bin2hex(random_bytes(50)); // generate unique token

    $otp = random_int(100000, 999999); // Example: return 192345

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt password
    // Example Encrypt : $2y$10$MOb52LbEqPoxWs6c9EhnHOW18eGQT3WNgU7xpTa2wBn.NsUUFCSZS

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = "Email already exists";
    }

    if (count($errors) === 0) {
        $query = "INSERT INTO users SET username=?, first_name=?, last_name=?, contact_no=?, email=?, otp=?, password=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssss', $username, $first_name, $last_name, $contact_no, $email, $otp, $password);
        $result = $stmt->execute();
        printf("Error: %s.\n", $stmt->error);

        if ($result) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            // send verification email to user
            sendVerificationEmail($email, $otp);
            // Saving details on session
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = false;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            // redirect verify_checker.php
            header('location: verify_check.php');
        } else {
            $_errors['msg'] = "Error";
            $_SESSION['error_msg'] = "Database error: Could not register user";
        }
    }
}

// LOGIN user
if (isset($_POST['login-btn'])) {
    // checking if username and password are not empty
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username or email required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (count($errors) === 0) {
        $query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        // $stmt = $conn->prepare($query);
        if($stmt = $conn->prepare($query)) { // assuming $mysqli is the connection
            $stmt->bind_param('ss', $username, $username); // ss means `String String`
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) { // if password matches
                    $stmt->close();

                    // Saving details on session
                    $_SESSION['id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['contact_no'] = $user['contact_no'];
                    $_SESSION['address'] = $user['address'];
                    $_SESSION['landmark'] = $user['landmark'];
                    $_SESSION['verified'] = $user['verified'];
                    $_SESSION['is_admin'] = $user['role_id'];
                    $_SESSION['message'] = 'You are logged in!';
                    $_SESSION['type'] = 'alert-success';
                    header('location: verify_check.php');
                    exit(0);

                } else { // if password does not match
                    $errors['login_fail'] = "Wrong username / password";
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

if (isset($_POST['verify-btn'])) {
    $otp_user = $_POST["dig-1"].$_POST["dig-2"].$_POST["dig-3"].$_POST["dig-4"].$_POST["dig-5"].$_POST["dig-6"];
    echo $otp_user;
    $sql = "SELECT * FROM users WHERE otp='$otp_user' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $query = "UPDATE users SET verified=1 WHERE otp='$otp_user'";

        if (mysqli_query($conn, $query)) {
            $_SESSION['id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = true;
            $_SESSION['message'] = "Your email address has been verified successfully";
            $_SESSION['type'] = 'alert-success';
            header('location: index.php');
            exit(0);
        }
    } else {
        $errors['otp_failed'] = "Incorrect OTP";
    }
}
function hintEmail($email){
    $stars = 4; // Min Stars to use
	$at = strpos($email,'@');
	if($at - 2 > $stars){
        $stars = $at - 2;
    }
	return substr($email,0,1) . str_repeat('*',$stars) . substr($email,$at - 1);
}