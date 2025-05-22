<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            $overdue_loans_count = Loan::where('status', 'overdue')->count();
            $active_loans_count = Loan::where('status', 'active')->count();
            $total_books = Book::count();
            $available_books = Book::all()->filter(function($book) {
                return $book->isAvailable();
            })->count();
        } else {
            $overdue_loans_count = Loan::where('status', 'overdue')->where('user_id', auth()->id())->count();
            $active_loans_count = Loan::where('status', 'active')->where('user_id', auth()->id())->count();
            $total_books = Book::count();
            $userActiveBookIds = Loan::where('user_id', auth()->id())
                ->where('status', 'active')
                ->pluck('book_id')
                ->toArray();
            $available_books = Book::all()->filter(function($book) use ($userActiveBookIds) {
                return $book->isAvailable() && !in_array($book->id, $userActiveBookIds);
            })->count();
        }
        $stats = [
            'total_books' => $total_books,
            'available_books' => $available_books,
            'total_authors' => DB::table('authors')->count(),
            'total_users' => User::count(),
            'active_loans' => $active_loans_count,
            'overdue_loans' => $overdue_loans_count,
            'pending_loans' => Loan::where('status', 'pending')->count(),
        ];

        // Livres les plus empruntés
        $most_borrowed_books = Book::withCount(['loans' => function($query) {
            $query->where('status', 'active');
        }])
        ->orderBy('loans_count', 'desc')
        ->take(5)
        ->get();

        // Emprunts récents
        $recent_loans = Loan::with(['book', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Emprunts en retard
        $overdue_loans = Loan::with(['book', 'user'])
            ->where('status', 'active')
            ->where('due_date', '<', now())
            ->get();

        return view('dashboard', compact(
            'stats',
            'most_borrowed_books',
            'recent_loans',
            'overdue_loans'
        ));
    }
} 