<?php

namespace App\Notifications;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProposalNotification extends Notification
{
    use Queueable;

    protected $proposal;
    protected $freelancer;
    /**
     * Create a new notification instance.
     */
    public function __construct(Proposal $proposal, User $freelancer)
    {
        $this->proposal = $proposal;
        $this->freelancer = $freelancer;
    }

    /**
     * Get the notification's delivery channels.
     * the channel to send a notification
     *
     * @return array<int, string>
     */
public function via(object $notifiable): array
    {
        $via = ['database'];
        if ($notifiable->notify_mail) {
            $via[] = 'mail';
        }
        if ($notifiable->notify_sms) {
            $via[] = 'nexmo';
        }
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $message = new MailMessage;
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title
        );

        $message->subject('New Proposal')->line("Hello $notifiable->name")
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->line($body)
            ->action('Show to Proposal', route('projects.show', $this->proposal->project_id))
            ->line('Thank you for using our application!');
        // ->view('');
        return $message;
    }

    /**
     * Summary of toDatabase
     * @param object $notifiable
     * @return array{body: string, icon: string, title: string, url: string}
     */
    public function toDatabase(object $notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title
        );
        return [
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-materail-outline-group',
            'url' => route('projects.show', $this->proposal->project_id)
        ];
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
