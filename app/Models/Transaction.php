<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'vote_id',
        'candidate_id',
        'nominal',
        'proof_image',
        'payment_method',
        'status',
    ];

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
