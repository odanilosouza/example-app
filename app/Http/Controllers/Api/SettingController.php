<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends ApiController
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return $this->success(['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string'],
            'banner_text' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'values' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email'],
        ]);

        foreach ($request->only(['site_name', 'logo_path', 'banner_text', 'mission', 'vision', 'values', 'contact_email']) as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return $this->success([], 'Configurações atualizadas.');
    }
}
