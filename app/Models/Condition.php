<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    public function professions() {
        return $this->belongsToMany(Profession::class, 'condition_profession');
    }

    public function offers() {
        return $this->belongsToMany(JobOffer::class, 'job_offer_condition');
    }

    public function candidates() {
        return $this->belongsToMany(Candidate::class, 'candidate_condition');
    }

}
