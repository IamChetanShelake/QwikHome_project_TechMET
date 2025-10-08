<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'image',
        'role',
        'application_document',
        'trade_license_document',
        'vat_certificate_document',
        'staff_documents',
        'contract_document',
        'payment_type',
        'fixed_rate_amount',
        'commission_rate',
        'revenue_share_ratio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships for different roles
    public function bookingsAsCustomer()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function bookingsAsServiceProvider()
    {
        return $this->hasMany(Booking::class, 'service_provider_id');
    }

    public function bookingsAsVendor()
    {
        return $this->hasMany(Booking::class, 'vendor_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVendor()
    {
        return $this->role === 'vendor';
    }

    public function isServiceProvider()
    {
        return $this->role === 'serviceprovider';
    }

    public function isCustomer()
    {
        return $this->role === 'user';
    }

    // Many-to-many relationship with services
    public function services()
    {
        return $this->belongsToMany(Service::class,'user_services')->withTimestamps();
    }

    // Feedback relationships
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function employeeFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'employee_id');
    }

    // Average rating calculation
    public function getAverageEmployeeRatingAttribute()
    {
        return $this->employeeFeedbacks()->avg('rating_employee');
    }
}
