<?php
    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';
    include 'connect.php';
    require 'PHPMailerAutoload.php';
    require './vendor/autoload.php';
    //Fetching email and password
    $sql = "SELECT * FROM `credentials`";                        
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $sourceEmail = $row['Email'];
    $passEmail = $row['Password'];
    $mail = new PHPMailer;
    $mail->SMTPDebug = 4;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'palayush2506@gmail.com';                 // SMTP username
    $mail->Password = 'Foxtrot@01';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('palayush2506@gmail.com', 'Infinito');
    $mail->addAddress($to, $name );     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('palayush2506@gmail.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = 'You have been successfully registered.';
?>