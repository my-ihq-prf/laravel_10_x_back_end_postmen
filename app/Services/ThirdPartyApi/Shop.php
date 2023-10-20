<?php

namespace App\Services\ThirdPartyApi;

use Closure;

class Shop
{

    public function purchase($subscription, Closure $next): bool
    {
        sleep(3);
        return $next(['success' => true]);
    }


}

