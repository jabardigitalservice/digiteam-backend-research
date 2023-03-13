<?php

namespace App\Repositories\Article;

use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function all()
    {
        $data = Article::with('createdBy:id,name', 'createdBy.organization')->get();
        return $data;
    }
}
