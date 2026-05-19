<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Send custom notification email
     */
    public function sendCustomNotification(string $email, string $message): bool
    {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email address");
        }

        try {
            // Send email using Gmail SMTP
            Mail::raw($message, function ($mail) use ($email) {

                $mail->to($email)
                    ->subject('SRAS Notification')
                    ->from(
                        config('mail.from.address', env('MAIL_USERNAME')),
                        config('mail.from.name', 'SRAS System')
                    );
            });

            return true;

        } catch (\Exception $e) {
            throw new \Exception("Email sending failed: " . $e->getMessage());
        }
    }

    /**
     * Send appointment confirmation email
     */
    public function sendAppointmentConfirmation(string $email, string $appointmentId): bool
    {
        $message = "Your SRAS appointment is confirmed. ID: " . $appointmentId;

        return $this->sendCustomNotification($email, $message);
    }
}