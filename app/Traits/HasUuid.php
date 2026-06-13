<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Auto-generate UUID saat model baru dibuat.
     * Menggunakan konvensi bootNamaTrait() agar tidak menimpa boot() di model.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Gunakan UUID sebagai route key (bukan integer ID).
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
