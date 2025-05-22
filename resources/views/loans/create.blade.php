@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Nouvel emprunt</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="book_id" class="form-label">Livre</label>
                    <select name="book_id" id="book_id" class="form-select" required>
                        <option value="">Sélectionnez un livre</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} ({{ $book->author->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Emprunteur</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Sélectionnez un utilisateur</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="loan_date" class="form-label">Date d'emprunt</label>
                    <input type="date" name="loan_date" id="loan_date" class="form-control" value="{{ old('loan_date', date('Y-m-d')) }}" required>
                    @error('loan_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Date de retour prévue</label>
                    <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
                    @error('due_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="text-end">
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-info">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 