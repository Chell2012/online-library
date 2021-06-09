<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Relation with tag record
     * 
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
