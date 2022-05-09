<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id Publisher's id
 * @property string $title Publisher's name
 */
class Publisher extends Model
{
    use HasFactory;
    
    protected $fillable = ['title'];

    /**
     * 
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
