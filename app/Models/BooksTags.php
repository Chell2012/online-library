<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $book_id 
 * @property int $tag_id 
 */
class BooksTags extends Model
{
    use HasFactory;
    
    protected $table = 'books_tags';
}
