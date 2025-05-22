<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authors = Author::all();
        $books = Book::with('author');

        // Filtres
        if ($request->filled('search')) {
            $books->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('author')) {
            $books->where('author_id', $request->author);
        }
        if ($request->filled('status')) {
            if ($request->status === 'available') {
                $books->whereRaw('quantity > (SELECT COUNT(*) FROM loans WHERE loans.book_id = books.id AND loans.status = "active")');
            } elseif ($request->status === 'unavailable') {
                $books->whereRaw('quantity <= (SELECT COUNT(*) FROM loans WHERE loans.book_id = books.id AND loans.status = "active")');
            }
        }

        $books = $books->paginate(10);
        // Ajout de la quantité disponible pour chaque livre
        foreach ($books as $book) {
            $book->available_quantity = $book->quantity - $book->loans()->where('status', 'active')->count();
        }

        return view('books.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required|string|max:20|unique:books',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'publication_year' => 'nullable|integer',
            'publisher' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('author', 'loans.user');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'publication_year' => 'nullable|integer',
            'publisher' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)->with('success', 'Livre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès.');
    }
}
