<?php

namespace App\Actions\Controller\Subscription;

use App\Actions\Controller\Subscription\Subscription as SubscriptionAction;
use App\Models\Subscription;


/**
 *
 */
class Create extends SubscriptionAction
{
    /**
     * @param $requestData
     * @return array
     */
    public function __invoke($requestData): array
    {
        parent::init($requestData);

        $SubscriptionData = ['name' => $this->data->name, 'price' => $this->data->price, 'max_articles' => $this->data->maxArticles,];
        $subscription = $SubscriptionQuery = Subscription::query()->create($SubscriptionData);
        return ['success' => true, 'article' => $subscription->toArray()];

    }

}
