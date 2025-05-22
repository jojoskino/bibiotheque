@component('mail::message')
# Rappel : Emprunt en retard

Cher(e) {{ $user->name }},

Nous vous rappelons que vous avez un emprunt en retard à la bibliothèque.

**Détails de l'emprunt :**
- Livre : {{ $book->title }}
- Date d'emprunt : {{ $loan->loan_date->format('d/m/Y') }}
- Date de retour prévue : {{ $loan->due_date->format('d/m/Y') }}
- Nombre de jours de retard : {{ $daysOverdue }}

@component('mail::button', ['url' => route('loans.show', $loan)])
Voir les détails de l'emprunt
@endcomponent

Merci de retourner le livre dès que possible pour éviter des pénalités de retard.

Cordialement,<br>
{{ config('app.name') }}
@endcomponent 