<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    private $book;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->book = Book::factory()->create(['quantity' => 1]);
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_create_a_loan()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'pending'
        ]);

        $this->assertInstanceOf(Loan::class, $loan);
        $this->assertEquals($this->book->id, $loan->book_id);
        $this->assertEquals($this->user->id, $loan->user_id);
        $this->assertEquals('pending', $loan->status);
    }

    /** @test */
    public function it_has_correct_relationships()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'pending'
        ]);

        $this->assertInstanceOf(Book::class, $loan->book);
        $this->assertInstanceOf(User::class, $loan->user);
    }

    /** @test */
    public function it_can_check_if_loan_is_overdue()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now()->subDays(20),
            'due_date' => now()->subDays(6),
            'status' => 'active'
        ]);

        $this->assertTrue($loan->isOverdue());
    }

    /** @test */
    public function it_can_check_if_loan_is_not_overdue()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        $this->assertFalse($loan->isOverdue());
    }

    /** @test */
    public function it_can_check_if_loan_is_active()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'active'
        ]);

        $this->assertTrue($loan->isActive());
    }

    /** @test */
    public function it_can_check_if_loan_is_pending()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'pending'
        ]);

        $this->assertTrue($loan->isPending());
    }

    /** @test */
    public function it_can_check_if_loan_is_returned()
    {
        $loan = Loan::create([
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'returned',
            'return_date' => now()
        ]);

        $this->assertTrue($loan->isReturned());
    }
} 