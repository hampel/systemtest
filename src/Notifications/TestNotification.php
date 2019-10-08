<?php

namespace Hampel\SystemTest\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    protected $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->name = config('app.name');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting("Test notification from {$this->name}")
                    ->line('The introduction to the notification.')
                    ->action('Call to action', url('/'))
                    ->line('Thank you for using the SystemTest package!');
    }

	 /**
	 * Get the Slack representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return SlackMessage
	 */
	public function toSlack($notifiable)
	{
	    return (new SlackMessage)
	                ->content("Test notification from {$this->name}");
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
            "Test notification from {$this->name}"
        ];
    }
}
