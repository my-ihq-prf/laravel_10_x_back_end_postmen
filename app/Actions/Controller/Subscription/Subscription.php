<?php

namespace App\Actions\Controller\Subscription;

use App\Models\Subscription as ModelSubscription;
use App\Models\User;

/**
 *
 */
abstract class Subscription
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
     * @var ModelSubscription|null
     */
    protected ModelSubscription|null $subscription;

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
