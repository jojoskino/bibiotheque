<?php

namespace App\Mail;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueLoanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->markdown('emails.loans.overdue')
            ->subject('Rappel : Emprunt en retard')
            ->with([
                'loan' => $this->loan,
                'book' => $this->loan->book,
                'user' => $this->loan->user,
                'daysOverdue' => now()->diffInDays($this->loan->due_date)
            ]);
    }
} 