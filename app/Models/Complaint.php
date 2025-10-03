<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    protected $guarded = [];

    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship with the user who filed the complaint
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the admin assigned to handle the complaint
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'in_review' => 'info',
            'resolved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status label for display
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'in_review' => 'In Review',
            'resolved' => 'Resolved',
            'rejected' => 'Rejected',
            default => 'Unknown'
        };
    }
}
