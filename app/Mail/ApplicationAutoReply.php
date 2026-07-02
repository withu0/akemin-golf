<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function envelope(): Envelope
    {
        $locale = $this->application->locale ?? config('app.locale');

        return new Envelope(
            subject: __('site.mail.join_auto_reply.subject', locale: $locale),
        );
    }

    public function content(): Content
    {
        $locale = $this->application->locale ?? config('app.locale');

        return new Content(
            view: 'emails.application-auto-reply',
            with: [
                'application' => $this->application,
                'lines'       => [
                    'greeting' => __('site.mail.join_auto_reply.greeting', ['name' => $this->application->name], $locale),
                    'body'     => __('site.mail.join_auto_reply.body', locale: $locale),
                    'closing'  => __('site.mail.join_auto_reply.closing', locale: $locale),
                ],
            ],
        );
    }
}
