<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;
    private $book;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create(['is_admin' => false]);
        $this->book = Book::factory()->create(['quantity' => 1]);
    }

    /** @test */
    public function it_can_display_loans_index()
    {
        $response = $this->actingAs($this->admin)->get(route('loans.index'));
        $response->assertStatus(200);
        $response->assertViewIs('loans.index');
    }

    /** @test */
    public function it_can_create_a_loan()
    {
        $response = $this->actingAs($this->admin)->post(route('loans.store'), [
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('loans', [
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function it_cannot_create_loan_for_unavailable_book()
    {
        // Créer un emprunt actif pour rendre le livre indisponible
        Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        $response = $this->actingAs($this->admin)->post(route('loans.store'), [
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('book_id');
    }

    /** @test */
    public function it_can_validate_a_loan()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->patch(route('loans.approve', $loan));

        $response->assertRedirect();
        $this->assertEquals('active', $loan->fresh()->status);
    }

    /** @test */
    public function it_can_return_a_loan()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        $response = $this->actingAs($this->admin)->patch(route('loans.return', $loan));

        $response->assertRedirect();
        $this->assertEquals('returned', $loan->fresh()->status);
        $this->assertNotNull($loan->fresh()->return_date);
    }

    /** @test */
    public function regular_user_cannot_validate_loans()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->user)->patch(route('loans.approve', $loan));

        $response->assertStatus(403);
    }

    /** @test */
    public function regular_user_can_only_see_their_own_loans()
    {
        // Créer un emprunt pour l'utilisateur
        $userLoan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        // Créer un emprunt pour un autre utilisateur
        $otherUser = User::factory()->create();
        $otherLoan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $otherUser->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        $response = $this->actingAs($this->user)->get(route('loans.show', $userLoan));
        $response->assertStatus(200);

        $response = $this->actingAs($this->user)->get(route('loans.show', $otherLoan));
        $response->assertStatus(403);
    }
} 