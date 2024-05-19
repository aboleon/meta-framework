<?php

namespace App\Mailer;

use Aboleon\MetaFramework\Interfaces\Mailer;
use Aboleon\MetaFramework\Mail\MailerMail;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Mail;

class InvoiceExample implements Mailer
{

    public array $data = [];

    public function __construct(public string $identifier)
    {
        $this->setData();
    }

    public function send(): ?SentMessage
    {
        return Mail::send(new MailerMail($this));
    }

    public function setData(): void
    {

        $this->order = Invoice::first();

        if ($this->order) {

        } else {
            abort(404, "Order not found with uuid " . $this->identifier);
        }

        if (!$this->invoice) {
            abort(404, "Aucune facture n'est éditée pour la commande N° " . $this->order->id);
        }

        $this->data = [
            'invoice' => $this->invoice,
        ];
    }

    public function addressee(): string
    {
        return "John Doe";
    }

    public function email(): string|array
    {
        return "john@doe.com";
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function subject(): string
    {
        return 'Your invoice';
    }

    public function view(): string
    {
        return 'mails.mailer.invoice';
    }

    public function attachments(): array
    {
        return [
            [
                'type'=> 'binary',
                'file' => (new \App\Printers\PDF\Invoice($this->invoice))->binary(),
                'as' => 'invoice.pdf',
                'mime' => 'application/pdf',
            ]
        ];
    }

}
