<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        // Config SMTP depuis .env
        $this->mailer->isSMTP();
        $this->mailer->Host = env('MAIL_HOST', 'smtp.example.com');
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = env('MAIL_USERNAME', 'user@example.com');
        $this->mailer->Password = env('MAIL_PASSWORD', 'password');
        $this->mailer->SMTPSecure = env('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
        $this->mailer->Port = env('MAIL_PORT', 587);
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->setFrom(
            env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            env('MAIL_FROM_NAME', 'Quantix')
        );
    }

    public function send($to, $subject, $body, $altBody = '')
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->isHTML(true);
            $this->mailer->AltBody = $altBody ?: strip_tags($body);
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('PHPMailer error: ' . $e->getMessage());
            // Affichage direct pour debug
            echo 'PHPMailer error: ' . $e->getMessage();
            return false;
        }
    }
}
