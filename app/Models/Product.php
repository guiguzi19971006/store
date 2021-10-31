<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = [];

    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function photos() {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function statuses() {
        return $this->morphMany(Status::class, 'statusable');
    }
}
