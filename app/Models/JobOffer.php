<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    public function candidates() {
        return $this->hasMany(Candidate::class);
    }

    public function profession() {
        return $this->belongsTo(Profession::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

