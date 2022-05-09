<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'books_tags');
    }
    /**
     * Relation with authors list
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'books_authors');
    }
    /**
     * Relation with publisher
     * @return BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
    /**
     * Relation with category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
