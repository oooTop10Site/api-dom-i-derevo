<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\ApiController;
use App\Models\Blog\Article;
use App\Models\Blog\Category;

class CategoryController extends ApiController
{
    public function index() {
        return $this->outputPaginationData(Category::where(function ($query) {
            $query->where('status', true);
            $query->whereNotNull('seo_keyword');
        })->orderBy('sort_order', 'ASC')->paginate($this->get_limit()));
    }

    public function show(string $seo_keyword) {
        $category = Category::where('seo_keyword', 'LIKE', $seo_keyword)->where('status', true)->first();
        return !empty($category) ? $this->outputData(['category' => $category, 'articles' => Article::where('category_id', $category->id)->where('status', true)->whereNotNull('seo_keyword')->orderBy('sort_order', 'ASC')->paginate($this->get_limit())]) : abort(404, __('api.message.not_found'));
    }
}
