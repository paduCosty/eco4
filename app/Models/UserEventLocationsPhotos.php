<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventLocationsPhotos extends Model
{
    protected $table = 'users_event_locations_photos';
    protected $fillable = [
        'path',
        'event_location_id',
        ];
    use HasFactory;

    public function userEventLocation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserEventLocation::class, 'event_location_id');
    }
}
