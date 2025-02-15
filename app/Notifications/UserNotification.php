<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $message;
    protected $email;
    protected $password;
    protected $extraData;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $message, $email = null, $password = null, $extraData = []) 
    {
        $this->type = $type;
        $this->message = $message;
        $this->email = $email;
        $this->password = $password;
        $this->extraData = $extraData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable) 
    {
        $mailMessage = (new MailMessage)
            ->subject('HR & LMS Notification')
            ->line($this->message);

        if ($this->type === 'user_created') {
            $mailMessage->action('Login to Your Account', url('/login'))
                        ->line("Your login credentials:")
                        ->line("**Email:** {$this->email}")
                        ->line("**Password:** {$this->password}")
                        ->line("Please change your password after logging in.");
        }

        if ($this->type === 'role_changed') {
            $mailMessage->line("New Role: **{$this->extraData['new_role']}**");
        }

        if ($this->type === 'department_lead_assigned') {
            $mailMessage->line("Department: **{$this->extraData['department_name']}**");
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable) {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'email' => $this->email,
            'password' => $this->password,
            'extra_data' => $this->extraData
        ];
    }
}
