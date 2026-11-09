<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $table = 'projects';
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'service_id',
        'title',
        'slug',
        'description',
        'thumbnail_url',
        'project_url',
        'tech_stack',
        'completed_at',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'completed_at' => 'date',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function scopePublished($query)
    {
        return $query->whereRaw('is_published is true');
    }

    public function scopeFeatured($query)
    {
        return $query->whereRaw('is_featured is true');
    }
}
