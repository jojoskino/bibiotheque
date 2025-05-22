@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Modifier le livre : {{ $book->title }}</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}" required autofocus>
                    @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="author_id" class="form-label">Auteur</label>
                    <select id="author_id" name="author_id" class="form-select" required>
                        <option value="">Sélectionner un auteur</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}" required>
                    @error('isbn')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantité</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $book->quantity) }}" min="1" required>
                    @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $book->description) }}</textarea>
                    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="publication_year" class="form-label">Année de publication</label>
                    <input type="number" name="publication_year" id="publication_year" class="form-control" value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="{{ date('Y') }}">
                    @error('publication_year')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="publisher" class="form-label">Éditeur</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" value="{{ old('publisher', $book->publisher) }}">
                    @error('publisher')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Image de couverture</label>
                    @if($book->cover_image)
                        <div class="mt-2 mb-4">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-32 h-32 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
                    @error('cover_image')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="text-end">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 