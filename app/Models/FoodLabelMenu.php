<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodLabelMenu extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'food_label_id',
        'name',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * The parent food label.
     *
     * @return BelongsTo<FoodLabel, $this>
     */
    public function foodLabel(): BelongsTo
    {
        return $this->belongsTo(FoodLabel::class);
    }
}
