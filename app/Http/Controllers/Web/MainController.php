<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\MainRequest;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MainController extends WebController
{
    public function edit() {
        $setting = Setting::all();

        $data = [];
        if (!empty($setting)) {
            foreach ($setting as $value) {
                $data[$value->code] = $value->value;
            }
        }

        return view('main.form', compact('data'));
    }

    public function update(MainRequest $request) {
        $validated = $request->validated();

        $data = [];
        $now = Carbon::now()->toDateTimeString();
        foreach ($validated['data'] as $code => $value) {
            if ($code === 'favicon') {
                continue;
            } elseif (!empty($value)) {
                $data[] = ['code' => $code, 'value' => $value, 'created_at' => $now, 'updated_at' => $now];
            }
        }

        if (request()->hasFile('data.favicon')) {
            $data[] = ['code' => 'favicon', 'value' => request()->file('data.favicon')->store('public/main', ['visibility' => 'public', 'directory_visibility' => 'public']), 'created_at' => $now, 'updated_at' => $now];
        } else {
            $favicon = Setting::where('code', 'LIKE', 'favicon')->first();
            if (!empty($favicon)) {
                $data[] = ['code' => 'favicon', 'value' => $favicon['value'], 'created_at' => $now, 'updated_at' => $now];
            }
        }

        DB::delete('DELETE FROM `settings`;');
        Setting::insert($data);

        return redirect(route('main.edit'))->with('success', __('main.alert.update'));
    }
}
