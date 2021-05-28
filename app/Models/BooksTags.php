<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Tag;

/**
 * @property int $book_id 
 * @property int $tag_id 
 */
class BooksTags extends Model
{
    use HasFactory;
    
    protected $table = 'books_tags';
    
    protected $fillable = [
        'book_id',
        'tag_id'
    ];
    
    public $timestamps = false;
    
    public function book() {
        return $this->belongsTo(Book::class);
    }
    /**
     * 
     * @return type
     */
    public function tag() {
        return $this->belongsTo(Tag::class);
    }
}
