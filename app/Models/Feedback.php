<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks'; 
    
    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function user(){ 
        return $this->belongsTo(User::Class);
    }

}
