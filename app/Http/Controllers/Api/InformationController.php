<?php

namespace App\Http\Controllers\Api;

use App\Models\Information;

class InformationController extends ApiController
{
    public function index() {
        return $this->outputData(Information::where('status', true)->where(function ($query) {
            $query->where('status', true);
            $query->whereNotNull('seo_keyword');
        })->orderBy('sort_order', 'ASC')->paginate($this->get_limit()), false, true);
    }

    public function show(string $seo_keyword) {
        $information = Information::where('seo_keyword', 'LIKE', $seo_keyword)->where('status', true)->first();
        return !empty($information) ? $this->outputData($information) : abort(404, __('api.message.not_found'));
    }
}
