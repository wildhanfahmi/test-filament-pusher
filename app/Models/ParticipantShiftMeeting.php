<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParticipantShiftMeeting extends Model
{
    use HasUuids;
    protected $table = "participant_shiftmeeting";

    public function shiftmeeting(): BelongsTo
    {
        return $this->belongsTo(ShiftMeeting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
