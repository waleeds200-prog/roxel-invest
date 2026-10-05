<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    // متغير لتخزين بيانات العميل التي وصلت من النموذج
    public $inquiryData; 

    public function __construct($inquiryData)
    {
        $this->inquiryData = $inquiryData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            // عنوان الإيميل الذي سيصلك
            subject: 'New Investment Inquiry - ROXEL INVEST', 
        );
    }

    public function content(): Content
    {
        return new Content(
            // 🌟 هنا حل المشكلة: قمنا بتغيير view.name إلى المسار الصحيح
            view: 'emails.contact',
        );
    }
}