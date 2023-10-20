<?php

namespace App\Http\Controllers\Api;

use App\Actions\Controller\Article\Create as ArticleCreateAction;
use App\Actions\Controller\Article\Delete as ArticleDeleteAction;
use App\Actions\Controller\Article\Show as ArticleShowAction;
use App\Actions\Controller\Article\Update as ArticleUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\Create as ArticleCreateRequest;
use App\Http\Requests\Article\Show as ArticleShowRequest;
use App\Http\Requests\Article\Update as ArticleUpdateRequest;
use App\Http\Resources\Article as ArticleResource;
use App\Models\Article;
use Throwable;


class ArticleController extends Controller
{
    /**
     * @param ArticleShowRequest $request
     * @param ArticleShowAction $action
     * @return ArticleResource
     */
    public function show(ArticleShowRequest $request, ArticleShowAction $action): ArticleResource
    {
        return ArticleResource::make($action());
    }

    /**
     * @param ArticleCreateRequest $request
     * @param ArticleCreateAction $action
     * @return ArticleResource
     */
    public function create(ArticleCreateRequest $request, ArticleCreateAction $action): ArticleResource
    {
        return ArticleResource::make($action($request->input()));
    }

    /**
     * @param ArticleUpdateRequest $request
     * @param ArticleUpdateAction $action
     * @param string $articleId
     * @return ArticleResource
     * @throws Throwable
     */
    public function update(ArticleUpdateRequest $request, ArticleUpdateAction $action, string $articleId): ArticleResource
    {
        //
        if (!$articleId) {
            abort(204, 'This article id is not found!');
        }

        return ArticleResource::make($action(Article::query()->findOrFail($articleId), $request->input()));
    }

    /**
     * @param ArticleDeleteAction $action
     * @param string $articleId
     * @return ArticleResource
     */
    public function delete(ArticleDeleteAction $action, string $articleId): ArticleResource
    {
        //
        if (!$articleId) {
            abort(204, 'The article ID could not be found!');
        }
        return ArticleResource::make($action(Article::query()->findOrFail($articleId)));
    }

}

