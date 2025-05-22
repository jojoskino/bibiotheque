<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la requête.
     */
    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'exists:books,id',
                function ($attribute, $value, $fail) {
                    $book = \App\Models\Book::find($value);
                    if (!$book || !$book->isAvailable()) {
                        $fail('Ce livre n\'est pas disponible.');
                    }
                },
            ],
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'due_date' => [
                'required',
                'date',
                'after:loan_date',
                function ($attribute, $value, $fail) {
                    $loanDate = $this->input('loan_date');
                    $maxDays = 30; // Maximum 30 jours d'emprunt
                    
                    if (strtotime($value) - strtotime($loanDate) > ($maxDays * 24 * 60 * 60)) {
                        $fail("La durée maximale d'emprunt est de {$maxDays} jours.");
                    }
                },
            ],
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'book_id.required' => 'Veuillez sélectionner un livre.',
            'book_id.exists' => 'Le livre sélectionné n\'existe pas.',
            'user_id.required' => 'Veuillez sélectionner un emprunteur.',
            'user_id.exists' => 'L\'emprunteur sélectionné n\'existe pas.',
            'loan_date.required' => 'La date d\'emprunt est requise.',
            'loan_date.date' => 'La date d\'emprunt doit être une date valide.',
            'due_date.required' => 'La date de retour prévue est requise.',
            'due_date.date' => 'La date de retour prévue doit être une date valide.',
            'due_date.after' => 'La date de retour prévue doit être postérieure à la date d\'emprunt.',
        ];
    }
} 