<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id Tag's id
 * @property string $title Tag's name
 * @property int $category_id This tag's category id
 */
class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'category_id'];
}
