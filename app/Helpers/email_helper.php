<?php

if (! function_exists('send_welcome_email')) {
    /**
     * Sends a welcome email to the registered user.
     *
     * @param string $toEmail
     * @param string $fullName
     * @param string $username
     * @return bool
     */
    function send_welcome_email(string $toEmail, string $fullName, string $username): bool
    {
        $email = \Config\Services::email();
        $email->setTo($toEmail);
        $config = config('Email');
        $email->setFrom($config->fromEmail, $config->fromName);
        $email->setSubject('Registration Successful');
        
        $message = "
        <p>Hello {$fullName},</p>
        <p>Your registration was successful! You can login now.</p>
        <p>Username: <strong>{$username}</strong></p>
        <p>Best Regards,<br>Event Ease Team</p>
        ";
        
        $email->setMessage($message);
        $email->setMailType('html');

        try {
            return $email->send();
        } catch (\Exception $e) {
            log_message('error', 'Email sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
