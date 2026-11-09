<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $table = 'testimonials';
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'person_name',
        'person_position',
        'content',
        'rating',
        'is_published',
    ];

    protected $casts = [
        'rating'       => 'integer',
        'is_published' => 'boolean',
        'created_at'   => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function scopePublished($query)
    {
        return $query->whereRaw('is_published is true');
    }
}
