<?php

namespace App\Mail;

use App\Models\Comments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
class CommentAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    public function __construct(Comments $comment)
    {
        $this->comment = $comment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("mustafaelkhokhy@gmail.com", "Blog System"),
            subject: "New Comment on Your Post"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comment_add_mail',
            with: ['comment' => $this->comment]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


    // public function build()
    // {
    //     return $this->subject('New Comment Added')
    //                 ->view('emails.comment_add_mail');
    // }
}
