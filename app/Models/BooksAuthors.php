<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Author;
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
     * 
     * @return Book
     */
    public function book() {
        return $this->belongsTo(Book::class);
    }
    /**
     * 
     * @return Author
     */
    public function author() {
        return $this->belongsTo(Author::class);
    }
}
