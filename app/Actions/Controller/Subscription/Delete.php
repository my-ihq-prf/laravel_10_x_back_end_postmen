<?php

namespace App\Actions\Controller\Subscription;

use App\Actions\Controller\Subscription\Subscription as SubscriptionAction;
use App\Models\Subscription;
use Closure;

/**
 * @property Subscription|null $subscription
 */
class Delete extends SubscriptionAction
{
    /**
     * @param Subscription|null $subscription
     * @return array
     */
    public function __invoke(Subscription|null $subscription): array
    {
        parent::init();
        $this->subscription = $subscription;

        $resFail = fn() => ['success' => false, 'message' => 'Nothing to delete!'];
        $resOk = fn() => [
            'success' => true,
            'receipt' =>
                [
                    'subscription' => $subscription->toArray(),
                    'users' => $subscription->users()->get()->toArray(),
                ]
        ];

        if ($this->user->isAdmin) {
            return $this->actAsAdmin($resOk, $resFail);
        } else {
            if ($this->subscription->users()->newPivotQuery()->where('user_id', '=', $this->user->id)->delete()) {
                return $resOk();
            }
        }
        return $resFail();
    }

    private function actAsAdmin(Closure $ok, Closure $fail): array
    {
        $this->subscription->users()->newPivotQuery()->delete();
        $res = $this->subscription->delete();
        if ($res === true) {
            return $ok();
        }
        return $fail();
    }
}
