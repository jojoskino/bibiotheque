@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Modifier l'emprunt</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('loans.update', $loan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="book_id" class="form-label">Livre</label>
                    <select name="book_id" id="book_id" class="form-select" required>
                        <option value="">Sélectionnez un livre</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id', $loan->book_id) == $book->id ? 'selected' : '' }}>
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
                            <option value="{{ $user->id }}" {{ old('user_id', $loan->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="loan_date" class="form-label">Date d'emprunt</label>
                    <input type="date" name="loan_date" id="loan_date" class="form-control" value="{{ old('loan_date', $loan->loan_date ? $loan->loan_date->format('Y-m-d') : null) }}" required>
                    @error('loan_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Date de retour prévue</label>
                    <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $loan->due_date ? $loan->due_date->format('Y-m-d') : null) }}" required>
                    @error('due_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="return_date" class="form-label">Date de retour</label>
                    <input type="date" name="return_date" id="return_date" class="form-control" value="{{ old('return_date', $loan->return_date ? $loan->return_date->format('Y-m-d') : null) }}">
                    @error('return_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" {{ old('status', $loan->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="active" {{ old('status', $loan->status) == 'active' ? 'selected' : '' }}>En cours</option>
                        <option value="returned" {{ old('status', $loan->status) == 'returned' ? 'selected' : '' }}>Retourné</option>
                        <option value="overdue" {{ old('status', $loan->status) == 'overdue' ? 'selected' : '' }}>En retard</option>
                    </select>
                    @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="text-end">
                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 