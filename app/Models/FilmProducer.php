<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmProducer extends Model
{
    use HasFactory;

    public function producer(){
        return $this->belongsTo(Producer::class);
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

}
