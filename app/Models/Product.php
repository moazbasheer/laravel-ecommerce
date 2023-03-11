<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Product extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'name',
        'slug',
        'details',
        'price',
        'description',
    ];
    public function presentPrice() {
        return number_format($this->price);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
