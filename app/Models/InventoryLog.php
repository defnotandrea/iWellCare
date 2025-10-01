<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'adjustment_quantity',
        'notes',
        'adjusted_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'adjusted_at' => 'datetime',
    ];

    /**
     * Get the inventory item that was adjusted.
     */
    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'item_id');
    }

    /**
     * Get the user who made the adjustment.
     */
    public function adjustedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    /**
     * Get the adjustment type (add or subtract).
     */
    public function getAdjustmentTypeAttribute(): string
    {
        return $this->adjustment_quantity > 0 ? 'add' : 'subtract';
    }

    /**
     * Get the absolute quantity adjusted.
     */
    public function getAbsoluteQuantityAttribute(): int
    {
        return abs($this->adjustment_quantity);
    }

    /**
     * Get the formatted adjustment quantity.
     */
    public function getFormattedAdjustmentAttribute(): string
    {
        $sign = $this->adjustment_quantity > 0 ? '+' : '';

        return $sign.$this->adjustment_quantity;
    }

    /**
     * Scope a query to only include adjustments by a specific user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('adjusted_by', $userId);
    }

    /**
     * Scope a query to only include adjustments for a specific item.
     */
    public function scopeForItem($query, int $itemId)
    {
        return $query->where('item_id', $itemId);
    }

    /**
     * Scope a query to only include adjustments within a date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('adjusted_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include positive adjustments (additions).
     */
    public function scopeAdditions($query)
    {
        return $query->where('adjustment_quantity', '>', 0);
    }

    /**
     * Scope a query to only include negative adjustments (subtractions).
     */
    public function scopeSubtractions($query)
    {
        return $query->where('adjustment_quantity', '<', 0);
    }
}
