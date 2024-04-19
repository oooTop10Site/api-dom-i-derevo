<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Api\ApiController;
use App\Models\Service\Service;

class ServiceController extends ApiController
{
    public function show(string $seo_keyword) {
        $service = Service::where(function ($query) use ($seo_keyword){
            $query->where('seo_keyword', 'LIKE', $seo_keyword);
            $query->where('status', true);
        })->first();

        if (!empty($service)) {
            $services = [];

            $service->price = json_decode($service->price);
            $service->additional_info = json_decode($service->additional_info);

            foreach (Service::where(function ($query) use ($service) {
                $query->where('status', true);
                $query->whereNotNull('seo_keyword');
                $query->whereHas('relationship_additional_service', function ($_query) use ($service) {
                    $_query->where('service_id', $service->id);
                });
            })->orderBy('sort_order', 'ASC')->get() as $item) {
                $item->price = json_decode($item->price);
                $item->additional_info = json_decode($item->additional_info);

                $services[] = $item;
            }

            return $this->outputData([
                'service' => $service,
                'services' => $services,
            ]);
        }

        abort(404, __('api.message.not_found'));
    }
}
