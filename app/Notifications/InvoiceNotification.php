<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvoiceNotification extends Notification
{
    use Queueable;

    private $invoice_id;
    
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'id'        => $this->invoice_id,
            'title'     => 'نم إضافة فاتورة جديدة بواسطة : ',
            'user'      => auth()->user()->name,
        ];
    }
}
