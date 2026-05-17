<?php

namespace App\Mail;

use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScholarshipAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Scholarship $scholarship
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Scholarship Available: ' . $this->scholarship->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.scholarship-alert',
        );
    }
}
