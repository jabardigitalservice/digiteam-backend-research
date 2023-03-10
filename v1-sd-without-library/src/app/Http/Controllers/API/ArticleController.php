<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Repositories\Article\ArticleRepositoryInterface;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    private $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index()
    {
        $articles = $this->articleRepository->all();
        return response()->format(Response::HTTP_OK, 'Articles Data', ArticleResource::collection($articles));
    }
}
