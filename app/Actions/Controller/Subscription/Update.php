<?php

namespace App\Actions\Controller\Subscription;

use App\Actions\Controller\Subscription\Subscription as SubscriptionAction;
use App\Models\Subscription;
use App\Services\ThirdPartyApi\Shop as ThirdPartyApiShop;
use Closure;
use Illuminate\Support\Carbon;


/**
 *
 */
class Update extends SubscriptionAction
{


    /**
     * @param Subscription|null $subscription
     * @param $requestData
     * @return array
     */
    public function __invoke(Subscription|null $subscription, $requestData): array
    {
        parent::init($requestData);
        $this->subscription = $subscription;

        $resFail = fn($msg = null) => ['success' => false, 'message' => $msg ?? 'Nothing to update!'];

        $resOk = fn() => [
            'success' => true,
            'receipt' =>
                [
                    'subscription' => $subscription->toArray(),
                    'subscription_users' => $subscription->users()->get()->toArray(),
                    'user' => $this->user->isAdmin ? ['roles' => $this->user->roles->toArray()] : $this->user->getAttributes(),
                    'pivot' => $this->user->subscription()?->first()?->toArray(),
                ]
        ];

        if ($this->user->isAdmin) {
            return $this->actAsAdmin($resOk, $resFail);
        } else {
            $subscriptionUserData = [];
            if (isset($this->data->isActive)) {
                $subscriptionUserData['is_active'] = $this->data->isActive;
            }
            if (isset($this->data->amount) && $this->data->amount) {
                if (is_null($this->user->subscription)) {
                    return $this->actUserShop($subscriptionUserData, $resOk);
                } else {
                    if ($this->subscription->getAttribute('id') !== $this->user->subscription->getAttribute('subscription_id')) {
                        return $resFail('This user is permitted to have only one subscription!');
                    } else {
                        return $this->actUserUpdatePivot($subscriptionUserData, $resOk, $resFail);
                    }
                }
            } else {
                if (is_null($this->user->subscription)) {
                    return $resFail('This user does not have any subscriptions!');
                }
                return $this->actUserUpdatePivot($subscriptionUserData, $resOk, $resFail);
            }
        }
    }

    private function actAsAdmin(Closure $ok, Closure $fail): array
    {
        $subscriptionData = $this->getSubscriptionAdminData();
        if (count($subscriptionData)) {
            $this->subscription->update($subscriptionData);
            return $ok();
        }
        return $fail();
    }

    /**
     * @return array
     */
    private function getSubscriptionAdminData(): array
    {
        $subscriptionData = [];

        if (isset($this->data->name)) {
            $subscriptionData['name'] = $this->data->name;
        }
        if (isset($this->data->price)) {
            $subscriptionData['price'] = $this->data->price;
        }
        if (isset($this->data->maxArticles)) {
            $subscriptionData['max_articles'] = $this->data->maxArticles;
        }

        return $subscriptionData;
    }

    private function actUserShop(array $subscriptionUserData, Closure $ok): array
    {
        $subscriptionPrice = $this->subscription->getAttribute('price');

        if (!$this->data->amount >= $subscriptionPrice) {
            abort(406, 'The amount must be at least ' . $subscriptionPrice . ' !');
        }

        if ((new ThirdPartyApiShop())->purchase([
            'subscription_id' => $this->subscription->id,
            'user_amount' => $subscriptionPrice
        ], function ($shopResult) use ($subscriptionUserData) {
            if (isset($shopResult['success']) && $shopResult['success'] === true) {
                if (
                    isset($subscriptionUserData['is_active'])
                    &&
                    $subscriptionUserData['is_active'] === true
                ) {
                    $subscriptionUserData['start_at'] = Carbon::now() . '';
                }
                $this->subscription->users()->attach($this->user->id, $subscriptionUserData);
                return true;
            }
            return false;
        })) {
            return $ok();
        } else {
            return ['success' => false, 'message' => 'Shop failure'];
        }
    }

    private function actUserUpdatePivot(array $subscriptionUserData, Closure $ok, Closure $fail): array
    {
        if (count($subscriptionUserData)) {
            $this->subscription->users()->updateExistingPivot($this->user->id,
                $subscriptionUserData
            );
            return $ok();
        }
        return $fail('Nothing to update for pivot table');
    }
}
