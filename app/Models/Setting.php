<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenure',
        'name',
        'logo',
        'favicon',
        'website',
        'tagline',
        'description',
        'email',
        'id_name',
        'phone',
        'address',
        'election_start',
        'election_end',
        'is_election_time',
        'is_registration_open',
    ];

    protected $casts = [
        'election_start' => 'date',
        'election_end' => 'date',
        'is_election_time' => 'boolean',
        'is_registration_open' => 'boolean',
    ];
}
