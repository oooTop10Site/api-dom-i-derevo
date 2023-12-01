<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private $categories = null;

    private function get_parent_recursive($category_id, $ignore_category, $name) {
        foreach ($this->categories as $category) {
            if ($category->id === $category_id) {
                if ($ignore_category === $category->id) {
                    return false;
                }

                $name = $category->name . ' > ' . $name;

                if (!empty($category->category_id)) {
                    $name = $this->get_parent_recursive($category->category_id, $ignore_category, $name);

                    if ($name === false) {
                        return false;
                    }
                }

                break;
            }
        }

        return $name;
    }

    protected function get_parents($data = null, $ignore_category = null) {
        if (empty($this->categories)) {
            $this->categories = \App\Models\Service\Category::all();
        }

        if (empty($data)) {
            $data = \App\Models\Service\Category::all();
        }

        foreach ($data as $key => $item) {
            if (!empty($item->category_id)) {
                $temp_name = $this->get_parent_recursive($item->category_id, $ignore_category, '');

                if ($temp_name === false) {
                    $data->forget($key);
                } else {
                    $item->name = $temp_name . $item->name;
                }
            }
        }

        return $data;
    }

    protected function get_limit() {
        return is_numeric(request('limit', 0)) && (int) request('limit', 0) > 0 ? (int) request('limit') : env('APP_PAGINATION_COUNT');
    }
}
