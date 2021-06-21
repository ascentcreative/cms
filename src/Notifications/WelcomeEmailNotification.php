<?php

namespace AscentCreative\CMS\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\HtmlString;

use AscentCreative\CMS\Settings\SiteSettings;

class WelcomeEmailNotification extends Notification
{
    use Queueable;

    private $_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->_user = $user;
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
                    ->subject( app(SiteSettings::class)->welcome_email_subject );

        //$msg->line(new HtmlString("<B>TEST</B>"));

        $msg->line(new HtmlString( app(SiteSettings::class)->welcome_email_content ));

        // $msg->greeting('A new contact request has been received:');

        
        // $msg->line('From: ' . $this->_contactRequest->name);
        // $msg->line('Email: ' . $this->_contactRequest->email);
       
        // $msg->line('---');

        // foreach(explode("\n", $this->_contactRequest->message) as $line) {
        //     $msg->line($line);
        // }
        
        // $msg->line('---');

         $msg->salutation(" ");

        // $msg->replyTo($this->_contactRequest->email);

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
