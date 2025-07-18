<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
        'nationality',
        'birth_date',
        'death_date'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
