<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'img_src',
        'condition_id',
        'name',
        'brand',
        'explanation',
        'price'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function buy(){
        return $this->hasOne(Buy::class);
    }

}