@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Ajouter un auteur</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('authors.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="nationality" class="form-label">Nationalité</label>
                    <input type="text" name="nationality" id="nationality" class="form-control" value="{{ old('nationality') }}">
                    @error('nationality')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Date de naissance</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date') }}">
                    @error('birth_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="death_date" class="form-label">Date de décès</label>
                    <input type="date" name="death_date" id="death_date" class="form-control" value="{{ old('death_date') }}">
                    @error('death_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="biography" class="form-label">Biographie</label>
                    <textarea name="biography" id="biography" class="form-control" rows="4">{{ old('biography') }}</textarea>
                    @error('biography')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="text-end">
                    <a href="{{ route('authors.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 