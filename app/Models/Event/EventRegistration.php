<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'event_registrations';
    protected $primaryKey = 'id_registration';

    protected $fillable = [
        'registration_code',
        'id_participant',
        'id_event_data',
        'total_amount',
        'payment_status',
        'registration_status',
        'registration_date',
    ];

    /**
     * Peserta yang melakukan transaksi pendaftaran ini.
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'id_participant', 'id_participant');
    }

    /**
     * Event yang didaftarkan.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(EventData::class, 'id_event_data', 'id_event_data');
    }

    /**
     * Kelas-kelas yang dipilih dalam transaksi pendaftaran ini (Many-to-Many via pivot).
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(
            EventDataSubClass::class,
            'event_registration_classes',
            'id_registration',
            'id_event_data_sub_class'
        )->withPivot('price', 'attendance_status', 'check_in_at', 'qr_code_token')
            ->withTimestamps();
    }
}
