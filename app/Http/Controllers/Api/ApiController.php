<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function outputData($data = [], $message = false)
    {
        $data = collect($data);

        if ($data->isNotEmpty() && $data->count() > 0) {
            return response()->json(['message' => $message ? $message['with_data'] : __('api.message.found'), 'data' => $data], 200);
        } else {
            return response()->json(['message' => $message ? $message['without_data'] : __('api.message.not_found'), 'data' => $data], 200);
        }
    }

    protected function outputPaginationData($data = [], $message = false)
    {
        $data = collect($data);

        if (!empty($data['data']) && count($data['data']) > 0) {
            return response()->json(['message' => $message ? $message['with_data'] : __('api.message.found'), 'data' => $data], 200);
        } else {
            return response()->json(['message' => $message ? $message['without_data'] : __('api.message.not_found'), 'data' => $data], 200);
        }
    }
}
