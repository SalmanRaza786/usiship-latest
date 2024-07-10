<?php

namespace App\Notifications;

use App\Http\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use PHPUnit\TextUI\Help;

class CloseArrivalNotification extends Notification implements  ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $mailData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {


        $mailMessage = (new MailMessage)
            ->subject($this->mailData['subject'])
            ->greeting($this->mailData['greeting'])
            ->line($this->mailData['content'])
            ->line('Thank you for using our application!');

        foreach ($this->mailData['attachments'] as $doc) {

            $filePath = storage_path('app/public/uploads/' . $doc['file_name']);
            $mimeType =Helper::getMimeType($doc['file_name']);
            $displayName = $doc['display_name'] ?? $doc['file_name'];
            // Remove underscores from display name
            $displayName = str_replace('_', ' ', $displayName);

            $mailMessage->attach($filePath, [
                'as' => $displayName,
                'mime' => $mimeType,
            ]);
        }

        return $mailMessage;


    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
