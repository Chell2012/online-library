<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id Id of Author
 * @property string $name Author's name
 * @property string $surname Author's surname
 * @property string $middle_name Author's middle_name
 */
class Author extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'middle_name',
        'surname'
        ];
    
}
