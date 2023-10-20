<?php

namespace App\Http\Controllers\Api;

use App\Actions\Controller\Subscription\Create as SubscriptionCreateAction;
use App\Actions\Controller\Subscription\Delete as SubscriptionDeleteAction;
use App\Actions\Controller\Subscription\Show as SubscriptionShowAction;
use App\Actions\Controller\Subscription\Update as SubscriptionUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\Create as SubscriptionCreateRequest;
use App\Http\Requests\Subscription\Update as SubscriptionUpdateRequest;
use App\Http\Resources\Subscription as SubscriptionResource;
use App\Models\Subscription as Subscription;


class SubscriptionController extends Controller
{
    /**
     * @param SubscriptionShowAction $action
     * @return SubscriptionResource
     */
    public function show(SubscriptionShowAction $action): SubscriptionResource
    {
        return SubscriptionResource::make($action());
    }

    /**
     * @param SubscriptionCreateRequest $request
     * @param SubscriptionCreateAction $action
     * @return SubscriptionResource
     */
    public function create(SubscriptionCreateRequest $request, SubscriptionCreateAction $action): SubscriptionResource
    {
        return SubscriptionResource::make($action($request->input()));
    }

    /**
     * @param SubscriptionUpdateRequest $request
     * @param SubscriptionUpdateAction $action
     * @param string $subscriptionId
     * @return SubscriptionResource
     */
    public function update(SubscriptionUpdateRequest $request, SubscriptionUpdateAction $action, string $subscriptionId): SubscriptionResource
    {
        //
        if (!$subscriptionId) {
            abort(204, 'The subscription ID could not be found!');
        }
        return SubscriptionResource::make($action(Subscription::query()->findOrFail($subscriptionId), $request->input()));
    }

    /**
     * @param SubscriptionDeleteAction $action
     * @param string $subscriptionId
     * @return SubscriptionResource
     */
    public function delete(SubscriptionDeleteAction $action, string $subscriptionId): SubscriptionResource
    {
        //
        if (!$subscriptionId) {
            abort(204, 'The subscription ID could not be found!');
        }
        return SubscriptionResource::make($action(Subscription::query()->findOrFail($subscriptionId)));
    }

}
