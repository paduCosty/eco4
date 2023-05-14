<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'name',
        'phone',
        'transport',
        'seats_available',
        'users_event_location_id',
        'terms_site',
        'terms_workshop',
        'volunteering_contract'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function usersEventLocation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserEventLocation::class);
    }
}
