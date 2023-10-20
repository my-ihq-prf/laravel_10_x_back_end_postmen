<?php

namespace App\Actions\Controller\Article;

use App\Actions\Controller\Article\Article as ArticleAction;
use App\Models\Article;

/**
 *
 */
class Show extends ArticleAction
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        parent::init();

        $article = Article::query()
            ->select(
                'articles.id',
                'articles.title',
                'articles.is_active',
                'articles.body',
                'articles.publish_at'
            );
        if (!$this->user->isAdmin) {
            $article->where('is_active', true)
                ->orWhere(function ($query) {
                    $query->where('user_id', $this->user->id);
                });
        }

        return $article
            ->withAuthor()
            ->filtered()
            ->paginate()
            ->toArray();


    }

}
