<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventDataSubClass extends Model
{
    use HasFactory;

    protected $table = 'event_data_sub_class';
    protected $primaryKey = 'id_event_data_sub_class';

    protected $fillable = [
        'event_data_sub_class_code',
        'id_event_data_sub',
        'event_data_sub_class_name',
        'event_data_sub_class_room',
        'event_data_sub_class_price',
        'event_data_sub_class_type',
        'event_data_sub_class_kuota',
        'event_data_sub_class_status',
    ];

    /**
     * Class milik sub event tertentu.
     */
    public function subEvent(): BelongsTo
    {
        return $this->belongsTo(EventDataSub::class, 'id_event_data_sub', 'id_event_data_sub');
    }

    /**
     * Transaksi pendaftaran yang mengambil kelas ini.
     */
    public function registrations(): BelongsToMany
    {
        return $this->belongsToMany(
            EventRegistration::class,
            'event_registration_classes',
            'id_event_data_sub_class',
            'id_registration'
        )->withPivot('price', 'attendance_status', 'check_in_at', 'qr_code_token')
         ->withTimestamps();
    }
}
