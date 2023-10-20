<?php

namespace App\Actions\Controller\Subscription;

use App\Actions\Controller\Subscription\Subscription as SubscriptionAction;
use App\Models\Subscription;

class Show extends SubscriptionAction
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        parent::init();
        $subscriptionQuery = Subscription::query();

        if ($this->user->isAdmin) {
            $subscriptionQuery->with('users');
        }

        return $subscriptionQuery->get()->toArray();
    }
}
