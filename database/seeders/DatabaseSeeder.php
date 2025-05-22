<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Création de l'utilisateur administrateur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Création d'un utilisateur normal
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Ajout d'autres utilisateurs
        User::create([
            'name' => 'Marie Curie',
            'email' => 'marie.curie@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
        User::create([
            'name' => 'Alice Martin',
            'email' => 'alice.martin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Auteurs réels
        $authors = [
            [
                'name' => 'Victor Hugo',
                'biography' => 'Écrivain français du XIXe siècle, auteur de nombreux romans, pièces de théâtre et poèmes.',
                'nationality' => 'Française',
                'birth_date' => '1802-02-26',
                'death_date' => '1885-05-22',
            ],
            [
                'name' => 'Albert Camus',
                'biography' => 'Écrivain, philosophe et journaliste français, prix Nobel de littérature en 1957.',
                'nationality' => 'Française',
                'birth_date' => '1913-11-07',
                'death_date' => '1960-01-04',
            ],
            [
                'name' => 'George Orwell',
                'biography' => 'Écrivain et journaliste britannique, auteur de romans dystopiques.',
                'nationality' => 'Britannique',
                'birth_date' => '1903-06-25',
                'death_date' => '1950-01-21',
            ],
            [
                'name' => 'Jane Austen',
                'biography' => 'Romancière anglaise, auteure de romans d\'amour et de mœurs.',
                'nationality' => 'Britannique',
                'birth_date' => '1775-12-16',
                'death_date' => '1817-07-18',
            ],
            [
                'name' => 'Jules Verne',
                'biography' => 'Écrivain français, pionnier de la science-fiction.',
                'nationality' => 'Française',
                'birth_date' => '1828-02-08',
                'death_date' => '1905-03-24',
            ],
        ];

        foreach ($authors as $authorData) {
            Author::create($authorData);
        }

        // Livres réels
        $books = [
            [
                'title' => 'Les Misérables',
                'author_id' => 1,
                'isbn' => '978-2-07-040922-8',
                'quantity' => 5,
                'description' => 'Roman historique de Victor Hugo paru en 1862.',
                'publication_year' => 1862,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => 'L\'Étranger',
                'author_id' => 2,
                'isbn' => '978-2-07-040121-5',
                'quantity' => 3,
                'description' => 'Roman philosophique d\'Albert Camus publié en 1942.',
                'publication_year' => 1942,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => '1984',
                'author_id' => 3,
                'isbn' => '978-2-07-040822-1',
                'quantity' => 4,
                'description' => 'Roman dystopique de George Orwell publié en 1949.',
                'publication_year' => 1949,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => 'Orgueil et Préjugés',
                'author_id' => 4,
                'isbn' => '978-2-07-040738-5',
                'quantity' => 3,
                'description' => 'Roman de Jane Austen publié en 1813.',
                'publication_year' => 1813,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => 'Vingt mille lieues sous les mers',
                'author_id' => 5,
                'isbn' => '978-2-07-040738-6',
                'quantity' => 4,
                'description' => 'Roman d\'aventures de Jules Verne publié en 1870.',
                'publication_year' => 1870,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => 'La Peste',
                'author_id' => 2,
                'isbn' => '9782070360428',
                'quantity' => 3,
                'description' => 'Roman d\'Albert Camus sur une épidémie à Oran.',
                'publication_year' => 1947,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => 'Notre-Dame de Paris',
                'author_id' => 1,
                'isbn' => '9782070409332',
                'quantity' => 2,
                'description' => 'Roman historique de Victor Hugo.',
                'publication_year' => 1831,
                'publisher' => 'Gallimard',
            ],
            [
                'title' => 'De la Terre à la Lune',
                'author_id' => 5,
                'isbn' => '9782253006320',
                'quantity' => 4,
                'description' => 'Roman de science-fiction de Jules Verne.',
                'publication_year' => 1865,
                'publisher' => 'Pierre-Jules Hetzel',
            ],
            [
                'title' => 'Emma',
                'author_id' => 4,
                'isbn' => '9780141439587',
                'quantity' => 2,
                'description' => 'Roman de Jane Austen.',
                'publication_year' => 1815,
                'publisher' => 'John Murray',
            ],
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }

        // Quelques emprunts de test
        Loan::create([
            'user_id' => 2,
            'book_id' => 1,
            'loan_date' => now()->subDays(5),
            'due_date' => now()->addDays(9),
            'status' => 'active'
        ]);

        // Ajout d'autres emprunts
        Loan::create([
            'book_id' => 6,
            'user_id' => 3,
            'loan_date' => now()->subDays(10),
            'due_date' => now()->addDays(4),
            'status' => 'active',
        ]);
        Loan::create([
            'book_id' => 7,
            'user_id' => 4,
            'loan_date' => now()->subDays(20),
            'due_date' => now()->subDays(5),
            'return_date' => now()->subDays(3),
            'status' => 'returned',
        ]);
        Loan::create([
            'book_id' => 8,
            'user_id' => 5,
            'loan_date' => now()->subDays(15),
            'due_date' => now()->subDays(2),
            'status' => 'overdue',
        ]);
    }
}
