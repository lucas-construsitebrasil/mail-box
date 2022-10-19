<?php

namespace App\Lib\PHPMailer;

use App\Exceptions\Messages\SendMessages\PHPMailerError;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMessage
{
    private static function setCredentials(): PHPMailer
    {
        $phpmailer = new PHPMailer(true);
        $phpmailer->isSMTP();
        $phpmailer->Host       = env('EMAIL_HOST');
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Username   = env('EMAIL_USER');
        $phpmailer->Password   = env('EMAIL_PASSWORD');
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $phpmailer->Port       = env('EMAIL_SMTP_PORT');
        return $phpmailer;
    }
    public static function send(string $to, string $subject, string $message): bool
    {
        try {
            $mail = self::setCredentials();
            $mail->setFrom(env('EMAIL_USER'), env('EMAIL_NAME'));
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            echo $mail->send();
            return true;
        } catch (\Exception $e) {
            throw new PHPMailerError($e->getMessage());
        }
    }
}
