<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $table = 'packages';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'name',
        'slug',
        'price',
        'price_note',
        'delivery_days',
        'revision_count',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
        'delivery_days'  => 'integer',
        'revision_count' => 'integer',
        'sort_order'     => 'integer',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class, 'package_id')->orderBy('sort_order');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'package_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
