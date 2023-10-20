<?php

namespace App\Actions\Controller\Article;

use App\Actions\Controller\Article\Article as ArticleAction;
use App\Models\Article;
use Throwable;

/**
 *
 */
class Update extends ArticleAction
{

    /**
     * @param Article|null $article
     * @param object|array|null $requestData
     * @return array
     * @throws Throwable
     */
    public function __invoke(Article|null $article, object|array|null $requestData): array
    {
        parent::init($requestData);

        if ($this->user->isAdmin) {
            $this->validateAdminAction();
            $this->data = (object)['is_active' => $this->data->isActive];
        } else {
            $this->validateUserAction($article);
        }
        $article->updateOrFail((array)$this->data);

        return ['success' => true, 'article' => $article->toArray()];

    }

    /**
     * Validate the action for non-admin users.
     *
     * @throws Throwable
     */
    private function validateAdminAction(): void
    {
        if (!isset($this->data->isActive)) {
            abort(406, 'This action is only allowed for non-admin users!');
        }
    }

    /**
     * Validate the action for admin users.
     *
     * @param Article $article
     * @throws Throwable
     */
    private function validateUserAction(Article $article): void
    {
        if (isset($this->data->isActive)) {
            abort(406, 'This action is only allowed for admin users!');
        } elseif ($article->getAttribute('user_id') !== $this->user->id) {
            abort(406, 'This article does not belong to this user!');
        }
    }
}
