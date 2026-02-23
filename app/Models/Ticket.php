<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_number',
        'subject',
        'category_id',      
        'priority',
        'status',
        'description',
        'attachments',        
        'resolution',
        'created_by',
        'assigned_to',
        'resolved_by',
        'resolved_at',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_company',
        'model',             
        'firmware_version', 
        'serial_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'resolved_at' => 'datetime',
        'attachments' => 'array',  // Cast JSON to array
    ];

    /**
     * Get the category associated with the ticket.
     */
    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    /**
     * Get the user who created the ticket.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the technician assigned to the ticket.
     */
    public function assignedTech()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who resolved the ticket.
     */
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the comments for the ticket.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a query to only include open tickets.
     */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['pending', 'open', 'in_progress']);
    }

    /**
     * Scope a query to only include resolved tickets.
     */
    public function scopeResolved($query)
    {
        return $query->whereIn('status', ['resolved', 'closed']);
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'status-pending',
            'open' => 'status-open',
            'in_progress' => 'status-in-progress',
            'resolved' => 'status-resolved',
            'closed' => 'status-closed',
            default => 'status-pending',
        };
    }

    /**
     * Get the priority badge color.
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'priority-low',
            'medium' => 'priority-medium',
            'high' => 'priority-high',
            default => 'priority-medium',
        };
    }

    /**
     * Generate a unique ticket number.
     */
    public static function generateTicketNumber()
    {
        $prefix = 'TKT';
        $date = now()->format('Ymd');
        $lastTicket = self::whereDate('created_at', today())->orderBy('id', 'desc')->first();
        
        if ($lastTicket) {
            $lastNumber = intval(substr($lastTicket->ticket_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . '-' . $date . '-' . $newNumber;
    }

    /**
         * Get the conversations for the ticket.
         */
        public function conversations()
        {
            return $this->hasMany(Conversation::class)->orderBy('created_at', 'asc');
        }

        /**
         * Get the latest conversation for the ticket.
         */
        public function latestConversation()
        {
            return $this->hasOne(Conversation::class)->latestOfMany();
        }

        /**
         * Get all public conversations (visible to client)
         */
        public function publicConversations()
        {
            return $this->hasMany(Conversation::class)
                ->where('is_internal_note', false)
                ->orderBy('created_at', 'asc');
        }

        /**
         * Get internal notes (staff only)
         */
        public function internalNotes()
        {
            return $this->hasMany(Conversation::class)
                ->where('is_internal_note', true)
                ->orderBy('created_at', 'asc');
        }
}