<?php

namespace App\Notifications;

use App\Channels\Log;
use App\Channels\Nepras;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
        // $via = ['database', 'mail', 'broadcast'];
        $via = [Log::class, Nepras::class];

        if (!$notifiable instanceof AnonymousNotifiable) {
            if ($notifiable->notify_mail) {
                $via[] = 'mail';
            }
            if ($notifiable->notify_sms) {
                $via[] = 'nexmo';
            }
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

        $message->subject('New Proposal')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->greeting('Hello ' . ($notifiable->name ?? ''))
            ->line($body)
            ->action('Show to Proposal', route('projects.show', $this->proposal->project_id))
            ->line('Thank you for using our application!');
        // ->view('mails.proposal', [
        //     'proposal' => $this->proposal,
        //     'notifiable' => $notifiable,
        //     'freelancer' => $this->freelancer
        // ]);
        return $message;
    }

    /**
     * Summary of toBroadcast
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title
        );
        return new BroadcastMessage([
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-materail-outline-group',
            'url' => route('projects.show', $this->proposal->project_id)
        ]);
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

    public function toLog($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title
        );

        return $body;
    }

    public function toNepras($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title
        );

        return $body;
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
