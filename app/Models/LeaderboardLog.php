<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaderboardLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'total_votes',
        'percentage',
        'ranking',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
