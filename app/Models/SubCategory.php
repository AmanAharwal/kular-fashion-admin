<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
