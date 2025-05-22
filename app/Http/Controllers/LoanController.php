<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Affiche la liste des emprunts avec filtrage par statut.
     */
    public function index(Request $request)
    {
        $query = Loan::with(['book', 'user']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest()->paginate(10);

        return view('loans.index', compact('loans'));
    }

    /**
     * Affiche le formulaire de création d'un emprunt.
     */
    public function create()
    {
        $books = Book::whereDoesntHave('loans', function ($query) {
            $query->where('status', 'active');
        })->orWhereHas('loans', function ($query) {
            $query->where('status', 'active');
        }, '<', DB::raw('books.quantity'))->get();

        $users = User::all();

        return view('loans.create', compact('books', 'users'));
    }

    /**
     * Enregistre un nouvel emprunt.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if (!$book->isAvailable()) {
            return back()->withErrors(['book_id' => 'Ce livre n\'est pas disponible.']);
        }

        $loan = Loan::create([
            'book_id' => $validated['book_id'],
            'user_id' => $validated['user_id'],
            'loan_date' => $validated['loan_date'],
            'due_date' => $validated['due_date'],
            'status' => 'pending'
        ]);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'L\'emprunt a été créé avec succès.');
    }

    /**
     * Affiche les détails d'un emprunt.
     */
    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    /**
     * Valide un emprunt en attente.
     */
    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->withErrors(['status' => 'Cet emprunt ne peut pas être validé.']);
        }

        $loan->update([
            'status' => 'active'
        ]);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'L\'emprunt a été validé avec succès.');
    }

    /**
     * Marque un emprunt comme retourné.
     */
    public function return(Loan $loan)
    {
        if ($loan->status !== 'active') {
            return back()->withErrors(['status' => 'Cet emprunt ne peut pas être retourné.']);
        }

        $loan->update([
            'status' => 'returned',
            'return_date' => now()
        ]);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Le livre a été marqué comme retourné.');
    }

    /**
     * Supprime un emprunt.
     */
    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            return back()->withErrors(['status' => 'Impossible de supprimer un emprunt actif.']);
        }

        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'L\'emprunt a été supprimé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un emprunt.
     */
    public function edit(Loan $loan)
    {
        $books = Book::all();
        $users = User::all();
        return view('loans.edit', compact('loan', 'books', 'users'));
    }

    /**
     * Met à jour un emprunt existant.
     */
    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|in:pending,active,returned,overdue',
        ]);

        $loan->update($validated);

        return redirect()->route('loans.show', $loan)
            ->with('success', "L'emprunt a été mis à jour avec succès.");
    }
}
