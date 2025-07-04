<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeImage extends Model
{
    use HasFactory;

    protected $table = 'home_images'; 
  protected $fillable = ['image_path', 'type'];
}
