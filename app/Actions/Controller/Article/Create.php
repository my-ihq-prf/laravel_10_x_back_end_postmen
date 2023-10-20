<?php

namespace App\Actions\Controller\Article;

use App\Actions\Controller\Article\Article as ArticleAction;
use App\Models\Article;

/**
 *
 */
class Create extends ArticleAction
{
    /**
     * @param ?object $requestData
     * @return array
     */
    public function __invoke(?object $requestData): array
    {
        parent::init($requestData);

        $articleData = array_merge((array)$this->data, ['user_id' => $this->user->id]);
        $article = Article::query()->create($articleData);

        return ['success' => true, 'article' => $article->toArray()];
    }

}
