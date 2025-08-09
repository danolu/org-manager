<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'position_id',
        'candidate_id',
        'vote',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'position_id' => 'integer',
        'candidate_id' => 'integer',
    ];

    /**
     * Get the user who cast this vote
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the position this vote is for
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the candidate this vote is for
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
