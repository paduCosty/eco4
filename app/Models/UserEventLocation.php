<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventLocation extends Model
{
    protected $table = 'users_event_locations';
    protected $fillable = [
        'user_id',
        'email',
        'name',
        'description',
        'crm_propose_event_id',
        'event_location_id',
        'due_date',
        'terms_site',
        'terms_workshop',
        'volunteering_contract',
        'status'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function eventLocation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EventLocation::class);
    }

    public function eventRegistrations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventRegistration::class, 'users_event_location_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'event_location_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'event_location_id');
    }

}
