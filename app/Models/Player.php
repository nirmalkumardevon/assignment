<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'firstName',
        'lastName',
        'playerImageURI',
        'team_id',
    ];

    protected $casts = [
        'firstName' => 'string',
        'lastName' => 'string',
        'playerImageURI' => 'string',
    ];

    /**
     * Player belongs to a team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
