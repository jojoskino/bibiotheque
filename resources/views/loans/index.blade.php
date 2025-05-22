@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Emprunts</h1>
        </div>
        @if(auth()->user()->is_admin)
        <div class="col-md-4 text-end">
            <a href="{{ route('loans.create') }}" class="btn btn-info">
                <i class="fas fa-plus"></i> Nouvel emprunt
            </a>
        </div>
        @endif
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Emprunteur</th>
                            <th>Date d'emprunt</th>
                            <th>Date de retour prévue</th>
                            <th>Date de retour</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                            <tr>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->user->name }}</td>
                                <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                                <td>{{ $loan->due_date->format('d/m/Y') }}</td>
                                <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $loan->status === 'active' ? 'success' : ($loan->status === 'returned' ? 'info' : ($loan->status === 'overdue' ? 'danger' : 'secondary')) }}">
                                        {{ $loan->status === 'active' ? 'En cours' : ($loan->status === 'returned' ? 'Retourné' : ($loan->status === 'overdue' ? 'En retard' : 'En attente')) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('loans.edit', $loan) }}" class="btn btn-sm btn-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucun emprunt trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 