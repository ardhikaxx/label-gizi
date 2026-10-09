<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ApplicationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
    ];

    public const CACHE_KEY = 'application_settings_all';

    /**
     * Retrieve a setting value by key with an optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::getAllSettings();

        if (! isset($all[$key])) {
            return $default;
        }

        $setting = $all[$key];
        $val = $setting['value'];

        return match ($setting['type']) {
            'boolean' => filter_var($val, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $val,
            default => $val,
        };
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, mixed $value, string $type = 'string', string $group = 'general', ?string $label = null): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value,
                'type' => $type,
                'group' => $group,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget(self::CACHE_KEY);

        return $setting;
    }

    /**
     * Get all settings cached as an associative array.
     *
     * @return array<string, array{value: ?string, type: string, group: string, label: ?string}>
     */
    public static function getAllSettings(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()
                ->get()
                ->keyBy('key')
                ->map(fn ($item) => [
                    'value' => $item->value,
                    'type' => $item->type,
                    'group' => $item->group,
                    'label' => $item->label,
                ])
                ->toArray();
        });
    }

    /**
     * Clear cached settings.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
