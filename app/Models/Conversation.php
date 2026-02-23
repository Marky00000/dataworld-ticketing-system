<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conversations';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
        'attachments',
        'message_type',
        'is_internal_note',
        'metadata'
    ];

    protected $casts = [
        'attachments' => 'array',
        'metadata' => 'array',
        'is_internal_note' => 'boolean',
    ];

    /**
     * Get the ticket that owns the conversation.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user who sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the message is from a client (regular user)
     */
    public function isFromClient()
    {
        return $this->user && $this->user->user_type === 'user';
    }

    /**
     * Check if the message is from a tech
     */
    public function isFromTech()
    {
        return $this->user && $this->user->user_type === 'tech';
    }

    /**
     * Check if the message is from an admin
     */
    public function isFromAdmin()
    {
        return $this->user && $this->user->user_type === 'admin';
    }

    /**
     * Check if the message is from staff (admin or tech)
     */
    public function isFromStaff()
    {
        return $this->user && in_array($this->user->user_type, ['admin', 'tech']);
    }

    /**
     * Get the sender's name with role indicator
     */
    public function getSenderNameAttribute()
    {
        $name = $this->user ? $this->user->name : 'Unknown User';
        
        if ($this->isFromAdmin()) {
            return $name . ' (Admin)';
        } elseif ($this->isFromTech()) {
            return $name . ' (Tech)';
        } elseif ($this->isFromClient()) {
            return $name . ' (Client)';
        }
        
        return $name;
    }

    /**
     * Get the sender's avatar color based on role
     */
    public function getSenderAvatarColorAttribute()
    {
        if ($this->isFromAdmin()) {
            return 'bg-purple-500';
        } elseif ($this->isFromTech()) {
            return 'bg-blue-500';
        } else {
            return 'bg-green-500';
        }
    }

    /**
     * Get the sender's icon based on role
     */
    public function getSenderIconAttribute()
    {
        if ($this->isFromAdmin()) {
            return 'fa-crown';
        } elseif ($this->isFromTech()) {
            return 'fa-tools';
        } else {
            return 'fa-user';
        }
    }

    /**
     * Scope a query to only include public comments (not internal notes).
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal_note', false);
    }

    /**
     * Scope a query to only include internal notes (staff only).
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal_note', true);
    }

    /**
     * Scope a query to only include system messages.
     */
    public function scopeSystem($query)
    {
        return $query->whereIn('message_type', [
            'status_change', 
            'assignment_change', 
            'priority_change', 
            'system_note'
        ]);
    }

    /**
     * Scope a query to only include user comments (not system messages).
     */
    public function scopeComments($query)
    {
        return $query->where('message_type', 'comment');
    }
}