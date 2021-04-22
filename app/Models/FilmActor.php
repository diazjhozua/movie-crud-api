<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmActor extends Model
{
    use HasFactory;

    public function actor(){
        return $this->belongsTo(Actor::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
