<?php
    require_once('email_content_notif.php');

    require_once '../vendor/autoload.php';

    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
    ->setUsername("hotsiderestobar@gmail.com") //official email
    ->setPassword("nnyqlvidcmfcpepa"); //generated token password from gmail
    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    function sendEmailNotification($userEmail, $subject_email, $body){

        global $mailer;
        $message = (new Swift_Message('Hotside Restobar - '.$subject_email))
        ->setFrom("hotsiderestobar@gmail.com")
        ->setTo($userEmail)
        ->setBody($body, 'text/html');
        // Send the message
        $result = $mailer->send($message);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
      }
    $subject_email = $_POST['reservation_status']. " Reservation";
    $body = prepareEmailContentNotif($_POST['party_size'],$_POST['reservation_dt'],$_POST['restaurant_no'],
                                        $_POST['customer_name'],$_POST['customer_number'],
                                        $_POST['customer_email'],$_POST['reservation_status'],
                                        $_POST['reason_cancellation']);

    // Create a message
    return sendEmailNotification($_POST['customer_email'], $subject_email, $body);
?>