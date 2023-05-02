<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'region_id',
        'name',
        'longitude',
        'latitude'
    ];

    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function eventLocations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventLocation::class, 'cities_id');
//        return $this->belongsTo(City::class, 'cities_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedEventLocations()
    {
        return $this->hasMany(EventLocation::class, 'cities_id')->whereHas('approvedUsersEventLocations');
    }

}
