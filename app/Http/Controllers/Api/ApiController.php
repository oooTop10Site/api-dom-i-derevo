<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function outputData($data = [], $message = false, $isPaginate = false)
    {
        $data = collect($data);

        if ((!$isPaginate && $data->isNotEmpty() && $data->count() > 0) || ($isPaginate && !empty($data['data']) && count($data['data']) > 0)) {
            $message = $message ? $message['with_data'] : __('api.message.found');
        } else {
            $message = $message ? $message['without_data'] : __('api.message.not_found');
        }

        return response()->json(['message' => $message, 'data' => $data], 200);
    }
}
