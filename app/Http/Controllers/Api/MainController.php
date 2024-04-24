<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class MainController extends ApiController
{
    public function index() {
        $settings = Setting::all();
        $data = [];

        if (!empty($settings)) {
            foreach ($settings as $setting) {
                if ($setting->code === 'favicon' || $setting->code === 'logo') {
                    $data[$setting->code] = env('APP_URL') . Storage::url($setting->value);
                } else {
                    $data[$setting->code] = $setting->value;
                }
            }
        }

        return $this->outputData($data);
    }

    public function show(string $code) {
        return $this->outputData(Setting::where('code', 'LIKE', $code)->first());
    }
}
