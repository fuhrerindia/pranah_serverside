<?php

        require 'includes/PHPMailer.php';
        require 'includes/SMTP.php';
        require 'includes/Exception.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
    function gmail($to, $subject, $body){


        global $gmail_username;
        global $gmail_password;
        global $gmail_from;

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->isHTML(true);
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = $gmail_username;
        $mail->Password = $gmail_password;
        $mail->Subject = $subject;
        $mail->setFrom($gmail_from);
        $mail->Body = $body;
        $mail->addAddress($to);
        if ($mail->Send()){
            return true;
        }else{
            return false;
        }
        $mail->smtpClose();
    }
?>