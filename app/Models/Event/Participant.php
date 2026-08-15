<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'event_participants';
    protected $primaryKey = 'id_participant';

    protected $fillable = [
        'participant_code',
        'full_name',
        'email',
        'phone_number',
    ];

    /**
     * Riwayat pendaftaran peserta ini.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'id_participant', 'id_participant');
    }
}
