<?php
namespace App\Repositories;

use App\Interfaces\AppSettingsRepositoryInterface;
use App\Models\AppSettings;

class AppSettingsRepository implements AppSettingsRepositoryInterface
{
    public function update($key, $value)
    {
        return AppSettings::where('key', $key)->update(['value' => $value]);
    }
}
