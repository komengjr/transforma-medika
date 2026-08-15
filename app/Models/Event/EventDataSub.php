<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventDataSub extends Model
{
    use HasFactory;

    protected $table = 'event_data_sub';
    protected $primaryKey = 'id_event_data_sub';

    protected $fillable = [
        'event_data_sub_code',
        'id_event_data',
        'event_data_sub_name',
        'event_data_sub_start',
        'event_data_sub_end',
    ];

    /**
     * Sub event milik event utama.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(EventData::class, 'id_event_data', 'id_event_data');
    }

    /**
     * Relasi ke Class (1 Sub Event punya banyak Class).
     */
    public function classes(): HasMany
    {
        return $this->hasMany(EventDataSubClass::class, 'id_event_data_sub', 'id_event_data_sub');
    }
}
