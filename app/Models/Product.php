<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
