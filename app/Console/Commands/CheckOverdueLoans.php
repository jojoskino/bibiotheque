<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueLoanNotification;

class CheckOverdueLoans extends Command
{
    protected $signature = 'loans:check-overdue';
    protected $description = 'Vérifie les emprunts en retard et envoie des notifications';

    public function handle()
    {
        $overdueLoans = Loan::where('status', 'active')
            ->where('due_date', '<', now())
            ->with(['user', 'book'])
            ->get();

        $count = 0;
        foreach ($overdueLoans as $loan) {
            Mail::to($loan->user->email)->send(new OverdueLoanNotification($loan));
            $count++;
        }

        $this->info("{$count} notifications d'emprunts en retard ont été envoyées.");
    }
} 