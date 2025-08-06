<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function update(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    public function get(string $key, $default = null)
    {
        return Setting::where('key', $key)->first()?->value ?? $default;
    }
}
