<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('site.mail.join_admin.subject', ['name' => $this->application->name]),
        );
    }

    public function content(): Content
    {
        $interest = $this->application->interest
            ? __("site.join.i_{$this->application->interest}", locale: $this->application->locale ?? config('app.locale'))
            : null;

        return new Content(
            view: 'emails.application-admin-notification',
            with: [
                'application' => $this->application,
                'interest'    => $interest,
                'labels'      => [
                    'intro'    => __('site.mail.join_admin.intro'),
                    'name'     => __('site.mail.join_admin.name'),
                    'email'    => __('site.mail.join_admin.email'),
                    'country'  => __('site.mail.join_admin.country'),
                    'interest' => __('site.mail.join_admin.interest'),
                    'message'  => __('site.mail.join_admin.message'),
                    'locale'   => __('site.mail.join_admin.locale'),
                    'none'     => __('site.mail.join_admin.none'),
                ],
            ],
        );
    }
}
