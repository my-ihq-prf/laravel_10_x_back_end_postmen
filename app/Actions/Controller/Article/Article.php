<?php

namespace App\Actions\Controller\Article;

use App\Models\User;

/**
 *
 */
abstract class Article
{
    /**
     * The decoded payload for the request.
     *
     * @var ?object
     */
    protected ?object $data;
    /**
     * The app user model.
     *
     * @var ?User
     */
    protected ?User $user;
    /**
     * The filter.
     *
     * @var null|object
     */
    protected ?object $filter;

    /**
     * Create a new Article action instance.
     *
     * @param ?array $data
     * @return void
     */
    public function init(?array $data = null): void
    {
        $this->data = $data ? (object)app('camelizeIt')($data) : null;
        $this->user = auth()?->user();
    }

}
