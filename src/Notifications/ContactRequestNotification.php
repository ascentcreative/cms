<?php

namespace AscentCreative\CMS\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactRequestNotification extends Notification
{
    use Queueable;

    private $_contactRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cr)
    {
        //
        $this->_contactRequest = $cr;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //return 
        
        $msg = (new MailMessage)
                    ->template('vendor.notifications.email')
                    ->subject('New Contact Request');

        $msg->greeting('A new contact request has been received:');

        
        $msg->line('From: ' . $this->_contactRequest->name);
        $msg->line('Email: ' . $this->_contactRequest->email);
       
        $msg->line('---');

        foreach(explode("\n", $this->_contactRequest->message) as $line) {
            $msg->line($line);
        }
        
        $msg->line('---');

        $msg->salutation('(Replies to this message will be sent to the enquirer\'s address)');

        $msg->replyTo($this->_contactRequest->email);

        return $msg;
                 
                    //->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
