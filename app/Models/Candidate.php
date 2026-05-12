<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'description',
        'total_votes',
        'percentage',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function leaderboardLogs()
    {
        return $this->hasMany(LeaderboardLog::class);
    }
}
