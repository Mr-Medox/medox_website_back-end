<?php

namespace App\Services;

use App\Mail\ContactNotification;
use App\Mail\ContactConfirmation;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class EmailService
{
    /**
     * Send contact notification email to admin.
     */
    public function sendContactNotification(Contact $contact): void
    {
        try {
            // Get admin email from site settings or use default
            $adminEmail = $this->getAdminEmail();
            
            Mail::to($adminEmail)->send(new ContactNotification($contact));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact notification: ' . $e->getMessage());
        }
    }

    /**
     * Send contact confirmation email to user.
     */
    public function sendContactConfirmation(Contact $contact): void
    {
        try {
            Mail::to($contact->email)->send(new ContactConfirmation($contact));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact confirmation: ' . $e->getMessage());
        }
    }

    /**
     * Get admin email from site settings.
     */
    private function getAdminEmail(): string
    {
        try {
            $setting = \App\Models\SiteSetting::where('key', 'contact_email')->first();
            return $setting ? $setting->value : config('mail.from.address');
        } catch (\Exception $e) {
            return config('mail.from.address');
        }
    }

    /**
     * Send welcome email to new subscriber.
     */
    public function sendWelcomeEmail(string $email, string $name = null): void
    {
        try {
            // This would be implemented with a WelcomeEmail mailable
            // Mail::to($email)->send(new WelcomeEmail($name));
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }
    }

    /**
     * Send newsletter email.
     */
    public function sendNewsletter(string $subject, string $content): void
    {
        try {
            $subscribers = \App\Models\NewsletterSubscriber::active()->get();
            
            foreach ($subscribers as $subscriber) {
                // This would be implemented with a NewsletterEmail mailable
                // Mail::to($subscriber->email)->send(new NewsletterEmail($subject, $content));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send newsletter: ' . $e->getMessage());
        }
    }
}
