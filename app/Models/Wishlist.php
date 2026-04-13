<?php

namespace App\Models;

use App\Models\ServiceOffer;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'service_id', 'offer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function offers()
    {
        return $this->belongsTo(ServiceOffer::class);
    }
}
