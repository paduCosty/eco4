<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    protected $fillable = [
        'name',
        'cities_id',
        'user_id',
        'longitude',
        'latitude',
        'address',
        'status',
        'relief_type',
        'size_volunteer_id'
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
//        return $this->belongsTo(City::class);
        return $this->belongsTo(City::class, 'cities_id');

    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function usersEventLocations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserEventLocation::class);
    }

    public function approvedUsersEventLocations()
    {
        return $this->hasMany(UserEventLocation::class)->where('status', 'aprobat');
    }

    public function sizeVolunteer()
    {
        return $this->belongsTo(SizeVolunteers::class);
    }

    public function eventRegistrations()
    {
        return $this->belongsTo(UserEventLocation::class, 'users_event_location_id', 'id');
    }
}
