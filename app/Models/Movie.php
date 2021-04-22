<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function certificate(){
        return $this->belongsTo(Certificate::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function filmActors(){
        return $this->hasMany(FilmActor::class);
    }

    public function filmProducers(){
        return $this->hasMany(FilmProducer::class);
    }

    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }
    
}
