<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'max_vote',
        'category',
    ];

    protected $casts = [
        'max_vote' => 'integer',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name, '-');
    }

    public function isSingle(): bool
    {
        return $this->type === 'single';
    }

    public function isMultiple(): bool
    {
        return $this->type === 'multiple';
    }

    public function isYesNo(): bool
    {
        return $this->type === 'yes-no';
    }

    public function canUserVote(User $user): bool
    {
        if (empty($this->category)) {
            return true;
        }

        return $user->category === $this->category;
    }
}
