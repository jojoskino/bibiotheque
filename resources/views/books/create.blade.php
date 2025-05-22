@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Ajouter un livre</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required autofocus>
                    @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="author_id" class="form-label">Auteur</label>
                    <select id="author_id" name="author_id" class="form-select" required>
                        <option value="">Sélectionner un auteur</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="form-control" value="{{ old('isbn') }}" required>
                    @error('isbn')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantité</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                    @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="publication_year" class="form-label">Année de publication</label>
                    <input type="number" name="publication_year" id="publication_year" class="form-control" value="{{ old('publication_year') }}" min="1000" max="{{ date('Y') }}">
                    @error('publication_year')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="publisher" class="form-label">Éditeur</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" value="{{ old('publisher') }}">
                    @error('publisher')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Image de couverture</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
                    @error('cover_image')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="text-end">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 