<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name', 'email', 'organization', 'inquiry_type', 'message', 'ip_address', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
