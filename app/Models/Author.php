<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id ID of Author
 * @property string $name Author's name
 * @property string $surname Author's surname
 * @property string $middle_name Author's middle_name
 * @property Carbon|null $birth_date
 * @property Carbon|null $death_date
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'middle_name',
        'surname',
        'birth_date',
        'death_date'
        ];

    protected $dates = ['birth_date','death_date'];
}
