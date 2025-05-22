@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Auteurs</h1>
        </div>
        @if(auth()->user()->is_admin)
        <div class="col-md-4 text-end">
            <a href="{{ route('authors.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Ajouter un auteur
            </a>
        </div>
        @endif
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @forelse($authors as $author)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $author->name }}</h5>
                                @if($author->nationality)
                                    <p class="mb-1"><strong>Nationalité :</strong> {{ $author->nationality }}</p>
                                @endif
                                @if($author->birth_date)
                                    <p class="mb-1">
                                        <strong>Période :</strong> {{ $author->birth_date->format('Y') }}
                                        @if($author->death_date)
                                            - {{ $author->death_date->format('Y') }}
                                        @endif
                                    </p>
                                @endif
                                <p class="mb-2">{{ $author->books_count }} livre(s)</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('authors.show', $author) }}" class="btn btn-primary btn-sm">Voir les livres</a>
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning btn-sm">Modifier</a>
                                        <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?')">Supprimer</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Aucun auteur trouvé.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $authors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 