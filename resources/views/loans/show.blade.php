@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Détail de l'emprunt</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            @if(auth()->user()->is_admin)
                <a href="{{ route('loans.edit', $loan) }}" class="btn btn-warning ms-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt ?')">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Livre</h5>
                    <p><strong>Titre :</strong> <a href="{{ route('books.show', $loan->book) }}">{{ $loan->book->title }}</a></p>
                    <p><strong>Auteur :</strong> {{ $loan->book->author->name }}</p>
                    <p><strong>ISBN :</strong> {{ $loan->book->isbn }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Emprunteur</h5>
                    <p><strong>Nom :</strong> {{ $loan->user->name }}</p>
                    <p><strong>Email :</strong> {{ $loan->user->email }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <p><strong>Date d'emprunt :</strong> {{ $loan->loan_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Date de retour prévue :</strong> {{ $loan->due_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Date de retour :</strong> {{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Statut :</strong> <span class="badge bg-{{ $loan->status === 'active' ? 'success' : ($loan->status === 'returned' ? 'info' : ($loan->status === 'overdue' ? 'danger' : 'secondary')) }}">
                        {{ $loan->status === 'active' ? 'En cours' : ($loan->status === 'returned' ? 'Retourné' : ($loan->status === 'overdue' ? 'En retard' : 'En attente')) }}
                    </span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 