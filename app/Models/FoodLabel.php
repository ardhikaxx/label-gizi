<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FoodLabel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'menu_date',
        'description',
        'image',
        'energy',
        'protein',
        'fat',
        'carbohydrate',
        'fiber',
        'consumption_limit_hours',
        'status',
        'scheduled_at',
        'published_at',
        'created_by',
        'updated_by',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'menu_date' => 'date',
            'scheduled_at' => 'datetime',
            'published_at' => 'datetime',
            'energy' => 'float',
            'protein' => 'float',
            'fat' => 'float',
            'carbohydrate' => 'float',
            'fiber' => 'float',
            'consumption_limit_hours' => 'float',
        ];
    }

    /**
     * The menu items associated with this food label.
     *
     * @return HasMany<FoodLabelMenu, $this>
     */
    public function menus(): HasMany
    {
        return $this->hasMany(FoodLabelMenu::class)->orderBy('sort_order', 'asc');
    }

    /**
     * The admin user who created this food label.
     *
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The admin user who last updated this food label.
     *
     * @return BelongsTo<User, $this>
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope query to only published food labels.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published');
    }

    /**
     * Scope query to draft food labels.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopeDraft(Builder $query): void
    {
        $query->where('status', 'draft');
    }

    /**
     * Scope query to scheduled food labels.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopeScheduled(Builder $query): void
    {
        $query->where('status', 'scheduled');
    }

    /**
     * Scope query to archived food labels.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopeArchived(Builder $query): void
    {
        $query->where('status', 'archived');
    }

    /**
     * Search scope across title, description, and menu item names.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopeSearch(Builder $query, ?string $term): void
    {
        if (empty($term)) {
            return;
        }

        $term = trim($term);
        $query->where(function (Builder $subQuery) use ($term) {
            $subQuery->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhereHas('menus', function (Builder $menuQuery) use ($term) {
                    $menuQuery->where('name', 'like', "%{$term}%");
                });
        });
    }

    /**
     * Filter by menu date.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopeForDate(Builder $query, ?string $date): void
    {
        if (! empty($date)) {
            $query->whereDate('menu_date', $date);
        }
    }

    /**
     * Filter by date range.
     *
     * @param  Builder<FoodLabel>  $query
     */
    public function scopeDateBetween(Builder $query, ?string $startDate, ?string $endDate): void
    {
        if (! empty($startDate)) {
            $query->whereDate('menu_date', '>=', $startDate);
        }
        if (! empty($endDate)) {
            $query->whereDate('menu_date', '<=', $endDate);
        }
    }

    /**
     * Check if label is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if label is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if label is scheduled.
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if label is archived.
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    /**
     * Human-friendly label for current status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'published' => 'Dipublikasikan',
            'scheduled' => 'Terjadwal',
            'archived' => 'Diarsipkan',
            default => 'Draft',
        };
    }

    /**
     * Bootstrap badge class for current status.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'published' => 'bg-success',
            'scheduled' => 'bg-info text-dark',
            'archived' => 'bg-secondary',
            default => 'bg-warning text-dark',
        };
    }

    /**
     * Formatted consumption limit text.
     */
    public function getFormattedConsumptionLimitAttribute(): string
    {
        $hours = $this->consumption_limit_hours;
        $formattedHours = fmod((float) $hours, 1) === 0.0
            ? number_format((float) $hours, 0, ',', '.')
            : number_format((float) $hours, 1, ',', '.');

        return "Maksimal {$formattedHours} jam setelah pengantaran";
    }

    /**
     * Format a numeric nutrient value using Indonesian decimal notation.
     */
    public function formatNutrient(float $value): string
    {
        return fmod($value, 1) === 0.0
            ? number_format($value, 0, ',', '.')
            : number_format($value, 1, ',', '.');
    }

    /**
     * Generate a unique slug based on title and date.
     */
    public static function generateUniqueSlug(string $title, string|Carbon $date, ?int $ignoreId = null): string
    {
        $dateStr = $date instanceof Carbon ? $date->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');
        $baseSlug = Str::slug($title.'-'.$dateStr);
        if (empty($baseSlug)) {
            $baseSlug = 'label-'.$dateStr;
        }

        $slug = $baseSlug;
        $counter = 1;

        while (static::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the publicly accessible URL for the food label image without storage:link.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? url('uploads/food-labels/'.$this->image) : null;
    }
}
