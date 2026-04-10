<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ServiceOffer;


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
