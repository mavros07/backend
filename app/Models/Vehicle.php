<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'status',
        'year',
        'make',
        'model',
        'price',
        'msrp',
        'finance_price',
        'finance_interest_rate',
        'finance_term_months',
        'finance_down_payment',
        'show_financing_calculator',
        'mileage',
        'city_mpg',
        'hwy_mpg',
        'transmission',
        'fuel_type',
        'drive',
        'body_type',
        'condition',
        'engine_size',
        'engine_layout',
        'top_track_speed',
        'zero_to_sixty',
        'number_of_gears',
        'location',
        'contact_phone',
        'contact_address',
        'contact_email',
        'map_location',
        'features',
        'exterior_color',
        'interior_color',
        'vin',
        'video_url',
        'description',
        'overview',
        'tech_specs',
        'is_special',
        'submitted_at',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'features' => 'array',
            'tech_specs' => 'array',
            'is_special' => 'boolean',
            'show_financing_calculator' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Same rule as dashboard “Staff listing” vs vendor: owner is console staff. */
    public function isStaffListing(): bool
    {
        return $this->user?->hasRole('admin') ?? false;
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class)->orderBy('sort_order');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(VehicleInquiry::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'vehicle_favorites')->withTimestamps();
    }
}
