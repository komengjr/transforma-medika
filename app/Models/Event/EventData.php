<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class EventData extends Model
{
    use HasFactory;

    protected $table = 'event_data';
    protected $primaryKey = 'id_event_data';

    protected $fillable = [
        'event_data_code',
        'event_data_tittle',
        'event_data_start_date',
        'event_data_end_date',
        'event_data_reg_deadline',
        'event_data_venue',
        'event_data_address',
        'event_data_city',
        'event_data_status',
        'event_data_user_id',
        'event_data_cover',
        'event_data_template',
        'event_data_desc',
    ];

    /**
     * User/Penyelenggara yang membuat event ini.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'event_data_user_id', 'id');
    }

    /**
     * Relasi ke Sub Event (1 Event punya banyak Sub Event).
     */
    public function subEvents(): HasMany
    {
        return $this->hasMany(EventDataSub::class, 'id_event_data', 'id_event_data');
    }

    /**
     * Relasi langsung ke Class melalui Sub Event.
     */
    public function classes(): HasManyThrough
    {
        return $this->hasManyThrough(
            EventDataSubClass::class,
            EventDataSub::class,
            'id_event_data',     // Foreign key di tabel event_data_sub
            'id_event_data_sub', // Foreign key di tabel event_data_sub_class
            'id_event_data',     // Local key di tabel event_data
            'id_event_data_sub'  // Local key di tabel event_data_sub
        );
    }

    /**
     * Pendaftaran yang terdaftar di event ini.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'id_event_data', 'id_event_data');
    }
}
