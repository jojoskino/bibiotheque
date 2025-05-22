@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $author->name }}</h1>
        </div>
        @if(auth()->user()->is_admin)
        <div class="col-md-4 text-end">
            <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?')">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
        @endif
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informations générales</h5>
                    @if($author->nationality)
                        <p><strong>Nationalité :</strong> {{ $author->nationality }}</p>
                    @endif
                    @if($author->birth_date)
                        <p><strong>Période :</strong> {{ $author->birth_date->format('Y') }}@if($author->death_date) - {{ $author->death_date->format('Y') }}@endif</p>
                    @endif
                    @if($author->biography)
                        <p><strong>Biographie :</strong> {{ $author->biography }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5>Livres de l'auteur</h5>
                    <ul class="list-group">
                        @forelse($author->books as $book)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <strong>{{ $book->title }}</strong>
                                    <span class="text-muted ms-2">ISBN : {{ $book->isbn }}</span>
                                </span>
                                <span class="badge {{ $book->isAvailable() ? 'bg-success' : 'bg-danger' }}">{{ $book->isAvailable() ? 'Disponible' : 'Non disponible' }}</span>
                                <a href="{{ route('books.show', $book) }}" class="btn btn-link btn-sm ms-2">Détails</a>
                            </li>
                        @empty
                            <li class="list-group-item">Aucun livre trouvé pour cet auteur.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('authors.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
</div>
@endsection 