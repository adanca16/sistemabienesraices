<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'property_id',
        'user_id',
        'interested_name',
        'interested_email',
        'interested_phone',
        'type',
        'reserved_at',
        'duration_minutes',
        'status',
        'notes',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    protected $appends = ['end_at'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getEndAtAttribute()
    {
        return $this->reserved_at?->copy()->addMinutes($this->duration_minutes);
    }

    /** Alcance para eventos entre rango (útil para FullCalendar) */
    public function scopeBetween($query, $start, $end)
    {
        return $query
            ->where('reserved_at', '<', $end)
            ->whereRaw('DATE_ADD(reserved_at, INTERVAL duration_minutes MINUTE) > ?', [$start]);
    }
}
