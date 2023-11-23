<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\ApiController;
use App\Models\Blog\Article;

class ArticleController extends ApiController
{
    public function show(string $seo_keyword) {
        $article = Article::where(function ($query) use ($seo_keyword){
            $query->where('seo_keyword', 'LIKE', $seo_keyword);
            $query->where('status', true);
        })->first();

        return !empty($article) ? $this->outputData($article) : abort(404, __('api.message.not_found'));
    }
}
