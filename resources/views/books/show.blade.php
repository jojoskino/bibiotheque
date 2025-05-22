@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ $book->title }}</h1>
                <div>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light rounded p-5 text-center mb-3">
                            <i class="fas fa-book fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="d-grid">
                        @if($book->isAvailable())
                            <a href="{{ route('loans.create', ['book_id' => $book->id]) }}" class="btn btn-primary">
                                <i class="fas fa-hand-holding"></i> Emprunter
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-ban"></i> Non disponible
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Informations</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Auteur :</strong> {{ $book->author->name }}</p>
                            <p><strong>ISBN :</strong> {{ $book->isbn }}</p>
                            <p><strong>Quantité totale :</strong> {{ $book->quantity }}</p>
                            <p><strong>Disponibles :</strong> {{ $book->quantity - $book->loans()->where('status', 'active')->count() }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Année de publication :</strong> {{ $book->publication_year }}</p>
                            <p><strong>Éditeur :</strong> {{ $book->publisher }}</p>
                            <p><strong>Statut :</strong> 
                                <span class="badge {{ $book->isAvailable() ? 'bg-success' : 'bg-danger' }}">
                                    {{ $book->isAvailable() ? 'Disponible' : 'Non disponible' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($book->description)
                        <div class="mt-4">
                            <h3>Description</h3>
                            <p>{{ $book->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($book->loans->isNotEmpty())
                <div class="card mt-4">
                    <div class="card-body">
                        <h2 class="card-title">Historique des emprunts</h2>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Emprunteur</th>
                                        <th>Date d'emprunt</th>
                                        <th>Date de retour prévue</th>
                                        <th>Date de retour</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book->loans as $loan)
                                        <tr>
                                            <td>{{ $loan->user->name }}</td>
                                            <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                                            <td>{{ $loan->due_date->format('d/m/Y') }}</td>
                                            <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $loan->status === 'active' ? 'success' : ($loan->status === 'returned' ? 'info' : 'warning') }}">
                                                    {{ $loan->status === 'active' ? 'En cours' : ($loan->status === 'returned' ? 'Retourné' : 'En attente') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 