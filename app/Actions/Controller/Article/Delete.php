<?php

namespace App\Actions\Controller\Article;

use App\Actions\Controller\Article\Article as ArticleAction;
use App\Models\Article;


/**
 *
 */
class Delete extends ArticleAction
{
    /**
     * @param Article|null $article
     * @return array
     */
    public function __invoke(Article|null $article): array
    {
        parent::init();

        $this->validateAction($article);

        $article->delete();

        return ['success' => true, 'article' => $article->toArray()];
    }

    /**
     * @param Article|null $article
     * @return void
     */
    private function validateAction(Article|null $article): void
    {
        if (!$this->isAuthorized($article)) {
            abort(406, 'This article does not belong to this user or they are not an admin!');
        }
    }

    /**
     * @param Article|null $article
     * @return bool
     */
    private function isAuthorized(Article|null $article): bool
    {
        return $this->user->isAdmin || ($article->getAttribute('user_id') === $this->user->id);
    }
}
