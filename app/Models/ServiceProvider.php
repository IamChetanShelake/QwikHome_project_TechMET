<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\User;


class ServiceProvider extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $guarded = [];

    // Each provider belongs to a service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // If a provider is linked to a user (employee/vendor)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
