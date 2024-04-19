<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Api\ApiController;
use App\Models\Service\Category;
use App\Models\Service\Service;

class CategoryController extends ApiController
{
    public function index() {
        return $this->outputData(Category::where(function ($query) {
            $query->where('status', true);
            $query->whereNull('category_id');
            $query->whereNotNull('seo_keyword');
        })->orderBy('sort_order', 'ASC')->paginate($this->get_limit()), false, true);
    }

    public function show(string $seo_keyword) {
        $category = Category::where(function ($query) use ($seo_keyword) {
            $query->where('status', true);
            $query->where('seo_keyword', 'LIKE', $seo_keyword);
            $query->whereNotNull('seo_keyword');
        })->orderBy('sort_order', 'ASC')->first();

        if (!empty($category)) {
            $services = [];

            foreach (Service::where(function ($query) use ($category) {
                $query->where('status', true);
                $query->whereNotNull('seo_keyword');
                $query->whereHas('relationship_category', function ($_query) use ($category) {
                    $_query->where('category_id', $category->id);
                });
            })->orderBy('sort_order', 'ASC')->paginate($this->get_limit()) as $item) {
                $item->price = json_decode($item->price);
                $item->additional_info = json_decode($item->additional_info);

                $services[] = $item;
            }

            return $this->outputData([
                'category' => $category,
                'categories' => Category::where(function ($query) use ($category) {
                    $query->where('status', true);
                    $query->where('category_id', $category->id);
                    $query->whereNotNull('seo_keyword');
                })->with('services', function ($query) {
                    $query->where('status', true);
                })->orderBy('sort_order', 'ASC')->get(),
                'services' => $services,
            ]);
        }

        abort(404, __('api.message.not_found'));
    }
}
