<?php

namespace App\Models;

use App\Models\Pivots\SubscriptionUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $id
 * @property Collection<User> $users
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'price', 'max_articles'];

    /**
     * The articles that belong to the user. user_subscription
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(SubscriptionUser::class)->withPivot(['is_active', 'start_at']);
    }
}
