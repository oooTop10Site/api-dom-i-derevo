<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;

class MainController extends ApiController
{
    public function index() {
        $settings = Setting::all();
        $data = [];

        if (!empty($settings)) {
            foreach ($settings as $setting) {
                $data[$setting->code] = $setting->value;
            }
        }

        return $this->outputData($data);
    }

    public function show(string $code) {
        return $this->outputData(Setting::where('code', 'LIKE', $code)->first());
    }
}
