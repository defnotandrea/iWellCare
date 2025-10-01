<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_name', 'item_type', 'description', 'quantity', 'unit_price', 'supplier', 'location', 'batch_number', 'notes', 'expiry_date', 'minimum_stock', 'is_archived', 'created_by',
    ];

    protected static function booted()
    {
        static::addGlobalScope('notArchived', function ($query) {
            $query->where('is_archived', false);
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'datetime',
        'unit_price' => 'decimal:2',
        'is_archived' => 'boolean',
    ];

    /**
     * Get the user who last updated this inventory item.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the inventory logs for this item.
     */
    public function logs()
    {
        return $this->hasMany(InventoryLog::class, 'item_id');
    }

    /**
     * Check if the item is low on stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->minimum_stock;
    }

    /**
     * Check if the item is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Check if the item is expired or will expire soon.
     */
    public function isExpiredOrExpiringSoon(int $days = 30): bool
    {
        if (! $this->expiry_date) {
            return false;
        }

        return $this->expiry_date->isPast() ||
               $this->expiry_date->diffInDays(now()) <= $days;
    }

    /**
     * Get the formatted unit price.
     */
    public function getFormattedUnitPriceAttribute(): string
    {
        return '₱'.number_format((float) $this->unit_price, 2);
    }

    /**
     * Get the total value of current stock.
     */
    public function getTotalValueAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Get the formatted total value.
     */
    public function getFormattedTotalValueAttribute(): string
    {
        return '₱'.number_format($this->total_value, 2);
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= minimum_stock');
    }

    /**
     * Scope a query to only include out of stock items.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Scope a query to only include expired or expiring soon items.
     */
    public function scopeExpiredOrExpiringSoon($query, int $days = 30)
    {
        return $query->where(function ($q) use ($days) {
            $q->where('expiry_date', '<=', now())
                ->orWhere('expiry_date', '<=', now()->addDays($days));
        });
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('item_type', $category);
    }

    /**
     * Scope a query to search by name or description.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('item_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('supplier', 'like', "%{$search}%");
        });
    }
}
