<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';


class SendMail
{
    public static function sendEmail($sender_mail, $recipient_mail, $recipient_name, $subject, $message)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            //we'll need a new email for this
            $mail->Username = 'mabaso.menzi911@gmail.com';
            $mail->Password = 'oqbkmkczlhrcglfu';

            //Where the mail is being sent and who shall receive it
            $mail->setFrom($sender_mail, 'Amandla High School'); //sender
            $mail->addAddress($recipient_mail, $recipient_name);    //recipient

            $mail->isHTML(false); //we want plain text

            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
            return true;
        }Catch (Exception $e) {
            return 'Sending the email failed. Error: ' . $e->getMessage();
        }
    }
}