<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShiftMeeting extends Model
{

    use HasUuids;
    public function participants(): HasMany
    {
        return $this->hasMany(ParticipantShiftMeeting::class);
    }

    protected $casts = [
            "attachments" => "array"
        ];
}
