<?php

namespace App\Services\SendEmail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendEmail
{
    protected $driver;
    protected $host;
    protected $userName;
    protected $password;
    protected $port;
    protected $phpMailer;

    protected $from;
    protected $to;

    protected $subject;
    protected $body;

    public function __construct()
    {
        $this->driver = getenv('MAIL_DRIVER');
        $this->host = getenv('MAIL_HOST');
        $this->userName = getenv('MAIL_USERNAME');
        $this->password = getenv('MAIL_PASSWORD');
        $this->port = getenv('MAIL_PORT');

        $this->phpMailer = new PHPMailer(true);
    }

    public function setFrom($email)
    {
        $this->from = $email;
    }

    public function setTo($email)
    {
        $this->to = $email;
    }

    public function setSubject($subject)
    {
        $this->subject = utf8_decode($subject);
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function send()
    {
        $this->config();

        $this->phpMailer->setFrom($this->from);
        $this->phpMailer->addAddress($this->to);

        $this->phpMailer->Subject = $this->subject;
        $this->phpMailer->Body = $this->body;

        try {
            $this->phpMailer->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->phpMailer->ErrorInfo}";
            exit;
        }
    }

    protected function config()
    {
        // $this->phpMailer->SMTPDebug = SMTP::DEBUG_SERVER;// Enable verbose debug output
        $this->phpMailer->isSMTP();
        $this->phpMailer->Host = $this->host;
        $this->phpMailer->SMTPAuth = true; // Enable SMTP authentication
        $this->phpMailer->Username = $this->userName;
        $this->phpMailer->Password = $this->password;
        $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption;
        $this->phpMailer->Port = 587;

        $this->phpMailer->isHTML(true);
    }
}
