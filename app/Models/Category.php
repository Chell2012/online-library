<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id Id of categoty
 * @property string $title Category name
 */
class Category extends Model
{
    use HasFactory;
}
