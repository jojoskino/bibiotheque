<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'isbn',
        'quantity',
        'author_id',
        'cover_image',
        'publication_year',
        'publisher'
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'quantity' => 'integer'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function isAvailable()
    {
        return $this->quantity > $this->loans()->where('status', 'active')->count();
    }
}
