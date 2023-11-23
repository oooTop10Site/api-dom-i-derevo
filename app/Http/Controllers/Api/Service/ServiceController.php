<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Api\ApiController;
use App\Models\Service\Example;
use App\Models\Service\Service;

class ServiceController extends ApiController
{
    public function show(string $seo_keyword) {
        $service = Service::where(function ($query) use ($seo_keyword){
            $query->where('seo_keyword', 'LIKE', $seo_keyword);
            $query->where('status', true);
        })->first();

        return !empty($service) ? $this->outputData([
            'service' => $service,
            'services' => Service::where(function ($query) use ($service) {
                $query->where('status', true);
                $query->whereNotNull('seo_keyword');
                $query->whereHas('relationship_additional_service', function ($_query) use ($service) {
                    $_query->where('service_id', $service->id);
                });
            })->orderBy('sort_order', 'ASC')->get(),
            'examples' => Example::where(function ($query) use ($service) {
                $query->where('status', true);
                $query->whereHas('relationship_service', function ($_query) use ($service) {
                    $_query->where('service_id', $service->id);
                });
            })->orderBy('sort_order', 'ASC')->get(),
        ]) : abort(404, __('api.message.not_found'));
    }
}
