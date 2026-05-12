<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'voter_name',
        'nominal',
        'vote_point',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
