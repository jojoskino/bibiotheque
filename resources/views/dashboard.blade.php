@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de Bord</h1>

    <!-- Statistiques -->
    <div class="row mb-4">
        @if(auth()->user()->is_admin)
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Livres</h5>
                        <p class="card-text display-4">{{ $stats['total_books'] }}</p>
                        <a href="{{ route('books.index') }}" class="btn btn-light">Gérer les livres</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Auteurs</h5>
                        <p class="card-text display-4">{{ $stats['total_authors'] }}</p>
                        <a href="{{ route('authors.index') }}" class="btn btn-light">Gérer les auteurs</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Emprunts actifs</h5>
                        <p class="card-text display-4">{{ $stats['active_loans'] }}</p>
                        <a href="{{ route('loans.index') }}" class="btn btn-light">Voir les emprunts</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Emprunts en retard</h5>
                        <p class="card-text display-4">{{ $stats['overdue_loans'] }}</p>
                        <a href="{{ route('loans.index', ['status' => 'overdue']) }}" class="btn btn-light">Voir les retards</a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="card bg-warning text-white h-100" style="min-height: 220px;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Mes Emprunts Actifs</h5>
                            <p class="card-text display-4">{{ $stats['active_loans'] }}</p>
                        </div>
                        <a href="{{ route('loans.index') }}" class="btn btn-light mt-auto">Voir mes emprunts</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary text-white h-100" style="min-height: 220px;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Livres Disponibles</h5>
                            <p class="card-text display-4">{{ $stats['available_books'] }}</p>
                        </div>
                        <a href="{{ route('books.index') }}" class="btn btn-light mt-auto">Voir les livres</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white h-100" style="min-height: 220px;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Mes Retards</h5>
                            <p class="card-text display-4">{{ $stats['overdue_loans'] }}</p>
                        </div>
                        <a href="{{ route('loans.index', ['status' => 'overdue']) }}" class="btn btn-light mt-auto">Voir mes retards</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Actions rapides -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->is_admin)
                            <div class="col-md-3">
                                <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg w-100 mb-2">
                                    <i class="fas fa-book"></i> Ajouter un livre
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('authors.create') }}" class="btn btn-success btn-lg w-100 mb-2">
                                    <i class="fas fa-user-edit"></i> Ajouter un auteur
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('loans.create') }}" class="btn btn-info btn-lg w-100 mb-2">
                                    <i class="fas fa-hand-holding"></i> Nouvel emprunt
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg w-100 mb-2">
                                    <i class="fas fa-users"></i> Gérer les utilisateurs
                                </a>
                            </div>
                        @else
                            <div class="col-md-6">
                                <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg w-100 mb-2">
                                    <i class="fas fa-book"></i> Voir les livres disponibles
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('loans.index') }}" class="btn btn-info btn-lg w-100 mb-2">
                                    <i class="fas fa-hand-holding"></i> Voir mes emprunts
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Livres populaires (admin) -->
    @if(auth()->user()->is_admin)
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Livres Populaires</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Auteur</th>
                                        <th>Emprunts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($most_borrowed_books as $book)
                                        <tr>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author->name ?? '-' }}</td>
                                            <td>{{ $book->loans_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Emprunts Récents</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Livre</th>
                                        <th>Emprunteur</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_loans as $loan)
                                        <tr>
                                            <td>{{ $loan->book->title }}</td>
                                            <td>{{ $loan->user->name }}</td>
                                            <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $loan->status === 'active' ? 'success' : ($loan->status === 'overdue' ? 'danger' : 'secondary') }}">
                                                    {{ $loan->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
