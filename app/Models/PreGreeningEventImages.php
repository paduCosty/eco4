<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreGreeningEventImages extends Model
{
    protected $table = 'pre_greening_event_images';
    protected $fillable = [
        'event_location_id',
        'path'
    ];
    use HasFactory;

    public function eventLocation()
    {
        return $this->belongsTo(UserEventLocation::class, 'event_location_id');
    }

}
