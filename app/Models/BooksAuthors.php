<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $book_id 
 * @property int $author_id 
 */
class BooksAuthors extends Model
{
    
    use HasFactory;
    
    protected $table = 'books_authors';
    protected $fillable = [
        'book_id',
        'author_id'
    ];
    public $timestamps = false;
    
    /**
     * Relation with book record
     * 
     * @return BelongsTo
     */
    public function book(): BelongsTo 
    {
        return $this->belongsTo(Book::class);
    }
    /**
     * Relation with author record
     * 
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
