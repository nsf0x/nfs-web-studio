<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $table = 'inquiries';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_id',
        'package_id',
        'budget_range',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
