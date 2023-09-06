<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventLocation extends Model
{
    protected $table = 'users_event_locations';
    protected $fillable = [
        'coordinator_id',
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

    public function coordinator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
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

    public function eventLocationImages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserEventLocationsPhotos::class, 'user_event_location_id');
    }

    public function preGreeningEventImages()
    {
        return $this->hasMany(PreGreeningEventImages::class, 'event_location_id');
    }

}
