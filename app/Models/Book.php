<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id book id
 * @property string $title book title
 * @property int $publisher_id publisher id
 * @property int $year publish year 
 * @property string $isbn book isbn
 * @property int $category_id book category id
 * @property int $user_id id of user that book
 * @property string $link book storage link
 * @property string $description book description
 * 
 */
class Book extends Model
{
    use HasFactory;
    
    //protected $with = ['books_authors', 'books_tags'];
    protected $fillable =[
        'title',
        'publisher_id',
        'year',
        'isbn',
        'category_id',
        'user_id',
        'link',
        'description'
    ];
    
    /**
     * Relation with tags list
     * @return HasMany
     */
    public function tags(): HasMany
    {
        return $this->hasMany(BooksTags::class);
    }
    /**
     * Relation with authors list
     * @return HasMany
     */
    public function authors(): HasMany
    {
        return $this->hasMany(BooksAuthors::class);
    }   
}
