<?php


namespace App\Services;

use App\Models\Setting;
use Cache;

class SettingsService
{

    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')     //['key'=>'value'] - ne ksi format na duhen datat
                ->toArray();
        });
    }

    public function setGlobalSettings(): void
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    public function clearCachedSettings(): void
    {
        Cache::forget('settings');
    }
}
